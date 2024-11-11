<?php
require_once '../controller/conexao.php';

// Instancia a classe Conexao e obtém a conexão
$conexao = new Conexao();
$conn = $conexao->getConexao();

// Verificação de conexão
if (!$conn) {
    die("Falha na conexão: " . mysqli_connect_error());
}

// Consulta para buscar todos os apelidos dos esteticistas
$sql = "SELECT apelido_esteticista FROM esteticista WHERE apelido_esteticista IS NOT NULL";
$result = mysqli_query($conn, $sql);

// Adiciona a opção inicial "Escolha o Profissional"
echo '<option value="">Escolha o Profissional</option>';

// Verifica se a consulta retornou resultados
if (mysqli_num_rows($result) > 0) {
    while ($row = mysqli_fetch_assoc($result)) {
        echo '<option value="' . htmlspecialchars($row['apelido_esteticista']) . '">' . htmlspecialchars($row['apelido_esteticista']) . '</option>';
    }
} else {
    echo '<option value="">Nenhum apelido encontrado</option>';
}

// Fecha a conexão com o banco de dados
mysqli_close($conn);
?>