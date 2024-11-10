<?php
require_once '../controller/conexao.php';

$conexao = new Conexao();
$conn = $conexao->getConexao();

if ($conn->connect_error) {
    die("Conexão falhou: " . $conn->connect_error);
}

// Obtenha e valide os parâmetros da consulta
$procedimento = isset($_GET['procedimento']) ? $_GET['procedimento'] : '';
$data = isset($_GET['data']) ? $_GET['data'] : '';
$profissional = isset($_GET['profissional']) ? $_GET['profissional'] : '';

// Horários disponíveis fixos
$horariosDisponiveis = ['09:00', '10:00', '11:00', '12:00', '13:00', '14:00', '15:00', '16:00', '17:00'];
$horariosDisponiveisFinal = $horariosDisponiveis;

// Se um profissional específico foi selecionado, filtra os horários para esse profissional
if ($profissional) {
    // Verifica se o profissional já possui consultas agendadas nessa data
    $stmt = $conn->prepare("SELECT hora_consulta FROM Consulta WHERE data_consulta = ? AND cpf_esteticista = ?");
    $stmt->bind_param('ss', $data, $profissional);
    $stmt->execute();
    $result = $stmt->get_result();

    $horariosOcupadosProfissional = [];
    while ($row = $result->fetch_assoc()) {
        // Converte de HH:MM:SS para HH:MM
        $horariosOcupadosProfissional[] = date('H:i', strtotime($row['hora_consulta']));
    }

    // Remover os horários ocupados apenas pelo profissional selecionado
    $horariosDisponiveisFinal = array_diff($horariosDisponiveisFinal, $horariosOcupadosProfissional);
}

// Fecha a declaração
$stmt->close();
$conn->close();

// Exibe os horários disponíveis ou uma mensagem caso não haja
if (count($horariosDisponiveisFinal) > 0) {
    echo "<ul>";
    foreach ($horariosDisponiveisFinal as $horario) {
        echo "<button onclick=\"mostrarResumo('$procedimento', '$profissional', '$data', '$horario')\">$horario</button>";
    }
    echo "</ul>";
} else {
    echo "<p>Não há horários disponíveis para esta data.</p>";
}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Agendamento</title>
    <!-- Link para o arquivo CSS -->
    <link rel="stylesheet" href="../css/styleAgendamento.css">
    <!-- Link para o arquivo JavaScript -->
    <script src="../js/agendamento.js" defer></script>
</head>
<body>
    <!-- O conteúdo gerado pelo PHP aparecerá aqui -->
</body>
</html>
