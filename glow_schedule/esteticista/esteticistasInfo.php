<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Care Tones</title>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css">
    <!-- Font Awesome para ícones de estrela -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css">
    <!-- Link SwiperJS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css">
    <!-- Estilização do carrossel -->
    <link rel="stylesheet" href="../css/carrosselAvaliacoes.css">
    <!-- Estilização padrão do web site -->
    <link rel="stylesheet" href="../css/style.css">
    <!-- Estilização Navbar -->
    <link rel="stylesheet" href="../css/navbar.css">
    <!-- Link Js Navbar -->
    <script src="../js/navbar.js"></script>
</head>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.min.js" integrity="sha384-cuYeSxntonz0PPNlHhBs68uyIAVpIIOZZ5JqeqvYYIcEL727kskC66kF92t6Xl2V" crossorigin="anonymous"></script>
<body>
<!-- Início da Navbar -->
    <nav class="navbar navbar-expand-lg">
        <div class="container-fluid">
            <a class="navbar-brand"> <img class="rounded-circle ms-4" src="../logo/Logo.png" alt="Logo care tones" width="69px"> </a>
            <link rel="preconnect" href="https://fonts.googleapis.com">
            <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
            <link href="https://fonts.googleapis.com/css2?family=Cinzel&family=Playfair+Display:ital@1&display=swap" rel="stylesheet">
            <div class="logo">
                <a class="nav-link" id="desativado" aria-current="page" href="home.php">Care Tones</a>
            </div>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent" >
                <ul class="navbar-nav w-auto">
                    <li class="nav-item pe-4 ps-4">
                        <a class="nav-link" aria-current="page" href="home.php">Home</a>
                    </li>
                    <li class="nav-item pe-4 ps-4">
                        <a class="nav-link active" aria-current="page" href="sobreNos.php">Sobre nós</a>
                    </li>
                    <li class="nav-item pe-4 ps-4">
                        <a class="nav-link active" aria-current="page" href="../procedimento/procedimentos.php">Procedimentos</a>
                    </li>
                    <li class="nav-item pe-4 ps-4">
                        <a class="nav-link active" aria-current="page" href="../esteticista/esteticistas.php">Profissionais</a>
                    </li>
                    <li class="nav-item pe-4 ps-4">
                        <a class="nav-link active" aria-current="page" href="../agendamento/agendamento.php">Agendamentos</a>
                    </li>
                </ul>
                <div class="dropdown">
                    <div class="login-icon">
                        <a href="Cadastro.html">
                        <i class="fa-solid fa-circle-user fa-xl" style="color: #fff;"></i>
                        </a>
                        <div class="dropdown-content">
                            <a href="../cliente/perfilCliente.php"><i class="fa-solid fa-pen-to-square"></i> Meu perfil</a>
                            <a href="../cliente/consultasCliente.php"><i class="fa-solid fa-calendar-days"></i> Minhas Consultas</a>
                            <a href="../avaliacoes/avaliacoes.php"><i class="fa-solid fa-ranking-star"></i> Avaliar</a>
                            <a href="/glow_schedule/controller/logout.php"><i class="fa-solid fa-right-to-bracket"></i> Sair</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </nav>
    <!-- Fim da Navbar -->
    <!-- Exibição do Esteticista -->
    <div id="Profissionais">
    <?php

    require_once $_SERVER["DOCUMENT_ROOT"]. "/glow_schedule/controller/conexao.php";
// Obtém o apelido_esteticista da URL
$apelido_esteticista = isset($_GET['apelido_esteticista']) ? $_GET['apelido_esteticista'] : '';

// Conecta ao banco de dados
$conexao = new Conexao();
$conn = $conexao->getConexao();

// Consulta SQL para buscar as informações do esteticista pelo apelido
$sql = "SELECT * FROM esteticista WHERE apelido_esteticista = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $apelido_esteticista);
$stmt->execute();
$result = $stmt->get_result();

// Verifica se há resultados
if ($result->num_rows > 0) {
    // Exibe as informações do esteticista
    $row = $result->fetch_assoc();
    echo '<h2 style="color: #CF6F7A; text-align: center; margin-top:10px; margin-bottom: 35px;">' . htmlspecialchars($row['nome_esteticista']) . '</h2>';
    echo '<div class="card mb-1" style="max-width: 1000px; margin-left: 10%; border: none;";>';
    echo '<div class="row g-0">';
    echo '<div class="col-md-3" style="margin-bottom: 50px;">';
    echo '<img src="' . (file_exists($_SERVER['DOCUMENT_ROOT'] . "/glow_schedule/" . $row['foto_esteticista']) ? "/glow_schedule/" . htmlspecialchars($row['foto_esteticista']) : "/glow_schedule/uploads/default.jpg") . '" alt="Foto do Esteticista" style="width:100%; height:auto;">';
    echo '</div>';
    echo '<div class="col-md-8" style="margin-top: 30px; margin-left: 3%;">';
    echo '<p style="margin-bottom: 1px;"><i class="fa-solid fa-graduation-cap"></i> ' . htmlspecialchars($row['formacao_esteticista']) . '</p>'; 
    echo '<p style="margin-top: 3px; margin-left: 2px; margin-bottom: 4px;"><i class="fa-brands fa-instagram"></i>'. htmlspecialchars($row['instagram_esteticista']) . '</p>'; 
    echo '<p style="margin-top: 3px; margin-left: 2px; margin-bottom: 4px;"><i class="fa-brands fa-linkedin"></i>' . htmlspecialchars($row['linkedin_esteticista']) . '</p>'; 
    echo '<p style="margin-top: 3px; margin-left: 2px; margin-bottom: 4px;"><i class="fa-brands fa-facebook"></i>' . htmlspecialchars($row['facebook_esteticista']) . '</p>';
    echo '&nbsp;';
    echo '<p class="card-text" style="color: black;">' . htmlspecialchars($row['descricao_g_esteticista']) . '</p>';
    echo '</div>';
    echo '</div>';
    echo '</div>';   
} else {
    echo '<h2 style="color: #CF6F7A; text-align: center; margin-top:10px; margin-bottom: 35px;">Esteticista não encontrado</h2>';
}
?>

