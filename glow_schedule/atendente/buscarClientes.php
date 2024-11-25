<?php
// Arquivo que Carrega a Tabela dos Clientes pro Atendente consultar
// Caminho do arquivo de conexão com o banco de dados
require_once $_SERVER['DOCUMENT_ROOT'] . "/glow_schedule/controller/conexao.php";

$conexao = new Conexao();
$conn = $conexao->getConexao();

// Recebe o valor da busca via POST
$search = isset($_POST['search']) ? trim($_POST['search']) : '';

$sql = "SELECT * FROM cliente";
if ($search !== '') {
    $sql .= " WHERE nome_cliente LIKE ? OR cpf_cliente LIKE ?";
}

$stmt = $conn->prepare($sql);
if ($search !== '') {
    $searchParam = "%" . $search . "%";
    $stmt->bind_param("ss", $searchParam, $searchParam);
}
$stmt->execute();
$result = $stmt->get_result();

// Verifica se há resultados
if ($result->num_rows > 0) {
    echo '<table class="table table-bordered">';
    echo '<thead>';
    echo '<tr>';
    echo '<th>Foto</th>';
    echo '<th>Nome</th>';
    echo '<th>CPF</th>';
    echo '<th>Email</th>';
    echo '<th>Telefone</th>';
    echo '<th>Ações</th>';
    echo '</tr>';
    echo '</thead>';
    echo '<tbody>';
    // Exibe os dados de cada cliente
    while ($row = $result->fetch_assoc()) {
        $fotoPath = $_SERVER['DOCUMENT_ROOT'] . "/glow_schedule/" . $row['foto_cliente'];
        $foto = file_exists($fotoPath) && !empty($row['foto_cliente']) 
                ? "/glow_schedule/" . htmlspecialchars($row['foto_cliente']) 
                : "../iconesPerfil/perfilPadrao.png";
        echo '<tr>';
        echo '<td class="text-center align-middle"><img src="' . $foto . '" alt="Foto do Cliente" id="consultar_fotos"></td>';
        echo '<td>' . htmlspecialchars($row['nome_cliente']) . '</td>';
        echo '<td>' . htmlspecialchars($row['cpf_cliente']) . '</td>';
        echo '<td>' . htmlspecialchars($row['email_cliente']) . '</td>';
        echo '<td>' . htmlspecialchars($row['telefone_cliente']) . '</td>';
        echo '<td>';
        echo '<a href="../atendente/editarClienteAtendente.php?token_cliente=' . urlencode($row['token_cliente']) . '" class="btn btn-primary" id="editar_consultar_button">Perfil</a>';
        echo '</td>';
        echo '</tr>';
    }
    echo '</tbody>';
    echo '</table>';
} else {
    echo '<p  style="color: #cf6f7a; font-size:18px; text-align:center;" >Nenhum cliente encontrado. Por favor, Verifique novamente.</p>';
}
$conn->close();
?>