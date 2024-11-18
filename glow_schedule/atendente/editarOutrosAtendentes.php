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
    <!-- Estilização padrão do web site -->
    <link rel="stylesheet" href="../css/style.css">
    <!-- Estilização formulários de Perfis -->
    <link rel="stylesheet" href="../css/perfil.css">
</head>
<body>
    <!-- Início da Navbar -->
    <nav class="navbar navbar-expand-lg">
        <div class="container-fluid">
            <a class="navbar-brand"> <img class="rounded-circle ms-4" src="../logo/Logo.png" alt="Logo care tones" width="69px"> </a>
            <link rel="preconnect" href="https://fonts.googleapis.com">
            <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
            <link href="https://fonts.googleapis.com/css2?family=Cinzel&family=Playfair+Display:ital@1&display=swap" rel="stylesheet">
            <div class="logo">
                <a class="nav-link active" aria-current="page" href="home.php">Care Tones</a>
            </div>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent" >
                <ul class="navbar-nav w-auto">
                    <li class="nav-item pe-4 ps-4">
                        <a class="nav-link active" aria-current="page" href="agenda.php">Agenda</a>
                    </li>
                    <li class="nav-item pe-4 ps-4">
                        <a class="nav-link active" aria-current="page" href="cadastroEsteticista.php">Cadastro Esteticista</a>
                    </li>
                    <li class="nav-item pe-4 ps-4">
                        <a class="nav-link active" aria-current="page" href="FormularioDuvidas.php">Formulário de dúvidas</a>
                    </li>
                </ul>
                <button type="button" class="btn btn-sm btn-link me-4 ms-4" id="link_agendamentos_ativado" > <a href="cadastrarConsulta.php" id="link_agendamentos_ativado">Agendamentos</a></button>
            </div>
        </div>
    </nav>
    <!-- Fim da Navbar -->
    <h2>Editar Perfil</h2>
    <!-- Exibição do perfil para edição -->
    <section class="container">
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
                    $atendente->setSenha($atendenteData['senha_atendente']);
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
            $atendente->setSenha($_POST['senha_atendente']);

            // Verifica se uma nova foto foi enviada
            if (isset($_FILES['foto_atendente']) && $_FILES['foto_atendente']['error'] == UPLOAD_ERR_OK) {
                $target_dir = $_SERVER['DOCUMENT_ROOT'] . "/glow_schedule/uploads/";
                $target_file = $target_dir . basename($_FILES["foto_atendente"]["name"]);

                if (move_uploaded_file($_FILES["foto_atendente"]["tmp_name"], $target_file)) {
                    $atendente->setFoto("uploads/" . basename($_FILES["foto_atendente"]["name"]));
                } else {
                    echo "<p>Erro ao fazer upload da foto.</p>";
                }
            } else {
                // Mantém a foto existente se nenhuma nova for enviada
                $atendente->setFoto($_POST['foto_atual']);
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
        <!-- Início formulário de edição -->
        <form method="POST" action="" enctype="multipart/form-data" class="form" id="form_perfil">
            <!-- Definindo a ação como "atualizar" -->
            <input type="hidden" name="acao" value="atualizar">
            <!-- CPF do atendente como campo oculto -->
            <input type="hidden" name="cpf_atendente" value="<?php echo htmlspecialchars($atendenteData['cpf_atendente']); ?>">
            <!-- Campo oculto para armazenar o caminho da foto atual -->
            <input type="hidden" name="foto_atual" value="<?php echo htmlspecialchars($atendenteData['foto_atendente']); ?>">
            <div class="column">
                <div class="input-box">
                    <div class="profile-pic-container">
                        <?php
                        // Verifica se a foto do atendente existe e não está vazia
                        $fotoPath = "/glow_schedule/" . htmlspecialchars($atendenteData['foto_atendente']);
                        $fotoExibida = (file_exists($_SERVER['DOCUMENT_ROOT'] . $fotoPath) && !empty($atendenteData['foto_atendente']))
                            ? $fotoPath
                            : "../iconesPerfil/perfilPadrao.png"; // Caminho da imagem padrão
                        ?>
                        <img src="<?php echo $fotoExibida; ?>" alt="Foto de perfil do atendente" class="profile-pic" id="profile-pic-preview">
                        <label class="upload-button" for="foto_atendente">
                            <i class="fa fa-plus"></i>
                        </label>
                        <input type="file" name="foto_atendente" id="foto_atendente" accept="image/*" onchange="previewProfilePic()">
                        <label id="label_foto_perfil" for="foto_atendente">Adicione a foto aqui:</label>
                    </div>
                </div>
            </div>
            <div class="column">
                <div class="input-box">
                    <label for="nome_atendente">*Nome:</label>
                    <input type="text" class="form-control" id="nome_atendente" name="nome_atendente"  placeholder="Digite o Nome Completo:" value="<?php echo htmlspecialchars($atendenteData['nome_atendente']); ?>" required>
                </div>
                <div class="input-box">
                    <label for="telefone_atendente">*Telefone:</label>
                    <input type="text" class="form-control" id="telefone_atendente" name="telefone_atendente"  placeholder="Digite o Telefone:" value="<?php echo htmlspecialchars($atendenteData['telefone_atendente']); ?>" required maxlength="15">
                </div>
            </div>
            <div class="column">
                <div class="input-box">
                    <label for="email_atendente">*E-mail:</label>
                    <input type="email" class="form-control" id="email_atendente" name="email_atendente" placeholder="Digite o E-mail:" value="<?php echo htmlspecialchars($atendenteData['email_atendente']); ?>" required>
                </div>
                <div class="input-box">
                    <label for="senha_atendente">*Senha Atual:</label>
                    <div class="password-container">
                        <input type="password" class="form-control" id="senha_atendente" name="senha_atendente" placeholder="Digite a Senha:"  >
                        <span class="eye-icon" onclick="togglePasswordVisibility()">
                            <i id="eye-icon" class="fa fa-eye"></i>
                        </span>
                    </div>
                </div>
                <div class="input-box">
                    <label for="senha_atendente">*Senha nova:</label>
                    <div class="password-container">
                        <input type="password" class="form-control" id="nova_senha" name="nova_senha" placeholder="Digite a Senha:"  >
                        <span class="eye-icon" onclick="togglePasswordVisibility()">
                            <i id="eye-icon" class="fa fa-eye"></i>
                        </span>
                    </div>
                </div>
            </div>
            <button type="submit" class="btn btn-primary">Atualizar</button>
        </form>
    </section>
    <script>
        // Máscara dos inputs
        $(document).ready(function() {
            // Aplica a máscara de telefone ao campo com ID 'telefone_atendente'
            $('#telefone_atendente').mask('(00) 00000-0000');
        });

        // Função para pré-visualizar a imagem selecionada do perfil
        function previewProfilePic() {
            // Obtém o elemento de input de arquivo e o elemento de imagem para pré-visualização
            const input = document.getElementById("foto_atendente");
            const preview = document.getElementById("profile-pic-preview");

            // Pega o arquivo selecionado
            const file = input.files[0];
            const reader = new FileReader(); // Cria um novo FileReader para ler o arquivo

            // Define a função que será chamada quando a leitura do arquivo estiver concluída
            reader.onloadend = function() {
                // Define a fonte da imagem de pré-visualização como o resultado da leitura do arquivo
                preview.src = reader.result;
            };

            // Se um arquivo foi selecionado, lê como URL de dados
            if (file) {
                reader.readAsDataURL(file);
            }
        }

        // Função para alternar a visibilidade da senha
        function togglePasswordVisibility() {
            // Obtém o campo de entrada de senha e o ícone que mostra/esconde a senha
            const passwordInput = document.getElementById("senha_atendente");
            const eyeIcon = document.getElementById("eye-icon");

            // Verifica o tipo atual do campo de senha
            if (passwordInput.type === "password") {
                passwordInput.type = "text"; // Altera para texto para mostrar a senha
                eyeIcon.classList.remove("fa-eye"); // Remove o ícone de olho aberto
                eyeIcon.classList.add("fa-eye-slash"); // Adiciona o ícone de olho fechado
            } else {
                passwordInput.type = "password"; // Altera de volta para senha
                eyeIcon.classList.remove("fa-eye-slash"); // Remove o ícone de olho fechado
                eyeIcon.classList.add("fa-eye"); // Adiciona o ícone de olho aberto
            }
        }
    </script>
    <?php
    }
    $conn->close();
    ?>
</body>
</html>
