<?php
require_once '../controller/conexao.php';

// Instancia a classe Conexao e obtém a conexão
$conexao = new Conexao();
$conn = $conexao->getConexao();
if ($conn->connect_error) {
    die("Erro na conexão com o banco de dados: " . $conn->connect_error);
}


// Obtém o CPF da requisição
$cpf = $_GET['cpf'] ?? '';

// Verifica se o CPF foi enviado
if (empty($cpf)) {
    echo json_encode(['cadastrado' => false, 'erro' => 'CPF não fornecido']);
    exit;
}

// Consulta no banco de dados
$query = $conn->prepare("SELECT COUNT(*) as total FROM cliente WHERE cpf_cliente = ?");
$query->bind_param('s', $cpf);
$query->execute();
$result = $query->get_result();
$row = $result->fetch_assoc();

// Retorna a resposta
if ($row['total'] > 0) {
    echo json_encode(['cadastrado' => true]);
} else {
    echo json_encode(['cadastrado' => false]);
}

$conn->close();
?>