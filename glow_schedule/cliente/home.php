<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Care Tones</title>
    <!-- Links externos -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css" integrity="sha512-MV7K8+y+gLIBoVD59lQIYicR65iaqukzvf/nwasF0nqhPay5w/9lJmVM2hMDcnK1OnMGCdVK+iQrJ7lzPJQd1w==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <!-- Estilização padrão do web site -->
    <link rel="stylesheet" href="../css/style.css">
    <link rel="stylesheet" href="css/css-mota.css">
    <!-- Estilização carrossel home -->
    <link rel="stylesheet" type="text/css" href="css/carrossel.css" media="screen" />
    <!-- Estilização link carrossel home -->
    <script src="Js/carrossel.js" defer></script>
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
    <!-- Links externos-->
    <integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <script src="glider.js"></script>
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
    <!-- Fim da Navbar -->
    <h2> Novidades da Semana </h2>

    <section class="slider">
        <div class="slider-content">
            <input type="radio" name="btn_radio" id="radio1">
            <input type="radio" name="btn_radio" id="radio2">
            <input type="radio" name="btn_radio" id="radio3">

            <div class="slidebox pri">
                <img class="imgDesktop" src="Imagens_Carrossel/Slide 1.png" alt="slide 1">
                <img class="imgMobile" src="Imagens_Carrossel/slide1[1.png" alt="slide 1"> 
            </div>
            <div class="slidebox">
                <img class="imgDesktop" src="Imagens_Carrossel/Slide 2.png" alt="slide 2">
                <img class="imgMobile" src="Imagens_Carrossel/slide2[1.png" alt="slide 2"> 
            </div>
            <div class="slidebox">
                <img class="imgDesktop" src="Imagens_Carrossel/Slide 3.png" alt="slide 3">
                <img class="imgMobile" src="Imagens_Carrossel/slide3[1.png" alt="slide 3"> 
            </div>

            <div class="navAuto">
                <div class="btn_auto1"></div>
                <div class="btn_auto2"></div>
                <div class="btn_auto3"></div>
            </div>

            <div class="navManu">
                <label for="radio1" class="btn_manu"></label>
                <label for="radio2" class="btn_manu"></label>
                <label for="radio3" class="btn_manu"></label>
            </div>
        </div>
    </section>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"
      integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL"
      crossorigin="anonymous"></script>

    <div>&nbsp;</div>
    <div>&nbsp;</div>
    <div>&nbsp;</div>
    
    <div class="container">

    <div class="card-simples">
            <div class="card-content">
                <h2 class="titulo-card">Estética</h2>
                <div class="cor-falsificada">
                    <p class="mais-texto">Saiba mais <i class="fa-solid fa-arrow-down"></i></p>
                <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</p>
                <div class="position-button">
            </div>
            </div>
            </div>
        </div>
        </div>

        <div class="card-simples">
            <div class="card-content">
                <h2 class="titulo-card">Estética</h2>
                <div class="cor-falsificada">
                    <p class="mais-texto">Saiba mais <i class="fa-solid fa-arrow-down"></i></p>
                <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</p>
                <div class="position-button">
            </div>
            </div>
            </div>
        </div>

        <div class="card-simples">
            <div class="card-content">
                <h2 class="titulo-card">Bio-estimulador</h2>
                <div class="cor-falsificada">
                        <p class="mais-texto">Saiba mais <i class="fa-solid fa-arrow-down"></i></p>
                    <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</p>
                    <div class="position-button">
                    </div>
                </div>
            </div>
        </div>
</div>
      
<!--começo dos cards das dicas-->
<div class="divisor">
        <div class="separador-de-tela">
            <h2>Dicas para as clientes Favoritas!!!</h2>
        </div>
    <div class="container">
        <div class="card">
            <img src="Imagens_Home/sala.jpg" alt="">
            <div class="card-content">
                <h2 class="titulo-card">Sala Nova</h2>
                <div class="cor-falsificada">
                    <p class="mais-texto">Saiba mais <i class="fa-solid fa-arrow-down"></i></p>
                <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</p>
                <div class="position-button">
            </div>
            </div>
            </div>
        </div>

        <div class="card">
            <img src="Imagens_Home/Protetor.jpg" alt="">
            <div class="card-content">
                <h2 class="titulo-card">Procimento</h2>
                <div class="cor-falsificada-2">
                    <p class="mais-texto">Saiba mais <i class="fa-solid fa-arrow-down"></i></p>
                <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</p>
                <div class="position-button">
                </div>
                </div>
            </div>
        </div>

        <div class="card">
            <img src="Imagens_Home/pele.jpg" alt="">
            <div class="card-content">
                <h2 class="titulo-card">Novos Tratamentos</h2>
                <div class="cor-falsificada-3">
                    <p class="mais-texto">Saiba mais <i class="fa-solid fa-arrow-down"></i></p>
                <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</p>
                <div class="position-button">
                </div>
                </div>
            </div>
        </div>
    </div>
</div>
  <!-- fim-->

  <div class="container">
        <div class="div_container">
            <h2>Precisa de ajuda?</h2>
            <p>Se precisar de ajuda, não hesite em nos chamar pelos meios de contato abaixo, ficaremos felizes em responder você!</p>
            <div class="contact-section">
                <div class="contact-info">
                    <h3>Entre em Contato, estamos disponiveis de diversas formas!</h3>
                    <div><i class="fa-brands fa-whatsapp"></i> WhatsApp: +55 (11) 99999-9999</div>
                    <div><i class="fa-regular fa-envelope"></i> E-mail: CareTones@gmail.com</div>
                    <div><i class="fa-brands fa-instagram"></i> Instagram: @CareTones</div>
                    <div><i class="fa-brands fa-facebook"></i> Facebook: @CareTones</div>
                    <!-- Div para exibir a mensagem de resposta -->
                <div id="mensagemResposta"></div>
                </div>
                <form class="contact-form" method="POST" id="formDuvida">
                    <h3>...ou nos mande uma mensagem</h3>
                    <label for="nome"><i class="fas fa-user"></i> Nome completo</label>
                    <input type="text" id="nome" name="nome" required>
                    
                    <label for="telefone"><i class="fa-solid fa-phone"></i> Telefone</label>
                    <input type="text" id="telefone" name="telefone" required>
                    
                    <label for="objetivo"><i class="fas fa-bullseye"></i> Objetivo</label>
                    <input type="text" id="objetivo" name="objetivo" required>
                    
                    <label for="mensagem">Mensagem</label>
                    <textarea id="mensagem" name="mensagem" required></textarea>
                    <button type="button" id="button-duvida" onclick="enviarDuvida()">Enviar Mensagem</button>
                </form>
            </div>
        </div>
    </div>
    

    <footer>
        <div id="footer_content">
            <div id="footer_contacts">
                <a class="navbar-brand"> <img class="rounded-circle ms-4" src="../logo/Logo.png" alt="Logo care tones" width="69px"></a>
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
                <div id="input_group">
                    <input type="email" id="email">
                    <button>
                        <i class="fa-regular fa-envelope"></i>
                    </button>
                </div>
            </div>
        </div>
        <div id="footer_copyright">
            &#169
            2024 all rights reserved
        </div>
    </footer>
</body>
</html>