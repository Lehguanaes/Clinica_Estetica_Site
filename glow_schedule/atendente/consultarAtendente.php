<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Consultar Atendentes</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
    <div class="container">
        <h2>Lista de Atendentes</h2>

        <?php
        // Caminho do arquivo de conexão com o banco de dados
        require_once $_SERVER['DOCUMENT_ROOT'] . "/glow_schedule/controller/conexao.php";

        // Cria uma nova instância da classe Conexao e obtém a conexão
        $conexao = new Conexao();
        $conn = $conexao->getConexao();

        // Consulta SQL para buscar todos os atendentes
        $sql = "SELECT * FROM atendente";
        $result = $conn->query($sql);

        // Verifica se há resultados
        if ($result->num_rows > 0) {
            echo '<table class="table table-bordered">';
            echo '<thead>';
            echo '<tr>';
            echo '<th>Foto</th>';
            echo '<th>CPF</th>';
            echo '<th>Nome</th>';
            echo '<th>Email</th>';
            echo '<th>Telefone</th>';
            echo '<th>Ações</th>';
            echo '</tr>';
            echo '</thead>';
            echo '<tbody>';

            // Exibe os dados de cada atendente
            while ($row = $result->fetch_assoc()) {
                echo '<tr>';
                echo '<td><img src="' . (file_exists($_SERVER['DOCUMENT_ROOT'] . "/glow_schedule/" . $row['foto_atendente']) ? "/glow_schedule/" . htmlspecialchars($row['foto_atendente']) : "https://via.placeholder.com/50") . '" alt="Foto do Atendente" style="width:50px;height:50px;"></td>';
                echo '<td>' . htmlspecialchars($row['cpf_atendente']) . '</td>';
                echo '<td>' . htmlspecialchars($row['nome_atendente']) . '</td>';
                echo '<td>' . htmlspecialchars($row['email_atendente']) . '</td>';
                echo '<td>' . htmlspecialchars($row['telefone_atendente']) . '</td>';
                echo '<td>';
                echo '<a href="editarAtendente.php?cpf_atendente=' . urlencode($row['cpf_atendente']) . '" class="btn btn-primary">Editar</a>';
                echo '</td>';
                echo '</tr>';
            }

            echo '</tbody>';
            echo '</table>';
        } else {
            echo '<p>Nenhum atendente encontrado.</p>';
        }

        // Fecha a conexão com o banco de dados
        $conn->close();
        ?>

        <a href="cadastroAtendente.php" class="btn btn-success">Adicionar Novo Atendente</a>
    </div>
</body>
</html>