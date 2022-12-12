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


    public function createUser($username, $password)
    {
        $salt = mcrypt_create_iv(256, MCRYPT_DEV_URANDOM);
        $token = mcrypt_create_iv(256, MCRYPT_DEV_URANDOM);
        $iterationCount = ITERATIONCOUNT;
        $hash = hash_pbkdf2($this->hashingAlgo, $password, $salt, $iterationCount);

        $sql =
            "INSERT INTO $this->table_user ($this->key_username, $this->key_hash, $this->key_salt, $this->key_iterationcount, $this->key_token)
             VALUES (?, ?, ?, ?);";

        $stmt = $this->connection->prepare($sql);
        $stmt->bind_param("sssis", $username, $hash, $salt, $iterationCount, $token);
        $stmt->execute();
        $stmt->close();

        return $token;
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
}