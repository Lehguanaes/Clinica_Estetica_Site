<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Carrossel de Avaliações</title>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css">
    <!-- Font Awesome para ícones de estrela -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css">
    <!-- Link SwiperJS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css">
    <!-- Estilização do carrossel -->
    <link rel="stylesheet" href="../css/carrosselAvaliacoes.css">
    <!-- Estilização Navbar -->
    <link rel="stylesheet" href="../css/navbar.css">
    <!-- Link Js Navbar -->
    <script src="../js/navbar.js"></script>
    <!-- Estilização padrão do web site -->
    <link rel="stylesheet" href="../css/style.css">
</head>
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
                        <a class="nav-link" aria-current="page" href="./cliente/home.php">Home</a>
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
    <!-- Exibição do Procedimento -->
    <!-- Exibição do Procedimento -->
<?php
require_once $_SERVER['DOCUMENT_ROOT'] . "/glow_schedule/controller/conexao.php";

$nome_procedimento = isset($_GET['nome_procedimento']) ? $_GET['nome_procedimento'] : '';

if (!empty($nome_procedimento)) {
    $conexao = new Conexao();
    $conn = $conexao->getConexao();

    // Consulta o procedimento pelo nome
    $sql = "SELECT * FROM procedimento WHERE nome_procedimento = ?";
    if ($stmt = $conn->prepare($sql)) {
        $stmt->bind_param("s", $nome_procedimento);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result) {
            if ($result->num_rows > 0) {
                $row = $result->fetch_assoc();

                // Exibir o procedimento
                echo '<h2 style="color: #CF6F7A; text-align: center; margin-top:10px; margin-bottom: 35px;">' 
                    . htmlspecialchars($row['nome_procedimento']) . '</h2>';
                echo '<div class="card" style="max-width: 1000px; margin-left: 10%; border: none;">';
                echo '<div class="row g-0">';

                // Exibindo imagem
                echo '<div class="col-md-3" style="margin-bottom: 50px;">';
                $fotoCaminho = "/glow_schedule/" . htmlspecialchars($row['foto_procedimento']);
                $fotoExibida = (file_exists($_SERVER['DOCUMENT_ROOT'] . $fotoCaminho) && !empty($row['foto_procedimento']))
                    ? $fotoCaminho 
                    : "/glow_schedule/uploads/default.jpg";
                echo '<img src="' . $fotoExibida . '" alt="Foto do Procedimento" style="width:100%; height:auto;">';
                echo '</div>';

                // Informações do procedimento
                echo '<div class="col-md-8" style="margin-top: 30px; margin-left: 3%;">';
                echo '<p><i class="fa-regular fa-clock"></i><strong>Duração:</strong> ' . htmlspecialchars($row['duracao_procedimento']) . '</p>';
                echo '<p><i class="fa-solid fa-hourglass-half"></i><strong>Manutenção:</strong> ' . htmlspecialchars($row['manutencao_procedimento']) . '</p>';
                echo '<p><i class="fa-solid fa-hand-holding-dollar"></i><strong>Preço:</strong> ' .  htmlspecialchars($row['preco_procedimento']) . '</p>';
                echo '<p style="color: black;">' . htmlspecialchars($row['descricao_g_procedimento']) . '</p>';
                echo '</div>';

                echo '</div>';
                echo '</div>';
            } else {
                echo '<h2 style="color: #CF6F7A; text-align: center; margin-top:10px; margin-bottom: 35px;">Procedimento não encontrado</h2>';
            }
        } else {
            echo '<p style="color: red; text-align: center;">Erro ao executar a consulta: ' . $stmt->error . '</p>';
        }

        $stmt->close();
    } else {
        echo '<p style="color: red; text-align: center;">Erro ao preparar a consulta: ' . $conn->error . '</p>';
    }

    $conn->close();
} else {
    echo '<h2 style="color: #CF6F7A; text-align: center; margin-top:10px; margin-bottom: 35px;">Nome do procedimento não informado.</h2>';
}
?>


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
</body>
</html>