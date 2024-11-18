<?php
   require_once $_SERVER['DOCUMENT_ROOT'] . "/glow_schedule/model/message.php";
   require_once $_SERVER['DOCUMENT_ROOT'] . "/glow_schedule/controller/global.php";
   require_once $_SERVER['DOCUMENT_ROOT'] . "/glow_schedule/controller/conexao.php";

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
    <title>Cadastro de Esteticista</title>
    <!-- Links externos -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.16/jquery.mask.min.js"></script>
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
                        <a class="nav-link active" aria-current="page" href="cadastroEsteticista.php">Cadastro Esteticista</a>
                    </li>
                    <li class="nav-item pe-4 ps-4">
                        <a class="nav-link active" aria-current="page" href="FormularioDuvidas.php">Formulário de dúvidas</a>
                    </li>
                </ul>
                <button type="button" class="btn btn-sm btn-link me-4 ms-4" id="link_agendamentos_ativado"><a href="cadastrarConsulta.php" id="link_agendamentos_ativado">Agendamentos</a></button>
            </div>
        </div>
    </nav>
    <!-- Fim da Navbar -->
    <h2>Cadastro de Esteticista</h2>
    <!-- Cadastro de Esteticista -->
    <section class="container">
        <form method="POST" action="/glow_schedule/controller/esteticista/esteticistaController.php" enctype="multipart/form-data" class="form" id="form_perfil">
            <input type="hidden" name="acao" value="inserir">
            <!-- Linha com a Foto e CPF -->
            <div class="column">
                <div class="input-box">
                    <!-- Campo de Foto de Perfil -->
                    <div class="profile-pic-container">
                        <img src="../iconesPerfil/perfilPadrao.png" alt="Foto de perfil padrão" class="profile-pic" id="profile-pic-preview">
                        <label class="upload-button" for="foto_esteticista">
                            <i class="fa fa-plus"></i>
                        </label>
                        <input type="file" name="foto_esteticista" id="foto_esteticista" accept="image/*" onchange="previewProfilePic()" required>
                        <label id="label_foto_perfil" for="foto_esteticista">*Adicione a foto aqui:</label>
                    </div>
                </div>
            </div>
            <div class="column">
                <div class="input-box"> 
                    <label for="nome_esteticista">*Nome completo:</label>
                    <input type="text" class="form-control" id="nome_esteticista" name="nome_esteticista" placeholder="Digite o Nome Completo:" required>
                </div>
                <div class="input-box">
                    <label for="apelido_esteticista">*Nome Profissional:</label>
                    <input type="text" class="form-control" id="apelido_esteticista" name="apelido_esteticista" placeholder="Digite o Nome Profissional:" required>
                </div>
            </div>
            <div class="column">
                <div class="input-box">
                    <label for="cpf_esteticista">*CPF:</label>
                    <input type="text" class="form-control" id="cpf_esteticista" name="cpf_esteticista" required maxlength="14" placeholder="Digite o CPF:">
                </div>
                <div class="input-box">
                    <label for="telefone_esteticista">*Telefone:</label>
                    <input type="text" class="form-control" id="telefone_esteticista" name="telefone_esteticista" placeholder="Digite o Telefone:" required maxlength="15">
                </div>
            </div>   
            <div class="column">
                <div class="input-box">
                    <label for="email_esteticista">*E-mail:</label>
                    <input type="email" class="form-control" id="email_esteticista" name="email_esteticista" placeholder="Digite o E-mail:" required>
                </div>
                <div class="input-box">
                    <label for="senha_esteticista">*Senha:</label>
                    <div class="password-container">
                        <input type="password" class="form-control" id="senha_esteticista" name="senha_esteticista" placeholder="Digite a Senha:" required>
                        <span class="eye-icon" onclick="togglePasswordVisibility()">
                            <i id="eye-icon" class="fa fa-eye"></i>
                        </span>
                    </div>
                </div>
            </div>
            <div class="column">
                <div class="input-box">
                    <label for="formacao_esteticista">*Formação Acadêmica:</label>
                    <input type="text" class="form-control" id="formacao_esteticista" name="formacao_esteticista" placeholder="Digite a Formação Acadêmica:" required>
                </div>
            </div>
            <div class="column">
                <div class="input-box">
                    <label for="descricao_p_esteticista">*Descrição Curta:</label>
                    <textarea class="form-control" id="descricao_p_esteticista" name="descricao_p_esteticista" placeholder="Digite a Pequena Descrição Profissional:" required></textarea>
                </div>
            </div>
            <div class="column">
                <div class="input-box">
                    <label for="descricao_g_esteticista">*Descrição Detalhada:</label>
                    <textarea class="form-control" id="descricao_g_esteticista" name="descricao_g_esteticista" placeholder="Digite a Grande Descrição Profissional:" required></textarea>
                </div>
            </div>
            <div class="column">
                <div class="input-box">
                    <label for="instagram_esteticista">*Instagram:</label>
                    <input type="text" class="form-control" id="instagram_esteticista" name="instagram_esteticista" placeholder="Digite o Instagram:" >
                </div>
                <div class="input-box">
                    <label for="facebook_esteticista">*Facebook:</label>
                    <input type="text" class="form-control" id="facebook_esteticista" name="facebook_esteticista" placeholder="Digite o Facebook:" >
                </div>
                <div class="input-box">
                    <label for="linkedin_esteticista">*LinkedIn:</label>
                    <input type="text" class="form-control" id="linkedin_esteticista" name="linkedin_esteticista" placeholder="Digite o LinkedIn:" >
                </div>
            </div>
            <button id="botao_cadastrar" type="submit" class="btn btn-primary">Cadastrar</button>
        </form>
    </section>
    <!-- Fim formulário de cadastro -->
    <script>
        // Função para pré-visualizar a imagem selecionada do perfil
        function previewProfilePic() {
            // Seleciona o input de arquivo e o elemento de visualização de imagem
            const input = document.getElementById("foto_esteticista");
            const preview = document.getElementById("profile-pic-preview");
            // Obtém o arquivo selecionado pelo usuário
            const file = input.files[0];
            // Cria um FileReader para ler o conteúdo do arquivo
            const reader = new FileReader();
            // Define a ação a ser realizada quando a leitura for concluída
            reader.onloadend = function() {
                // Define o conteúdo lido como fonte (src) da imagem de pré-visualização
                preview.src = reader.result;
            };
            // Se um arquivo for selecionado, inicia a leitura como uma URL de dados
            if (file) {
                reader.readAsDataURL(file);
            }
        }
        // Máscara dos inputs
        $(document).ready(function() {
            // Aplica máscara para o campo de telefone, no formato "(00) 00000-0000"
            $('#telefone_esteticista').mask('(00) 00000-0000');
            // Aplica máscara para o campo de CPF, no formato "000.000.000-00"
            $('#cpf_esteticista').mask('000.000.000-00');
        });
        // Função para alternar a visibilidade do campo de senha
        function togglePasswordVisibility() {
            // Seleciona o campo de senha e o ícone do olho
            const passwordInput = document.getElementById("senha_esteticista");
            const eyeIcon = document.getElementById("eye-icon");
            // Verifica se o tipo de entrada é "password" para alternar
            if (passwordInput.type === "password") {
                // Torna a senha visível alterando o tipo para "text"
                passwordInput.type = "text";
                // Muda o ícone para o olho com barra (fa-eye-slash)
                eyeIcon.classList.remove("fa-eye");
                eyeIcon.classList.add("fa-eye-slash");
            } else {
                // Oculta a senha alterando o tipo de volta para "password"
                passwordInput.type = "password";
                // Muda o ícone de volta para o olho normal (fa-eye)
                eyeIcon.classList.remove("fa-eye-slash");
                eyeIcon.classList.add("fa-eye");
            }
        }
    </script>
</body>
</html>
