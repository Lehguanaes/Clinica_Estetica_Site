<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Consultas Agendadas</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
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
    <!-- Link Js Navbar -->
    <script src="../js/navbar.js"></script>
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
    <nav class="nav-bar">
            <a class="logo" href="#"><img src="../logo/Logo.png" class="logoIMG">Care Tones</a>
            <ul class="nav-list">
                <li><a href="esteticistas.php" class="nav">Profissionais</a>
                <li><a href="../procedimento/procedimentos.php" class="nav">Procedimentos</a>
                <li><a href="visualizarConsultas.php" class="nav">Agenda</a></li>
            </ul>
            <div class="dropdown">
                <div class="login-icon">
                    <a href="perfilAtendente.php">
                        <i class="fa-solid fa-circle-user fa-xl" style="color: #fff;"></i>
                    </a>
                    <div class="dropdown-content">
                        <a href="perfilEsteticista.php"><i class="fa-solid fa-user fa-sm" style="color: #cf6f7a;"></i> Perfil </a>
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
                    <a href="perfilEsteticista.php" class="footer-link">Perfil</a>
                </li>
                <li>
                    <a href="cadastroAtendente.php" class="footer-link">Editar Perfil</a>
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
                    <a href="../agendamentoAtendente/agendamento.php" class="footer-link">Agendamento</a>
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
</body>
</html>
