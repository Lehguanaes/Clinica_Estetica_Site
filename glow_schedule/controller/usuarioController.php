<?php
require_once $_SERVER['DOCUMENT_ROOT'] . "/glow_schedule/controller/conexao.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/glow_schedule/model/atendente/atendente.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/glow_schedule/model/esteticista/esteticista.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/glow_schedule/model/cliente/cliente.php";

if(session_status() === PHP_SESSION_NONE){
    session_start();
}

$acao = filter_input(INPUT_POST, "acao");
$conexaoMini = new Conexao();
$conexao = $conexaoMini->getConexao();     

if ($acao == "login") {
    $email = filter_input(INPUT_POST, "email");
    $senha = filter_input(INPUT_POST, "senha");


    function Login($conexao, $email, $senha){
        
        $sql1 = "SELECT * FROM atendente WHERE `email_atendente` = ? AND `senha_atendente`=?";
        $stmt1 = $conexao->prepare($sql1);
        $stmt1->bind_param('ss', $email, $senha);
        $stmt1->execute();
        $resultado1 = $stmt1->get_result();

        if($resultado1->num_rows > 0){
            $usuario = $resultado1->fetch_assoc();
            $usuario['tipo'] = 'atendente';
            echo "Login como atendente bem-sucedido!<br>"; // Depuração
            return $usuario;
        }

        $sql2 = "SELECT * FROM esteticista WHERE `email_esteticista` = ? AND `senha_esteticista`=?";
        $stmt2 = $conexao->prepare($sql2);
        $stmt2->bind_param('ss', $email, $senha);
        $stmt2->execute();
        $resultado2 = $stmt2->get_result();

        if($resultado2->num_rows > 0){
            $usuario = $resultado2->fetch_assoc();
            $usuario['tipo'] = 'esteticista';
            echo "Login como esteticista bem-sucedido!<br>"; // Depuração
            return $usuario;
        }
        
        $sql3 = "SELECT * FROM cliente WHERE `email_cliente` = ? AND `senha_cliente`=?";
        $stmt3 = $conexao->prepare($sql3);
        $stmt3->bind_param('ss', $email, $senha);
        $stmt3->execute();
        $resultado3 = $stmt3->get_result();

        if($resultado3->num_rows > 0){
            $usuario = $resultado3->fetch_assoc();
            $usuario['tipo'] = 'cliente';
            echo "Login como cliente bem-sucedido!<br>"; // Depuração
            return $usuario;
        }

        echo "INenhum usuário encontrado.<br>"; // Depuração
        return null;
    }

    $usuario = Login($conexao, $email, $senha);

    if ($usuario !== null) {

        if ($usuario['tipo'] === 'atendente') {

            $_SESSION['usuario_cpf'] = $usuario['cpf_atendente'];
            $_SESSION['usuario_tipo'] = $usuario['tipo'];
            header("Location: /glow_schedule/atendente/perfilAtendente.php");

        } elseif ($usuario['tipo'] === 'esteticista') {

            $_SESSION['usuario_cpf'] = $usuario['cpf_esteticista'];
            $_SESSION['usuario_tipo'] = $usuario['tipo'];
            header("Location: /glow_schedule/esteticista/perfilEsteticista.php");

        } elseif ($usuario['tipo'] === 'cliente') {

            $_SESSION['usuario_cpf'] = $usuario['cpf_cliente'];
            $_SESSION['usuario_tipo'] = $usuario['tipo'];
            header("Location: /glow_schedule/cliente/consultarCliente.php");
        }
    } else {
        echo "Senha ou email incorretos";
    }
}
?>
