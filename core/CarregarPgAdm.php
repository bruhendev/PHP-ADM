<?php

namespace Core;

class CarregarPgAdm
{
    private string $urlController;
    private string $urlMetodo;
    private string $urlParametro;
    private string $slugController;
    private string $slugMetodo;
    private $classe;
    private array $pgPublica;
    private array $pgRestrita;

    public function loadPage(string|null $urlController, string|null $urlMetodo, string|null $urlParametro)
    {
        $this->urlController = $urlController;
        $this->urlMetodo = $urlMetodo;
        $this->urlParametro = $urlParametro;

        var_dump($this->urlController);
        var_dump($this->urlMetodo);
        var_dump($this->urlParametro);

        $this->pgPublica();

        if (class_exists($this->classe)) {
            $this->loadMetodo();
        } else {
            echo "teste";
            $this->urlController = $this->slugController(CONTROLLER);
            $this->urlMetodo = $this->slugMetodo(METODO);
            $this->urlParametro = "";
            $this->classe = "\\App\\adms\\Controllers\\" . $this->urlController;
            $this->loadMetodo();
        }
    }

    private function loadMetodo()
    {
        // Instancia um objeto. É necessário neste ponto, acrescentar o (), pois $this->classe só possui até então,
        // o caminho: "\\App\\adms\\Controllers\\".nome_da_classe
        $classeCarregar = new $this->classe();
        // Se a classe existir e o método não, o programa é abortado, caso contrário, o método é invocado. Observe que como
        // a classe, é necessário acrescentar (), pois também só temos o nome do método
        if (method_exists($classeCarregar, $this->urlMetodo)) {
            // $classeCarregar->{$this->urlMetodo}(); Antes de visulizar detalhes do usuáiro, não utilizava parâmetro
            $classeCarregar->{$this->urlMetodo}($this->urlParametro);
        } else {
            die('Erro (Método): Por favor tente novamente. Caso o erro persista entre em contato com o administrador: ' . EMAILADM . '<br>');
        }
    }

    private function pgPublica()
    {
        $this->pgPublica = ["Login", "Logout", "NewUser", "ConfEmail", "NewConfEmail", "RecoverPassword", "UpdatePassword"];

        if (in_array($this->urlController, $this->pgPublica)) {
            $this->classe = "\\App\\adms\\Controllers\\" . $this->urlController;
        } else {
            $this->pgRestrita();
        }
    }

    private function pgRestrita()
    {
        $this->pgRestrita = ["Dashboard", "ListUsers", "ViewUsers", "AddUsers", "EditUsers", "EditUsersPassword", "EditUsersImage"];

        if (in_array($this->urlController, $this->pgRestrita)) {
            // Corrigir o erro da funcao class_exists
            $this->classe = "";
            $this->verificarLogin();

        } else {
            $this->classe = "";
            $_SESSION['msg'] = "Erro: Página não encontrada!<br>";
            $urlDestino = URLADM . "login/index";
            header("Location: $urlDestino");
        }
    }

    public function verificarLogin()
    {
        if (isset($_SESSION['user_id']) and isset($_SESSION['user_name']) and isset($_SESSION['user_email'])) {
            $this->classe = "\\App\\adms\\Controllers\\" . $this->urlController;
        } else {
            $_SESSION['msg'] = "Erro: Para acessar a página realize o login!<br>";
            $urlDestino = URLADM . "login/index";
            header("Location: $urlDestino");
        }
    }

    private function slugController(string $slugController): string
    {
        // Converte para minusculo
        $this->slugController = strtolower($slugController);
        // Substituir o traço para espaço em branco
        $this->slugController = str_replace("-", " ", $this->slugController);
        // Coloca a primeira letra da cada palavra do controller em maiúscula
        $this->slugController = ucwords($this->slugController);
        // Retira os espaços em branco
        $this->slugController = str_replace(" ", "", $this->slugController);

        return $this->slugController;
    }

    /**
     * Formatar o método recebido da URL
     *
     * @param string $slugMetodo
     * @return string
     */
    private function slugMetodo(string $slugMetodo): string
    {
        //Converter para minúsculo  
        $this->slugMetodo = strtolower($slugMetodo);
        //Substituir o traço para espaço em branco 
        $this->slugMetodo = str_replace("-", " ", $this->slugMetodo);
        //Converter a primeira letra de cada palavra do controller em maiúscula
        $this->slugMetodo = ucwords($this->slugMetodo);
        //Retirar os espaços em branco
        $this->slugMetodo = str_replace(" ", "", $this->slugMetodo);
        //Converter a primeira letra para minúscula
        $this->slugMetodo = lcfirst($this->slugMetodo);

        return $this->slugMetodo;
    }
}
