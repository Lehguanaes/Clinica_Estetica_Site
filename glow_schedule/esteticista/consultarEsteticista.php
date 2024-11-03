<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Consultar Esteticistas</title>
    <!-- Links externos -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.16/jquery.mask.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css" integrity="sha512-MV7K8+y+gLIBoVD59lQIYicR65iaqukzvf/nwasF0nqhPay5w/9lJmVM2hMDcnK1OnMGCdVK+iQrJ7lzPJQd1w==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <!-- Estilização padrão do web site -->
    <link rel="stylesheet" href="../css/style.css">
    <!-- Estilização formulários de Perfis -->
    <link rel="stylesheet" href="../css/perfil.css">
</head>
<body>
    <div class="container">
        <h2>Esteticistas Cadastrados</h2>
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
                echo '<tr>';
                // Verifica se a foto do atendente existe
                $fotoPath = $_SERVER['DOCUMENT_ROOT'] . "/glow_schedule/" . $row['foto_esteticista'];
                $foto = file_exists($fotoPath) && !empty($row['foto_esteticista']) 
                ? "/glow_schedule/" . htmlspecialchars($row['foto_esteticista']) 
                : "../iconesPerfil/perfilPadrao.png"; // URL da imagem padrão
                // Exibe a foto do atendente com formatação
                echo '<td class="text-center align-middle"><img src="' . $foto . '" alt="Foto do Atendente" id="consultar_fotos"></td>';
                echo '<td>' . htmlspecialchars($row['cpf_esteticista']) . '</td>';
                echo '<td>' . htmlspecialchars($row['nome_esteticista']) . '</td>';
                echo '<td>' . htmlspecialchars($row['apelido_esteticista']) . '</td>';
                echo '<td>' . htmlspecialchars($row['email_esteticista']) . '</td>';
                echo '<td>' . htmlspecialchars($row['telefone_esteticista']) . '</td>';
                echo '<td>';
                echo '<a href="editarEsteticista.php?cpf_esteticista=' . urlencode($row['cpf_esteticista']) . '" class="btn btn-primary" id="editar_consultar_button">Editar</a> ';
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
        <a href="cadastroEsteticista.php" class="btn btn-success" class="btn btn-success" id="editar_perfil_button"><i class="fa fa-plus"></i> Adicionar Novo Esteticista</a>
    </div>
</body>
</html>
