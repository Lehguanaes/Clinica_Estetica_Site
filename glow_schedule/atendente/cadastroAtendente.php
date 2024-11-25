<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8"> 
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Care Tones</title>
    <!-- Ícone para navegadores modernos -->
    <link rel="icon" href="../logo/Logo.png" type="image/png">
    <!-- Ícone para navegadores antigos -->
    <link rel="shortcut icon" href="../logo/Logo.png" type="image/x-icon">
    <!-- Links externos -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.16/jquery.mask.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css" integrity="sha512-MV7K8+y+gLIBoVD59lQIYicR65iaqukzvf/nwasF0nqhPay5w/9lJmVM2hMDcnK1OnMGCdVK+iQrJ7lzPJQd1w==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <!-- Estilização padrão do web site -->
    <link rel="stylesheet" href="../css/style.css">
    <!-- Estilização formulários de Perfis -->
    <link rel="stylesheet" href="../css/perfil.css">
    <!-- Estilização Navbar -->
    <link rel="stylesheet" href="../css/navbar.css">
</head>
<body>
    <!-- Início da Navbar -->
    <header>
        <nav class="nav-bar">
            <a class="logo" href="#"><img src="../logo/Logo.png" class="logoIMG">Care Tones</a>
            <ul class="nav-list">
                <li><a href="../atendente/visualizarDuvidas.php" class="nav">Dúvidas</a></li>
                <li><a href="../atendente/visualizarAvaliacoes.php" class="nav">Avaliações</a></li>
                <li><a href="../procedimento/consultarProcedimento.php" class="nav">Procedimentos</a></li>
                <li><a href="../atendente/visualizarConsultas.php" class="nav">Agenda</a></li>
                <li><a href="../agendamentoAtendente/agendamento.php" class="nav">Agendamento</a></li>
            </ul>
            <div class="dropdown">
                <div class="login-icon">
                    <a href="perfilAtendente.php">
                        <i class="fa-solid fa-circle-user fa-xl" style="color: #fff;"></i>
                    </a>
                    <div class="dropdown-content">
                        <a href="perfilAtendente.php"><i class="fa-solid fa-user fa-sm" style="color: #cf6f7a;"></i> Perfil </a>
                        <a href="../atendente/consultarCliente.php"><i class="fa-solid fa-users-line" style="color: #cf6f7a;"></i> Clientes </a>
                        <a href="../atendente/consultarAtendente.php"><i class="fa-solid fa-user-tie" style="color: #cf6f7a;"></i> Atendentes</a>
                        <a href="../atendente/consultarEsteticista.php"><i class="fa-solid fa-user-doctor" style="color: #cf6f7a;"></i> Profissionais </a>
                        <a href="../procedimento/consultarProcedimento.php"><i class="fa-brands fa-shopify" style="color: #cf6f7a;"></i> Procedimentos </a>
                        <a href="/glow_schedule/controller/logout.php"><i class="fa-solid fa-right-to-bracket fa-sm"></i> Sair</a>
                    </div>
            </div>
            </div>
            <div class="mobile-menu">
                <div class="line1"></div>
                <div class="line2"></div>
                <div class="line3"></div>
            </div>
        </nav>
    </header>
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
         <!-- Inicio Footer -->
    <footer>
        <div id="footer_content">
            <div id="footer_contacts">
                <a class="navbar-brand" href="#"> <img class="rounded-circle ms-4" src="../logo/Logo.png" alt="Logo care tones" width="69px"></a>
                <h3>Care Tones</h3>  
                <div id="footer_social_media">
                    <a href="#" class="footer-link" id="instagram">
                        <i class="fa-brands fa-instagram"></i>
                    </a>
                    <a href="#" class="footer-link" id="facebook">
                        <i class="fa-brands fa-facebook-f fa-xs"></i>
                    </a>
                    <a href="#" class="footer-link" id="whatsapp">
                        <i class="fa-brands fa-whatsapp"></i>
                    </a>
                    <a href="#" class="footer-link" id="localizacao">
                        <i class="fa-solid fa-location-dot"></i>
                    </a>
                </div>
            </div>
            <ul class="footer-list">
                <li>
                    <h4 id="subtitulo-footer">Cadastros</h4>
                </li>
                <li>
                    <a href="cadastrarClienteAtendente.php" class="footer-link">Cadastrar Cliente</a>
                </li>
                <li>
                    <a href="cadastroAtendente.php" class="footer-link">Cadastrar Atendentes</a>
                </li>
                <li>
                    <a href="cadastroEsteticista.php" class="footer-link">Cadastrar Profissionais</a>
                </li>
            </ul>
            <ul class="footer-list">
                <li>
                    <h4 id="subtitulo-footer">Interesses</h4>
                </li>
                <li>
                    <a href="visualizarConsultas.php" class="footer-link">Agenda</a>
                </li>
                <li>
                    <a href="visualizarAvaliacoes.php" class="footer-link">Avaliações</a>
                </li>
                <li>
                    <a href="visualizarDuvidas.php" class="footer-link">Dúvidas</a>
                </li>
            </ul>
            <div id="footer_subscribe">
                <h4 id="subtitulo-footer">Clínica</h4>
                <p>
                    Venha visualizar o que temos!
                </p>
                <ul class="footer-list">
                <li>
                    <a href="../esteticista/esteticistas.php" class="footer-link">Profissionais</a>
                </li>
                <li>
                    <a href="../procedimento/procedimentos.php" class="footer-link">Procedimentos</a>
                </li>
                </ul>
            </div>
        </div>
        <div id="footer_copyright">
            &#169
            2024 all rights reserved
        </div>
    </footer>
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
    <!-- Link Sweet Alert -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <!-- Link Js Navbar -->
    <script src="../js/navbar.js"></script>
</body>
</html>
