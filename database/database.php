<?php
/**
 * Created by PhpStorm.
 * User: Kabeer
 * Date: 29/05/2015
 * Time: 14:03
 */

class database {

    private $db_host = "localhost";
    private $db_user = "user";
    private $db_pass = "password";
    private $db_name = "database";

    private $table_keys = "`keys`";
    private $table_user = "`user`";
    private $table_emailConfirmations = "`emailconfirmations`";
    private $table_stripe = "`stripe`";

    private $key_id = "`ID`";
    private $key_name = "`Name`";
    private $key_username = "`Username`";
    private $key_hash = "`Hash`";
    private $key_salt = "`Salt`";
    private $key_cost = "`Cost`";
    private $key_token = "`Token`";
    private $key_userID = "`UserID`";
    private $key_domain = "`Domain`";
    private $key_emailHash = "`EmailHash`";
    private $key_emailVerification = "`EmailVerified`";
    private $key_email = "`Email`";
    private $key_email1 = "`Email1`";
    private $key_email2 = "`Email2`";
    private $key_subscriptionEnd = "`SubscriptionEnd`";
    private $key_passwordHash = "`PasswordHash`";
    private $key_hash1 = "`Hash1`";
    private $key_hash2 = "`Hash2`";
    private $key_verification1 = "`Verification1`";
    private $key_verification2 = "`Verification2`";
    private $key_customerID = "`CustomerID`";
    private $key_plan = "`Plan`";

