<?php

namespace App\adms\Models\helper;

use PDO;

class AdmsConn
{
    
    private string $host = HOST;
    private string $user = USER;
    private string $pass = PASS;
    private string $dbName = DBNAME;
    private int|string $port = PORT;
    private object $connect;

    public function connectDB(): PDO
    {
        try {
            $this->connect = new PDO("mysql:host={$this->host};dbname={$this->dbName};port={$this->port}", $this->user, $this->pass);
            //echo "Conexão...Ok!";
            return $this->connect;
        } catch (\PDOException $err) {
            die("Error: Por favor tente novamente");
        }
    }
}
