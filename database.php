<?php
/**
 * Created by PhpStorm.
 * User: Kabeer
 * Date: 29/05/2015
 * Time: 14:03
 */

define("ITERATIONCOUNT", 150000);

class database {

    private $db_host = "localhost";
    private $db_user = "user";
    private $db_pass = "password";
    private $db_name = "database";

    private $table_keys = "`keys`";
    private $table_user = "`user`";

    private $key_id = "`ID`";
    private $key_name = "`Name`";
    private $key_username = "`Username`";
    private $key_hash = "`Hash`";
    private $key_salt = "`Salt`";
    private $key_iterationcount = "`IterationCount`";
    private $key_token = "`Token`";
    private $key_userid = "`UserID`";
    private $key_domain = "`Domain`";
    private $key_emailhash = "`EmailHash`";
    private $key_emailverification = "`EmailVerified`";
    private $key_email = "`Email`";
    private $key_passwordhash = "`PasswordHash`";

    private $hashingAlgo = "sha256";

    private $connected = false;
    private $connection;


    public function Database($host, $user, $password, $database)
    {
        $this->db_host = $host;
        $this->db_user = $user;
        $this->db_pass = $password;
        $this->db_name = $database;
        $this->connection = new mysqli("", "", "", "");
    }

    public function connect()
    {
        if(!$this->connected)
        {
            $this->connection = new mysqli($this->db_host,$this->db_user,$this->db_pass,$this->db_name);
            if($this->connection->connect_errno > 0)
            {
                return false;
            }
            else
            {
                $this->connected = true;
                return true;
            }
        }
        else
        {
            return true;
        }
    }


