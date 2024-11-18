<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Perfil Atendentes</title>
    <!-- Links externos -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.16/jquery.mask.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css" integrity="sha512-MV7K8+y+gLIBoVD59lQIYicR65iaqukzvf/nwasF0nqhPay5w/9lJmVM2hMDcnK1OnMGCdVK+iQrJ7lzPJQd1w==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <!-- Estilização formulários de Perfis -->
    <link rel="stylesheet" href="../css/perfil.css">
    <!-- Estilização padrão do web site -->
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>
    <nav class="navbar navbar-expand-lg">
        <div class="container-fluid">
            <a class="navbar-brand"> <img class="rounded-circle ms-4" src="../logo/Logo.png" alt="Logo care tones" width="69px"> </a>
            <div class="logo">
                <a class="nav-link active" aria-current="page" href="home.php">Care Tones</a>
            </div>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav w-auto">
                    <li class="nav-item pe-4 ps-4">
                        <a class="nav-link active" aria-current="page" href="agenda.php">Agenda</a>
                    </li>
                    <li class="nav-item pe-4 ps-4">
                        <a class="nav-link active" aria-current="page" href="cadastroProcedimento.php">Cadastro Procedimento</a>
                    </li>
                    <li class="nav-item pe-4 ps-4">
                        <a class="nav-link active" aria-current="page" href="FormularioDuvidas.php">Formulário de dúvidas</a>
                    </li>
                </ul>
                <button type="button" class="btn btn-sm btn-link me-4 ms-4" id="link_agendamentos_ativado"> <a href="cadastrarConsulta.php" id="link_agendamentos_ativado">Agendamentos</a></button>
            </div>
        </div>
    </nav>

    <h2>Editar Procedimento</h2>

    <section class="container">
        <?php
        require_once $_SERVER['DOCUMENT_ROOT'] . "/glow_schedule/controller/conexao.php";
        require_once $_SERVER['DOCUMENT_ROOT'] . "/glow_schedule/model/procedimento/procedimento.php";

        $procedimento = new Procedimento();
        if (isset($_GET['id_procedimento'])) {
            $id_procedimento = $_GET['id_procedimento'];

            $sql = "SELECT * FROM procedimento WHERE id_procedimento = ?";
            $conn = (new Conexao())->getConexao();

            if ($stmt = $conn->prepare($sql)) {
                $stmt->bind_param("i", $id_procedimento);
                $stmt->execute();
                $result = $stmt->get_result();

                if ($result->num_rows > 0) {
                    $procedimentoData = $result->fetch_assoc();
                    $procedimento->setId($procedimentoData['id_procedimento']);
                    $procedimento->setNome($procedimentoData['nome_procedimento']);
                    $procedimento->setDescricaoP($procedimentoData['descricao_p_procedimento']);
                    $procedimento->setDescricaoG($procedimentoData['descricao_g_procedimento']);
                    $procedimento->setPreco($procedimentoData['preco_procedimento']);
                    $procedimento->setDuracao($procedimentoData['duracao_procedimento']);
                    $procedimento->setManutencao($procedimentoData['manutencao_procedimento']);
                    $procedimento->setFoto($procedimentoData['foto_procedimento']);
                } else {
                    echo "<p>Nenhum procedimento encontrado com o ID informado.</p>";
                }
                $stmt->close();
            } else {
                echo "Erro na consulta: " . $conn->error;
            }
        } else {
            echo "<p>ID do procedimento não foi informado.</p>";
        }

        if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['id_procedimento'])) {
            $procedimento->setId($_POST['id_procedimento']);
            $procedimento->setNome($_POST['nome_procedimento']);
            $procedimento->setDescricaoP($_POST['descricao_p_procedimento']);
            $procedimento->setDescricaoG($_POST['descricao_g_procedimento']);
            $procedimento->setPreco($_POST['preco_procedimento']);
            $procedimento->setDuracao($_POST['duracao_procedimento']);
            $procedimento->setManutencao($_POST['manutencao_procedimento']);

            // Verifica se uma nova foto foi enviada
            if (isset($_FILES['foto_procedimento']) && $_FILES['foto_procedimento']['error'] == UPLOAD_ERR_OK) {
                $target_dir = $_SERVER['DOCUMENT_ROOT'] . "/glow_schedule/uploads/";
                $file_name = uniqid() . "." . pathinfo($_FILES["foto_procedimento"]["name"], PATHINFO_EXTENSION);
                $target_file = $target_dir . $file_name;

                if (move_uploaded_file($_FILES["foto_procedimento"]["tmp_name"], $target_file)) {
                    $procedimento->setFoto("uploads/" . $file_name);
                } else {
                    echo "<p>Erro ao fazer upload da foto.</p>";
                }
            } else {
                $procedimento->setFoto($_POST['foto_atual']);
            }

            if ($procedimento->atualizar()) {
                echo "<p>Procedimento atualizado com sucesso.</p>";
                header("Location: consultarProcedimento.php");
                exit();
            } else {
                echo "<p>Erro ao atualizar procedimento.</p>";
            }
        }

        if (isset($procedimentoData)) {
        ?>
        <form method="POST" action="" class="form" id="form_perfil" enctype="multipart/form-data">
            <input type="hidden" name="acao" value="atualizar">
            <input type="hidden" name="id_procedimento" value="<?php echo htmlspecialchars($procedimentoData['id_procedimento']); ?>">
            <div class="column">
                <div class="input-box">
                    <div class="profile-pic-container">
                            <?php
                            $fotoPath = "/glow_schedule/" . htmlspecialchars($procedimentoData['foto_procedimento']);
                            $fotoExibida = (file_exists($_SERVER['DOCUMENT_ROOT'] . $fotoPath) && !empty($procedimentoData['foto_procedimento']))
                                ? $fotoPath
                                : "../iconesProcedimento/procedimentoPadrao.png";
                            ?>
                            <img src="<?php echo $fotoExibida; ?>" alt="Foto de Procedimento" class="profile-pic" id="profile-pic-preview">
                            <label class="upload-button" for="foto_procedimento">
                                <i class="fa fa-plus"></i>
                            </label>
                            <input type="file" name="foto_procedimento" id="foto_procedimento" accept="image/*" onchange="previewProfilePic()">
                            <input type="hidden" name="foto_atual" value="<?php echo htmlspecialchars($procedimentoData['foto_procedimento']); ?>">
                        </div>
                    </div>
                </div>
            </div>
            <div class="column">
                <div class="input-box">
                    <label for="nome_procedimento">*Nome:</label>
                    <input type="text" class="form-control" id="nome_procedimento" name="nome_procedimento" placeholder="Digite o Nome do Procedimento" value="<?php echo htmlspecialchars($procedimentoData['nome_procedimento']); ?>" required>
                </div>
                <div class="column">
                    <div class="input-box">
                        <label for="duracao_procedimento">*Duração:</label>
                        <input type="text" class="form-control" id="duracao_procedimento" name="duracao_procedimento" placeholder="Digite a duração do procedimento" value="<?php echo htmlspecialchars($procedimentoData['duracao_procedimento']); ?>" required>
                    </div>
                </div>
                <div class="column">
                    <div class="input-box">
                        <label for="manutencao_procedimento">Manutenção:</label>
                        <input type="text" class="form-control" id="manutencao_procedimento" name="manutencao_procedimento" placeholder="Digite a manutenção" value="<?php echo htmlspecialchars($procedimentoData['manutencao_procedimento']); ?>">
                    </div>
                </div>
                <div class="column">
                    <div class="input-box">
                        <label for="descricao_p_procedimento">Descrição Pequena:</label>
                        <textarea class="form-control" id="descricao_p_procedimento" name="descricao_p_procedimento" placeholder="Digite uma breve descrição"><?php echo htmlspecialchars($procedimentoData['descricao_p_procedimento']); ?></textarea>
                    </div>
                </div>
                <div class="column">
                    <div class="input-box">
                        <label for="descricao_g_procedimento">Descrição Grande:</label>
                        <textarea class="form-control" id="descricao_g_procedimento" name="descricao_g_procedimento" placeholder="Digite uma descrição completa"><?php echo htmlspecialchars($procedimentoData['descricao_g_procedimento']); ?></textarea>
                    </div>
                </div>
                <div class="column">
                    <div class="input-box">
                        <label for="preco_procedimento">*Preço:</label>
                        <input type="number" class="form-control" id="preco_procedimento" name="preco_procedimento" placeholder="Digite o preço do procedimento" value="<?php echo htmlspecialchars($procedimentoData['preco_procedimento']); ?>" required>
                    </div>
                </div>
            </div>
            <div class="button-row">
                <button type="submit" class="btn btn-primary">Atualizar</button>
            </div>
        </form>
        <?php } ?>
    </section>

    <script>
    function previewProfilePic() {
        const fileInput = document.getElementById('foto_procedimento');
        const previewImage = document.getElementById('profile-pic-preview');
        const file = fileInput.files[0];

        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                previewImage.src = e.target.result;
            };
            reader.readAsDataURL(file);
        }
    }
    </script>
</body>
</html>