    private $cryptMateHashingAlgo = PASSWORD_DEFAULT;
    private $generateHashingAlgo = PASSWORD_BCRYPT;
    private $cost = 10;

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
                $this->connected = true;
        }
    }

    public function connect()
    {
        if(!$this->connected)
        {
            $this->connection = new mysqli($this->db_host,$this->db_user,$this->db_pass,$this->db_name);
            if($this->connection->connect_errno > 0)
                return false;
            else
                $this->connected = true;
                return true;
        }
        else
            return true;
    }


    public function createUser($name, $username, $password, $email)
    {
        $query1 =
            "SELECT 1
             FROM $this->table_user
             WHERE $this->key_username = ?";

        $successful = $this->queryWithoutReturningResult($query1, "s", array($username));

        if ($successful)
        {
           return "username";
        }

        $query2 =
            "SELECT 1
             FROM $this->table_user
             WHERE $this->key_email = ?";
        $successful = $this->queryWithoutReturningResult($query2, "s", array($email));

        if ($successful)
            return "email";

        $query3 =
            "SELECT *
             FROM $this->table_user
             WHERE $this->key_token = ?;";

        $token = null;

        while (true)
        {
            $token = $this->randomString(256);
            $used = $this->queryWithoutReturningResult($query3, "s", array($token));
            if (!$used) break;
        }

        $emailHash = $this->randomString(32);
        $emailVerification = intval(false);

        $this->sendEmailVerification($emailHash, $email, $name);

        $hash = password_hash($password, $this->cryptMateHashingAlgo);

        $query4 =
            "INSERT INTO $this->table_user ($this->key_name, $this->key_username, $this->key_hash,
                         $this->key_token, $this->key_emailHash, $this->key_emailVerification, $this->key_email,
                         $this->key_subscriptionEnd)
             VALUES (?, ?, ?, ?, ?, ?, ?, (NOW() + INTERVAL 1 MONTH));";
        $this->queryWithoutReturningResult($query4, "sssssis",
            array($name, $username, $hash, $token, $emailHash, $emailVerification, $email));

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

        $query1 =
            "SELECT *
             FROM $this->table_user
             WHERE $this->key_email = ? AND $this->key_emailHash = ?;";
        $result = $this->queryWithoutReturningResult($query1, "ss", array($email, $hash));

        if ($result)
        {
            $query2 =
                "UPDATE $this->table_user
                 SET $this->key_emailVerification = $verified
                 WHERE $this->key_email = ? AND $this->key_emailHash = ?;";
            $this->queryWithoutReturningResult($query2, "ss", array($email, $hash));
            return true;
        }
        else
        {
            return false;
        }

    }

    public function verifyUser($username, $password)
    {
        $query =
            "SELECT $this->key_hash, $this->key_token, $this->key_emailVerification
             FROM $this->table_user
             WHERE $this->key_username = ?;";
        $result = $this->queryReturningResult($query, "s", array($username));

        if ($result == false)
            return "username";
        elseif($result[2] == 0)
            return "unverified";
        elseif (password_verify($password, $result[0]))
            return $result[1];
        else
            return "password";
    }

    public function getLoggedInUser($token)
    {
        $query =
            "SELECT $this->key_username
             FROM $this->table_user
             WHERE $this->key_token = ?;";
        return $this->queryReturningSingleResult($query, "s", array($token));
    }

    public function createDomain ($token, $password, $subdomain, $hostname, $tld, $linkDomain)
    {
        if ($subdomain == "")
            $domain = "$hostname.$tld";
        else
            $domain = "$subdomain.$hostname.$tld";

        $domain = strtolower($domain);

        if (!filter_var(gethostbyname($domain), FILTER_VALIDATE_IP))
            return "domaininvalid";

        $query1 =
            "SELECT $this->key_id, $this->key_username
             FROM $this->table_user
             WHERE $this->key_token = ?;";
        $userID = $this->queryReturningSingleResult($query1, "s", array($token));

        if($userID == false)
            return "tokenerror";

        if ($linkDomain == "")
            $salt = $this->randomString(256);
        else
        {
            $query2 =
                "SELECT $this->key_salt
                 FROM $this->table_keys
                 WHERE $this->key_userID = ? AND $this->key_domain = ?;";
            $salt = $this->queryReturningSingleResult($query2, "is", array($userID, $linkDomain));
        }

        $query3 =
            "SELECT 1
             FROM $this->table_keys
             WHERE $this->key_userID = ? AND $this->key_domain = ?;";
        $result = $this->queryWithoutReturningResult($query3, "is", array($userID, $domain));

        if($result)
            return "domainused";

        $query4 =
            "INSERT INTO $this->table_keys ($this->key_userID, $this->key_domain, $this->key_salt, $this->key_cost)
             VALUES (?, ?, ?, ?);";
        $this->queryWithoutReturningResult($query4, "issi", array($userID, $domain, $salt, $this->cost));

        return str_replace(array("'", "\""), "!", password_hash($password, $this->generateHashingAlgo,
            [$salt, $this->cost]));
    }


    public function createDomainFromRest ($token, $password, $domain)
    {
        $domain = strtolower($domain);

        if (!filter_var(gethostbyname($domain), FILTER_VALIDATE_IP))
            return "domaininvalid";

        $query1 =
            "SELECT $this->key_id
             FROM $this->table_user
             WHERE $this->key_token = ?;";
        $userID = $this->queryReturningSingleResult($query1, "s", array($token));

        if($userID == false)
            return "tokenerror";

        $salt = $this->randomString(256);

        $query2 =
            "SELECT 1
             FROM $this->table_keys
             WHERE $this->key_userID = ? AND $this->key_domain = ?;";
        $successful = $this->queryWithoutReturningResult($query2, "is", array($userID, $domain));

        if($successful)
            return "domainused";

        $query3 =
            "INSERT INTO $this->table_keys ($this->key_userID, $this->key_domain, $this->key_salt, $this->key_cost)
             VALUES (?, ?, ?, ?);";
        $this->queryWithoutReturningResult($query3, "issi", array($userID, $domain, $salt, $this->cost));

        return str_replace(array("'", "\""), "!", password_hash($password, $this->generateHashingAlgo,
            [$salt, $this->cost]));
    }


    public function isKeyedDomain($token, $domain)
    {
        $query1 =
            "SELECT $this->key_id
             FROM $this->table_user
             WHERE $this->key_token = ?;";
        $userID = $this->queryReturningSingleResult($query1, "s", array($token));

        if($userID == false)
            return "tokenerror";

        $query2 =
            "SELECT *
             FROM $this->table_keys
             WHERE $this->key_userID = ? AND $this->key_domain = ?;";
        $successful = $this->queryWithoutReturningResult($query2, "ss", array($userID, $domain));
        return ($successful) ? "iskeyeddomain" : "isntkeyeddomain";
    }

    public function getKeyedDomains($token)
    {
        $query1 =
            "SELECT $this->key_id
             FROM $this->table_user
             WHERE $this->key_token = ?;";
        $userID = $this->queryReturningSingleResult($query1, "s", array($token));

        if($userID == false)
            return "tokenerror";

        $query2 =
            "SELECT $this->key_domain
             FROM $this->table_keys
             WHERE $this->key_userID = ?;";
        $array = $this->queryReturningMultipleResults($query2, "s", array($userID));

        return $array;
    }

    public function generatePassword($domain, $password, $token)
    {
        $query1 =
            "SELECT $this->key_id
             FROM $this->table_user
             WHERE $this->key_token = ?;";
        $userID = $this->queryReturningSingleResult($query1, "s", array($token));

        if($userID == false)
        {
            return "tokenerror";
        }

        $query2 =
            "SELECT $this->key_salt, $this->key_cost
             FROM $this->table_keys
             WHERE $this->key_userID = ? AND $this->key_domain = ?;";
        $result = $this->queryReturningResult($query2, "is", array($userID, $domain));
        return str_replace(array("'", "\""), "!", password_hash($password, $this->generateHashingAlgo,
            [$result[0], $result[1]]));
    }

    public function resendVerification($email, $username)
    {
        $verified = intval(false);
        $emailHash = $this->randomString(32);

        $query1 =
            "UPDATE $this->table_user
             SET $this->key_emailHash = ?, $this->key_emailVerification = ?
             WHERE $this->key_email = ? OR $this->key_username = ?;";
        $this->queryWithoutReturningResult($query1, "ssss", array($emailHash, $verified, $email, $username));

        $query2 =
            "SELECT $this->key_email, $this->key_username
             FROM $this->table_user
             WHERE $this->key_email = ? OR $this->key_username = ?;";
        $result = $this->queryReturningResult($query2, "ss", array($email, $username));

        if($result != false)
        {
            $this->sendEmailVerification($emailHash, $result[0], $result[1]);
            return true;
        }
        else
            return false;
    }

    public function forgottenPassword($email, $username)
    {
        $passwordHash = $this->randomString(32);

        $query1 =
            "SELECT *
             FROM $this->table_user
             WHERE $this->key_email = ? AND $this->key_username = ?;";
        $successful = $this->queryWithoutReturningResult($query1, "ss", array($email, $username));

        if($successful)
        {
            $query2 =
                "UPDATE $this->table_user
                 SET $this->key_passwordHash = ?
                 WHERE $this->key_email = ? AND $this->key_username = ?;";
            $this->queryWithoutReturningResult($query2, "sss", array($passwordHash, $email, $username));
            $this->sendPasswordReset($passwordHash, $email, $username);
            return true;
        }
        else
            return false;
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
or you can simply ignore it and continue using your account as normal.

To cancel the password reset request:

https://www.cryptmate.com/resetpassword.php?email=' . $email . '&cancelreset=true

Thanks!

CryptMate';

        $headers = 'From: admin@cryptmate.com' . "\r\n";
        mail($to, $subject, $message, $headers);
    }

    public function checkResetPassword($email, $passwordHash)
    {
        $query =
            "SELECT *
             FROM $this->table_user
             WHERE $this->key_email = ? AND $this->key_passwordHash = ?;";
        $success = $this->queryWithoutReturningResult($query, "ss", array($email, $passwordHash));
        return $success;
    }


    public function cancelResetPassword($email)
    {
        $query =
            "UPDATE $this->table_user
             SET $this->key_passwordHash = NULL
             WHERE $this->key_email = ?;";
        return $this->queryReturningAffectedRows($query, "s", array($email)) == 1;
    }

    public function resetPassword($password, $hash, $email)
    {
        $query =
            "UPDATE $this->table_user
             SET $this->key_hash = ?
             WHERE $this->key_email = ? AND $this->key_passwordHash = ?;";
        $passHash = password_hash($password, $this->cryptMateHashingAlgo);
        return $this->queryReturningAffectedRows($query, "sss", array($passHash, $email, $hash)) == 1;
    }


    public function remindUsername($email)
    {
        $query =
            "SELECT $this->key_name, $this->key_username
             FROM $this->table_user
             WHERE $this->key_email = ?;";
        $result = $this->queryReturningResult($query, "s", array($email));

        if ($result != false)
            $this->sendUsername($email, $result[0], $result[1]);

        return $result;
    }

    private function sendUsername($email, $name, $username)
    {
        $to      = $email;
        $subject = 'CryptMate Username Reminder';
        $message = 'Dear ' . $name . '

Somebody has requested a username reminder for your account

If this was you, your username is ' . $username . '

If this was not you, please ignore this email.

Thanks!

CryptMate';

        $headers = 'From: admin@cryptmate.com' . "\r\n";
        mail($to, $subject, $message, $headers);
    }

    public function getNumberDomains($token)
    {
        $query1 =
            "SELECT $this->key_id
             FROM $this->table_user
             WHERE $this->key_token = ?;";
        $userID = $this->queryReturningSingleResult($query1, "s", array($token));

        if($userID == false)
            return 0;

        $query2 =
            "SELECT COUNT(*)
             FROM $this->table_keys
             WHERE $this->key_userID = ?";
        $count = $this->queryReturningSingleResult($query2, "i", array($userID));

        if ($count == false)
            return 0;
        else
            return $count;
    }

    public function deleteDomain($domain, $token)
    {
        $query1 =
            "SELECT $this->key_id
             FROM $this->table_user
             WHERE $this->key_token = ?;";
        $userID = $this->queryReturningSingleResult($query1, "s", array($token));

        if($userID == false)
            return false;

        $query2 =
            "DELETE FROM $this->table_keys
             WHERE $this->key_userID = ? AND $this->key_domain = ?;";
        $rows = $this->queryReturningAffectedRows($query2, "is", array($userID, $domain));

        return ($rows == 1);
    }

    public function deleteAccount($token)
    {
        $query =
            "DELETE FROM $this->table_user
             WHERE $this->key_token = ?;";
        $rows = $this->queryReturningAffectedRows($query, "s", array($token));
        return ($rows >= 1);
    }

    public function getAccountDetails($token)
    {
        $query =
            "SELECT $this->key_name, $this->key_username, $this->key_email
             FROM $this->table_user
             WHERE $this->key_token = ?;";
        $result = $this->queryReturningSingleResult($query, "s", array($token));
        return
            array(
                "name" => $result[0],
                "username" => $result[1],
                "email" => $result[2]
            );
    }

    public function verifyNewEmail($email, $hash)
    {
        $verified = intval(true);
        $query1 =
            "SELECT $this->key_token
             FROM $this->table_emailConfirmations
             WHERE $this->key_email1 = ? AND $this->key_hash1 = ? ;";
        $token = $this->queryReturningSingleResult($query1, "ss", array($email, $hash));
        if ($token != false)
        {
            $query2 =
                "UPDATE $this->table_emailConfirmations
                 SET $this->key_verification1 = ?
                 WHERE $this->key_email1 = ? AND $this->key_hash1 = ?;";
            $this->queryWithoutReturningResult($query2, "sss", array($verified, $email, $hash));
            $updated = 1;
        }
        else
        {
            $query2 =
                "SELECT $this->key_token
                 FROM $this->table_emailConfirmations
                 WHERE $this->key_email2 = ? AND $this->key_hash2 = ?;";
            $token = $this->queryReturningSingleResult($query2, "ss", array($email, $hash));
            if ($token != false)
            {
                $query3 =
                    "UPDATE $this->table_emailConfirmations
                     SET $this->key_verification2 = ?
                     WHERE $this->key_email2 = ? AND $this->key_hash2 = ?";
                $this->queryWithoutReturningResult($query3, "sss", array($verified, $email, $hash));
                $updated = 2;
            }
            else
            {
                return 4;
            }
        }

        if (isset($token))
        {
            $query4 =
                "SELECT $this->key_verification1, $this->key_verification2, $this->key_email2
                 FROM $this->table_emailConfirmations
                 WHERE $this->key_token = ?;";
            $result = $this->queryReturningResult($query4, "s", array($token));
            $verified1 = $result[0];
            $verified2 = $result[1];
            $email2 = $result[2];

            if ($verified1 == intval(true) && $verified2 == intval(true))
            {
                $query5 =
                    "UPDATE $this->table_user
                     SET $this->key_email = ?
                     WHERE $this->key_token = ?;";
                $this->queryWithoutReturningResult($query5, "ss", array($email2, $token));
                return 3;
            }
            else
                return $updated;

        }

        //should never be reached
        return null;
    }

    public function isCurrentEmail($token, $currentEmail)
    {
        $query =
            "SELECT 1
             FROM $this->table_user
             WHERE $this->key_email = ? AND $this->key_token = ?;";
        $successful = $this->queryWithoutReturningResult($query, "ss", array($currentEmail, $token));
        return $successful;
    }

    public function isNewEmail($email)
    {
        $query =
            "SELECT 1
             FROM $this->table_user
             WHERE $this->key_email = ?";
        $hasResult = $this->queryWithoutReturningResult($query, "s", array($email));
        return !$hasResult;
    }


    public function changeEmail($token, $currentEmail, $newEmail)
    {
        $verified = intval(false);
        $hash1 = $this->randomString(32);
        $hash2 = $this->randomString(32);

        $query1 =
            "INSERT INTO $this->table_emailConfirmations
                  ($this->key_token, $this->key_email1, $this->key_hash1, $this->key_verification1,
                   $this->key_email2, $this->key_hash2, $this->key_verification2)
             VALUES (?, ?, ?, ?, ?, ?, ?);";
        $rows = $this->queryReturningAffectedRows($query1, "sssissi",
            array($token, $currentEmail, $hash1, $verified, $newEmail, $hash2, $verified));

        if ($rows != 1)
            return false;

        $query2 =
            "SELECT $this->key_name
             FROM $this->table_user
             WHERE $this->key_token = ?;";
        $name = $this->queryReturningSingleResult($query2, "s", array($token));

        if ($name == false)
            return false;

        $this->sendCurrentEmailVerification($hash1, $currentEmail, $name);
        $this->sendNewEmailVerification($hash2, $newEmail, $name);
        return true;
    }


    //TODO: create enum for magic numbers
    public function changePassword($oldPassword, $newPassword, $token)
    {
        $query1 =
            "SELECT $this->key_hash
             FROM $this->table_user
             WHERE $this->key_token = ?;";
        $hash = $this->queryReturningSingleResult($query1, "s", array($token));

        if ($hash != false)
        {
            if (password_verify($oldPassword, $hash))
            {
                $newHash = password_hash($newPassword, $this->cryptMateHashingAlgo);

                $query2 =
                    "UPDATE $this->table_user
                     SET $this->key_hash = ?
                     WHERE $this->key_token = ?";
                $rows = $this->queryReturningAffectedRows($query2, "ss", array($newHash, $token));
                if ($rows == 1)
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
        $query =
            "SELECT DATE_FORMAT($this->key_subscriptionEnd,'%D %M %Y')
             FROM $this->table_user
             WHERE $this->key_token = ?;";
        return $this->queryReturningSingleResult($query, "s", array($token));
    }

    public function getSubscriptionEndUnix($token)
    {
        $query =
            "SELECT UNIX_TIMESTAMP($this->key_subscriptionEnd)
             FROM $this->table_user
             WHERE $this->key_token = ?;";
        return $this->queryReturningSingleResult($query, "s", array($token));
    }

    public function getSubscriptionEnded($token)
    {
        $query =
            "SELECT $this->key_subscriptionEnd < CURRENT_DATE()
             FROM $this->table_user
             WHERE $this->key_token = ?;";
        return $this->queryReturningSingleResult($query, "s", $token);
    }

    public function addOneMonth($customerID)
    {
        $this->addInterval("INTERVAL 1 MONTH", $customerID);
    }

    public function addOneYear($customerID)
    {
        $this->addInterval("INTERVAL 1 YEAR", $customerID);
    }

    private function addInterval($interval, $customerID)
    {
        $payerToken = $this->getTokenFromCustomer($customerID);
        if ($this->getSubscriptionEnded($payerToken))
            $query =
                "UPDATE $this->table_user
                 SET $this->key_subscriptionEnd = DATE_ADD(now(), $interval)
                 WHERE $this->key_token = ?;";
        else
            $query =
                "UPDATE $this->table_user
                 SET $this->key_subscriptionEnd = DATE_ADD($this->key_subscriptionEnd, $interval)
                 WHERE $this->key_token = ?;";
        $this->queryWithoutReturningResult($query, "s", array($payerToken));
    }

    private function getTokenFromCustomer($customerID)
    {
        $query1 =
            "SELECT $this->key_userID
             FROM $this->table_stripe
             WHERE $this->key_customerID = ?;";
        $user_id = $this->queryReturningSingleResult($query1, "s", $customerID);

        $query2 =
            "SELECT $this->key_token
             FROM $this->table_user
             WHERE $this->key_id = ?;";

        return $this->queryReturningSingleResult($query2, "s", $user_id)["token"];
    }

    private function getUserIDFromToken($token)
    {
        $query =
            "SELECT $this->key_id
             FROM $this->table_user
             WHERE $this->key_token = ?;";
        return $this->queryReturningSingleResult($query, "s", array($token));
    }


    public function addStripeCustomerDetails($token, $customerID, $plan)
    {
        $user_id = $this->getUserIDFromToken($token);
        $query =
            "INSERT INTO $this->table_stripe
                ($this->key_userID, $this->key_customerID, $this->key_plan)
             VALUES
                (?, ?, ?);";
        $this->queryWithoutReturningResult($query, "iss", array($user_id, $customerID, $plan));
    }

    public function getStripeCustomerDetails($token)
    {
        $user_id = $this->getUserIDFromToken($token);
        $query =
            "SELECT $this->key_customerID
             FROM $this->table_stripe
             WHERE $this->key_userID = ?;";
        return $this->queryReturningSingleResult($query, "i", array($user_id));
    }

    private function queryReturningSingleResult($query, $types, $params) {
        $result = $this->queryReturningResult($query, $types, $params);
        if ($result != false)
            return $result[0];
        else
            return false;
    }

    private function queryReturningResult($query, $types, $params) {
        $stmt = $this->connection->prepare($query);
        call_user_func_array(array($stmt, "bind_param"), array_merge(array($types), $params));
        $stmt->execute();
        $result = $stmt->get_result()->fetch_array();
        $successful = $stmt->fetch();
        $stmt->close();
        if ($successful)
            return $result;
        else
            return false;
    }

    private function queryWithoutReturningResult($query, $types, $params) {
        $stmt = $this->connection->prepare($query);
        call_user_func_array(array($stmt, "bind_param"), array_merge(array($types), $params));
        $stmt->execute();
        $successful = $stmt->fetch();
        $stmt->close();
        return $successful;
    }

    private function queryReturningAffectedRows($query, $types, $params) {
        $stmt = $this->connection->prepare($query);
        call_user_func_array(array($stmt, "bind_param"), array_merge(array($types), $params));
        $stmt->execute();
        $rows = $stmt->affected_rows;
        $stmt->close();
        return $rows;
    }

    private function queryReturningMultipleResults($query, $types, $params) {
        $stmt = $this->connection->prepare($query);
        call_user_func_array(array($stmt, "bind_param"), array_merge(array($types), $params));
        $stmt->execute();
        $stmt->bind_result($result);
        $array = [];
        while ($stmt->fetch())
            array_push($array, $result);
        $stmt->close();
        return $array;
    }

    private function randomString($length, $type = '')
    {
        // Select which type of characters you want in your random string
        switch($type) {
            case 'num':
                // Use only numbers
                $salt = '1234567890';
                break;
            case 'lower':
                // Use only lowercase letters
                $salt = 'abcdefghijklmnopqrstuvwxyz';
                break;
            case 'upper':
                // Use only uppercase letters
                $salt = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
                break;
            default:
                // Use uppercase, lowercase, numbers, and symbols
                $salt = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890';
                break;
        }
        $rand = '';
        $i = 0;
        while ($i < $length) { // Loop until you have met the length
            $num = rand() % strlen($salt);
            $tmp = substr($salt, $num, 1);
            $rand = $rand . $tmp;
            $i++;
        }
        return $rand; // Return the random string
    }
}