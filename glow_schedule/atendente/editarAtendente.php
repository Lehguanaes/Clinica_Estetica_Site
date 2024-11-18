<?php
        require_once $_SERVER['DOCUMENT_ROOT'] . "/glow_schedule/controller/conexao.php";
        require_once $_SERVER['DOCUMENT_ROOT'] . "/glow_schedule/model/atendente/atendente.php";
        require_once $_SERVER['DOCUMENT_ROOT'] . "/glow_schedule/model/message.php";
        require_once $_SERVER['DOCUMENT_ROOT'] . "/glow_schedule/controller/global.php";

    $conexaoMini = new Conexao();
    $conexao = $conexaoMini->getConexao();
    $message = new Message($BASE_URL);
    $flashMsg = $message->getMessage();

   if (!empty($flashMsg["msg"])) {
    $message->limparMessage();
    }
    
    $token = $_SESSION['usuario_token'];
    $stmt = $conexao->prepare("SELECT * FROM atendente WHERE token_atendente = ?");

    if ($stmt === false) {

        die('Erro no sql: ' . $conexao->error);
    }
    $stmt->bind_param("s", $token);
    $stmt->execute();
    $resultado = $stmt->get_result();
    $atendente = $resultado->fetch_assoc();
       ?>

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
            <button class="navbar-toggler" type="button" -bs-toggle="collapse" -bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
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
        <!-- Início formulário de edição -->
        <form method="POST" action="../controller/atendente/atendenteController.php" enctype="multipart/form-data" class="form" id="form_perfil">
            <!-- Definindo a ação como "atualizar" -->
            <input type="hidden" name="acao" value="atualizar">
            <!-- token do atendente como campo oculto -->
            <input type="hidden" name="token_atendente" value="<?php echo htmlspecialchars($atendente['token_atendente']); ?>">
            <!-- Campo oculto para armazenar o caminho da foto atual -->
            <input type="hidden" name="foto_atual" value="<?php echo htmlspecialchars($atendente['foto_atendente']); ?>">
            <div class="column">
                <div class="input-box">
                    <div class="profile-pic-container">
                        <?php
                        // Verifica se a foto do atendente existe e não está vazia
                        $fotoPath = "/glow_schedule/" . htmlspecialchars($atendente['foto_atendente']);
                        $fotoExibida = (file_exists($_SERVER['DOCUMENT_ROOT'] . $fotoPath) && !empty($atendente['foto_atendente']))
                            ? $fotoPath
                            : "../iconesPerfil/perfilPadrao.png"; 
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
                    <input type="text" class="form-control" id="nome_atendente" name="nome_atendente"  placeholder="Digite o Nome Completo:" value="<?php echo htmlspecialchars($atendente['nome_atendente']); ?>" required>
                </div>
                <div class="input-box">
                    <label for="telefone_atendente">*Telefone:</label>
                    <input type="text" class="form-control" id="telefone_atendente" name="telefone_atendente"  placeholder="Digite o Telefone:" value="<?php echo htmlspecialchars($atendente['telefone_atendente']); ?>" required maxlength="15">
                </div>
            </div>
            <div class="column">
                <div class="input-box">
                    <label for="email_atendente">*E-mail:</label>
                    <input type="email" class="form-control" id="email_atendente" name="email_atendente" placeholder="Digite o E-mail:" value="<?php echo htmlspecialchars($atendente['email_atendente']); ?>" required>
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
                reader.readAsURL(file);
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
</body>
</html>
