<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Minhas Consultas</title>
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
<body><body>
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
                        <a class="nav-link active" aria-current="page" href="esteticistas.php">Profissionais</a>
                    </li>
                    <li class="nav-item pe-4 ps-4">
                        <a class="nav-link active" aria-current="page" href="../procedmento/procedimento.php">Procedimentos</a>
                    </li>
                    <li class="nav-item pe-4 ps-4">
                        <a class="nav-link active" aria-current="page" href="visualizarConsultas.php">Perfil</a>
                    </li>
                    <li class="nav-item pe-4 ps-4">
                        <a class="nav-link active" aria-current="page" href="perfilEsteticista.php">Agenda</a>
                    </li>
                </ul>
                <button type="button" class="btn btn-sm btn-link me-4 ms-4" id="link_agendamentos_ativado"> <a href="cadastrarConsulta.php" id="link_agendamentos_ativado">Agendamentos</a></button>
            </div>
        </div>
    </nav>
    <!-- Fim da Navbar -->

<div id="Procedimentos">
    <h2>Consultas Agendadas</h2>
    <div class="container-cards-home" id="consultasContainer">
        <?php
            require_once $_SERVER['DOCUMENT_ROOT'] . "/glow_schedule/controller/conexao.php";
            require_once $_SERVER['DOCUMENT_ROOT'] . "/glow_schedule/model/message.php";
            require_once $_SERVER['DOCUMENT_ROOT'] . "/glow_schedule/controller/global.php";

            $cpf_cliente = $_GET['cpf_cliente'] ?? '';

            $message = new Message($BASE_URL);
            $flashMsg = $message->getMessage();
        

            if ($cpf_cliente) {
                $conexao = new Conexao();
                $conn = $conexao->getConexao();

                $cpf_cliente_escaped = mysqli_real_escape_string($conn, $cpf_cliente);
                $data_atual = date('Y-m-d');
                $hora_atual = date('H:i:s');

                // Consultas futuras
                $sql_futuras = "
                    SELECT c.id_consulta, c.data_consulta, c.hora_consulta, e.apelido_esteticista, p.nome_procedimento
                    FROM consulta AS c
                    JOIN esteticista AS e ON c.cpf_esteticista = e.cpf_esteticista
                    JOIN procedimento AS p ON c.id_procedimento = p.id_procedimento
                    WHERE c.cpf_cliente = '$cpf_cliente_escaped'
                    AND (c.data_consulta > '$data_atual' OR (c.data_consulta = '$data_atual' AND c.hora_consulta > '$hora_atual'))
                ";

                $result_futuras = mysqli_query($conn, $sql_futuras);

                if ($result_futuras && mysqli_num_rows($result_futuras) > 0) {
                    while ($consulta = mysqli_fetch_assoc($result_futuras)) {
                        echo "
                        <div class='card-corpo-dicas'>
                            <h5 class='card-title'>{$consulta['nome_procedimento']}</h5>
                            <p>Data: {$consulta['data_consulta']}</p>
                            <p>Hora: {$consulta['hora_consulta']}</p>
                            <p>Profissional: {$consulta['apelido_esteticista']}</p>
                            <button style='background-color: #1A7F83; color: #fff; padding: 5px; border-radius: 5px; border: none; cursor: pointer;'>
                                Mais Informações
                            </button>
                        </div>";
                    }
                } else {
                    echo "<p>Não há consultas futuras agendadas ainda.</p>";
                }

                // Consultas passadas
                $sql_passadas = "
                    SELECT c.id_consulta, c.data_consulta, c.hora_consulta, e.apelido_esteticista, p.nome_procedimento
                    FROM consulta AS c
                    JOIN esteticista AS e ON c.cpf_esteticista = e.cpf_esteticista
                    JOIN procedimento AS p ON c.id_procedimento = p.id_procedimento
                    WHERE c.cpf_cliente = '$cpf_cliente_escaped'
                    AND (c.data_consulta < '$data_atual' OR (c.data_consulta = '$data_atual' AND c.hora_consulta <= '$hora_atual'))
                ";

                $result_passadas = mysqli_query($conn, $sql_passadas);

                if ($result_passadas && mysqli_num_rows($result_passadas) > 0) {
                    echo "<div'>
                    &nbsp;
                        </div>";
                    echo "<h3 style='color: #CF6F7A; text-align: center;'>Consultas Realizadas</h3>";
                    echo "<div class='container-cards-home' id='consultasPassadasContainer'>";
                    while ($consulta = mysqli_fetch_assoc($result_passadas)) {
                        echo "
                        <div class='card-corpo-dicas'>
                            <h5 class='card-title'>{$consulta['nome_procedimento']}</h5>
                            <p>Data: {$consulta['data_consulta']}</p>
                            <p>Hora: {$consulta['hora_consulta']}</p>
                            <p>Profissional: {$consulta['apelido_esteticista']}</p>
                            <button style='background-color: #1A7F83; color: #fff; padding: 5px; border-radius: 5px; border: none; cursor: pointer;'>
                                Mais Informações
                            </button>
                        </div>";
                    }
                    echo "</div>";
                } 
                mysqli_close($conn);
            } else {
                $message->setMessage("Opa", "CPF do cliente não foi fornecido ou é inválido.", "error", "../perfilEsteticista.php");
            }
        ?>
    </div>
</div>
</body>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<!--  php da mensagem; se a mensagem não estiver vazia, ela é inserida na página  -->
  <?php if (!empty($flashMsg["msg"])): ?>
            <script>
                Swal.fire({
                       icon: "<?= $flashMsg['type'] ?>",
                       title: "<?= $flashMsg['titulo'] ?>",
                       text: "<?= $flashMsg['msg'] ?>",
                       toast: true
                    });
            </script>      
<?php endif; ?>
</html>