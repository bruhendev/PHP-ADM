<?php

namespace App\adms\Models;

use App\adms\Models\helper\AdmsConn;

class AdmsLogin extends AdmsConn
{
    private array|null $data;

    public function login(array $data= null)
    {
        $this->data = $data;
        var_dump($this->data);

        $this->connectDB();
    }
}