<?php

namespace App\adms\Controllers;

class ViewUsers
{
    public function index()
    {
       $loadView = new \Core\ConfigView('adms/views/users/viewUser');
       $loadView->loadView();
    }
}