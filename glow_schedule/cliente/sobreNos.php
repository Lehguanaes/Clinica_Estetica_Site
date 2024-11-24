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
    <integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
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
    <div id="Procedimentos">

                    <div class="titulo-sobre-nos">
                        <h2 class="o-que">Sobre nós</h2>
                    </div>

                    <div class="titulo-sobre-nos-2">
                        <h2 class="care-tones">O que é a Caretones?</h2>
                    </div>

                    <section class="h--timeline js-h--timeline">
                      <div class="h--timeline-container">
                        <div class="h--timeline-dates">
                          <div class="h--timeline-line">
                            <ol>
                              <li><a href="#0" data-date="16/01/2014" class="h--timeline-date h--timeline-date--selected">2011</a></li>
                              <li><a href="#0" data-date="20/04/2013" class="h--timeline-date">2013</a></li>
                              <li><a href="#0" data-date="20/05/2012" class="h--timeline-date">2015</a></li>
                              <li><a href="#0" data-date="09/07/2011" class="h--timeline-date">2017</a></li>
                              <li><a href="#0" data-date="30/08/2007" class="h--timeline-date">2019</a></li>
                              <li><a href="#0" data-date="15/09/2001" class="h--timeline-date">2022</a></li>
                            </ol>
                      
                            <span class="h--timeline-filling-line" aria-hidden="true"></span>
                          </div> <!-- .h--timeline-line -->
                        </div> <!-- .h--timeline-dates -->
                      
                        <nav class="h--timeline-navigation-container">
                            <ul>
                              <li><a href="#0" class="text-replace h--timeline-navigation h--timeline-navigation--prev h--timeline-navigation--inactive">Prev</a></li>
                              <li><a href="#0" class="text-replace h--timeline-navigation h--timeline-navigation--next">Next</a></li>
                            </ul>
                        </nav>
                      </div> <!-- .h--timeline-container -->
                      
                      <div class="h--timeline-events">
                        <ol>
                          <li class="h--timeline-event h--timeline-event--selected text-component">
                            <div class="h--timeline-event-content container">
                              
                              <h2 >Criação da clínica</h2>
                              <p class="h--timeline-event-description">
                                  A criação da Clínica Care Tones - Estética nasceu do sonho de proporcionar um espaço diferenciado para cuidados com a beleza e o bem-estar. Desde o início, idealizamos um ambiente que unisse alta tecnologia e técnicas avançadas a um atendimento humanizado e acolhedor. Nossa visão era criar um local onde as pessoas pudessem encontrar tratamentos personalizados, que cuidassem da aparência de forma saudável e que respeitassem a individualidade de cada cliente.
                              </p>
                            </div>
                          </li>
                      
                      
                          <li class="h--timeline-event text-component">
                            <div class="h--timeline-event-content container">
                              <h2 >Aprimoramento do estabelecimento</h2>
                              <p class="h--timeline-event-description">
                                  Na Care Tones, o aprimoramento constante é um pilar fundamental. Nosso compromisso com a excelência e com a satisfação dos clientes nos leva a buscar continuamente formas de melhorar a estrutura, os serviços e o atendimento da clínica. Este processo de aprimoramento envolve investimentos em novas tecnologias, treinamentos frequentes para a equipe e melhorias nos espaços para tornar a experiência ainda mais agradável e eficiente para todos.
                              </p>
                            </div>
                          </li>
                      
                          <li class="h--timeline-event text-component">
                            <div class="h--timeline-event-content container">
                              <h2 >Criação do website</h2>
                              <p class="h--timeline-event-description">
                                  O website da Clínica Care Tones - Estética foi desenvolvido para ser um canal informativo, funcional e intuitivo, que reflete a essência e os valores da clínica. Pensado para oferecer uma experiência digital agradável e acessível, o site permite que nossos clientes conheçam mais sobre os serviços oferecidos, nossa equipe, e agendem consultas de forma prática e rápida, tudo em um único lugar.
                              </p>
                            </div>
                          </li>
                      
                          <li class="h--timeline-event text-component">
                            <div class="h--timeline-event-content container">
                              <h2 >Re-desing do site</h2>
                              <p class="h--timeline-event-description">
                                  O redesign do website da Clínica Care Tones - Estética foi uma iniciativa para aprimorar a experiência dos usuários, tornando o site mais moderno, funcional e alinhado com a identidade da clínica. Buscamos criar uma interface visualmente agradável e intuitiva, focada em destacar nossos serviços, facilitar o acesso às informações e tornar o processo de agendamento ainda mais simples.
                              </p>
                            </div>
                          </li>
                      
                          <li class="h--timeline-event text-component">
                            <div class="h--timeline-event-content container">
                              <h2 >Planejamentos de um app</h2>
                              <p class="h--timeline-event-description">
                                  O aplicativo da Clínica Care Tones - Estética será uma extensão digital da experiência oferecida na clínica, proporcionando aos clientes uma plataforma acessível e prática para gerenciar agendamentos, conhecer nossos serviços e interagir com a equipe. Com um design moderno e funcional, o app visa facilitar o dia a dia dos clientes e fortalecer o relacionamento com a Care Tones.
                              </p>
                            </div>
                          </li>
                      
                          <li class="h--timeline-event text-component">
                            <div class="h--timeline-event-content container">
                              <h2 >Aplicativo</h2>
                              <p class="h--timeline-event-description">
                                  O aplicativo da Clínica Care Tones - Estética foi desenvolvido para ser uma ferramenta prática, acessível e personalizada, oferecendo aos clientes uma experiência digital que facilitasse o cuidado com a beleza e o bem-estar. Através de uma interface intuitiva e recursos práticos, o app permitiu aos clientes acessar informações sobre serviços, agendar consultas, gerenciar seus históricos de tratamento e se conectar com a equipe de maneira simples.
                              </p>
                            </div>
                          </li>
                      
                        </ol>
                      </div> <!-- .h--timeline-events -->
                      </section>
                      <script src="Js/linha-tempo.js"></script>
                  <!--espaço para fazer a linha do tempo-->
                        
  <div class="separador-de-tela-2">
    <h2>Avaliações</h2>
    </div>

    <div class="container">

      <div class="card-simples">
          <div class="card-content">
              <h2 class="titulo-card">Nova sala Disponivel</h2>
              <div class="cor-falsificada">
                  <p class="mais-texto">Saiba mais  <i class="fa-solid fa-arrow-down"></i></p>
              <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</p>
              <div class="position-button">
          </div>
          </div>
          </div>
      </div>

      <div class="card-simples">
        <div class="card-content">
            <h2 class="titulo-card">Nova sala Disponivel</h2>
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
          <h2 class="titulo-card">Nova sala Disponivel</h2>
          <div class="cor-falsificada">
              <p class="mais-texto">Saiba mais <i class="fa-solid fa-arrow-down"></i></p>
          <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</p>
          <div class="position-button">
      </div>
      </div>
      </div>
  </div>

      </div>
