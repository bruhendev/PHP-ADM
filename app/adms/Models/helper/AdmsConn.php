<?php

namespace App\adms\Models\helper;

use PDO;

class AdmsConn
{
    private string $db = DB;
    private string $host = HOST;
    private string $user = USER;
    private string $pass = PASS;
    private string $dbName = DBNAME;
    private int|string $port = PORT;
    private object $connect;

    public function connectDB()
    {
        try {
            // $this->connect = new PDO("{$this->db}:host={$this->host};port={$this->port};dbname=" . $this->dbName, $this->user, $this->pass);
            $this->connect = new PDO("mysql:host=db;dbname=adm;port=3306", "root", "123456");
            echo "Conexão...Ok!";
            return $this->connect;
        } catch (\PDOException $err) {
            die("Error: Por favor tente novamente");
        }
    }
}
