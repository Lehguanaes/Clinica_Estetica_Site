<?php
require_once $_SERVER['DOCUMENT_ROOT'] . "/glow_schedule/controller/conexao.php";

$conexao = new Conexao();
$conn = $conexao->getConexao();

// Recebe dados enviados via AJAX
$nome = $_POST['nome'] ?? '';
$telefone = $_POST['telefone'] ?? '';
$objetivo = $_POST['objetivo'] ?? '';
$mensagem = $_POST['mensagem'] ?? '';

// Insere no banco de dados se os campos necessários forem preenchidos
if ($nome && $telefone && $objetivo && $mensagem) {
    $sql = "INSERT INTO duvidas (nome, telefone, objetivo, mensagem) VALUES (?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssss", $nome, $telefone, $objetivo, $mensagem);
    
    if ($stmt->execute()) {
        echo json_encode(['success' => true, 'message' => 'Obrigado! Entraremos em contato em breve.']);
    } else {
        echo json_encode(['success' => false, 'message' => 'Erro ao enviar a mensagem. Tente novamente mais tarde.']);
    }
    $stmt->close();
} else {
    echo json_encode(['success' => false, 'message' => 'Por favor, preencha todos os campos.']);
}
$conn->close();
?>