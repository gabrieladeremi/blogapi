<?php

class Database
{
    // DB PARAMS
    private $host =  'localhost';
    private  $db_name = 'myblog';
    private $username = 'root';
    private $password = '';
    private $conn;

    // DB CONNECT
    public function connect()
    {
        $this->conn = null;

        try {
            //connection to db
            $this->conn = new PDO(
                'mysql:host=' . $this->host . ';dbname=' . $this->db_name,
                $this->username,
                $this->password
            );
            // get error when query goes wrong
            $this->conn->setAttribute(
                PDO::ATTR_ERRMODE,
                PDO::ERRMODE_EXCEPTION
            );

        } catch (PDOException $exception) {
            echo 'Connection Error: ' . $exception->getMessage();
        }

        return $this->conn;
    }
}