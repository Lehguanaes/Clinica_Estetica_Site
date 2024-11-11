<?php

require_once $_SERVER['DOCUMENT_ROOT'] . "/glow_schedule/controller/global.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/glow_schedule/controller/conexao.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/glow_schedule/model/cliente/cliente.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/glow_schedule/model/message.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/glow_schedule/model/atendente/atendente.php"; 
require_once $_SERVER['DOCUMENT_ROOT'] . "/glow_schedule/model/esteticista/esteticista.php";

if(session_status() === PHP_SESSION_NONE){
    session_start();
}

$mensagem = new Message($BASE_URL);

$acao = filter_input(INPUT_POST, "acao");
$conexaoMini = new Conexao();
$conexao = $conexaoMini->getConexao();     
 
 
if ($acao == "login") {

    $email = filter_input(INPUT_POST, "email");
    $senha = filter_input(INPUT_POST, "senha");

    function BuscarPorEmail($email, $conexao){
    if($email != ""){
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

        if($resultado1->num_rows>0){
            $usuario = $resultado1->fetch_assoc();
            $usuario['tipo'] = 'atendente';
            return $usuario;
        }elseif($resultado2->num_rows>0){  
            $usuario = $resultado2->fetch_assoc();
            $usuario['tipo'] = 'esteticista';
            return $usuario;
        }elseif($resultado3->num_rows>0){
            $usuario = $resultado3->fetch_assoc();
            $usuario['tipo'] = 'cliente';
            return $usuario;
        }else{
            return null;
        }
    }
}

function autenticarUser($conexao, $email, $senha) {
    $usuario = BuscarPorEmail($email, $conexao);
    if ($usuario != null) {
        print_r($usuario);
        echo "senha input: $senha<br>";
        if ($usuario['tipo'] == 'atendente') {
            if (password_verify($senha, $usuario['senha_atendente'])) {
                return $usuario;
            }
        } elseif ($usuario['tipo'] == 'esteticista') {
            if (password_verify($senha, $usuario['senha_esteticista'])) {
                return $usuario;
            }
        } elseif ($usuario['tipo'] == 'cliente') {
            if (password_verify($senha, $usuario['senha_cliente'])) {
                return $usuario;
            }
        }
    } else {
        $usuario = [];
        $usuario['tipo'] = 'vazio';
        return $usuario;
    }
}

    $usuario = autenticarUser($conexao, $email, $senha);
    if ($usuario['tipo'] === 'atendente') { 
        $_SESSION['usuario_token'] = $usuario['token_atendente'];
        $_SESSION['usuario_tipo'] = $usuario['tipo'];   
        $mensagem->setMessage("Login realizado", "Login realizado com sucesso, bem-vindo(a) de volta atendente " . $usuario['nome_atendente'], "success", "../atendente/perfilAtendente.php");
        }elseif ($usuario['tipo'] === 'esteticista') { 
        $_SESSION['usuario_token'] = $usuario['token_esteticista']; 
        $_SESSION['usuario_tipo'] = $usuario['tipo']; 
        $mensagem->setMessage("Login realizado", "Login realizado com sucesso, bem-vindo(a) de volta esteticista " . $usuario['nome_esteticista'], "success", "../esteticista/perfilEsteticista.php"); 
        } elseif ($usuario['tipo'] === 'cliente') {
        $_SESSION['usuario_token'] = $usuario['token_cliente']; 
        $_SESSION['usuario_tipo'] = $usuario['tipo']; 
        $mensagem->setMessage("Login realizado", "Login realizado com sucesso, bem-vindo(a) de volta cliente " . $usuario['nome_cliente'], "success", "../cliente/perfilCliente.php"); 
    }else{
        $mensagem->setMessage("Erro","Informações incorretas, tente novamente","error","back");
    }

}// oq vc fez de diferente?
?>