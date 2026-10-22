<?php

class Database {

    private $host = "localhost";
    private $dbname = "salon_booking";
    private $username = "root";
    private $password = "";

    public function connect() {

        $pdo = new PDO(
            "mysql:host=$this->host;dbname=$this->dbname;charset=utf8mb4",
            $this->username,
            $this->password
        );

        return $pdo;
    }
}