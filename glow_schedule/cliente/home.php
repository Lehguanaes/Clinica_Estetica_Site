<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Care Tones</title>
    <link rel="stylesheet" href="../css/duvidas.css">
    <link rel="stylesheet" href="../css/Style.css">
    <link rel="stylesheet" href="../css/css-mota.css">
    <link rel="stylesheet" href="../css/navbar.css">
    <link rel="stylesheet" href="../css/carrossel.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css" integrity="sha512-MV7K8+y+gLIBoVD59lQIYicR65iaqukzvf/nwasF0nqhPay5w/9lJmVM2hMDcnK1OnMGCdVK+iQrJ7lzPJQd1w==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <link rel="stylesheet" type="text/css" href="../css/carrossel.css" media="screen" />
    <script src="../js/carrossel.js" defer></script>
    <script src="../js/navbar.js" defer></script>
    <integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <script src="glider.js"></script>
</head>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.min.js" integrity="sha384-cuYeSxntonz0PPNlHhBs68uyIAVpIIOZZ5JqeqvYYIcEL727kskC66kF92t6Xl2V" crossorigin="anonymous"></script>
<body>
    <header>
        <nav class="nav-bar">
          <a class="logo" href="Home.html"><img src="../logo/Logo.png" class="logoIMG">Care Tones</a>
          <ul class="nav-list">
            <li><a href="Home.php" class="nav">Home</a></li>
            <li><a href="Sobrenos.php" class="nav">Sobre Nós</a></li>
            <li><a href="Procedimentos.php" class="nav">Procedimentos</a></li>
            <li><a href="Profissionais.php" class="nav">Profissionais</a></li>
            <li><a href="../agendamento/agendamento.php" class="nav">Agendamentos</a></li>
          </ul>
          <div class="dropdown">
            <div class="login-icon">
                <a href="../cliente/perfilCliente.php">
                <i class="fa-solid fa-circle-user fa-xl" style="color: #fff;"></i>
                </a>
                <div class="dropdown-content">
                <a href="consultasCliente.php"><i class="fa-solid fa-user" style="color: #cf6f7a;"></i> Ver Perfil </i></a>
                <a href="editarCliente.php"><i class="fa-solid fa-user-pen" style="color: #cf6f7a;"></i> Editar Perfil </a>
                <a href="consultasCliente.php"><i class="fa-solid fa-calendar-check" style="color: #cf6f7a;"></i> Ver Consultas </i></a>
                <a href="perfilCliente.php"><i class="fa-solid fa-star" style="color: #cf6f7a;"></i> Avaliar Clínica </a>
                
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

    <h2> Novidades da Semana </h2>

    <section class="slider">
        <div class="slider-content">
            <input type="radio" name="btn_radio" id="radio1">
            <input type="radio" name="btn_radio" id="radio2">
            <input type="radio" name="btn_radio" id="radio3">

            <div class="slidebox pri">
                <img class="imgDesktop" src="../preLogin/Imagens_Carrossel/Slide 1.png" alt="slide 1">
                <img class="imgMobile" src="../preLogin/Imagens_Carrossel/slide1[1.png" alt="slide 1"> 
            </div>
            <div class="slidebox">
                <img class="imgDesktop" src="../preLogin/Imagens_Carrossel/Slide 2.png" alt="slide 2">
                <img class="imgMobile" src="../preLogin/Imagens_Carrossel/slide2[1.png" alt="slide 2"> 
            </div>
            <div class="slidebox">
                <img class="imgDesktop" src="../preLogin/Imagens_Carrossel/Slide 3.png" alt="slide 3">
                <img class="imgMobile" src="../preLogin/Imagens_Carrossel/slide3[1.png" alt="slide 3"> 
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
                <h2 class="titulo-card">Nova sala Disponivel</h2>
                <div class="cor-falsificada">
                    <p class="mais-texto">Saiba mais ↧</p>
                <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</p>
                <div class="position-button">
            </div>
            </div>
            </div>
        </div>

        <div class="card-simples">
            <div class="card-content">
                <h2 class="titulo-card">Estética</h2>
                <div class="cor-falsificada">
                    <p class="mais-texto">Saiba mais ↧</p>
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
                    <p class="mais-texto">Saiba mais ↧</p>
                <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</p>
                <div class="position-button">
            </div>
            </div>
            </div>
        </div>

