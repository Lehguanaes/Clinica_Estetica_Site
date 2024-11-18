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

    
    $procedimento = $data['procedimento'] ?? '';
    $profissional = $data['profissional'] ?? '';
    $dataConsulta = $data['data'] ?? '';
    $horario = $data['horario'] ?? '';
    $cpf_cliente = $data['cliente'] ?? '';

    $erros = [];
    if (empty($procedimento)) $erros[] = "O campo 'procedimento' não pode estar vazio.";
    if (empty($profissional)) $erros[] = "O campo 'profissional' não pode estar vazio.";
    if (empty($dataConsulta)) $erros[] = "O campo 'data' não pode estar vazio.";
    if (empty($horario)) $erros[] = "O campo 'horario' não pode estar vazio.";
    if (empty($cpf_cliente)) $erros[] = "O campo 'cliente' não pode estar vazio.";

    if (!empty($erros)) {
        echo json_encode([
            'success' => false,
            'message' => implode(" ", $erros)
        ]);
        exit;
    }

    $stmt = $conn->prepare("SELECT id_procedimento FROM procedimento WHERE nome_procedimento = ?");
    $stmt->bind_param('s', $procedimento);
    $stmt->execute();
    $stmt->bind_result($idProcedimento);
    $stmt->fetch();
    $stmt->close();

    if ($idProcedimento) {
        $stmt = $conn->prepare("INSERT INTO Consulta (id_procedimento, cpf_esteticista, cpf_cliente, data_consulta, hora_consulta) VALUES (?, ?, ?, ?, ?)");
        $stmt->bind_param('sssss', $idProcedimento, $profissional, $cpf_cliente, $dataConsulta, $horario);

        if ($stmt->execute()) {
            echo json_encode([
                'success' => true,
                'message' => 'Agendamento confirmado com sucesso!'
            ]);
        } else {
            echo json_encode([
                'success' => false,
                'message' => "Erro ao executar a consulta: " . $stmt->error
            ]);
        }
        $stmt->close();
    } else {
        echo json_encode([
            'success' => false,
            'message' => "Erro: O procedimento informado não existe."
        ]);
    }
    $conn->close();
}
?>