    public function createUser($name, $username, $password, $email)
    {
        $sql1 =
            "SELECT 1
             FROM $this->table_user
             WHERE $this->key_username = ?";

        $stmt1 = $this->connection->prepare($sql1);
        $stmt1->bind_param("s", $username);
        $stmt1->execute();
        $result = $stmt1->fetch();
        $stmt1->close();

        if ($result)
        {
           return "username";
        }

        $sql2 =
            "SELECT 1
             FROM $this->table_user
             WHERE $this->key_email = ?";

        $stmt2 = $this->connection->prepare($sql2);
        $stmt2->bind_param("s", $email);
        $stmt2->execute();
        $result = $stmt2->fetch();
        $stmt2->close();

        if ($result)
        {
            return "email";
        }

        $salt = mcrypt_create_iv(256, MCRYPT_DEV_URANDOM);
        $token = mcrypt_create_iv(256, MCRYPT_DEV_URANDOM);
        $emailhash = md5(mcrypt_create_iv(32, MCRYPT_DEV_URANDOM));
        $emailverification = intval(false);
        $iterationCount = ITERATIONCOUNT;

        $this->sendEmailVerification($emailhash, $email, $name);

        $hash = hash_pbkdf2($this->hashingAlgo, $password, $salt, $iterationCount);

        $sql3 =
            "INSERT INTO $this->table_user ($this->key_name, $this->key_username, $this->key_hash, $this->key_salt,
                         $this->key_iterationcount, $this->key_token, $this->key_emailhash,
                         $this->key_emailverification, $this->key_email)
             VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?);";

        $stmt3 = $this->connection->prepare($sql3);
        $stmt3->bind_param("ssssissis", $name, $username, $hash, $salt, $iterationCount,
            $token, $emailhash, $emailverification, $email);
        $stmt3->execute();
        $stmt3->close();

        return $token;
    }

    private function sendEmailVerification($hash, $email, $name)
    {
        $to      = $email;
        $subject = 'SafeCrypt Email Verification';
        $message = 'Dear ' . $name . '

Thanks for using our service!

You can use your account after you have activated
it by clicking on the url below.

Please click this link to activate your account:
https://www.safecrypt.me/verifyemail.php?email=' . $email . '&hash=' . $hash . '

Enjoy!

SafeCrypt';

        $headers = 'From: admin@safecrypt.me' . "\r\n";
        mail($to, $subject, $message, $headers);
    }

    public function verifyEmail($email, $hash)
    {
        $verified = intval(true);

        $sql1 =
            "SELECT *
             FROM $this->table_user
             WHERE $this->key_email = ? AND $this->key_emailhash = ?;";

        $stmt1 = $this->connection->prepare($sql1);
        $stmt1->bind_param("ss", $email, $hash);
        $stmt1->execute();
        $result = $stmt1->fetch();
        $stmt1->close();

        if ($result)
        {
            $sql2 =
                "UPDATE $this->table_user
                 SET $this->key_emailverification = $verified
                 WHERE $this->key_email = ? AND $this->key_emailhash = ?;";

            $stmt2 = $this->connection->prepare($sql2);
            $stmt2->bind_param("ss", $email, $hash);
            $stmt2->execute();
            $stmt2->close();
            return true;
        }
        else
        {
            return false;
        }

    }

    public function verifyUser($username, $password)
    {

        $sql =
            "SELECT $this->key_salt, $this->key_iterationcount, $this->key_hash, $this->key_token, $this->key_emailverification
             FROM $this->table_user
             WHERE $this->key_username = ?;";


        $stmt = $this->connection->prepare($sql);
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $stmt->bind_result($salt, $iterationcount, $hash, $token, $emailverified);
        $result = $stmt->fetch();
        $stmt->close();
        $emailverified = $emailverified == 1;

        if (!$result)
            return "username";
        elseif(!$emailverified)
            return "unverified";
        elseif (hash_pbkdf2($this->hashingAlgo, $password, $salt, $iterationcount) == $hash)
            return $token;
        else
            return "password";
    }

    public function getLoggedinUser($token)
    {
        $sql1 =
            "SELECT $this->key_username
             FROM $this->table_user
             WHERE $this->key_token = ?;";

        $stmt1 = $this->connection->prepare($sql1);
        $stmt1->bind_param("s", $token);
        $stmt1->execute();
        $stmt1->bind_result($username);
        $result = $stmt1->fetch();
        $stmt1->close();

        if($result)
        {
            return $username;
        }
        else
        {
            return false;
        }
    }

    public function createDomain ($token, $password, $subdomain, $hostname, $tld)
    {
        if ($subdomain == "")
            $domain = "$hostname.$tld";
        else
            $domain = "$subdomain.$hostname.$tld";

        $domain = strtolower($domain);

        if (!filter_var(gethostbyname($domain), FILTER_VALIDATE_IP))
            return "domaininvalid";

        $sql1 =
            "SELECT $this->key_id, $this->key_username
             FROM $this->table_user
             WHERE $this->key_token = ?;";

        $stmt1 = $this->connection->prepare($sql1);
        $stmt1->bind_param("s", $token);
        $stmt1->execute();
        $stmt1->bind_result($userid, $username);
        $result = $stmt1->fetch();
        $stmt1->close();

        if(!$result)
            return "tokenerror";

        $salt = mcrypt_create_iv(256, MCRYPT_DEV_URANDOM);
        $iterationCount = ITERATIONCOUNT;

        $sql2 =
            "SELECT 1
             FROM $this->table_keys
             WHERE $this->key_userid = ? AND $this->key_domain = ?;";
        $stmt2 = $this->connection->prepare($sql2);
        $stmt2->bind_param("is", $userid, $domain);
        $stmt2->execute();
        $result = $stmt2->fetch();
        $stmt2->close();

        if($result)
            return "domainused";

        $sql3 =
            "INSERT INTO $this->table_keys ($this->key_userid, $this->key_domain, $this->key_salt, $this->key_iterationcount)
             VALUES (?, ?, ?, ?);";

        $stmt3 = $this->connection->prepare($sql3);
        $stmt3->bind_param("issi", $userid, $domain, $salt, $iterationCount);
        $stmt3->execute();
        $stmt3->close();

        return hash_pbkdf2($this->hashingAlgo, $password, $salt, $iterationCount);
    }

    public function getKeyedDomains($token)
    {
        $sql1 =
            "SELECT $this->key_id
             FROM $this->table_user
             WHERE $this->key_token = ?;";

        $stmt1 = $this->connection->prepare($sql1);
        $stmt1->bind_param("s", $token);
        $stmt1->execute();
        $stmt1->bind_result($userid);
        $result = $stmt1->fetch();
        $stmt1->close();

        if(!$result)
        {
            return "tokenerror";
        }

        $sql2 =
            "SELECT $this->key_domain
             FROM $this->table_keys
             WHERE $this->key_userid = ?;";

        $stmt2 = $this->connection->prepare($sql2);
        $stmt2->bind_param("s", $userid);
        $stmt2->execute();
        $result = $stmt2->get_result();
        $array = [];
        for ($i = 0; $i < $result->num_rows; $i++)
        {
            array_push($array, $result->fetch_array()['Domain']);
        }
        $stmt2->close();

        return $array;
    }

    public function generatePassword($domain, $password, $token)
    {
        $sql1 =
            "SELECT $this->key_id
             FROM $this->table_user
             WHERE $this->key_token = ?;";

        $stmt1 = $this->connection->prepare($sql1);
        $stmt1->bind_param("s", $token);
        $stmt1->execute();
        $stmt1->bind_result($userid);
        $result = $stmt1->fetch();
        $stmt1->close();

        if(!$result)
        {
            return "tokenerror";
        }

        $sql2 =
            "SELECT $this->key_salt, $this->key_iterationcount
             FROM $this->table_keys
             WHERE $this->key_userid = ? AND $this->key_domain = ?;";

        $stmt2 = $this->connection->prepare($sql2);
        $stmt2->bind_param("is", $userid, $domain);
        $stmt2->execute();
        $stmt2->bind_result($salt, $iterationCount);
        $stmt2->fetch();
        $stmt2->close();
        return hash_pbkdf2($this->hashingAlgo, $password, $salt, $iterationCount);
    }

    public function resendVerification($email, $username)
    {
        $verified = intval(false);
        $emailhash = md5(mcrypt_create_iv(32, MCRYPT_DEV_URANDOM));

        $sql1 =
            "UPDATE $this->table_user
             SET $this->key_emailhash = ?, $this->key_emailverification = ?
             WHERE $this->key_email = ? OR $this->key_username = ?;";

        $stmt1 = $this->connection->prepare($sql1);
        $stmt1->bind_param("ssss",$emailhash, $verified, $email, $username);
        $stmt1->execute();
        $stmt1->close();

        $sql2 =
            "SELECT $this->key_email, $this->key_username
             FROM $this->table_user
             WHERE $this->key_email = ? OR $this->key_username = ?;";

        $stmt2 = $this->connection->prepare($sql2);
        $stmt2->bind_param("ss", $email, $username);
        $stmt2->execute();
        $result = $stmt2->fetch();

        if($result)
        {
            $stmt2->bind_result($sqlemail, $sqlusername);
            $this->sendEmailVerification($emailhash, $sqlemail, $sqlusername);
            $stmt2->close();
            return true;
        }
        else
        {
            $stmt2->close();
            return false;
        }
    }

    public function forgottenPassword($email, $username)
    {
        $passwordhash = md5(mcrypt_create_iv(32, MCRYPT_DEV_URANDOM));

        $sql1 =
            "SELECT *
             FROM $this->table_user
             WHERE $this->key_email = ? AND $this->key_username = ?;";

        $stmt1 = $this->connection->prepare($sql1);
        $stmt1->bind_param("ss", $email, $username);
        $stmt1->execute();
        $result = $stmt1->fetch();
        $stmt1->close();

        if($result)
        {
            $sql2 =
                "UPDATE $this->table_user
                 SET $this->key_passwordhash = ?
                 WHERE $this->key_email = ? AND $this->key_username = ?;";

            $stmt2 = $this->connection->prepare($sql2);
            $stmt2->bind_param("sss", $passwordhash, $email, $username);
            $stmt2->execute();
            $stmt2->close();
            $this->sendPasswordReset($passwordhash, $email, $username);
            return true;
        }
        else
        {
            return false;
        }

    }

    private function sendPasswordReset($passwordhash, $email, $username)
    {
        $to      = $email;
        $subject = 'SafeCrypt Password Reset';
        $message = 'Dear ' . $username . '

Somebody has requested a password reset for your account

If this was you please click the link below to reset your password:

https://www.safecrypt.me/resetpassword.php?email=' . $email . '&hash=' . $passwordhash . '

If this was not you, please click the link below to cancel this request
or you can simply leave it and continue using your account as normal.

To cancel the password reset request:

https://www.safecrypt.me/resetpassword.php?email=' . $email . '&cancelreset=true

Thanks!

SafeCrypt';

        $headers = 'From: admin@safecrypt.me' . "\r\n";
        mail($to, $subject, $message, $headers);
    }

    public function remindUsername($email)
    {
        $sql1 =
            "SELECT $this->key_name
             FROM $this->table_user
             WHERE $this->key_email = ?;";

        $stmt1 = $this->connection->prepare($sql1);
        $stmt1->bind_param("s", $email);
        $stmt1->execute();
        $stmt1->bind_result($name);
        $result = $stmt1->fetch();
        $stmt1->close();

        if ($result)
        {
            $this->sendUsername($email, $name);
            return true;
        }
        else
        {
            return false;
        }
    }

    private function sendUsername($email, $name)
    {
        $to      = $email;
        $subject = 'SafeCrypt Username Reminder';
        $message = 'Dear ' . $name . '

Somebody has requested a username reminder for your account

If this was you, your username is ' . $name . '

If this was not you, please ignore this email.

Thanks!

SafeCrypt';

        $headers = 'From: admin@safecrypt.me' . "\r\n";
        mail($to, $subject, $message, $headers);
    }

    public function getNumberDomains($token)
    {
        $sql1 =
            "SELECT $this->key_id
             FROM $this->table_user
             WHERE $this->key_token = ?;";

        $stmt1 = $this->connection->prepare($sql1);
        $stmt1->bind_param("s", $token);
        $stmt1->execute();
        $stmt1->bind_result($userid);
        $result = $stmt1->fetch();
        $stmt1->close();

        if(!$result)
        {
            return 0;
        }

        $sql2 =
            "SELECT COUNT(*)
             FROM $this->table_keys
             WHERE $this->key_userid = ?";
        $stmt2 = $this->connection->prepare($sql2);
        $stmt2->bind_param("i", $userid);
        $stmt2->execute();
        $stmt2->bind_result($count);
        $result = $stmt2->fetch();
        $stmt2->close();

        if (!$result)
        {
            return 0;
        }
        else
        {
            return $count;
        }
    }

    public function deleteDomain($domain, $token)
    {
        $sql1 =
            "SELECT $this->key_id
             FROM $this->table_user
             WHERE $this->key_token = ?;";

        $stmt1 = $this->connection->prepare($sql1);
        $stmt1->bind_param("s", $token);
        $stmt1->execute();
        $stmt1->bind_result($userid);
        $result = $stmt1->fetch();
        $stmt1->close();

        if(!$result)
        {
            return false;
        }

        $sql2 =
            "DELETE FROM $this->table_keys
             WHERE $this->key_userid = ? AND $this->key_domain = ?;";

        $stmt2 = $this->connection->prepare($sql2);
        $stmt2->bind_param("is", $userid, $domain);
        $stmt2->execute();
        $result = $stmt2->affected_rows;
        $stmt2->close();

        return ($result == 1);
    }

    public function deleteAccount($token)
    {
        
    }


}