<!--enrolação sobre o que é a clínica-->

<!--espaço para fazer a linha do tempo-->
<!--enrolação sobre o que é a clínica-->
<div class="divisor2">
  <h2>Interessado?</h3>
  <h2 class="texto">Venha nos Conhecer a baixo!!</h2>
      <p>Cada cliente é essencial para nós. Assim como o coração bombeia sangue para o corpo, mantendo-o vivo e saudável, nossas clientes são a força vital que mantém nossa clínica pulsando. Com cada visita e cada confiança depositada em nossos serviços, vocês contribuem para o crescimento e a energia do nosso trabalho.</p>
</div>
<!--enrolação sobre o que é a clínica-->
<h2>Avaliações da Clínica</h2>
<!-- Swiper para avaliações -->
<div class="swiper">
    <!-- Wrapper para os slides -->
    <div class="swiper-wrapper">
    <?php
    require_once $_SERVER['DOCUMENT_ROOT'] . '/glow_schedule/controller/conexao.php';

    // Inicializa a conexão com o banco de dados
    $conexao = new Conexao(); // Cria uma instância da classe Conexao
    $conn = $conexao->getConexao(); // Obtém a conexão MySQLi a partir do método

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

    // Consulta para buscar as avaliações da clínica
    $sql_avaliacoes = "
        SELECT a.estrelas_avaliacao, a.comentario_avaliacao, a.data_criacao_avaliacao, 
            c.nome_cliente, c.foto_cliente
        FROM Avaliacoes a
        JOIN Cliente c ON a.cpf_cliente = c.cpf_cliente
        WHERE a.avaliado = 'clinica'"; // Avaliado como 'clinica'

    // Prepara a consulta
    $stmt_avaliacoes = $conn->prepare($sql_avaliacoes);

    if ($stmt_avaliacoes) {
        // Executa a consulta
        $stmt_avaliacoes->execute();
        $result_avaliacoes = $stmt_avaliacoes->get_result();

        // Verifica se há avaliações
        if ($result_avaliacoes->num_rows > 0) {
            while ($avaliacao = $result_avaliacoes->fetch_assoc()) {
                echo '<div class="swiper-slide">';
                echo '    <div class="card-review">';
                echo '        <img src="' . 
                (isset($avaliacao['foto_cliente']) && file_exists($_SERVER['DOCUMENT_ROOT'] . "/glow_schedule/uploads/" . $avaliacao['foto_cliente']) 
                    ? "/glow_schedule/uploads/" . htmlspecialchars($avaliacao['foto_cliente']) 
                    : "../iconesPerfil/perfilPadrao.png") . 
                '" alt="Foto do Cliente" class="avatar mb-3">';
                echo '        <p class="text-muted small">' . formatarData($avaliacao['data_criacao_avaliacao']) . '</p>';
                echo '        <h5 class="card-title">' . htmlspecialchars($avaliacao['nome_cliente']) . '</h5>';
                echo '        <p class="card-text">' . htmlspecialchars($avaliacao['comentario_avaliacao']) . '</p>';
                echo '        <div class="star-rating mb-2">';
                for ($i = 0; $i < 5; $i++) {
                    echo $i < $avaliacao['estrelas_avaliacao'] ? '<span class="fa fa-star"></span>' : '<span class="fa fa-star-o"></span>';
                }
                echo '        </div>';
                echo '    </div>';
                echo '</div>';
            }
        } else {
            // Mensagem caso não haja avaliações
            echo '<div class="swiper-slide">';
            echo '    <div class="card-review">';
            echo '        <p class="card-text text-muted">Nenhuma avaliação disponível no momento.</p>';
            echo '    </div>';
            echo '</div>';
        }

        $stmt_avaliacoes->close(); // Fecha a consulta
    } else {
        echo "Erro ao preparar a consulta: " . $conn->error;
    }

    $conn->close(); // Fecha a conexão
    ?>
    </div>
    <!-- Paginação -->
    <div class="swiper-pagination"></div>
            <div>&nbsp;</div> 
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
    <!-- SwiperJS Script -->
    <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
    <script src="../js/carrosselAvaliacao.js"></script>
</body>
</html>