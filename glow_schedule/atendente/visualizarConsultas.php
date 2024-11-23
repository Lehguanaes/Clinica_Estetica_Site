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
    <header>
        <nav class="nav-bar">
          <a class="logo" href="Home.html"><img src="../logo/Logo.png" class="logoIMG">Care Tones</a>
          <ul class="nav-list">
            <li><a href="visualizarConsultas.php" class="nav">Agenda</a></li>
            <li><a href="visualizarDuvidas.php" class="nav">Dúvidas</a></li>
            <li><a href="../avaliacoes/avaliacoes.php" class="nav">Avaliações</a></li>
            <li><a href="../agendamento/agendamentoAtendente.php" class="nav">Agendar Consulta</a></li>
            <li><a href="../esteticista/esteticistas.php" class="nav">Esteticistas</a></li>
          </ul>
          <div class="dropdown">
            <div class="login-icon">
                <a href="perfilAtendente.php">
                <i class="fa-solid fa-circle-user fa-xl" style="color: #fff;"></i>
                </a>
                <div class="dropdown-content">
                    <a href="perfilAtendente.php"><i class="fa-solid fa-right-to-bracket" style="color: #cf6f7a;"></i> Perfil </a>
                    <a href="../esteticista/cadastroEsteticistaAtendente.php"><i class="fa-solid fa-address-card" style="color: #cf6f7a;"></i> Cadastrar Esteticista </a>
                    <a href="../cliente/cadastrarClienteAtendente.php"><i class="fa-solid fa-address-card" style="color: #cf6f7a;"></i> Cadastrar Cliente </a>
                    <a href="../procedimento/cadastrarProcedimento.php"><i class="fa-solid fa-address-card" style="color: #cf6f7a;"></i> Cadastrar Procedimento </a>
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
    <script src="../js/navbar.js"></script>
</body>
</html>
