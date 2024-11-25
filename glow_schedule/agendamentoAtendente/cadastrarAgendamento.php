<?php
require_once '../controller/conexao.php';

// Configurações para JSON e exibição de erros
header('Content-Type: application/json');
ini_set('display_errors', 1);
error_reporting(E_ALL);

// Estabelecendo conexão com o banco de dados
$conexao = new Conexao();
$conn = $conexao->getConexao();

// Verifica conexão
if ($conn->connect_error) {
    echo json_encode([
        'success' => false,
        'message' => "Erro na conexão com o banco de dados: " . $conn->connect_error
    ]);
    exit;
}

// Processa apenas requisições POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $json = file_get_contents('php://input');
    $data = json_decode($json, true);

    // Verifica se o JSON foi decodificado corretamente
    if ($data === null && json_last_error() !== JSON_ERROR_NONE) {
        echo json_encode([
            'success' => false,
            'message' => 'Erro ao decodificar o JSON recebido: ' . json_last_error_msg()
        ]);
        exit;
    }

    // Extrai dados do JSON
    $procedimento = $data['procedimento'] ?? '';
    $profissional = $data['profissional'] ?? '';
    $dataConsulta = $data['data'] ?? '';
    $horario = $data['horario'] ?? '';
    $cpf_cliente = $data['cliente'] ?? '';

    // Valida campos obrigatórios
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

    // Converte a data para o formato YYYY-MM-DD
    $dataConsultaFormatada = DateTime::createFromFormat('d/m/Y', $dataConsulta);
    if (!$dataConsultaFormatada) {
        echo json_encode([
            'success' => false,
            'message' => 'Formato de data inválido. Use o formato DIA/MÊS/ANO.'
        ]);
        exit;
    }
    $dataConsulta = $dataConsultaFormatada->format('Y-m-d');

    // Obtém o ID do procedimento com base no nome
    $stmt = $conn->prepare("SELECT id_procedimento FROM procedimento WHERE nome_procedimento = ?");
    $stmt->bind_param('s', $procedimento);
    $stmt->execute();
    $stmt->bind_result($idProcedimento);
    $stmt->fetch();
    $stmt->close();

    if (!$idProcedimento) {
        echo json_encode([
            'success' => false,
            'message' => "Erro: O procedimento informado não existe."
        ]);
        exit;
    }

    // Obtém o CPF do esteticista baseado no apelido
    $stmt = $conn->prepare("SELECT cpf_esteticista FROM esteticista WHERE apelido_esteticista = ?");
    $stmt->bind_param('s', $profissional);
    $stmt->execute();
    $stmt->bind_result($cpfEsteticista);
    $stmt->fetch();
    $stmt->close();

    if (!$cpfEsteticista) {
        echo json_encode([
            'success' => false,
            'message' => "Erro: O esteticista informado não existe."
        ]);
        exit;
    }

    // Insere o agendamento na tabela Consulta
    $stmt = $conn->prepare("INSERT INTO Consulta (id_procedimento, cpf_esteticista, cpf_cliente, data_consulta, hora_consulta) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param('sssss', $idProcedimento, $cpfEsteticista, $cpf_cliente, $dataConsulta, $horario);

    if ($stmt->execute()) {
        echo json_encode([
            'success' => true,
            'message' => 'Agendamento confirmado com sucesso!',
            'dados' => [
                'procedimento' => $procedimento,
                'profissional' => $profissional,
                'cliente' => $cpf_cliente,
                'data' => $dataConsulta,
                'horario' => $horario
            ]
        ]);
    } else {
        echo json_encode([
            'success' => false,
            'message' => "Erro ao executar a consulta: " . $stmt->error
        ]);
    }
    $stmt->close();
    $conn->close();
} else {
    echo json_encode([
        'success' => false,
        'message' => 'Método HTTP inválido. Apenas POST é aceito.'
    ]);
    exit;
}
?>