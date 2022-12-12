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


    public function createUser($username, $password, $email)
    {
        $salt = mcrypt_create_iv(256, MCRYPT_DEV_URANDOM);
        $token = mcrypt_create_iv(256, MCRYPT_DEV_URANDOM);
        $emailhash = md5(mcrypt_create_iv(32, MCRYPT_DEV_URANDOM));
        $emailverification = intval(false);
        $iterationCount = ITERATIONCOUNT;

        $this->sendEmailVerification($emailhash, $email, $username);

        $hash = hash_pbkdf2($this->hashingAlgo, $password, $salt, $iterationCount);

        $sql =
            "INSERT INTO $this->table_user ($this->key_username, $this->key_hash, $this->key_salt,
                         $this->key_iterationcount, $this->key_token, $this->key_emailhash,
                         $this->key_emailverification, $this->key_email)
             VALUES (?, ?, ?, ?, ?, ?, ?, ?);";

        $stmt = $this->connection->prepare($sql);
        $stmt->bind_param("sssissis", $username, $hash, $salt, $iterationCount,
            $token, $emailhash, $emailverification, $email);
        $stmt->execute();
        $stmt->close();

        return $token;
    }

    private function sendEmailVerification($hash, $email, $username)
    {
        $to      = $email;
        $subject = 'SafeCrypt Email Verification';
        $message = '
        Dear ' . $username . '

        Thanks for using our service!

        You can use your account after you have activated
        it by clicking on the url below.

        Please click this link to activate your account:
        http://www.safecrypt.me/verifyemail.php?email=' . $email . '&hash=' . $hash . '

        Enjoy!

        SafeCrypt
        ';

        $headers = 'From: admin@safecrypt.me' . "\r\n";
        mail($to, $subject, $message, $headers);
    }

    public function verifyEmail($email, $hash)
    {
        $verified = intval(true);

        $sql1 =
            "UPDATE $this->table_user
             SET $this->key_emailverification = $verified
             WHERE $this->key_email = ? AND $this->key_emailhash = ?;";

        $stmt1 = $this->connection->prepare($sql1);
        $stmt1->bind_param("ss", $email, $hash);
        $result = $stmt1->execute();
        $stmt1->close();

        if ($result)
        {
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
            "SELECT $this->key_salt, $this->key_iterationcount, $this->key_hash, $this->key_token
             FROM $this->table_user
             WHERE $this->key_username = ?;";


        $stmt = $this->connection->prepare($sql);
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $stmt->bind_result($salt, $iterationcount, $hash, $token);
        $result = $stmt->fetch();
        $stmt->close();

        if(!$result)
        {
            return "username";
        }
        elseif (hash_pbkdf2($this->hashingAlgo, $password, $salt, $iterationcount) == $hash)
        {
            return $token;
        }
        else
        {
            return "password";
        }

    }

    public function newWebsite ($token, $password, $subdomain, $hostname, $tld)
    {
        $domain = "$subdomain.$hostname.$tld";

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
        {
            return "tokenerror";
        }

        $salt = mcrypt_create_iv(256, MCRYPT_DEV_URANDOM);
        $iterationCount = ITERATIONCOUNT;

        $sql2 =
            "INSERT INTO $this->table_keys ($this->key_userid, $this->key_domain, $this->key_username, $this->key_salt, $this->key_iterationcount)
             VALUES (?, ?, ?, ?, ?);";

        $stmt2 = $this->connection->prepare($sql2);
        $stmt2->bind_param("isssi", $userid, $domain, $username, $salt, $iterationCount);
        $stmt2->execute();
        $stmt2->close();

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
        $array = $stmt2->get_result()->fetch_array();
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
            return true;
        }
        else
        {
            return false;
        }
    }

    public function forgottenPassword($email, $username)
    {
        $passwordhash = md5(mcrypt_create_iv(32, MCRYPT_DEV_URANDOM));

        $sql1 =
            "UPDATE $this->table_user
             SET $this->key_passwordhash = ?
             WHERE $this->key_email = ? AND $this->key_username = ?;";

        $stmt1 = $this->connection->prepare($sql1);
        $stmt1->bind_param("ssss",$passwordhash, $email, $username);
        $result = $stmt1->execute();

        if($result)
        {
            $this->sendPasswordReset($passwordhash, $email, $username);
        }

    }

    private function sendPasswordReset($passwordhash, $email, $username)
    {
        $cancel = intval(true);

        $to      = $email;
        $subject = 'SafeCrypt Password Reset';
        $message = '
        Dear ' . $username . '

        Somebody has requested a password reset for your account

        If this was you please click the link below to reset your password:

        http://www.safecrypt.me/resetpassword.php?email=' . $email . '&hash=' . $passwordhash . '

        If this was not you, please click the link below to cancel this request
        or you can simply leave it and continue using your account as normal.

        To cancel the password reset request:

        http://www.safecrypt.me/resetpassword.php?email=' . $email . '&cancelreset' . $cancel . '

        Thanks!

        SafeCrypt
        ';

        $headers = 'From: admin@safecrypt.me' . "\r\n";
        mail($to, $subject, $message, $headers);
    }
}