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
    private $table_keys = "keys";
    private $table_user = "user";

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
        $hash = hash_pbkdf2("sha256", $password, $salt, $iterationCount);

        $sql =
            "INSERT INTO ? (Username, Hash, Salt, IterationCount, Token)
             VALUES (?, ?, ?, ?);";

        $stmt = $this->connection->prepare($sql);
        $stmt->bind_param("ssssis", $this->table_user, $username, $hash, $salt, $iterationCount, $token);
        $stmt->execute();
    }

    public function verifyUser($username, $password)
    {

        $sql =
            "SELECT *
             FROM ?
             WHERE Username = ?;";

        $stmt = $this->connection->prepare($sql);
        $stmt->bind_param("ss", $this->table_user, $username);
        $stmt->execute();

        if(mysqli_stmt_num_rows($stmt) == 0)
        {
            return "username";

        }

        $result = $stmt->fetch();

        if (hash_pbkdf2("sha256", $password, $result["Salt"], $result["IterationCount"]) == $result["Hash"])
        {
            return $result["Token"];
        }

        return "password";
    }

    public function newEncryption ($token, $password, $subdomain, $hostname, $tld)
    {
        $domain = "$subdomain.$hostname.$tld";

        $sql =
            "SELECT *
             FROM ?
             WHERE Token = ?;";

        $stmt = $this->connection->prepare($sql);
        $stmt->bind_param("ss", $this->table_user, $token);
        $stmt->execute();

        if(mysqli_stmt_num_rows($stmt) == 0)
        {
            return "tokenerror";
        }

        $result = $stmt->fetch();

        $username = $result["Username"];
        $userid = $result["ID"];
        $salt = mcrypt_create_iv(256, MCRYPT_DEV_URANDOM);
        $iterationCount = ITERATIONCOUNT;

        $sql =
            "INSERT INTO ? (UserID, Domain, Username, Salt, IterationCount)
             VALUES (?, ?, ?, ?, ?);";

        $stmt = $this->connection->prepare($sql);
        $stmt->bind_param("sisssi", $this->table_keys, $userid, $domain, $username, $salt, $iterationCount);
        $stmt->execute();

        return hash_pbkdf2("sha256", $password, $salt, $iterationCount);
    }
}