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
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css" integrity="sha512-MV7K8+y+gLIBoVD59lQIYicR65iaqukzvf/nwasF0nqhPay5w/9lJmVM2hMDcnK1OnMGCdVK+iQrJ7lzPJQd1w==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
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
                <li><a href="visualizarConsultas.php" class="nav">Agenda</a></li>
                <li><a href="../agendamentoAtendente/agendamento.php" class="nav">Agendamento</a></li>
            </ul>
            <div class="dropdown">
                <div class="login-icon">
                    <a href="perfilAtendente.php">
                        <i class="fa-solid fa-circle-user fa-xl" style="color: #fff;"></i>
                    </a>
                    <div class="dropdown-content">
                        <a href="../atendente/perfilAtendente.php"><i class="fa-solid fa-user fa-sm" style="color: #cf6f7a;"></i> Perfil </a>
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
    <h2>Cadastro de Procedimento</h2>
    <!-- Cadastro de Procedimento -->
    <section class="container">
        <form method="POST" action="/glow_schedule/controller/esteticista/esteticistaController.php" enctype="multipart/form-data" class="form" id="form_perfil">
            <input type="hidden" name="acao" value="inserir">
            <!-- Linha com a Foto e CPF -->
            <div class="column">
                <div class="input-box">
                    <!-- Campo de Foto de Perfil -->
                    <div class="profile-pic-container">
                    <img src="../iconesProcedimento/procedimentoPadrao.png" alt="Foto de procedimento padrão" class="profile-pic" id="procedimento-pic-preview">
                        <label class="upload-button" for="foto_procedimento">
                            <i class="fa fa-plus"></i>
                        </label>
                        <input type="file" name="foto_procedimento" id="foto_procedimento" accept="image/*" onchange="previewProcedimentoPic()" required>
                        <label id="label_foto_perfil" for="foto_procedimento">*Adicione a foto aqui:</label>
                    </div>
                </div>
            </div>
            <div class="column">
                <div class="input-box">
                    <label for="nome_procedimento">*Nome do Procedimento:</label>
                    <input type="text" class="form-control" id="nome_procedimento" name="nome_procedimento" placeholder="Digite o Nome do Procedimento:" required>
                </div>
                <!-- Campo de Preço do Procedimento -->
                <div class="input-box">
                    <label for="preco_procedimento">*Preço:</label>
                    <input type="text" class="form-control" id="preco_procedimento" name="preco_procedimento" placeholder="Digite o preço do procedimento" required>
                </div>
            </div>
            <!-- Duração do Procedimento -->
            <div class="column">
                <div class="input-box">
                    <label for="duracao_procedimento">*Duração:</label>
                    <input type="text" class="form-control" id="duracao_procedimento" name="duracao_procedimento" placeholder="Digite a duração do procedimento" required>
                </div>
                <!-- Manutenção do Procedimento -->
                <div class="input-box">
                    <label for="manutencao_procedimento">*Manutenção:</label>
                    <input type="text" class="form-control" id="manutencao_procedimento" name="manutencao_procedimento" placeholder="Digite a manutenção do procedimento" required>
                </div>
            </div>
            <!-- Descrição Curta do Procedimento -->
            <div class="column">
                <div class="input-box">
                    <label for="descricao_p_procedimento">*Descrição Curta:</label>
                    <textarea class="form-control" id="descricao_p_procedimento" name="descricao_p_procedimento" placeholder="Digite uma breve descrição do procedimento:" required></textarea>
                </div>
            </div>
            <!-- Descrição Detalhada do Procedimento -->
            <div class="column">
                <div class="input-box">
                    <label for="descricao_g_procedimento">*Descrição Detalhada:</label>
                    <textarea class="form-control" id="descricao_g_procedimento" name="descricao_g_procedimento" placeholder="Digite uma descrição detalhada do procedimento:" required></textarea>
                </div>
            </div>
            <!-- Botão de Submissão -->
            <button id="botao_cadastrar" type="submit" class="btn btn-primary">Cadastrar</button>
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
                    <a href="../atendente/cadastrarClienteAtendente.php" class="footer-link">Cadastrar Cliente</a>
                </li>
                <li>
                    <a href="../atendente/cadastroAtendente.php" class="footer-link">Cadastrar Atendentes</a>
                </li>
                <li>
                    <a href="../atendente/cadastroEsteticista.php" class="footer-link">Cadastrar Profissionais</a>
                </li>
            </ul>
            <ul class="footer-list">
                <li>
                    <h4 id="subtitulo-footer">Interesses</h4>
                </li>
                <li>
                    <a href="../atendente/visualizarConsultas.php" class="footer-link">Agenda</a>
                </li>
                <li>
                    <a href="../atendente/visualizarAvaliacoes.php" class="footer-link">Avaliações</a>
                </li>
                <li>
                    <a href="../atendente/visualizarDuvidas.php" class="footer-link">Dúvidas</a>
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
    <!-- Script de Pré-visualização da Imagem -->
    <script>
        function previewProcedimentoPic() {
            const file = document.getElementById("foto_procedimento").files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    document.getElementById("procedimento-pic-preview").src = e.target.result;
                };
                reader.readAsDataURL(file);
            }
        }
    </script>
</body>
</html>
