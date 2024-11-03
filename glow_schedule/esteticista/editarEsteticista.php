<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Perfil Esteticista</title>
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
                    $esteticista->setSenha($esteticistaData['senha_esteticista']);
                    $esteticista->setFoto($esteticistaData['foto_esteticista']);
                    $esteticista->setFormacao($esteticistaData['formacao_esteticista']);
                    $esteticista->setDescricaoP($esteticistaData['descricao_p_esteticista']);
                    $esteticista->setDescricaoG($esteticistaData['descricao_g_esteticista']);
                    $esteticista->setInstagram($esteticistaData['instagram_esteticista']);
                    $esteticista->setFacebook($esteticistaData['facebook_esteticista']);
                    $esteticista->setLinkedin($esteticistaData['linkedin_esteticista']);
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
            // Define todos os campos menos o CPF
            $esteticista->setNome($_POST['nome_esteticista']);
            $esteticista->setApelido($_POST['apelido_esteticista']);
            $esteticista->setEmail($_POST['email_esteticista']);
            $esteticista->setTelefone($_POST['telefone_esteticista']);
            $esteticista->setFormacao($_POST['formacao_esteticista']);
            $esteticista->setDescricaoP($_POST['descricao_p_esteticista']);
            $esteticista->setDescricaoG($_POST['descricao_g_esteticista']);
            $esteticista->setInstagram($_POST['instagram_esteticista']);
            $esteticista->setFacebook($_POST['facebook_esteticista']);
            $esteticista->setLinkedin($_POST['linkedin_esteticista']);

            // Verifica se uma nova senha foi enviada
            if (!empty($_POST['senha_esteticista'])) {
                $esteticista->setSenha($_POST['senha_esteticista']);
            }
            // Verifica se uma nova foto foi enviada
            if (isset($_FILES['foto_esteticista']) && $_FILES['foto_esteticista']['error'] == UPLOAD_ERR_OK) {
                $target_dir = $_SERVER['DOCUMENT_ROOT'] . "/glow_schedule/uploads/";
                $target_file = $target_dir . basename($_FILES["foto_esteticista"]["name"]);

                // Move a nova foto para o diretório de uploads
                if (move_uploaded_file($_FILES["foto_esteticista"]["tmp_name"], $target_file)) {
                    $esteticista->setFoto("uploads/" . basename($_FILES["foto_esteticista"]["name"])); // Atualiza a foto com a nova
                } else {
                    echo "<p>Erro ao fazer upload da foto.</p>";
                }
            } else {
                // Mantém a foto existente se nenhuma nova for enviada
                $esteticista->setFoto($_POST['foto_atual']);
            }

            // Atualiza os dados no banco de dados
            if ($esteticista->atualizar()) {
                echo "<p>Esteticista atualizado com sucesso.</p>";
                header("Location: consultarEsteticista.php");
                exit();
            } else {
                echo "<p>Erro ao atualizar os dados.</p>";
            }

        }
        // Verifica se os dados do esteticista foram encontrados para exibir o formulário
        if (isset($esteticistaData)) {
        ?>
        <form method="POST" action="editarEsteticista.php?cpf_esteticista=<?php echo urlencode($esteticistaData['cpf_esteticista']); ?>" enctype="multipart/form-data" class="form" id="form_perfil">
            <!-- Definindo o CPF do esteticista como campo oculto -->
            <input type="hidden" name="cpf_esteticista" value="<?php echo htmlspecialchars($esteticistaData['cpf_esteticista']); ?>">
            <!-- Campo oculto para armazenar o caminho da foto atual -->
            <input type="hidden" name="foto_atual" value="<?php echo htmlspecialchars($esteticistaData['foto_esteticista']); ?>">
            
            <!-- Foto do esteticista com pré-visualização -->
            <div class="column">
                <div class="input-box">
                    <div class="profile-pic-container">
                        <?php
                            // Verifica se a foto do esteticista existe e não está vazia
                            $fotoPath = "/glow_schedule/" . htmlspecialchars($esteticistaData['foto_esteticista']);
                            $fotoExibida = (file_exists($_SERVER['DOCUMENT_ROOT'] . $fotoPath) && !empty($esteticistaData['foto_esteticista']))
                                ? $fotoPath
                                : "../iconesPerfil/perfilPadrao.png"; // Caminho da imagem padrão
                        ?>
                        <img src="<?php echo $fotoExibida; ?>" alt="Foto de perfil do esteticista" class="profile-pic" id="profile-pic-preview">
                        <label class="upload-button" for="foto_esteticista">
                            <i class="fa fa-plus"></i>
                        </label>
                        <input type="file" name="foto_esteticista" id="foto_esteticista" accept="image/*" onchange="previewProfilePic()">
                        <label id="label_foto_perfil" for="foto_esteticista">*Adicione a foto aqui:</label>
                    </div>
                </div>
            </div>
            <!-- Campos de entrada para informações do esteticista -->
            <div class="column">
                <div class="input-box">
                    <label for="nome_esteticista">*Nome:</label>
                    <input type="text" class="form-control" id="nome_esteticista" name="nome_esteticista" placeholder="Digite o Nome Completo:"  value="<?php echo htmlspecialchars($esteticistaData['nome_esteticista']); ?>" required>
                </div>
            </div>
            <div class="column">
                <div class="input-box">
                    <label for="apelido_esteticista">*Apelido:</label>
                    <input type="text" class="form-control" id="apelido_esteticista" name="apelido_esteticista" placeholder="Digite o Nome Profissional:"  value="<?php echo htmlspecialchars($esteticistaData['apelido_esteticista']); ?>" required>
                </div>
                <div class="input-box">
                    <label for="telefone_esteticista">*Telefone:</label>
                    <input type="text" class="form-control" id="telefone_esteticista" name="telefone_esteticista" placeholder="Digite o Telefone:" value="<?php echo htmlspecialchars($esteticistaData['telefone_esteticista']); ?>" required>
                </div>
            </div>
            <div class="column">
                <div class="input-box">
                    <label for="email_esteticista">*E-mail:</label>
                    <input type="email" class="form-control" id="email_esteticista" name="email_esteticista" placeholder="Digite o E-mail:" value="<?php echo htmlspecialchars($esteticistaData['email_esteticista']); ?>" required>
                </div>
                <div class="input-box">
                    <label for="senha_esteticista">*Senha:</label>
                    <div class="password-container">
                        <input type="password" class="form-control" id="senha_esteticista" name="senha_esteticista" placeholder="Digite a senha:"  value="<?php echo htmlspecialchars($esteticistaData['senha_esteticista']); ?>" required>
                        <span class="eye-icon" onclick="togglePasswordVisibility()">
                            <i id="eye-icon" class="fa fa-eye"></i>
                        </span>
                    </div>
                </div>
            </div>
            <div class="column">
                <div class="input-box">
                    <label for="formacao_esteticista">*Formação Acadêmica:</label>
                    <input type="text" class="form-control" id="formacao_esteticista" name="formacao_esteticista"  placeholder="Digite a Formação:"  value="<?php echo htmlspecialchars($esteticistaData['formacao_esteticista']); ?>" required>
                </div>
            </div>
            <div class="column">
                <div class="input-box">
                    <label for="descricao_p_esteticista">*Descrição Curta:</label>
                    <textarea class="form-control" id="descricao_p_esteticista" name="descricao_p_esteticista" placeholder="Digite a Pequena Descrição Profissional:" required><?php echo htmlspecialchars($esteticistaData['descricao_p_esteticista']); ?></textarea>
                </div>
            </div>
            <div class="column">
                <div class="input-box">
                    <label for="descricao_g_esteticista">*Descrição Detalhada:</label>
                    <textarea class="form-control" id="descricao_g_esteticista" name="descricao_g_esteticista" placeholder="Digite a Grande Descrição Profissional:" required><?php echo htmlspecialchars($esteticistaData['descricao_g_esteticista']); ?></textarea>
                </div>
            </div>
            <div class="column">
                <div class="input-box">
                    <label for="instagram_esteticista">*Instagram:</label>
                    <input type="text" class="form-control" id="instagram_esteticista" name="instagram_esteticista" placeholder="Digite o Instagram:" value="<?php echo htmlspecialchars($esteticistaData['instagram_esteticista']); ?>" placeholder="Digite o Instagram:" required>
                </div>
                <div class="input-box">
                    <label for="facebook_esteticista">*Facebook:</label>
                    <input type="text" class="form-control" id="facebook_esteticista" name="facebook_esteticista" placeholder="Digite o Facebook:" value="<?php echo htmlspecialchars($esteticistaData['facebook_esteticista']); ?>" placeholder="Digite o Facebook:" required>
                </div>
                <div class="input-box">
                    <label for="linkedin_esteticista">*LinkedIn:</label>
                    <input type="text" class="form-control" id="linkedin_esteticista" name="linkedin_esteticista" placeholder="Digite o LinkedIn:" value="<?php echo htmlspecialchars($esteticistaData['linkedin_esteticista']); ?>" placeholder="Digite o LinkedIn:" required>
                </div>
            </div>
            <button type="submit" class="btn btn-primary">Atualizar</button>
        </form>
    </section>
    <script>
        // Máscara dos inputs
        $(document).ready(function() {
            // Aplica a máscara de telefone ao campo com ID 'telefone_esteticista'
            $('#telefone_esteticista').mask('(00) 00000-0000');
        });
        // Função para pré-visualizar a imagem selecionada do perfil
        function previewProfilePic() {
            // Obtém o elemento de input de arquivo e o elemento de imagem para pré-visualização
            const input = document.getElementById("foto_esteticista");
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
            const passwordInput = document.getElementById("senha_esteticista");
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
