<?php

namespace App\adms\Controllers;

class Login
{
    private $data;
    private $dataForm;

    public function index()
    {
        $this->dataForm = filter_input_array(INPUT_POST, FILTER_DEFAULT);

        if (!empty($this->dataForm["SendLogin"])) {
            $valLogin = new \App\adms\Models\AdmsLogin();
            $valLogin->login($this->dataForm);

            if ($valLogin->getResult()) {
                $urlDestino = "http://localhost:8000/dashboard/index";
                header("Location: http://localhost:8000/dashboard/index");
            }
            $this->data['form'] = $this->dataForm;
        }

        //$this->data = null;

        $loadView = new \Core\ConfigView('adms/views/login/access', $this->data);
        $loadView->loadView();
    }
}