</div>
      
<!--começo dos cards das dicas-->
<div class="divisor-2">
    <div class="separador-de-tela">
        <h2>Dicas para as clientes Favoritas!!!</h2>
        </div>
<div class="container">
    <div class="card">
        <img src="../preLogin/Imagens_Home/sala.jpg" alt="">
        <div class="card-content">
            <h2 class="titulo-card">Sala Nova</h2>
            <div class="cor-falsificada">
                <p class="mais-texto">Saiba mais ↧</p>
            <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</p>
            <div class="position-button">
        </div>
        </div>
        </div>
    </div>

    <div class="card">
        <img src="../preLogin/Imagens_Home/Protetor.jpg" alt="">
        <div class="card-content">
            <h2 class="titulo-card">Procimento</h2>
            <div class="cor-falsificada-2">
                <p class="mais-texto">Saiba mais ↧</p>
            <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</p>
            <div class="position-button">
            </div>
            </div>
        </div>
    </div>

    <div class="card">
        <img src="../preLogin/Imagens_Home/pele.jpg" alt="">
        <div class="card-content">
            <h2 class="titulo-card">Novos Tratamentos</h2>
            <div class="cor-falsificada-3">
                <p class="mais-texto">Saiba mais ↧</p>
            <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</p>
            <div class="position-button">
            </div>
            </div>
        </div>
    </div>
</div>
</div>
  <!-- fim-->
   <br>
  <div class="container">
        <div class="div_container" style="box-shadow: 0 2px 5px rgba(0, 0, 0, 0.4); background-color: #FFF;">
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
                    <input type="text" id="nome" name="nome" style="color: #333; position: relative; height: 50px; width: 100%; outline: none; font-size: 1rem; color: #707070; margin-top: 8px; border: 2px solid #707070; border-radius: 6px; padding: 0 15px; background-color: #D3DFE5; background-color: #FFF; border-color: #1A7F83; box-shadow: 0 1px 0 rgba(0, 0, 0, 0.1);" required>

                    <label for="telefone"><i class="fa-solid fa-phone"></i> Telefone</label>
                    <input type="text" id="telefone" name="telefone" style="height: 50px; width: 100%; outline: none; font-size: 1rem; color: #707070; margin-top: 8px; border: 2px solid #707070; border-radius: 6px; padding: 0 15px; background-color: #D3DFE5; background-color: #FFF; border-color: #1A7F83; box-shadow: 0 1px 0 rgba(0, 0, 0, 0.1);" required>

                    <label for="objetivo"><i class="fas fa-bullseye"></i> Objetivo</label>
                    <input type="text" id="objetivo" name="objetivo" style="height: 50px; width: 100%; outline: none; font-size: 1rem; color: #707070; margin-top: 8px; border: 2px solid #707070; border-radius: 6px; padding: 0 15px; background-color: #D3DFE5;  background-color: #FFF; border-color: #1A7F83; box-shadow: 0 1px 0 rgba(0, 0, 0, 0.1);" required>

                    <label for="mensagem"><i class="fa-solid fa-message"></i> Mensagem</label>
                    <textarea id="mensagem" name="mensagem" style="width: 100%; outline: none; font-size: 1rem; color: #707070; margin-top: 8px; border: 2px solid #707070; border-radius: 6px; padding: 0 15px; background-color: #D3DFE5; background-color: #FFF; border-color: #1A7F83; box-shadow: 0 1px 0 rgba(0, 0, 0, 0.1);" required></textarea>
                    <button type="button" id="button-duvida" onclick="enviarDuvida()">Enviar Mensagem</button>
                </form>
            </div>
        </div>
    </div>
    <br>
    <?php  include("../footers/footerClienteLog.php"); ?>
</body>
</html>