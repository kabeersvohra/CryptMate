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
    private $table_emailconfirmations = "`emailconfirmations`";
    private $table_transactions = "`transactions`";

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
    private $key_email1 = "`Email1`";
    private $key_email2 = "`Email2`";
    private $key_subscriptionend = "`SubscriptionEnd`";
    private $key_passwordhash = "`PasswordHash`";
    private $key_hash1 = "`Hash1`";
    private $key_hash2 = "`Hash2`";
    private $key_verification1 = "`Verification1`";
    private $key_verification2 = "`Verification2`";
    private $key_transactionid = "`TransactionID`";
    private $key_transactiontype = "`TransactionType`";
    private $key_paymentstatus = "`PaymentStatus`";
    private $key_paymentamount = "`PaymentAmount`";
    private $key_paymentcurrency = "`PaymentCurrency`";
    private $key_paymentfee = "`PaymentFee`";
    private $key_payeremail = "`PayerEmail`";
    private $key_payername = "`PayerName`";
    private $key_payertoken = "`PayerToken`";
    private $key_recieveremail = "`RecieverEmail`";
    private $key_subscriberid = "`SubscriberID`";
    private $key_verified = "`Verified`";

    private $hashingAlgo = "sha256";

    private $connected = false;
    private $connection;


    public function Database($host, $user, $password, $database)
    {
        $this->db_host = $host;
        $this->db_user = $user;
        $this->db_pass = $password;
        $this->db_name = $database;
        if(!$this->connected)
        {
            $this->connection = new mysqli($this->db_host,$this->db_user,$this->db_pass,$this->db_name);
            if(!($this->connection->connect_errno > 0))
            {
                $this->connected = true;
            }
        }
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

        $sql3 =
            "SELECT *
             FROM $this->table_user
             WHERE $this->key_token = ?;";
        $stmt3 = $this->connection->prepare($sql3);

        while (true)
        {
            $token = mcrypt_create_iv(256, MCRYPT_DEV_URANDOM);
            $stmt3->bind_param("s", $token);
            $stmt3->execute();
            $result = $stmt3->fetch();
            if (!$result) break;
        }

        $stmt3->close();

        $emailhash = md5(mcrypt_create_iv(32, MCRYPT_DEV_URANDOM));
        $emailverification = intval(false);
        $iterationcount = ITERATIONCOUNT;

        $this->sendEmailVerification($emailhash, $email, $name);

        $hash = hash_pbkdf2($this->hashingAlgo, $password, $salt, $iterationcount);

        $sql4 =
            "INSERT INTO $this->table_user ($this->key_name, $this->key_username, $this->key_hash, $this->key_salt,
                         $this->key_iterationcount, $this->key_token, $this->key_emailhash,
                         $this->key_emailverification, $this->key_email, $this->key_subscriptionend)
             VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, (NOW() + INTERVAL 1 MONTH));";

        $stmt4 = $this->connection->prepare($sql4);
        $stmt4->bind_param("ssssissis", $name, $username, $hash, $salt, $iterationcount,
            $token, $emailhash, $emailverification, $email);
        $stmt4->execute();
        $stmt4->close();

        return $token;
    }

    private function sendEmailVerification($hash, $email, $name)
    {
        $to      = $email;
        $subject = 'CryptMate Email Verification';
        $message = 'Dear ' . $name . '

Thanks for using our service!

You can use your account after you have activated
it by clicking on the url below.

Please click this link to activate your account:
https://www.cryptmate.com/verifyemail.php?email=' . $email . '&hash=' . $hash . '&newemail=0

Enjoy!

CryptMate';

        $headers = 'From: admin@cryptmate.com' . "\r\n";
        mail($to, $subject, $message, $headers);
    }

    private function sendCurrentEmailVerification($hash, $email, $name)
    {
        $to      = $email;
        $subject = 'CryptMate Email Verification';
        $message = 'Dear ' . $name . '

To ensure the legitimacy of an email change on your account you must verify this email address as well as your new email address

Please click this link to verify this email address:
https://www.cryptmate.com/verifyemail.php?email=' . $email . '&hash=' . $hash . '&newemail=1

Thanks!

CryptMate';

        $headers = 'From: admin@cryptmate.com' . "\r\n";
        mail($to, $subject, $message, $headers);
    }

    private function sendNewEmailVerification($hash, $email, $name)
    {
        $to      = $email;
        $subject = 'CryptMate Email Verification';
        $message = 'Dear ' . $name . '

To ensure the legitimacy of an email change on your account you must verify this email address as well as your previous email address

Please click this link to verify this email address:
https://www.cryptmate.com/verifyemail.php?email=' . $email . '&hash=' . $hash . '&newemail=1

Thanks!

CryptMate';

        $headers = 'From: admin@cryptmate.com' . "\r\n";
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
        $stmt2->bind_result($result);
        $array = [];
        while ($stmt2->fetch())
        {
            array_push($array, $result['Domain']);
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
        $subject = 'CryptMate Password Reset';
        $message = 'Dear ' . $username . '

Somebody has requested a password reset for your account

If this was you please click the link below to reset your password:

https://www.cryptmate.com/resetpassword.php?email=' . $email . '&hash=' . $passwordhash . '

If this was not you, please click the link below to cancel this request
or you can simply leave it and continue using your account as normal.

To cancel the password reset request:

https://www.cryptmate.com/resetpassword.php?email=' . $email . '&cancelreset=true

Thanks!

CryptMate';

        $headers = 'From: admin@cryptmate.com' . "\r\n";
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
        $subject = 'CryptMate Username Reminder';
        $message = 'Dear ' . $name . '

Somebody has requested a username reminder for your account

If this was you, your username is ' . $name . '

If this was not you, please ignore this email.

Thanks!

CryptMate';

        $headers = 'From: admin@cryptmate.com' . "\r\n";
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
        $sql1 =
            "DELETE FROM $this->table_user
             WHERE $this->key_token = ?;";

        $stmt1 = $this->connection->prepare($sql1);
        $stmt1->bind_param("s", $token);
        $stmt1->execute();
        $result = $stmt1->affected_rows;
        $stmt1->close();
        return ($result >= 1);
    }

    public function getAccountDetails($token)
    {
        $sql1 =
            "SELECT $this->key_name, $this->key_username, $this->key_email
             FROM $this->table_user
             WHERE $this->key_token = ?;";
        $stmt1 = $this->connection->prepare($sql1);
        $stmt1->bind_param("s", $token);
        $stmt1->execute();
        $stmt1->bind_result($name, $username, $email);
        $stmt1->fetch();
        $stmt1->close();
        return
            array(
                "name" => $name,
                "username" => $username,
                "email" => $email
            );
    }

    public function verifyNewEmail($email, $hash)
    {
        $verified = intval(true);
        $sql1 =
            "SELECT $this->key_token
             FROM $this->table_emailconfirmations
             WHERE $this->key_email1 = ? AND $this->key_hash1 = ? ;";
        $stmt1 = $this->connection->prepare($sql1);
        $stmt1->bind_param("ss", $email, $hash);
        $stmt1->execute();
        $stmt1->bind_result($token);
        $result = $stmt1->fetch();
        $stmt1->close();
        if ($result)
        {
            $sql2 =
                "UPDATE $this->table_emailconfirmations
                 SET $this->key_verification1 = ?
                 WHERE $this->key_email1 = ? AND $this->key_hash1 = ?;";
            $stmt2 = $this->connection->prepare($sql2);
            $stmt2->bind_param("sss", $verified, $email, $hash);
            $stmt2->execute();
            $stmt2->close();

            $updated = 1;
        }
        else
        {
            $sql2 =
                "SELECT $this->key_token
                 FROM $this->table_emailconfirmations
                 WHERE $this->key_email2 = ? AND $this->key_hash2 = ?;";
            $stmt2 = $this->connection->prepare($sql2);
            $stmt2->bind_param("ss", $email, $hash);
            $stmt2->execute();
            $stmt2->bind_result($token);
            $result = $stmt2->fetch();
            $stmt2->close();
            if ($result)
            {
                $sql3 =
                    "UPDATE $this->table_emailconfirmations
                     SET $this->key_verification2 = ?
                     WHERE $this->key_email2 = ? AND $this->key_hash2 = ?";
                $stmt3 = $this->connection->prepare($sql3);
                $stmt3->bind_param("sss", $verified, $email, $hash);
                $stmt3->execute();
                $stmt3->close();

                $updated = 2;
            }
            else
            {
                return 4;
            }
        }

        if (isset($token))
        {
            $sql4 =
                "SELECT $this->key_verification1, $this->key_verification2, $this->key_email2
                 FROM $this->table_emailconfirmations
                 WHERE $this->key_token = ?;";
            $stmt4 = $this->connection->prepare($sql4);
            $stmt4->bind_param("s", $token);
            $stmt4->execute();
            $stmt4->bind_result($verified1, $verified2, $email2);
            $stmt4->fetch();
            $stmt4->close();

            if ($verified1 == 1 && $verified2 == 1)
            {
                $sql5 =
                    "UPDATE $this->table_user
                     SET $this->key_email = ?
                     WHERE $this->key_token = ?;";
                $stmt5 = $this->connection->prepare($sql5);
                $stmt5->bind_param("ss", $email2, $token);
                $stmt5->execute();
                $stmt5->close();
                return 3;
            }
            else
                return $updated;

        }
    }

    public function isCurrentEmail($token, $currentemail)
    {
        $sql1 =
            "SELECT 1
             FROM $this->table_user
             WHERE $this->key_email = ? AND $this->key_token = ?;";
        $stmt1 = $this->connection->prepare($sql1);
        $stmt1->bind_param("ss", $currentemail, $token);
        $stmt1->execute();
        $result = $stmt1->fetch();
        $stmt1->close();

        return $result;
    }

    public function isNewEmail($newemail)
    {
        $sql1 =
            "SELECT 1
             FROM $this->table_user
             WHERE $this->key_email = ?";
        $stmt1 = $this->connection->prepare($sql1);
        $stmt1->bind_param("s", $newemail);
        $stmt1->execute();
        $result = $stmt1->fetch();
        $stmt1->close();

        return !$result;
    }


    public function changeEmail($token, $currentemail, $newemail)
    {
        mysqli_report(MYSQLI_REPORT_ERROR);
        $verified = intval(false);
        $hash1 = md5(mcrypt_create_iv(32, MCRYPT_DEV_URANDOM));
        $hash2 = md5(mcrypt_create_iv(32, MCRYPT_DEV_URANDOM));

        $sql1 =
            "INSERT INTO $this->table_emailconfirmations
                  ($this->key_token, $this->key_email1, $this->key_hash1, $this->key_verification1,
                   $this->key_email2, $this->key_hash2, $this->key_verification2)
             VALUES (?, ?, ?, ?, ?, ?, ?);";

        $stmt1 = $this->connection->prepare($sql1);
        $stmt1->bind_param("sssissi", $token, $currentemail, $hash1, $verified, $newemail, $hash2, $verified);
        $stmt1->execute();
        $result = $stmt1->affected_rows;
        $stmt1->close();

        if ($result != 1)
            return false;

        $sql2 =
            "SELECT $this->key_name
             FROM $this->table_user
             WHERE $this->key_token = ?;";

        $stmt2 = $this->connection->prepare($sql2);
        $stmt2->bind_param("s", $token);
        $stmt2->execute();
        $stmt2->bind_result($name);
        $result = $stmt2->fetch();
        $stmt2->close();

        if (!$result)
            return false;

        $this->sendCurrentEmailVerification($hash1, $currentemail, $name);
        $this->sendNewEmailVerification($hash2, $newemail, $name);

        return true;
    }

    public function changePassword($oldpassword, $newpassword, $token)
    {
        $sql1 =
            "SELECT $this->key_hash, $this->key_salt, $this->key_iterationcount
             FROM $this->table_user
             WHERE $this->key_token = ?;";
        $stmt1 = $this->connection->prepare($sql1);
        $stmt1->bind_param("s", $token);
        $stmt1->execute();
        $stmt1->bind_result($hash, $salt, $iterationcount);
        $result = $stmt1->fetch();
        $stmt1->close();

        if ($result)
        {
            if ($hash == hash_pbkdf2($this->hashingAlgo, $oldpassword, $salt, $iterationcount))
            {
                $newsalt = mcrypt_create_iv(256, MCRYPT_DEV_URANDOM);
                $newiterationcount = ITERATIONCOUNT;
                $newhash = hash_pbkdf2($this->hashingAlgo, $newpassword, $newsalt, $newiterationcount);

                $sql3 =
                    "UPDATE $this->table_user
                     SET $this->key_hash = ?, $this->key_salt = ?, $this->key_iterationcount = ?
                     WHERE $this->key_token = ?";

                $stmt3 = $this->connection->prepare($sql3);
                $stmt3->bind_param("ssis", $newhash, $newsalt, $newiterationcount, $token);
                $stmt3->execute();
                $result = $stmt3->affected_rows;
                $stmt3->close();
                if ($result == 1)
                    return 1;
                else
                    return 3;
            }
            else
            {
                return 2;
            }
        }
        else
        {
            return 3;
        }
    }

    public function getSubscriptionEnd($token)
    {
        $sql1 =
            "SELECT DATE_FORMAT($this->key_subscriptionend,'%D %M %Y')
             FROM $this->table_user
             WHERE $this->key_token = ?;";
        $stmt1 = $this->connection->prepare($sql1);
        $stmt1->bind_param("s", $token);
        $stmt1->execute();
        $stmt1->bind_result($subscriptionend);
        $result = $stmt1->fetch();
        $stmt1->close();

        if ($result)
            return $subscriptionend;
        else
            return $result;
    }

    public function getSubscriptionEnded($token)
    {
        $sql1 =
            "SELECT $this->key_subscriptionend < CURRENT_DATE()
             FROM $this->table_user
             WHERE $this->key_token = ?;";
        $stmt1 = $this->connection->prepare($sql1);
        $stmt1->bind_param("s", $token);
        $stmt1->execute();
        $stmt1->bind_result($subscriptionended);
        $stmt1->fetch();
        $stmt1->close();

        return $subscriptionended;
    }

    public function isNewTransaction($txn_id)
    {
        $sql1 =
            "SELECT *
             FROM $this->table_transactions
             WHERE $this->key_transactionid = ?;";
        $stmt1 = $this->connection->prepare($sql1);
        $stmt1->bind_param("i", $txn_id);
        $stmt1->execute();
        $result = $stmt1->fetch();
        $stmt1->close();

        return !$result;
    }

    public function createNewTransaction($txn_id, $txn_type, $payment_status, $payment_amount, $payment_currency, $payment_fee, $payer_email, $payer_name, $payer_token, $receiver_email, $subscriber_id, $verified)
    {
        $sql1 =
            "INSERT INTO $this->table_transactions
                ($this->key_transactionid, $this->key_transactiontype, $this->key_paymentstatus, $this->key_paymentamount, $this->key_paymentcurrency, $this->key_paymentfee, $this->key_payeremail, $this->key_payername, $this->key_payertoken, $this->key_recieveremail, $this->key_subscriberid, $this->key_verified)
             VALUES
                (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?);";
        $stmt1 = $this->connection->prepare($sql1);
        $stmt1->bind_param("issisissssis", $txn_id, $txn_type, $payment_status, $payment_amount, $payment_currency, $payment_fee, $payer_email, $payer_name, $payer_token, $receiver_email, $subscriber_id, $verified);
        $stmt1->execute();
        $stmt1->close();
    }

    public function addOneMonth($payer_token)
    {
        if ($this->getSubscriptionEnded($payer_token))
            $sql1 =
                "UPDATE $this->table_user
                 SET $this->key_subscriptionend = DATE_ADD(now(), INTERVAL 1 MONTH)
                 WHERE $this->key_token = ?;";
        else
            $sql1 =
                "UPDATE $this->table_user
                 SET $this->key_subscriptionend = DATE_ADD($this->key_subscriptionend, INTERVAL 1 MONTH)
                 WHERE $this->key_token = ?;";

        $stmt1 = $this->connection->prepare($sql1);
        $stmt1->bind_param("s", $payer_token);
        $stmt1->execute();
        $stmt1->close();
    }

    public function addOneYear($payer_token)
    {
        if ($this->getSubscriptionEnded($payer_token))
            $sql1 =
                "UPDATE $this->table_user
                 SET $this->key_subscriptionend = DATE_ADD(now(), INTERVAL 1 YEAR)
                 WHERE $this->key_token = ?;";
        else
            $sql1 =
                "UPDATE $this->table_user
                 SET $this->key_subscriptionend = DATE_ADD($this->key_subscriptionend, INTERVAL 1 YEAR)
                 WHERE $this->key_token = ?;";
        $stmt1 = $this->connection->prepare($sql1);
        $stmt1->bind_param("s", $payer_token);
        $stmt1->execute();
        $stmt1->close();
    }

}