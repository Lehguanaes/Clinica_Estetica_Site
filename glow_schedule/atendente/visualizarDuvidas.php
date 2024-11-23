<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dúvidas Recebidas</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <!-- Estilização padrão do web site -->
    <link rel="stylesheet" href="../css/style.css">
    <!-- Estilização formulários de Perfis -->
    <link rel="stylesheet" href="../css/perfil.css">
    <!-- Estilização Filtro -->
    <link rel="stylesheet" href="../css/filtro.css">
    <!-- Estilização Cards -->
    <link rel="stylesheet" href="../css/cards.css">
    <!-- Estilização Navbar -->
    <link rel="stylesheet" href="../css/navbar.css">
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
</head>
<body>
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
    <div id="Duvidas">
        <h2>Dúvidas Recebidas</h2>
        <!-- Mensagem de instruções do filtro -->
        <div class="container-filtro">
            <!-- Container de filtro com ícone e opções -->
            <div class="filter-container">
                <i class="fas fa-filter" style="color: #cf6f7a;" onclick="toggleFilterOptions()"> </i> Filtrar dúvidas
                <div class="filter-options">
                    <button onclick="filtrarDuvidas('ativado')" class="btn btn-info"><i class="fa-solid fa-check-to-slot"></i> Dúvidas Não Respondidas</button>
                    <button onclick="filtrarDuvidas('desativado')" class="btn btn-secondary"><i class="fa-solid fa-clock-rotate-left"></i> Dúvidas Respondidas</button>
                </div>
            </div>
        </div>
        <div class="container-cards-home" id="duvidasContainer">
            <?php
                require_once $_SERVER['DOCUMENT_ROOT'] . "/glow_schedule/controller/conexao.php";
                $conexao = new Conexao();
                $conn = $conexao->getConexao();
                $status = $_GET['status'] ?? 'ativado';
                $status_escaped = mysqli_real_escape_string($conn, $status);
                $sql_duvidas = "
                    SELECT id, nome, telefone, objetivo, mensagem, data_envio, status
                    FROM duvidas 
                    WHERE status = '$status_escaped' 
                    ORDER BY data_envio DESC
                ";
                $result_duvidas = mysqli_query($conn, $sql_duvidas);
                if ($result_duvidas && mysqli_num_rows($result_duvidas) > 0) {
                    while ($duvida = mysqli_fetch_assoc($result_duvidas)) {
                        // Verifica se a data de envio é válida
                        $data_envio_formatada = '';
                        if (!empty($duvida['data_envio'])) {
                            $data_envio = DateTime::createFromFormat('Y-m-d H:i:s', $duvida['data_envio']);
                            if ($data_envio) {
                                $data_envio_formatada = $data_envio->format('d/m/Y \à\s H:i');
                            } else {
                                $data_envio_formatada = 'Data inválida'; // Caso a data não seja válida
                            }
                        } else {
                            $data_envio_formatada = 'Sem data'; // Caso não haja data
                        }

                
                        echo "
                            <div class='container'>
                                <div class='card-simples'>
                                    <div class='card-content' id='duvidaCard{$duvida['id']}'>
                                        <h2 class='titulo-card'>Dúvida de {$duvida['nome']}</h2>
                                        <div class='cor-falsificada'>
                                            <p class='mais-texto' style='font-size:15px'>Telefone: {$duvida['telefone']}</p>
                                            <p class='mais-texto' style='font-size:15px'>Objetivo: {$duvida['objetivo']}</p>
                                            <p class='mais-texto' style='font-size:15px'> Enviada em {$data_envio_formatada}</p>
                                            <button onclick='lerDuvida({$duvida['id']})' class='btn-leitura' id='lerDuvida{$duvida['id']}'>Ler Dúvida</button>
                                            <div id='mensagemCompleta{$duvida['id']}' class='mensagem-expandida'>
                                                <p>{$duvida['mensagem']}</p>";
                                            
                                            // Verifica o status da dúvida para exibir o botão "Marcar como Respondida"
                                            if ($duvida['status'] === 'ativado') {
                                                echo "<button onclick='marcarComoRespondida({$duvida['id']})' class='btn-respondida'>Marcar como Respondida</button>";
                                            }
                                        echo "</div>
                                        </div>
                                    </div>
                                </div>
                            </div>";
                    }
                } else {
                    echo "<p style='color: #CF6F7A;'>Não há dúvidas nesta categoria.</p>";
                }
                mysqli_close($conn);
            ?>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <!-- Link Js Navbar -->
    <script src="../js/navbar.js"></script>
    <!-- Link Js Duvidas -->
    <script src="../js/duvidas.js"></script>
</body>
</html> 
