<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Consultar Esteticistas</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
    <div class="container">
        <h2>Lista de Esteticistas</h2>
        <?php
        // Atualize o caminho do arquivo de conexão com o banco de dados
        require_once $_SERVER['DOCUMENT_ROOT'] . "/glow_schedule/controller/conexao.php";

        // Cria uma nova instância da classe Conexao e obtém a conexão
        $conexao = new Conexao();
        $conn = $conexao->getConexao(); // Certifique-se de que isso retorna um objeto de conexão válido

        // Consulta SQL para buscar todos os esteticistas
        $sql = "SELECT * FROM esteticista";
        $result = $conn->query($sql);

        // Verifica se há resultados
        if ($result->num_rows > 0) {
            echo '<table class="table table-bordered">';
            echo '<thead>';
            echo '<tr>';
            echo '<th>Foto</th>';
            echo '<th>CPF</th>';
            echo '<th>Nome</th>';
            echo '<th>Apelido</th>';
            echo '<th>Email</th>';
            echo '<th>Telefone</th>';
            echo '<th>Ações</th>';
            echo '</tr>';
            echo '</thead>';
            echo '<tbody>';

            // Exibe os dados de cada esteticista
            while ($row = $result->fetch_assoc()) {
                echo '<tr>';
                echo '<td><img src="' . (file_exists($_SERVER['DOCUMENT_ROOT'] . "/glow_schedule/" . $row['foto_esteticista']) ? "/glow_schedule/" . htmlspecialchars($row['foto_esteticista']) : "https://via.placeholder.com/50") . '" alt="Foto do Esteticista" style="width:50px;height:50px;"></td>';
                echo '<td>' . htmlspecialchars($row['cpf_esteticista']) . '</td>';
                echo '<td>' . htmlspecialchars($row['nome_esteticista']) . '</td>';
                echo '<td>' . htmlspecialchars($row['apelido_esteticista']) . '</td>';
                echo '<td>' . htmlspecialchars($row['email_esteticista']) . '</td>';
                echo '<td>' . htmlspecialchars($row['telefone_esteticista']) . '</td>';
                echo '<td>';
                echo '<a href="editarEsteticista.php?cpf_esteticista=' . urlencode($row['cpf_esteticista']) . '" class="btn btn-primary">Editar</a> ';
                echo '</td>';
                echo '</tr>';
            }

            echo '</tbody>';
            echo '</table>';
        } else {
            echo '<p>Nenhum esteticista encontrado.</p>';
        }

        // Fecha a conexão com o banco de dados
        $conn->close();
        ?>

        <a href="cadastroEsteticista.php" class="btn btn-success">Adicionar Novo Esteticista</a>
    </div>
</body>
</html>