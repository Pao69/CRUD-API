<?php

class Db
{
    protected $conn;

    public function __construct()
    {
        $host = "localhost";
        $db_name = "car_dealership";
        $user = "root";
        $pass = "";


        try {
            $this->conn = new PDO("mysql:host=$host;dbname=$db_name;", $user, $pass);
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            die($e->getMessage());
        }
    }
}
