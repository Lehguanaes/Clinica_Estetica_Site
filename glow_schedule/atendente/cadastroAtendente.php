<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro de Atendentes</title>
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
    <h2>Cadastro do Atendente</h2>
    <!-- Início formulário de cadastro -->
    <section class="container">
        <form method="POST" action="/glow_schedule/controller/atendente/atendenteController.php" enctype="multipart/form-data" class="form" id="form_perfil">
            <input type="hidden" name="acao" value="inserir"> 
            <div class="column">
                <div class="input-box">
                    <!-- Campo de Foto de Perfil -->
                    <div class="profile-pic-container">
                        <img src="../iconesPerfil/perfilPadrao.png" alt="Foto de perfil padrão" class="profile-pic" id="profile-pic-preview">
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
                    <input type="text" class="form-control" id="nome_atendente" name="nome_atendente"  placeholder="Digite o Nome Completo:" required>
                </div>
            </div>
            <div class="column">
                <div class="input-box">
                    <label for="cpf_atendente">*CPF:</label>
                    <input type="text" class="form-control" id="cpf_atendente" name="cpf_atendente"  placeholder="Digite o CPF:" required maxlength="14">
                </div>
                <div class="input-box">
                    <label for="telefone_atendente">*Telefone:</label>
                    <input type="text" class="form-control" id="telefone_atendente" name="telefone_atendente"  placeholder="Digite o Telefone:" required maxlength="15">
                </div>
            </div>
            <div class="column">
                <div class="input-box">
                    <label for="email_atendente">*E-mail:</label>
                    <input type="email" class="form-control" id="email_atendente" name="email_atendente"  placeholder="Digite o E-mail:" required>
                </div>
                <div class="input-box">
                    <label for="senha_atendente">*Senha:</label>
                    <div class="password-container">
                        <input type="password" class="form-control" id="senha_atendente" name="senha_atendente" placeholder="Digite a Senha:" required>
                        <span class="eye-icon" onclick="togglePasswordVisibility()">
                            <i id="eye-icon" class="fa fa-eye"></i>
                        </span>
                    </div>
                </div>
            </div>
            <button type="submit" class="btn btn-primary">Cadastrar</button>
        </form>
    </section>
    <!-- Fim formulário de cadastro -->
    <script>
        // Função para pré-visualizar a imagem selecionada do perfil
        function previewProfilePic() {
            // Seleciona o input de arquivo e o elemento de visualização de imagem
            const input = document.getElementById("foto_atendente");
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
            $('#telefone_atendente').mask('(00) 00000-0000');
            // Aplica máscara para o campo de CPF, no formato "000.000.000-00"
            $('#cpf_atendente').mask('000.000.000-00');
        });
        // Função para alternar a visibilidade do campo de senha
        function togglePasswordVisibility() {
            // Seleciona o campo de senha e o ícone do olho
            const passwordInput = document.getElementById("senha_atendente");
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
