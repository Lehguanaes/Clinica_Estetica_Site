<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Consultas Agendadas</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <link rel="stylesheet" href="../css/style.css">
    <link rel="stylesheet" href="../css/perfil.css">
    <link rel="stylesheet" href="../css/calendario.css">
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
    <h2>Consultas Agendadas</h2>
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
    <div class="container-cards-home" id="consultasContainer">
        <!-- Resultados das consultas serão carregados aqui -->
    </div>
</body>
</html>