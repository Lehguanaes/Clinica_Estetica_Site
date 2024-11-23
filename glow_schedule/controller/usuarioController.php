<?php

require_once $_SERVER['DOCUMENT_ROOT'] . "/glow_schedule/controller/global.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/glow_schedule/controller/conexao.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/glow_schedule/model/cliente/cliente.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/glow_schedule/model/message.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/glow_schedule/model/atendente/atendente.php"; 
require_once $_SERVER['DOCUMENT_ROOT'] . "/glow_schedule/model/esteticista/esteticista.php";

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$mensagem = new Message($BASE_URL);
$acao = filter_input(INPUT_POST, "acao");
$conexaoMini = new Conexao();
$conexao = $conexaoMini->getConexao(); 

if ($acao == "login") {
    $email = filter_input(INPUT_POST, "email");
    $senha = filter_input(INPUT_POST, "senha");

    function BuscarPorEmail($email, $conexao) {
        if ($email != "") {
            echo "Procurando e-mail: $email\n";
            
            $stmt1 = $conexao->prepare("SELECT * FROM atendente WHERE `email_atendente` = ?");
            $stmt1->bind_param('s', $email);
            $stmt1->execute();
            $resultado1 = $stmt1->get_result();

            $stmt2 = $conexao->prepare("SELECT * FROM esteticista WHERE `email_esteticista` = ?");
            $stmt2->bind_param('s', $email);
            $stmt2->execute();
            $resultado2 = $stmt2->get_result();

            $stmt3 = $conexao->prepare("SELECT * FROM cliente WHERE `email_cliente` = ?");
            $stmt3->bind_param('s', $email);
            $stmt3->execute();
            $resultado3 = $stmt3->get_result();

            
            if ($resultado1->num_rows > 0) {
                $usuario = $resultado1->fetch_assoc();
                $usuario['tipo'] = 'atendente';
                return $usuario;
            } elseif ($resultado2->num_rows > 0) {
                $usuario = $resultado2->fetch_assoc();
                $usuario['tipo'] = 'esteticista';
                return $usuario;
            } elseif ($resultado3->num_rows > 0) {
                if ($resultado3->num_rows > 1) {
                    echo "Erro: e-mail duplicado encontrado para cliente.\n";
                    return null;
                } // fzr esse if pra todos os 3 tipos de select
                $usuario = $resultado3->fetch_assoc();
                $usuario['tipo'] = 'cliente';
                return $usuario;
            } else {
                    echo "email nao achado"; // trocar pra message
            }
        }
        return null;
    }

    function autenticarUser($conexao, $email, $senha) {
        $usuario = BuscarPorEmail($email, $conexao);
        
        if ($usuario === null) {
            return null;
        }
        switch ($usuario['tipo']) {
            case 'atendente':
                if (password_verify($senha, $usuario['senha_atendente'])) {
                    echo "Senha verificada com sucesso para atendente.\n";
                    return $usuario;
                }
                break;
            case 'esteticista':
                if (password_verify($senha, $usuario['senha_esteticista'])) {
                    echo "Senha verificada com sucesso para esteticista.\n";
                    return $usuario;
                }
                break;
            case 'cliente':
                if (password_verify($senha, $usuario['senha_cliente'])) {
                    echo "Senha verificada com sucesso para cliente.\n";
                    return $usuario;
                }
                break;
        }
        return null;
    }

    $usuario = autenticarUser($conexao, $email, $senha);

    if ($usuario != null) {
        $_SESSION['usuario_tipo'] = $usuario['tipo'];
        switch ($usuario['tipo']) {
            case 'atendente':
                $_SESSION['usuario_token'] = $usuario['token_atendente'];
                $mensagem->setMessage("Login realizado", "Bem-vindo(a) de volta atendente " . $usuario['nome_atendente'], "success", "../atendente/perfilAtendente.php");
                break;
            case 'esteticista':
                $_SESSION['usuario_token'] = $usuario['token_esteticista'];
                $mensagem->setMessage("Login realizado", "Bem-vindo(a) de volta esteticista " . $usuario['nome_esteticista'], "success", "../esteticista/perfilEsteticista.php");
                break;
            case 'cliente':
                $_SESSION['usuario_token'] = $usuario['token_cliente'];
                $mensagem->setMessage("Login realizado", "Bem-vindo(a) de volta cliente " . $usuario['nome_cliente'], "success", "../cliente/perfilCliente.php");
                break;
        }
        
    } else {
        $mensagem->setMessage("Login falhou", "Senha ou email incorretos ", "error", "../login.php");
    }
}
?>
