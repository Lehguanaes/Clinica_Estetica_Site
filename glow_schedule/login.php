<?php

require_once $_SERVER['DOCUMENT_ROOT'] . "/glow_schedule/model/message.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/glow_schedule/controller/global.php";

   $message = new Message($BASE_URL);
   $flashMsg = $message->getMessage();

if (!empty($flashMsg["msg"])) {
     $message->limparMessage();
}

?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Página de Acesso</title>
        <!-- Links externos -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css" integrity="sha512-MV7K8+y+gLIBoVD59lQIYicR65iaqukzvf/nwasF0nqhPay5w/9lJmVM2hMDcnK1OnMGCdVK+iQrJ7lzPJQd1w==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <!-- Estilização padrão do web site -->
    <link rel="stylesheet" href="/glow_schedule/css/style.css">
    <!-- Estilização carrossel home -->
    <link rel="stylesheet" type="text/css" href="/glow_schedule/css/carrossel.css" media="screen" />
    <!-- Estilização link carrossel home -->
    <script src="Js/carrossel.js" defer></script>
    <!-- Estilização formulários de Perfis -->
    <link rel="stylesheet" href="/glow_schedule/css/perfil.css">
    <!-- Estilização Navbar -->
    <link rel="stylesheet" href="/glow_schedule/css/navbar.css">
    <!-- Link Js Navbar -->
    <script src="/glow_schedule/js/navbar.js"></script>
    <!-- Estilização form duvidas -->
    <link rel="stylesheet" href="/glow_schedule/css/duvidas.css">
    <!-- Link  form duvidas-->
    <script src="/glow_schedule/js/cadastrarDuvidas.js" defer></script>
    <!-- Link para os icones -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
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
                        <a class="nav-link" aria-current="page" href="/glow_schedule/cliente/home.php">Home</a>
                    </li>
                    <li class="nav-item pe-4 ps-4">
                    <a class="nav-link active" aria-current="page" href="/glow_schedule/cliente/sobreNos.php">Sobre Nós</a>
                    </li>
                    <li class="nav-item pe-4 ps-4">
                        <a class="nav-link active" aria-current="page" href="/glow_schedule/procedimento/procedimentos.php">Procedimentos</a>
                    </li>
                    <li class="nav-item pe-4 ps-4">
                    <li class="nav-item pe-4 ps-4">
                        <a class="nav-link active" aria-current="page" href="/glow_schedule/esteticista/esteticistas.php"> Nossos Profissionais</a>
                   </li>
                    <li class="nav-item pe-4 ps-4">
                        <a class="nav-link active" aria-current="page" href="/glow_schedule/agendamento/agendamento.php">Agendamentos</a>
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

    <!-- Início do login -->
    <h2>Login</h2>  
    <section class="container"> 
    <form method="post" action="/glow_schedule/controller/usuarioController.php" class="form" id="form_perfil">
        <input type="hidden" name="acao" value="login">
            <div class="Login">        
                    <div class="input-box">
                        <label>Email:</label>
                        <input type="text" id="email" name="email" placeholder="Email:" required />
                    </div>
                    <div class="input-box">
                        <label for="senha">*Senha:</label>
                        <div class="password-container">
                            <input type="password" class="form-control" id="senha" name="senha" placeholder="Digite a Senha:" required>
                            <span class="eye-icon" onclick="togglePasswordVisibility()">
                                <i id="eye-icon" class="fa fa-eye"></i>
                            </span>
                        </div>
                    </div>
                    <button>Entrar</button>
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

    <!-- Fim footer -->
    <script>
        // Função para alternar a visibilidade do campo de senha
        function togglePasswordVisibility() {
            // Seleciona o campo de senha e o ícone do olho
            const passwordInput = document.getElementById("senha");
            const eyeIcon = document.getElementById("eye-icon");

            // Verifica se o tipo de entrada é "password" para alternar
            if (passwordInput.type === "password") {
                // Torna a senha visível alterando o tipo para "text"
                passwordInput.type = "text";
                // Muda o ícone para o olho com barra (fa-eye-slash)
                eyeIcon.classList.remove("fa-eye");
                eyeIcon.classList.add("fa-eye-slash");
            } else {
                // Oculta a senha alterando o tipo de volta para "password"
                passwordInput.type = "password";
                // Muda o ícone de volta para o olho normal (fa-eye)
                eyeIcon.classList.remove("fa-eye-slash");
                eyeIcon.classList.add("fa-eye");
            }
        }
    </script>
    
</body>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<!--  php da mensagem; se a mensagem não estiver vazia, ela é inserida na página  -->
  <?php if (!empty($flashMsg["msg"])): ?>
            <script>
                Swal.fire({
                       icon: "<?= $flashMsg['type'] ?>",
                       title: "<?= $flashMsg['titulo'] ?>",
                       text: "<?= $flashMsg['msg'] ?>",
                       width: '450px',
                       iconColor: '#CF6F7A',     
                       toast: true
                    });
            </script>      
<?php endif; ?>
</html>
