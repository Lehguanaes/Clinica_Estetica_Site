<?php
require_once $_SERVER['DOCUMENT_ROOT'] . "/glow_schedule/controller/conexao.php";

$conexao = new Conexao();
$conn = $conexao->getConexao();

$cpf_cliente = $_GET['cpf_cliente'] ?? '';
$data_consulta = $_GET['data_consulta'] ?? date('Y-m-d');
$cpf_cliente_escaped = mysqli_real_escape_string($conn, $cpf_cliente);
$data_consulta_escaped = mysqli_real_escape_string($conn, $data_consulta);

// Verifica se o CPF foi fornecido antes de buscar o cliente
$nome_cliente = '';
if (!empty($cpf_cliente)) {
    // Consulta SQL para obter o nome do cliente, caso o CPF seja fornecido
    $sql_cliente = "
        SELECT nome_cliente 
        FROM cliente 
        WHERE cpf_cliente = '$cpf_cliente_escaped'
    ";
    $result_cliente = mysqli_query($conn, $sql_cliente);

    // Verifica se o CPF do cliente está cadastrado
    if ($result_cliente && mysqli_num_rows($result_cliente) > 0) {
        $cliente = mysqli_fetch_assoc($result_cliente);
        $nome_cliente = $cliente['nome_cliente'];
    } else {
        echo "<p style='color: #CF6F7A; text-align: center;'>CPF não cadastrado. Por favor, verifique e tente novamente.</p>";
        mysqli_close($conn);
        exit; // Encerra o script se o CPF não estiver cadastrado
    }
}

// Define a consulta de acordo com os parâmetros fornecidos
if ($cpf_cliente && $data_consulta) {
    // Consulta por CPF e data
    $sql_consultas = "
        SELECT c.id_consulta, c.data_consulta, c.hora_consulta, e.apelido_esteticista, p.nome_procedimento, '$nome_cliente' AS nome_cliente
        FROM consulta AS c
        JOIN esteticista AS e ON c.cpf_esteticista = e.cpf_esteticista
        JOIN procedimento AS p ON c.id_procedimento = p.id_procedimento
        WHERE c.cpf_cliente = '$cpf_cliente_escaped'
        AND c.data_consulta = '$data_consulta_escaped'
    ";
    $titulo = "Consultas de $nome_cliente (CPF: $cpf_cliente) na Data: " . date('d/m/Y', strtotime($data_consulta));
} elseif ($cpf_cliente) {
    // Consulta por CPF apenas
    $sql_consultas = "
        SELECT c.id_consulta, c.data_consulta, c.hora_consulta, e.apelido_esteticista, p.nome_procedimento, '$nome_cliente' AS nome_cliente
        FROM consulta AS c
        JOIN esteticista AS e ON c.cpf_esteticista = e.cpf_esteticista
        JOIN procedimento AS p ON c.id_procedimento = p.id_procedimento
        WHERE c.cpf_cliente = '$cpf_cliente_escaped'
    ";
    $titulo = "Consultas de $nome_cliente (CPF: $cpf_cliente)";
} else {
    // Consulta apenas por data
    $sql_consultas = "
        SELECT c.id_consulta, c.data_consulta, c.hora_consulta, e.apelido_esteticista, p.nome_procedimento,c.cpf_cliente, cl.nome_cliente
        FROM consulta AS c
        JOIN esteticista AS e ON c.cpf_esteticista = e.cpf_esteticista
        JOIN procedimento AS p ON c.id_procedimento = p.id_procedimento
        JOIN cliente AS cl ON c.cpf_cliente = cl.cpf_cliente
        WHERE c.data_consulta = '$data_consulta_escaped'
    ";
    $titulo = "Consultas para o Dia " . date('d/m/Y', strtotime($data_consulta));
}

// Executa a consulta de agendamentos
$result_consultas = mysqli_query($conn, $sql_consultas);
echo "<h3 style='color: #CF6F7A; text-align: center;'>$titulo</h3>";
// Exibe os resultados das consultas ou uma mensagem caso não haja resultados
if ($result_consultas && mysqli_num_rows($result_consultas) > 0) {
    while ($consulta = mysqli_fetch_assoc($result_consultas)) {
        // Formata a data
        $data_formatada = DateTime::createFromFormat('Y-m-d', $consulta['data_consulta'])->format('d/m/Y');
         
        echo '
            <div class="container">
                <div class="card-simples">
                    <div class="card-content">
                        <h2 class="titulo-card">' . htmlspecialchars($consulta['nome_procedimento']) . '</h2>
                        <div class="cor-falsificada">
                            <p class="mais-texto" style="font-size:15px">Cliente: ' . htmlspecialchars($consulta['nome_cliente']) . '</p>
                            <p class="mais-texto" style="font-size:15px">Às: ' . htmlspecialchars($consulta['hora_consulta']) . '</p>
                            <p class="mais-texto" style="font-size:15px">Procedimento: ' . htmlspecialchars($consulta['nome_procedimento']) . '.</p>
                            <p class="mais-texto" style="font-size:15px">Para a data: ' . $data_formatada . '</p>
                            <p class="mais-texto" style="font-size:15px">Marcada com o(a) profissional: ' . htmlspecialchars($consulta['apelido_esteticista']) . '.</p>
 <button onclick="window.location.href=\'../prontuario/consultarProntuarioEsteticista.php?id=' . $consulta['id_consulta'] . '\'">Ver Prontuário</button>
                        </div>
                    </div>
                </div>
        </div>';        
    }
} else {
    echo "<div class='separacao'>";
    echo "<p style='color: #CF6F7A;'>Nenhuma consulta encontrada.</p>"; // Removido o text-align aqui
    echo "</div>";     
}

mysqli_close($conn);
?>