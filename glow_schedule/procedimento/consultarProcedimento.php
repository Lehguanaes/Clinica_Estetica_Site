<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Consultar Procedimentos</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Perfil</title>
    <!-- Ícone para navegadores modernos -->
    <link rel="icon" href="../logo/Logo.png" type="image/png">
    <!-- Ícone para navegadores antigos -->
    <link rel="shortcut icon" href="../logo/Logo.png" type="image/x-icon">
    <!-- Links externos -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css" integrity="sha512-MV7K8+y+gLIBoVD59lQIYicR65iaqukzvf/nwasF0nqhPay5w/9lJmVM2hMDcnK1OnMGCdVK+iQrJ7lzPJQd1w==" crossorigin="anonymous" referrerpolicy="no-referrer" />
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
                <li><a href="../atendente/visualizarConsultas.php" class="nav">Agenda</a></li>
                <li><a href="../agendamento/agendamentoAtendente.php" class="nav">Agendamento</a></li>
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


    <div class="container">
        <h2>Procedimentos Cadastrados</h2>
        <?php
            // Caminho do arquivo de conexão com o banco de dados
            require_once $_SERVER['DOCUMENT_ROOT'] . "/glow_schedule/controller/conexao.php";

            // Cria uma nova instância da classe Conexao e obtém a conexão
            $conexao = new Conexao();
            $conn = $conexao->getConexao();

            // Consulta SQL para buscar todos os procedimentos
            $sql = "SELECT * FROM procedimento";
            $result = $conn->query($sql);

            // Verifica se há resultados
            if ($result->num_rows > 0) {
                echo '<table class="table table-bordered">';
                echo '<thead>';
                echo '<tr>';
                echo '<th>Foto</th>';
                echo '<th>Nome</th>';
                echo '<th>Preço</th>';
                echo '<th>Duração</th>';
                echo '<th>Manutenção</th>';
                echo '<th>Ações</th>';
                echo '</tr>';
                echo '</thead>';
                echo '<tbody>';
                // Exibe os dados de cada procedimento
                while ($row = $result->fetch_assoc()) {
                    echo '<tr>';
                    // Verifica se a foto do procedimento existe
                    $fotoPath = $_SERVER['DOCUMENT_ROOT'] . "/glow_schedule/" . $row['foto_procedimento'];
                    $foto = file_exists($fotoPath) && !empty($row['foto_procedimento']) 
                            ? "/glow_schedule/" . htmlspecialchars($row['foto_procedimento']) 
                            : "../iconesProcedimento/procedimentoPadrao.png"; // URL da imagem padrão
                    // Exibe a foto do procedimento com formatação
                    echo '<td class="text-center align-middle"><img src="' . $foto . '" alt="Foto do Procedimento" id="consultar_fotos"></td>';
                    echo '<td>' . htmlspecialchars($row['nome_procedimento']) . '</td>';
                    echo '<td>' . htmlspecialchars($row['preco_procedimento']) . '</td>';
                    echo '<td>' . htmlspecialchars($row['duracao_procedimento']) . '</td>';
                    echo '<td>' . htmlspecialchars($row['manutencao_procedimento']) . '</td>';
                    echo '<td>';
                    echo '<a href="editarProcedimento.php?id_procedimento=' . urlencode($row['id_procedimento']) . '" class="btn btn-primary" id="editar_consultar_button">Editar</a>';
                    echo '</td>';
                    echo '</tr>';
                }
                echo '</tbody>';
                echo '</table>';
            } else {
                echo '<p>Nenhum procedimento encontrado.</p>';
            }
            // Fecha a conexão com o banco de dados
            $conn->close();
        ?>
        <a href="cadastrarProcedimento.php" class="btn btn-success" id="editar_perfil_button"><i class="fa fa-plus"></i> Adicionar Novo Procedimento</a>
    </div>
    
    <footer>
            <div id="footer_content">
                <div id="footer_contacts">
                    <a class="navbar-brand"> <img class="rounded-circle ms-4" src="Imagem_Logo/Logo.png" alt="Logo care tones" width="69px"></a>
                    <h3>Care Tones</h3>  
                    <div id="footer_social_media">
                        <a href="#" class="footer-link" id="instagram">
                            <i class="fa-brands fa-instagram"></i>
                        </a>
    
                        <a href="#" class="footer-link" id="facebook">
                            <i class="fa-brands fa-facebook-f"></i>
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
                        <h4 id="subtitulo-footer">Quem somos?</h4>
                    </li>
                    <li>
                        <a href="/glow_schedule/cliente/sobreNos.php" class="footer-link">Sobre nós</a>
                    </li>
                    <li>
                        <a href="/glow_schedule/cliente/sobreNos.php" class="footer-link">Clínica</a>
                    </li>
                    <li>
                        <a href="/glow_schedule/esteticista/esteticistas.php" class="footer-link">Profissionais</a>
                    </li>
                </ul>
    
                <ul class="footer-list">
                    <li>
                        <h4 id="subtitulo-footer">Interesses</h4>
                    </li>
                    <li>
                        <a href="/glow_schedule/cliente/sobreNos.php" class="footer-link">Curiosidades</a>
                    </li>
                    <li>
                        <a href="/glow_schedule/procedimentos/procedimentos.php" class="footer-link">Promoções</a>
                    </li>
                    <li>
                        <a href="/glow_schedule/avaliacoes/avaliacoes.php" class="footer-link">Avaliações</a>
                    </li>
                </ul>
    
                <div id="footer_subscribe">
                    <h4 id="subtitulo-footer">Cadastre-se</h4>
                    <p>
                        Cadastre-se, venha conhecer nosso trabalho e saber das novidades!
                    </p>
                        <button>
                        <a href="/glow_schedule/cliente/cadastrarCliente.php"> 
                            <i class="fa-regular fa-envelope"></i>Entrar</a>
                        </button>
                </div>
            </div>
            <div id="footer_copyright">
                &#169
                2024 all rights reserved
            </div>
        </footer>
</body>
</html>