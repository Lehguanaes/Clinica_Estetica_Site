<?php
require_once $_SERVER['DOCUMENT_ROOT'] . "/glow_schedule/controller/conexao.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/glow_schedule/model/message.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/glow_schedule/controller/global.php";


if(session_status() === PHP_SESSION_NONE){
    session_start();
}

$mensagem = new Message($BASE_URL);
$acao = filter_input(INPUT_POST, "acao");
$conexaoMini = new Conexao();
$conexao = $conexaoMini->getConexao();

if ($acao == "inserir") {
        $cor_pele = filter_input(INPUT_POST, "cor_pele");
        $tipo_pele = filter_input(INPUT_POST, "tipo_pele");
        $observacoes_cliente = filter_input(INPUT_POST, "observacoes_cliente");
       
        $cpf_cliente = $_SESSION['usuario_cpf'];

        $sql1 = "INSERT INTO prontuario (cpf_cliente, cor_pele, tipo_pele, observacoes_cliente) VALUES (?, ?, ?, ?)";
        $stmt1 = $conexao->prepare($sql1);
        $stmt1->bind_param('ssss', $cpf_cliente, $cor_pele, $tipo_pele, $observacoes_cliente);
        $stmt1->execute();

        
        $last_id = $conexao->insert_id;
        $_SESSION['usuario_prontuario'] = $last_id;
        
        $mensagem->setMessage("Prontuário realizado","Prontuário realizado com sucesso, consulte suas informações, edite caso nãos estejam corretas.","success","../../prontuario/consultarProntuario.php");

    }elseif ($acao == "atualizar") {
    $cor_pele = filter_input(INPUT_POST, "cor_pele");
    $tipo_pele = filter_input(INPUT_POST, "tipo_pele");
    $observacoes_cliente = filter_input(INPUT_POST, "observacoes_cliente");

    $cpf_cliente = $_SESSION['usuario_cpf'];

    $sql1 = "UPDATE prontuario SET cor_pele = ?, tipo_pele = ?, observacoes_cliente = ?  WHERE id_prontuario=?";
    $stmt1 = $conexao->prepare($sql1);
    $stmt1->bind_param('ssss', $cpf_cliente, $cor_pele,  $tipo_pele, $observacoes_cliente);
    $stmt1->execute();

    $mensagem->setMessage("Prontuário atualizado","Prontuário atualizado com sucesso.","success","../../prontuario/consultarProntuario.php");
 
    session_unset();  // Limpa as variáveis de sessão
    session_destroy(); // destrói a sessão
    exit;
}


?>