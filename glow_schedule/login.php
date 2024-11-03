<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Care Tones</title>
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css" integrity="sha512-MV7K8+y+gLIBoVD59lQIYicR65iaqukzvf/nwasF0nqhPay5w/9lJmVM2hMDcnK1OnMGCdVK+iQrJ7lzPJQd1w==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <link rel="stylesheet" type="text/css" href="Css/carrossel.css" media="screen" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css" integrity="sha512-MV7K8+y+gLIBoVD59lQIYicR65iaqukzvf/nwasF0nqhPay5w/9lJmVM2hMDcnK1OnMGCdVK+iQrJ7lzPJQd1w==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <script src="Js/carrossel.js" defer></script>
    <integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <script src="glider.js"></script>


</head>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.min.js" integrity="sha384-cuYeSxntonz0PPNlHhBs68uyIAVpIIOZZ5JqeqvYYIcEL727kskC66kF92t6Xl2V" crossorigin="anonymous"></script>
<body>

 <!-- Início da Navbar -->
    <nav class="navbar navbar-expand-lg">
        <div class="container-fluid">
            <a class="navbar-brand"> <img class="rounded-circle ms-4" src="logo/Logo.png" alt="Logo care tones" width="69px"> </a>
            <link rel="preconnect" href="https://fonts.googleapis.com">
            <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
            <link href="https://fonts.googleapis.com/css2?family=Cinzel&family=Playfair+Display:ital@1&display=swap" rel="stylesheet">
            <div class="logo">
                <a class="nav-link" id="desativado" aria-current="page" href="Home.html">Care Tones</a>
            </div>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent" >
                <ul class="navbar-nav w-auto">
                    <li class="nav-item pe-4 ps-4">
                         <a class="nav-link" aria-current="page" href="Home.html">Home</a>
                    </li>
                    <li class="nav-item pe-4 ps-4">
                         <a class="nav-link active" aria-current="page" href="Sobre_nos.html">Sobre nós</a>
                    </li>
                    <li class="nav-item pe-4 ps-4">
                        <a class="nav-link active" aria-current="page" href="Procedimentos.html">Procedimentos</a>
                    </li>
                    <li class="nav-item pe-4 ps-4">
                        <a class="nav-link active" aria-current="page" href="Profissionais.html">Profissionais</a>
                    </li>
                </ul>

                <button type="button" class="btn btn-sm btn-link me-4 ms-4"> <a href="Agendamentos.html" id="link_agendamentos">Agendamentos</a> </button>
                <div class="dropdown">
                    <div class="login-icon">
                        <a href="Cadastro.html">
                        <i class="fa-solid fa-circle-user fa-xl" style="color: #fff;"></i>
                        </a>
                        <div class="dropdown-content">
                            <a href="Login.html"><i class="fa-solid fa-right-to-bracket" style="color: #cf6f7a;"></i> Log in</a>
                            <a href="Cadastro.html"><i class="fa-solid fa-address-card" style="color: #cf6f7a;"></i> Cadastre-se</i></a>
                        </div>
                    </div>
                 </div>
            </div>
        </div>
    </nav>
     <!-- Fim da Navbar -->

      <!-- Início do login -->
    <h2 class="h2_novo">Login</h2>  
    <section class="container">
    <form method="post" action="/glow_schedule/controller/usuarioController.php">
       <input type="hidden" name="acao" value="login">
             <div class="Login">        
                    <div class="input-box">
                        <label>Email:</label>
                        <input type="text" id="email" name="email" placeholder="Email:" required />
                    </div>
                    <div class="input-box">
                        <label>Senha:</label>
                        <input type="password"  id="senha" name="senha" placeholder="Senha" required />
                    </div>
                    <button>  <i class="fa-solid fa-right-to-bracket" ></i>  Entrar</button>
            </div>
            <a href="cliente/cadastrarCliente.php" style="color: #cf6f7a;"> Não possui conta? </a>
        </form>
    </section>

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
            2023 all rights reserved
        </div>
    </footer>