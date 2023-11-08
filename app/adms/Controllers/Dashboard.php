<?php

namespace App\adms\Controllers;

class Dashboard
{
    public function index()
    {
        $loadView = new \Core\ConfigView('adms/views/dashboard/home');
        $loadView->loadView();
    }
}