<h2>Avaliações</h2>
    <div class="swiper">
        <div class="swiper-wrapper">
        <?php
            // Função para formatar a data
            function formatarData($data) {
                $meses = [
                    '01' => 'janeiro', '02' => 'fevereiro', '03' => 'março',
                    '04' => 'abril', '05' => 'maio', '06' => 'junho',
                    '07' => 'julho', '08' => 'agosto', '09' => 'setembro',
                    '10' => 'outubro', '11' => 'novembro', '12' => 'dezembro'
                ];
                
                $dia = date('d', strtotime($data));
                $mes = $meses[date('m', strtotime($data))];
                $ano = date('Y', strtotime($data));
                
                return "{$dia} de {$mes} de {$ano}";
            }

            // Consulta avaliações
            $sql_avaliacoes = "SELECT a.estrelas_avaliacao, a.comentario_avaliacao, a.data_criacao_avaliacao, c.nome_cliente, c.foto_cliente
                            FROM Avaliacoes a
                            JOIN Cliente c ON a.cpf_cliente = c.cpf_cliente
                            WHERE a.avaliado = ?";
            $stmt_avaliacoes = $conn->prepare($sql_avaliacoes);
            $stmt_avaliacoes->bind_param("s", $apelido_esteticista);
            $stmt_avaliacoes->execute();
            $result_avaliacoes = $stmt_avaliacoes->get_result();

            while ($avaliacao = $result_avaliacoes->fetch_assoc()) {
                // Caminho padrão para a foto do cliente
                $foto_cliente = file_exists($_SERVER['DOCUMENT_ROOT'] . "/glow_schedule/" . $avaliacao['foto_cliente']) && !empty($avaliacao['foto_cliente'])
                    ? "/glow_schedule/" . htmlspecialchars($avaliacao['foto_cliente'])
                    : "../iconesPerfil/perfilPadrao.png";
                
                echo '<div class="swiper-slide">';
                echo '    <div class="card-review">';
                echo '        <img src="' . $foto_cliente . '" alt="Foto do Cliente" class="avatar mb-3">';
                echo '        <p class="text-muted small">' . formatarData($avaliacao['data_criacao_avaliacao']) . '</p>';
                echo '        <h5 class="card-title">' . htmlspecialchars($avaliacao['nome_cliente']) . '</h5>';
                echo '        <p class="card-text">' . htmlspecialchars($avaliacao['comentario_avaliacao']) . '</p>';
                echo '        <p class="text-muted small">por ' . htmlspecialchars($avaliacao['nome_cliente']) . '</p>';
                echo '        <div class="star-rating mb-2">';
                for ($i = 0; $i < 5; $i++) {
                    echo $i < $avaliacao['estrelas_avaliacao'] ? '<span class="fa fa-star"></span>' : '<span class="fa fa-star-o"></span>';
                }
                echo '        </div>';
                echo '    </div>';
                echo '</div>';
            }
            $stmt_avaliacoes->close();
            $conn->close();
            ?>
        </div>
        <div class="swiper-pagination"></div>
        <div>&nbsp;</div> 
    </div>
</div>
<footer>
    <div id="footer_content">
        <div id="footer_contacts">
            <a class="navbar-brand"><img class="rounded-circle ms-4" src="../logo/Logo.png" alt="Logo Care Tones" width="69px"></a>
            <h3>Care Tones</h3>
            <div id="footer_social_media">
                <a href="#" class="footer-link" id="instagram"><i class="fa-brands fa-instagram"></i></a>
                <a href="#" class="footer-link" id="facebook"><i class="fa-brands fa-facebook-f"></i></a>
                <a href="#" class="footer-link" id="whatsapp"><i class="fa-brands fa-whatsapp"></i></a>
                <a href="#" class="footer-link" id="localizacao"><i class="fa-solid fa-location-dot"></i></a>
            </div>
        </div>
        <ul class="footer-list">
            <li><h4 id="subtitulo-footer">Quem somos?</h4></li>
            <li><a href="#" class="footer-link">Sobre nós</a></li>
            <li><a href="#" class="footer-link">Clínica</a></li>
            <li><a href="#" class="footer-link">Profissionais</a></li>
        </ul>
        <ul class="footer-list">
            <li><h4 id="subtitulo-footer">Interesses</h4></li>
            <li><a href="#" class="footer-link">Curiosidades</a></li>
            <li><a href="#" class="footer-link">Promoções</a></li>
            <li><a href="#" class="footer-link">Avaliações</a></li>
        </ul>
        <div id="footer_subscribe">
            <h4 id="subtitulo-footer">Cadastre-se</h4>
            <p>Cadastre-se, venha conhecer nosso trabalho e saber das novidades!</p>
            <div id="input_group">
                <input type="email" id="email">
                <button><i class="fa-regular fa-envelope"></i></button>
            </div>
        </div>
    </div>
    <div id="footer_copyright">
        &#169 2023 all rights reserved
    </div>
</footer>
<!-- SwiperJS Script -->
<script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
<script src="../js/carrosselAvaliacao.js"></script>
</body>
</html>