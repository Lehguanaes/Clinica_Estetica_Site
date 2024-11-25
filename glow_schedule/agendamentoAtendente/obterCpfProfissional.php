<?php
require_once '../controller/conexao.php';

header('Content-Type: application/json');
ini_set('display_errors', 1);
error_reporting(E_ALL);

$conexao = new Conexao();
$conn = $conexao->getConexao();

if ($conn->connect_error) {
    echo json_encode([
        'success' => false,
        'message' => "Erro na conexão com o banco de dados: " . $conn->connect_error
    ]);
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $json = file_get_contents('php://input');
    $data = json_decode($json, true);
    $apelido = $data['apelido'] ?? '';

    if (empty($apelido)) {
        echo json_encode([
            'success' => false,
            'message' => 'O apelido do profissional não foi informado.'
        ]);
        exit;
    }

    $stmt = $conn->prepare("SELECT cpf_esteticista FROM esteticista WHERE apelido_esteticista = ?");
    $stmt->bind_param('s', $apelido);
    $stmt->execute();
    $stmt->bind_result($cpfEsteticista);
    $stmt->fetch();
    $stmt->close();

    if ($cpfEsteticista) {
        echo json_encode([
            'success' => true,
            'cpf' => $cpfEsteticista
        ]);
    } else {
        echo json_encode([
            'success' => false,
            'message' => 'Profissional não encontrado.'
        ]);
    }
    $conn->close();
}
?>