<?php

namespace App\adms\Models;

use App\adms\Models\helper\AdmsConn;
use PDO;

class AdmsLogin extends AdmsConn
{
    private array|null $data;
    private $resultDB;
    private bool $result;

    /**
     * Get the value of result
     */
    public function getResult(): bool
    {
        return $this->result;
    }

    public function login(array $data = null)
    {
        $this->data = $data;

        $conn = $this->connectDB();

        $sql = "SELECT id, name, nickname, email, password, image FROM adms_users where user = ? LIMIT 1";

        $stm = $conn->prepare($sql);
        $stm->bindValue(1, $this->data['user'], PDO::PARAM_STR);

        $stm->execute();

        $this->resultDB = $stm->fetch();

        // var_dump($this->resultDB['password']); die();

        if ($this->resultDB) {
            $this->validarSenha();
        } else {
            $_SESSION['msg'] = "<p>Erro: Usuário não encontrado</p>";
            $this->result = false;
        }
    }

    private function validarSenha()
    {
        //Vefifica se o que a senha que o usuário digitou no fomulário é igual a que existe vindo do banco de dados
        if (password_verify($this->data['password'], $this->resultDB['password'])) {
            //Salvando os dados do usuário na sessão
            $_SESSION['user_id'] = $this->resultDB['id'];
            $_SESSION['user_name'] = $this->resultDB['name'];
            $_SESSION['user_nickname'] = $this->resultDB['nickname'];
            $_SESSION['user_email'] = $this->resultDB['email'];
            $_SESSION['user_image'] = $this->resultDB['image'];

            return $this->result = true;
        } else {
            $_SESSION['msg'] = "Erro: Usuário e/ou Senha incorreta!<br><br>";
            return $this->result = false;
        }
    }
}
