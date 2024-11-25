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
    <!-- Link Js Navbar -->
    <script src="../js/navbar.js"></script>
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
