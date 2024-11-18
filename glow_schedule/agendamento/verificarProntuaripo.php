
<?php
require_once '../controller/conexao.php';

$data = json_decode(file_get_contents('php://input'), true); // Recebe os dados JSON enviados via POST
$cpfCliente = $data['cpfCliente'];

if (!$cpfCliente) {
    echo json_encode(['success' => false, 'message' => 'CPF não fornecido.']);
    exit;
}

$conexao = new Conexao();
$conn = $conexao->getConexao();

$stmt = $conn->prepare("SELECT id_prontuario FROM prontuario WHERE cpf_cliente = ?");
$stmt->bind_param("s", $cpfCliente);
$stmt->execute();
$resultado = $stmt->get_result();

if ($resultado->num_rows > 0) {
    echo json_encode(['success' => true, 'temProntuario' => true]);
} else {
    echo json_encode(['success' => true, 'temProntuario' => false]);
}
?>