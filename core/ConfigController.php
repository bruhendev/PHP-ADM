<?php

namespace Core;

use Adms\Login;

class ConfigController extends Config
{
    private string $url;
    private array $urlConjunto;
    private string $urlController;
    private string $slugController;
    private string $urlMetodo;
    private string $slugMetodo;
    private string $urlParametro;
    private array $format;
    private string $classe;

    public function __construct()
    {
        $this->configAdm();

        if (!empty(filter_input(INPUT_GET, 'url', FILTER_DEFAULT))) {
            $this->url = filter_input(INPUT_GET, 'url', FILTER_DEFAULT);

            $this->clearUrl();

            // Transforma a url recebida, em um array
            $this->urlConjunto = explode("/", $this->url);

            // Verifica se há um controller e converte para minúsculo
            if (isset($this->urlConjunto[0])) {
                // Coloca o controller (uma classe) em um formato válido
                $this->urlController = $this->slugController($this->urlConjunto[0]);
            } else {
                //Se não existir um controller, o controlle padrão será a constante CONTROLLER (=Login)
                $this->urlController = $this->slugController(CONTROLLER);
            }

            // Verifica se há um método e convete para minúsculo
            if (isset($this->urlConjunto[1])) {
                //Coloca o método(um método) em um formato válido
                $this->urlMetodo = $this->slugMetodo($this->urlConjunto[1]);
            } else {
                //Se o usuário não definir o método, é definido o controller e o método
                //Se não existir um método, o método padrão será a constante METODO (=access)
                $this->urlController = $this->slugController(CONTROLLER);
                $this->urlMetodo = $this->slugMetodo(METODO);
            }

            // Verifica se há um parâmetro
            if (isset($this->urlConjunto[2])) {
                $this->urlParametro = $this->urlConjunto[2];
            } else {
                $this->urlParametro = "";
            }
        } else {
            $this->urlController = $this->slugController(CONTROLLER);
            $this->urlMetodo = $this->slugMetodo(METODO);
            $this->urlParametro = "";
        }

    }

    /**
     * Formatar a Controller recebida da URL
     *
     * @param string $slugController
     * @return string
     */
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

    /**
     * Limpar a URL recebida
     *
     * @return void
     */
    private function clearUrl(): void
    {
        // Eliminar as tags
        $this->url = strip_tags($this->url);
        //Eliminar a barra no final da URL
        $this->url = trim($this->url);
        //Eliminar a barra no final da URL
        $this->url = rtrim($this->url, "/");

        $this->format['a'] = 'ÀÁÂÃÄÅÆÇÈÉÊËÌÍÎÏÐÑÒÓÔÕÖØÙÚÛÜüÝÞßàáâãäåæçèéêëìíîïðñòóôõöøùúûýýþÿRr"!@#$%&*()_-+={[}]?;:.,\\\'<>°ºª ';
        $this->format['b'] = 'aaaaaaaceeeeiiiidnoooooouuuuuybsaaaaaaaceeeeiiiidnoooooouuuyybyRr--------------------------------';
        $this->url = strtr(iconv("UTF-8", "ISO-8859-1", $this->url), iconv("UTF-8", "ISO-8859-1", $this->format['a']), $this->format['b']);
    }

    /**
     * Função responsavel por invocar o Controller e a Método
     *
     * @return void
     */
    public function loadPage()
    {
       
        //Define o caminho da classe depois de "sanitizada pelo constructor"
        $this->classe = "\\App\\adms\\Controllers\\" . $this->urlController;
        //Instancia a classe através de um obojeto, seu nome + ()
        $classeCarregar = new $this->classe();
        //Invoca o método da classe, seu nome + ()
        $classeCarregar->{$this->urlMetodo}();
    }
}
