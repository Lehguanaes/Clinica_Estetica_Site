<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Procedimentos</title>
    <!-- Links externos -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css" integrity="sha512-MV7K8+y+gLIBoVD59lQIYicR65iaqukzvf/nwasF0nqhPay5w/9lJmVM2hMDcnK1OnMGCdVK+iQrJ7lzPJQd1w==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <!-- Estilização padrão do web site -->
    <link rel="stylesheet" href="../css/style.css">
    <link rel="stylesheet" href="../css/css-mota.css">
    <!-- Estilização formulários de Perfis -->
    <link rel="stylesheet" href="../css/linhaTempo.css">
    <!-- Estilização formulários de Perfis -->
    <link rel="stylesheet" href="../css/perfil.css">
    <!-- Estilização Navbar -->
    <link rel="stylesheet" href="../css/navbar.css">
    <!-- Link Js Navbar -->
    <script src="../js/navbar.js"></script>
    <!-- Estilização form duvidas -->
    <link rel="stylesheet" href="../css/duvidas.css">
    <!-- Link  form duvidas-->
    <script src="../js/cadastrarDuvidas.js" defer></script>
    <!-- Link SwiperJS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css">
    <!-- Estilização do carrossel -->
    <link rel="stylesheet" href="../css/carrosselAvaliacoes.css">
    <!-- Links externos-->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.min.js" integrity="sha384-cuYeSxntonz0PPNlHhBs68uyIAVpIIOZZ5JqeqvYYIcEL727kskC66kF92t6Xl2V" crossorigin="anonymous"></script>
    <!-- Link para os icones -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
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
                            <a href="perfilCliente.php"><i class="fa-solid fa-pen-to-square"></i> Meu perfil</a>
                            <a href="consultasCliente.php"><i class="fa-solid fa-calendar-days"></i> Minhas Consultas</a>
                            <a href="avaliacoes.php"><i class="fa-solid fa-ranking-star"></i> Avaliar</a>
                            <a href="/glow_schedule/controller/logout.php"><i class="fa-solid fa-right-to-bracket"></i> Sair</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </nav>
    <?php
    require_once $_SERVER['DOCUMENT_ROOT'] . '/glow_schedule/controller/conexao.php';

    $conexao = new Conexao();
    $conn = $conexao->getConexao();

    $sql = "SELECT * FROM procedimento";
    
    $result = $conn->query($sql);

    echo '<div id="Procedimentos">';
    echo '<h2>Procedimentos</h2>';
    echo '<div class="container">';

    if ($result->num_rows > 0) {
    while ($procedimento = $result->fetch_assoc()) {
        $foto = isset($procedimento['foto_procedimento']) && file_exists($_SERVER['DOCUMENT_ROOT'] . "/glow_schedule/uploads/" . $procedimento['foto_procedimento'])
            ? "/glow_schedule/uploads/" . htmlspecialchars($procedimento['foto_procedimento'])
            : "../iconesPerfil/perfilPadrao.png"; 

        echo '<div class="card">';
        echo '    <img src="' . $foto . '" alt="Foto do procedimento">';
        echo '    <div class="card-content">';
        echo '        <h2 class="titulo-card">' . htmlspecialchars($procedimento['nome_procedimento']) . '</h2>';
        echo '        <div class="cor-falsificada">';
        echo '            <p class="mais-texto">Saiba mais <i class="fa-solid fa-arrow-down"></i></p>';
        echo '            <p>' . htmlspecialchars($procedimento['descricao_p_procedimento']) . '</p>';
        echo '            <div class="position-button">';
        echo '                <a href="procedimentosInfo.php?nome_procedimento=' . urlencode($procedimento['nome_procedimento']) . '" class="card-button">Saiba mais</a>';
        echo '            </div>';
        echo '        </div>';
        echo '    </div>';
        echo '</div>';
    }
} else {
    echo '<p>Nenhum procedimento encontrado.</p>';
}

// Fecha o container
echo '</div>';
echo '</div>';

$conn->close();
?>

<!--enrolação sobre o que é a clínica-->
<div class="divisor3">
    <h2>Alguma sugestão??</h3>
    <h2 class="texto">Que tal nos dar um feedback?</h2>
        <p>Na Care Tones - Estética, oferecemos uma ampla gama de procedimentos cuidadosamente planejados para atender as diversas necessidades de nossos clientes. Cada tratamento é realizado com técnicas avançadas e produtos de alta qualidade, com o objetivo de realçar a beleza natural e promover o bem-estar. Desde bioestimuladores de colágeno para uma pele mais firme e rejuvenescida, até peelings químicos que renovam e iluminam a pele, cada procedimento é personalizado para garantir resultados visíveis e duradouros. </p>
</div>

<!--enrolação sobre o que é a clínica-->
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
                    <a href="#" class="footer-link">Sobre nós</a>
                </li>
                <li>
                    <a href="#" class="footer-link">Clínica</a>
                </li>
                <li>
                    <a href="#" class="footer-link">Profissionais</a>
                </li>
            </ul>
    
            <ul class="footer-list">
                <li>
                    <h4 id="subtitulo-footer">Interesses</h4>
                </li>
                <li>
                    <a href="#" class="footer-link">Curiosidades</a>
                </li>
                <li>
                    <a href="#" class="footer-link">Promoções</a>
                </li>
                <li>
                    <a href="#" class="footer-link">Avaliações</a>
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