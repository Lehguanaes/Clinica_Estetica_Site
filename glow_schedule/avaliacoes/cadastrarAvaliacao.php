<?php
require_once '../controller/conexao.php';

// Instancia a classe Conexao e obtém a conexão
$conexao = new Conexao();
$conn = $conexao->getConexao();

// Captura os dados enviados pelo formulário
$stars = $_POST['stars'] ?? ''; // Nota em estrelas
$reviewText = $_POST['reviewText'] ?? ''; // Comentário
$cpf_cliente = $_POST['cpf_cliente'] ?? ''; // CPF do cliente
$avaliado = $_POST['avaliado'] ?? ''; // Avaliado (pode ser 'Clínica' ou o apelido do profissional)

// Verificação dos dados recebidos
if (!$stars || !$reviewText || !$cpf_cliente || !$avaliado) {
    echo "Erro: Preencha todos os campos. Dados recebidos -> Stars: $stars, Comentário: $reviewText, CPF: $cpf_cliente, Avaliado: $avaliado";
    exit; // Termina o script se faltar algum dado
}

// Tenta preparar e executar a inserção no banco de dados
$stmt = $conn->prepare("INSERT INTO Avaliacoes (cpf_cliente, estrelas_avaliacao, comentario_avaliacao, avaliado) VALUES (?, ?, ?, ?)");

if ($stmt) {
    $stmt->bind_param('siss', $cpf_cliente, $stars, $reviewText, $avaliado);

    if ($stmt->execute()) {
        // Avaliação inserida com sucesso
        echo 'Obrigada pela avaliação!'; // Envia uma mensagem de sucesso
    } else {
        echo "Erro ao executar a inserção: " . $stmt->error; // Mensagem de erro na execução
    }

    $stmt->close();
} else {
    echo "Erro na preparação da query: " . $conn->error; // Mensagem de erro na preparação da query
}

$conn->close();
?>