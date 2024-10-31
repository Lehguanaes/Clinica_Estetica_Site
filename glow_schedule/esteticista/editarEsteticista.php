<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Esteticista</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <script src="js/mascaraInput.js" defer></script>
</head>
<body>
    <div class="container">
        <h2>Editar Esteticista</h2>

        <?php
         require_once $_SERVER['DOCUMENT_ROOT'] . "/glow_schedule/controller/conexao.php";
         require_once $_SERVER['DOCUMENT_ROOT'] . "/glow_schedule/model/esteticista/esteticista.php";

        // Cria uma nova instância da classe Esteticista
        $esteticista = new Esteticista();

        // Verifica se o CPF do esteticista foi passado pela URL
        if (isset($_GET['cpf_esteticista'])) {
            $cpf_esteticista = $_GET['cpf_esteticista'];

            // Consulta para buscar os dados do esteticista
            $sql = "SELECT * FROM esteticista WHERE cpf_esteticista = ?";
            $conn = (new Conexao())->getConexao();

            if ($stmt = $conn->prepare($sql)) {
                $stmt->bind_param("s", $cpf_esteticista);
                $stmt->execute();
                $result = $stmt->get_result();

                if ($result->num_rows > 0) {
                    $esteticistaData = $result->fetch_assoc();
                    // Define os dados do esteticista
                    $esteticista->setCpf($esteticistaData['cpf_esteticista']);
                    $esteticista->setNome($esteticistaData['nome_esteticista']);
                    $esteticista->setApelido($esteticistaData['apelido_esteticista']);
                    $esteticista->setEmail($esteticistaData['email_esteticista']);
                    $esteticista->setTelefone($esteticistaData['telefone_esteticista']);
                    $esteticista->setFoto($esteticistaData['foto_esteticista']); // Mantém a foto atual
                } else {
                    echo "<p>Nenhum esteticista encontrado com o CPF informado.</p>";
                }
                $stmt->close();
            } else {
                echo "Erro na consulta: " . $conn->error;
            }
        } else {
            echo "<p>CPF do esteticista não foi informado.</p>";
        }

        // Lógica para atualizar os dados do esteticista
        if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['cpf_esteticista'])) {
            $esteticista->setCpf($_POST['cpf_esteticista']);
            $esteticista->setNome($_POST['nome_esteticista']);
            $esteticista->setApelido($_POST['apelido_esteticista']);
            $esteticista->setEmail($_POST['email_esteticista']);
            $esteticista->setTelefone($_POST['telefone_esteticista']);

            // Verifica se uma nova foto foi enviada
            if (isset($_FILES['foto_esteticista']) && $_FILES['foto_esteticista']['error'] == UPLOAD_ERR_OK) {
                $target_dir = "uploads/";
                $target_file = $target_dir . basename($_FILES["foto_esteticista"]["name"]);

                // Move a nova foto para o diretório de uploads
                if (move_uploaded_file($_FILES["foto_esteticista"]["tmp_name"], $target_file)) {
                    $esteticista->setFoto($target_file); // Atualiza a foto com a nova
                } else {
                    echo "<p>Erro ao fazer upload da foto.</p>";
                }
            }

            // Atualiza os dados no banco de dados
            if ($esteticista->atualizar()) {
                echo "<p>Esteticista atualizado com sucesso.</p>";
                header("Location: consultarEsteticista.php");
                exit();
            }
        }

        // Verifica se os dados do esteticista foram encontrados
        if (isset($esteticistaData)) {
            // Formulário para editar os dados do esteticista
            ?>
            <form method="POST" action="editarEsteticista.php?cpf_esteticista=<?php echo urlencode($esteticistaData['cpf_esteticista']); ?>" enctype="multipart/form-data">
                <input type="hidden" name="cpf_esteticista" value="<?php echo htmlspecialchars($esteticistaData['cpf_esteticista']); ?>">

                <div class="form-group">
                    <label for="foto_esteticista">Foto:</label><br>
                    <img src="<?php echo htmlspecialchars($esteticistaData['foto_esteticista']); ?>" alt="Foto do Esteticista" style="width:100px;height:100px;"><br>
                    <input type="file" name="foto_esteticista" id="foto_esteticista" accept="image/*">
                </div>

                <div class="form-group">
                    <label for="nome_esteticista">Nome:</label>
                    <input type="text" class="form-control" id="nome_esteticista" name="nome_esteticista" value="<?php echo htmlspecialchars($esteticistaData['nome_esteticista']); ?>" required>
                </div>

                <div class="form-group">
                    <label for="apelido_esteticista">Apelido:</label>
                    <input type="text" class="form-control" id="apelido_esteticista" name="apelido_esteticista" value="<?php echo htmlspecialchars($esteticistaData['apelido_esteticista']); ?>" required>
                </div>

                <div class="form-group">
                    <label for="email_esteticista">Email:</label>
                    <input type="email" class="form-control" id="email_esteticista" name="email_esteticista" value="<?php echo htmlspecialchars($esteticistaData['email_esteticista']); ?>" required>
                </div>

                <div class="form-group">
                    <label for="telefone_esteticista">Telefone:</label>
                    <input type="text" class="form-control" id="telefone_esteticista" name="telefone_esteticista" value="<?php echo htmlspecialchars($esteticistaData['telefone_esteticista']); ?>" required>
                </div>

                <button type="submit" class="btn btn-primary">Atualizar</button>
            </form>
            <?php
        }

        // Fecha a conexão com o banco de dados
        $conn->close();
        ?>
    </div>
</body>
</html>