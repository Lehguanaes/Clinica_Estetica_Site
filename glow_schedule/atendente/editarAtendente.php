<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Atendente</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <script src="js/mascaraInput.js" defer></script>
</head>
<body>
    <div class="container">
        <h2>Editar Atendente</h2>

        <?php
        require_once $_SERVER['DOCUMENT_ROOT'] . "/glow_schedule/controller/conexao.php";
        require_once $_SERVER['DOCUMENT_ROOT'] . "/glow_schedule/model/atendente/atendente.php";

        $mensagem = "";
        $atendente = new Atendente();

        if (isset($_GET['cpf_atendente'])) {
            $cpf_atendente = $_GET['cpf_atendente'];

            $sql = "SELECT * FROM atendente WHERE cpf_atendente = ?";
            $conn = (new Conexao())->getConexao();

            if ($stmt = $conn->prepare($sql)) {
                $stmt->bind_param("s", $cpf_atendente);
                $stmt->execute();
                $result = $stmt->get_result();

                if ($result->num_rows > 0) {
                    $atendenteData = $result->fetch_assoc();
                    $atendente->setCpf($atendenteData['cpf_atendente']);
                    $atendente->setNome($atendenteData['nome_atendente']);
                    $atendente->setEmail($atendenteData['email_atendente']);
                    $atendente->setTelefone($atendenteData['telefone_atendente']);
                    $atendente->setFoto($atendenteData['foto_atendente']);
                } else {
                    echo "<p>Nenhum atendente encontrado com o CPF informado.</p>";
                }
                $stmt->close();
            } else {
                echo "Erro na consulta: " . $conn->error;
            }
        } else {
            echo "<p>CPF do atendente não foi informado.</p>";
        }

        if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['cpf_atendente'])) {
            $atendente->setCpf($_POST['cpf_atendente']);
            $atendente->setNome($_POST['nome_atendente']);
            $atendente->setEmail($_POST['email_atendente']);
            $atendente->setTelefone($_POST['telefone_atendente']);

            if (isset($_FILES['foto_atendente']) && $_FILES['foto_atendente']['error'] == UPLOAD_ERR_OK) {
                $target_dir = $_SERVER['DOCUMENT_ROOT'] . "/glow_schedule/uploads/";
                $target_file = $target_dir . basename($_FILES["foto_atendente"]["name"]);

                if (move_uploaded_file($_FILES["foto_atendente"]["tmp_name"], $target_file)) {
                    $atendente->setFoto("uploads/" . basename($_FILES["foto_atendente"]["name"]));
                } else {
                    echo "<p>Erro ao fazer upload da foto.</p>";
                }
            }

            if ($atendente->atualizar()) {
                echo "<p>Atendente atualizado com sucesso.</p>";
                header("Location: consultarAtendente.php");
                exit();
            } else {
                echo "<p>Erro ao atualizar atendente.</p>";
            }
        }

        if (isset($atendenteData)) {
            ?>
            <form method="POST" action="editarAtendente.php?cpf_atendente=<?php echo urlencode($atendenteData['cpf_atendente']); ?>" enctype="multipart/form-data">
                <input type="hidden" name="cpf_atendente" value="<?php echo htmlspecialchars($atendenteData['cpf_atendente']); ?>">

                <div class="form-group">
                    <label for="foto_atendente">Foto:</label><br>
                    <img src="<?php echo htmlspecialchars($atendenteData['foto_atendente']); ?>" alt="Foto do Atendente" style="width:100px;height:100px;"><br>
                    <input type="file" name="foto_atendente" id="foto_atendente" accept="image/*">
                </div>

                <div class="form-group">
                    <label for="nome_atendente">Nome:</label>
                    <input type="text" class="form-control" id="nome_atendente" name="nome_atendente" value="<?php echo htmlspecialchars($atendenteData['nome_atendente']); ?>" required>
                </div>

                <div class="form-group">
                    <label for="email_atendente">Email:</label>
                    <input type="email" class="form-control" id="email_atendente" name="email_atendente" value="<?php echo htmlspecialchars($atendenteData['email_atendente']); ?>" required>
                </div>

                <div class="form-group">
                    <label for="telefone_atendente">Telefone:</label>
                    <input type="text" class="form-control" id="telefone_atendente" name="telefone_atendente" value="<?php echo htmlspecialchars($atendenteData['telefone_atendente']); ?>" required>
                </div>

                <button type="submit" class="btn btn-primary">Atualizar</button>
            </form>
            <?php
        }

        $conn->close();
        ?>
    </div>
</body>
</html>