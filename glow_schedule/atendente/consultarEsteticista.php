<?php
        // Atualize o caminho do arquivo de conexão com o banco de dados
        require_once $_SERVER['DOCUMENT_ROOT'] . "/glow_schedule/controller/conexao.php";
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
        
        $sql = "SELECT * FROM esteticista";
        $result = $conexao->query($sql);
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
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css" integrity="sha512-MV7K8+y+gLIBoVD59lQIYicR65iaqukzvf/nwasF0nqhPay5w/9lJmVM2hMDcnK1OnMGCdVK+iQrJ7lzPJQd1w==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <!-- Estilização padrão do web site -->
    <link rel="stylesheet" href="../css/style.css">
    <!-- Estilização formulários de Perfis -->
    <link rel="stylesheet" href="../css/perfil.css">
    <!-- Estilização Navbar -->
    <link rel="stylesheet" href="../css/navbar.css">
    <!-- Estilização Tabela -->
    <link rel="stylesheet" href="../css/tabela.css">
</head>
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
    <div class="container">
        <h2>Esteticistas Cadastrados</h2>
        <div class="filter-section">
            <form class="form-inline mb-3">
            <label for="search-esteticistas">Por favor, informe o Nome ou CPF do Esteticista:</label>
                    <input type="text" id="search-esteticistas" class="form-control" placeholder="Digite nome ou CPF">
            </form>
        </div>
    <a href="../atendente/cadastroEsteticista.php" class="btn btn-success"  id="editar_perfil_button_consultar" id="editar_perfil_button"><i class="fa fa-plus"></i> Adicionar Novo Esteticista</a>
    <p id="noResultsMessage" style="color: #cf6f7a; font-size:18px; text-align:center;">Nenhum esteticista encontrado. Por favor, Verifique novamente.</p>
    <?php
        // Verifica se há resultados
        if ($result->num_rows > 0) {
            echo '<table class="table table-bordered" id="esteticistasTabela">';
            echo '<thead>';
            echo '<tr>';
            echo '<th>Foto</th>';
            echo '<th>Nome</th>';
            echo '<th>CPF</th>';
            echo '<th>Apelido</th>';
            echo '<th>Email</th>';
            echo '<th>Telefone</th>';
            echo '<th>Ações</th>';
            echo '</tr>';
            echo '</thead>';
            echo '<tbody>';
            // Exibe os dados de cada esteticista
            while ($row = $result->fetch_assoc()) {
                echo '<tr>';
                echo '<tr>';
                // Verifica se a foto do atendente existe
                $fotoPath = $_SERVER['DOCUMENT_ROOT'] . "/glow_schedule/" . $row['foto_esteticista'];
                $foto = file_exists($fotoPath) && !empty($row['foto_esteticista']) 
                ? "/glow_schedule/" . htmlspecialchars($row['foto_esteticista']) 
                : "../iconesPerfil/perfilPadrao.png"; // URL da imagem padrão
                // Exibe a foto do atendente com formatação
                echo '<td class="text-center align-middle"><img src="' . $foto . '" alt="Foto do Atendente" id="consultar_fotos"></td>';
                echo '<td>' . htmlspecialchars($row['nome_esteticista']) . '</td>';
                echo '<td>' . htmlspecialchars($row['cpf_esteticista']) . '</td>';
                echo '<td>' . htmlspecialchars($row['apelido_esteticista']) . '</td>';
                echo '<td>' . htmlspecialchars($row['email_esteticista']) . '</td>';
                echo '<td>' . htmlspecialchars($row['telefone_esteticista']) . '</td>';
                echo '<td>';
                echo '<a href="../atendente/editarEsteticistaAtendente.php?token_esteticista=' . urlencode($row['token_esteticista']) . '" class="btn btn-primary" id="editar_consultar_button">Perfil</a> ';
                echo '</td>';
                echo '</tr>';
            }
            echo '</tbody>';
            echo '</table>';
        } else {
            echo '<p>Nenhum esteticista encontrado.</p>';
        }
        // Fecha a conexão com o banco de dados
        $conexao->close();
        ?>
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
    <!-- Link Js Navbar -->
    <script src="../js/navbar.js"></script>
    <!-- Link Js Filtro Tabela -->
    <script src="../js/tabela.js"></script>
</body>
</html>
