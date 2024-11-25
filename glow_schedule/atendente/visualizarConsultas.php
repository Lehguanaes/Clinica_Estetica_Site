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
    <!-- Estilização Filtro -->
    <link rel="stylesheet" href="../css/filtro.css">
    <!-- Estilização Cards -->
    <link rel="stylesheet" href="../css/cards.css">
    <!-- Estilização Calendario -->
    <link rel="stylesheet" href="../css/calendario.css">
    <!-- Estilização Navbar -->
    <link rel="stylesheet" href="../css/navbar.css">
</head>
<script>
    function carregarMes(mes = new Date().getMonth() + 1, ano = new Date().getFullYear()) {
        $.ajax({
            url: 'calendario.php',
            method: 'GET',
            data: { mes: mes, ano: ano },
            success: function(response) {
                $('#calendario-dinamico').html(response);
            }
        });
    }

    function selecionarData(data, element) {
        $('#data_consulta').val(data); // Define o valor da data selecionada
        $('#calendario-dinamico .date-select').removeClass('selected');
        $(element).addClass('selected');
        buscarConsultas();
    }

    function buscarConsultas() {
        let cpf_cliente = $('#cpf_cliente').val();
        let data_consulta = $('#data_consulta').val();

        $.ajax({
            url: 'consultasFiltro.php', // Script para realizar o filtro
            method: 'GET',
            data: {
                cpf_cliente: cpf_cliente,
                data_consulta: data_consulta
            },
            success: function(response) {
                $('#consultasContainer').html(response);
            }
        });
    }

    $(document).ready(function() {
        carregarMes(); // Carrega o calendário inicial

        // Evento para buscar por CPF
        $('#buscarCPF').on('click', function(event) {
            event.preventDefault();
            buscarConsultas();
        });
    });
</script>
<body>
    <!-- Início da Navbar -->
    <header>
        <nav class="nav-bar">
            <a class="logo" href="#"><img src="../logo/Logo.png" class="logoIMG">Care Tones</a>
            <ul class="nav-list">
                <li><a href="visualizarDuvidas.php" class="nav">Dúvidas</a></li>
                <li><a href="visualizarAvaliacoes.php" class="nav">Avaliações</a></li>
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
    <h2>Consultas Agendadas</h2>
    <h3 style="text-align: center">Digite o cpf, a data, ou ambos:</h3>
    <section class="container">
        <form class="form mb-4" id="form_perfil">
            <div class="column">
                <div class="input-box">
                    <label for="cpf_cliente">Filtrar por CPF do Cliente:</label>
                    <input type="text" id="cpf_cliente" name="cpf_cliente" class="form-control" placeholder="Digite o CPF" required maxlength="14" />
                    <button type="button" id="buscarCPF" class="btn btn-primary mt-2" style="padding:10px; width:40%;">Buscar por CPF</button>
                </div>
            </div>
            <div class="column">
                <div class="input-box">
                    <label>Filtrar por Data:</label>
                    <input type="hidden" id="data_consulta">
                    <div id="calendario-dinamico">
                        <!-- Calendário será carregado aqui via AJAX -->
                    </div>
                </div>
            </div>
        </form> 
    </section>
    <div class="container" id="consultasContainer">
        <!-- Resultados das consultas serão carregados aqui -->
    </div>
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
    <script src="../js/navbar.js"></script>
</body>
</html>
