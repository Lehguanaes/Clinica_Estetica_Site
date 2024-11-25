<?php
// Caminho do arquivo de conexão com o banco de dados
require_once $_SERVER['DOCUMENT_ROOT'] . "/glow_schedule/controller/conexao.php";

$conexao = new Conexao();
$conn = $conexao->getConexao();

// Verifica se foi enviado o ID da avaliação via POST
if (isset($_POST['id_avaliacao'])) {
    $id_avaliacao = (int)$_POST['id_avaliacao']; // Garante que o ID seja um número inteiro

    // Primeiro, verifica se a avaliação existe
    $checkSql = "SELECT COUNT(*) FROM Avaliacoes WHERE id_avaliacao = ?";
    $checkStmt = $conn->prepare($checkSql);
    $checkStmt->bind_param('i', $id_avaliacao);
    $checkStmt->execute();
    $checkStmt->bind_result($count);
    $checkStmt->fetch();
    $checkStmt->close();

    if ($count > 0) {
        // Prepara a consulta SQL para deletar a avaliação
        $sql = "DELETE FROM Avaliacoes WHERE id_avaliacao = ?";
        $stmt = $conn->prepare($sql);

        // Verifica se a preparação foi bem-sucedida
        if ($stmt === false) {
            die(json_encode(['error' => 'Erro na preparação da consulta: ' . $conn->error]));
        }

        // Vincula o parâmetro (ID da avaliação) à consulta
        $stmt->bind_param('i', $id_avaliacao);

        // Executa a consulta
        if ($stmt->execute()) {
            if ($stmt->affected_rows > 0) {
                echo json_encode(['success' => 'Avaliação deletada com sucesso']);
            } else {
                echo json_encode(['error' => 'Avaliação não encontrada']);
            }
        } else {
            echo json_encode(['error' => 'Erro ao deletar avaliação: ' . $stmt->error]);
        }

        // Fecha a consulta
        $stmt->close();
    } else {
        echo json_encode(['error' => 'Avaliação não encontrada']);
    }

} else {
    // Caso não tenha sido enviado o ID da avaliação
    echo json_encode(['error' => 'ID da avaliação não fornecido']);
}

// Fecha a conexão com o banco de dados
$conn->close();
?>