<?php
header('Content-Type: application/json');
require_once $_SERVER['DOCUMENT_ROOT'] . "/glow_schedule/controller/conexao.php";

$conexao = new Conexao();
$conn = $conexao->getConexao();
$id = $_POST['id'] ?? 0;

if ($id) {
    $id_escaped = mysqli_real_escape_string($conn, $id);
    $sql_update = "UPDATE duvidas SET status = 'desativado' WHERE id = '$id_escaped'";

    if (mysqli_query($conn, $sql_update)) {
        echo json_encode(['success' => true, 'message' => 'Dúvida marcada como respondida com sucesso.']);
    } else {
        echo json_encode(['success' => false, 'message' => 'Erro ao atualizar a dúvida.']);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'ID da dúvida não fornecido.']);
}

mysqli_close($conn);
?>