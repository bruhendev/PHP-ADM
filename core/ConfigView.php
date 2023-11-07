<?php

namespace Core;

/**
 * Carregar as páginas da View
 */
class ConfigView
{


    public function __construct(private string $nameView)
    {
    }

    public function loadView(): void
    {
        if (file_exists('app/' . $this->nameView . '.php')) {
            include 'app/' . $this->nameView . '.php';
        } else {
           die('Erro: Página não encontada');
        }
    }
}
