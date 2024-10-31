<?php

require_once $_SERVER['DOCUMENT_ROOT'] . "/glow_schedule/model/esteticista.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/glow_schedule/model/atendente.php";

class UsuarioController {
    public function __construct() {
        if (isset($_POST['acao']) && $_POST['acao'] === 'login') {
            $this->autenticarUsuario($_POST['email'], $_POST['senha']);
        }
    }

    private function autenticarUsuario($email, $senha) {
        // Inicializa os models
        $esteticista = new Esteticista();
        $atendente = new Atendente();

        // Verifica o domínio do email para decidir qual tabela consultar
        if (strpos($email, '@esteticista.com') !== false) {
            // Autenticar como esteticista

            $usuarioEsteticista = $esteticista->entrarE($email, $senha);//variavel UsuariEsteticista armazena os resultados do login
            if ($usuarioEsteticista) {
                $_SESSION['usuario'] = $usuarioEsteticista;
                header("Location: /glow_schedule/esteticistas.php");
                exit();
            }
        } elseif (strpos($email, '@atendente.com') !== false) {
            // Autenticar como atendente
            $usuarioAtendente = $atendente->entrarA($email, $senha);
            if ($usuarioAtendente) {
                $_SESSION['usuario'] = $usuarioAtendente;
                header("Location: /glow_schedule/esteticistas.php");
                exit();
            }
        }

        // Se nenhuma autenticação for bem-sucedida
        header("Location: /glow_schedule/login.php?error=1");
        exit();
    }
}

new UsuarioController();
?>
