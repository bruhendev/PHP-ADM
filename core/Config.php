<?php

namespace Core;

abstract class Config {

    protected function configAdm() {
        define('URL', 'http://localhost:8000/');
        define('URLADM', 'http://localhost:8000/');

        define('CONTROLLER', 'Login');
        define('METODO', 'index');
        define('CONTROLLERERRO', 'Erro');
        
        define('EMAILADM', 'bruno@email.com');
        
        //Credenciais de acesso ao Banco de Dados
        define('DB', 'mysql');
        define('HOST', 'db');
        define('USER', 'root');
        define('PASS', '123456');
        define('DBNAME', 'adm');
        define('PORT', 3306);
        
        // echo "<pre>"; var_dump("Script: xxxxxxxx, Linha: xxxx ", $this->xxxxxxx); echo "</pre>";
        
    }

}