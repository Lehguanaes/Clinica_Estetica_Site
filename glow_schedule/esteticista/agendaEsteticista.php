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
