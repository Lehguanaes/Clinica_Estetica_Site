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
                    <a class="nav-link active" aria-current="page" href="visualizarConsultas.php">Consultas</a>
                    </li>
                    <li class="nav-item pe-4 ps-4">
                    <a class="nav-link active" aria-current="page" href="consultarEsteticista.php">Cadastrar Esteticistas</a>
                    </li>
                    <li class="nav-item pe-4 ps-4">
                    <a class="nav-link active" aria-current="page" href="consultarCliente.php">Cadastrar Cliente</a>
                    </li>
                    <li class="nav-item pe-4 ps-4">
                        <a class="nav-link active" aria-current="page" href="/glow_schedule/controller/logout.php">Sair</a>
                    </li>
                    <li class="nav-item pe-4 ps-4">
                        <a class="nav-link active" aria-current="page" href="/glow_schedule/procedimento/cadastrarProcedimento.php">cadastrarProcedimento</a>
                    </li>
                </ul>
                <button type="button" class="btn btn-sm btn-link me-4 ms-4" id="link_agendamentos_ativado" > <a href="/glow_schedule/agendamentoAtendente/agendamento.php" id="link_agendamentos_ativado">Agendamentos</a></button>
            </div>
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
</body>
</html>