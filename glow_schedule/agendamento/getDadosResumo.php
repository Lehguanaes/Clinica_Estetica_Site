<?php
require_once '../controller/conexao.php';

$conexao = new Conexao();
$conn = $conexao->getConexao();

$procedimentoId = $_GET['procedimento'] ?? '';
$profissionalCpf = $_GET['profissional'] ?? '';
$data = $_GET['data'] ?? ''; // Capturando a data
$horario = $_GET['horario'] ?? ''; // Capturando a hora

// Função para obter o nome do procedimento
function obterNomeProcedimento($conn, $id_procedimento) {
    $stmt = $conn->prepare("SELECT nome_procedimento FROM procedimento WHERE id_procedimento = ?");
    $stmt->bind_param('i', $id_procedimento);
    $stmt->execute();
    $result = $stmt->get_result();
    return $result->fetch_assoc()['nome_procedimento'] ?? 'Desconhecido';
}

// Função para obter o apelido do esteticista
function obterApelidoEsteticista($conn, $cpf_esteticista) {
    $stmt = $conn->prepare("SELECT apelido_esteticista FROM esteticista WHERE cpf_esteticista = ?");
    $stmt->bind_param('s', $cpf_esteticista);
    $stmt->execute();
    $result = $stmt->get_result();
    return $result->fetch_assoc()['apelido_esteticista'] ?? 'Desconhecido';
}

// Obtendo os dados
$nomeProcedimento = obterNomeProcedimento($conn, $procedimentoId);
$apelidoEsteticista = obterApelidoEsteticista($conn, $profissionalCpf);

// Retorna os dados em formato JSON, incluindo data e hora
echo json_encode([
    'nome_procedimento' => $nomeProcedimento,
    'apelido_esteticista' => $apelidoEsteticista,
    'data' => $data, // Passando a data
    'horario' => $horario // Passando a hora
]);
?>