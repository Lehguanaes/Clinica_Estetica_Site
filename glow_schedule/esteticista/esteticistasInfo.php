<?php
    require_once $_SERVER['DOCUMENT_ROOT'] . "/glow_schedule/controller/usuarioController.php";
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
    //smt com placeholder ?, pq o método ':cpf', $cpf não funcionou
    $stmt = $conexao->prepare("SELECT * FROM esteticista WHERE token_esteticista = ?");
    // um if para a verificação se o statement resulta em algo
    if ($stmt === false) {
        // Exibe o erro da preparação da consulta
        die('Erro no sql: ' . $conexao->error);
    }
    //smt com placeholder ?, pq o método ':cpf', $cpf não funcionou
    $stmt->bind_param("s", $token);
    $stmt->execute();
    
    // atribui o resultado da consulta  do stmt ao vetor $resultado
    $resultado = $stmt->get_result();
    // atribui o $esteticista a uma linha do $resultado
    $esteticista = $resultado->fetch_assoc();
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
                <li><a href="esteticistas.php" class="nav">Profissionais</a>
                <li><a href="../procedimento/procedimentos.php" class="nav">Procedimentos</a>
                <li><a href="visualizarConsultas.php" class="nav">Agenda</a></li>
            </ul>
            <div class="dropdown">
                <div class="login-icon">
                    <a href="perfilAtendente.php">
                        <i class="fa-solid fa-circle-user fa-xl" style="color: #fff;"></i>
                    </a>
                    <div class="dropdown-content">
                        <a href="perfilEsteticista.php"><i class="fa-solid fa-user fa-sm" style="color: #cf6f7a;"></i> Perfil </a>
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
    <h2>Minhas Informações</h2>
    <!-- Exibição do perfil -->
    <div class="container mt-4" id="perfil_conteiner">
        <div class="card mb-4" id="perfil_card" style="max-width: 1000px; margin: auto; border: none;">
            <div class="row g-0">
                <!-- Foto e nome do esteticista -->
                <div class="profile-pic-container_visualizar" style="margin-bottom: 65px;">
                    <img src="<?php echo file_exists($_SERVER['DOCUMENT_ROOT'] . "/glow_schedule/" . $esteticista['foto_esteticista']) ? "/glow_schedule/" . htmlspecialchars($esteticista['foto_esteticista']) : "/glow_schedule/uploads/default.jpg"; ?>" alt="Foto do esteticista" class="profile-pic" id="profile-pic-preview">
                    <p id="nome_perfil"><strong> </strong> <?php echo htmlspecialchars($esteticista['nome_esteticista']); ?></p>
                </div>
                <!-- Coluna de informações -->
                <div class="col-12 col-md-8" style="margin-top: 30px;">
                    <p><strong>Nome Completo:</strong> <?php echo htmlspecialchars($esteticista['nome_esteticista']); ?></p>
                    <p><strong>CPF:</strong> <?php echo htmlspecialchars($esteticista['cpf_esteticista']); ?></p>
                    <p><strong>Telefone:</strong> <?php echo htmlspecialchars($esteticista['telefone_esteticista']); ?></p>
                    <p><strong>Email:</strong> <?php echo htmlspecialchars($esteticista['email_esteticista']); ?></p>
                    <p><strong>Formação:</strong> <?php echo htmlspecialchars($esteticista['formacao_esteticista']); ?></p>
                    <p><strong>Descrição Curta:</strong> <?php echo htmlspecialchars($esteticista['descricao_p_esteticista']); ?></p>
                    <p><strong>Descrição Detalhada:</strong> <?php echo htmlspecialchars($esteticista['descricao_g_esteticista']); ?></p>
                    <p><strong>Instagram:</strong> <a href="<?php echo htmlspecialchars($esteticista['instagram_esteticista']); ?>" target="_blank"><?php echo htmlspecialchars($esteticista['instagram_esteticista']); ?></a></p>
                    <p><strong>Facebook:</strong> <a href="<?php echo htmlspecialchars($esteticista['facebook_esteticista']); ?>" target="_blank"><?php echo htmlspecialchars($esteticista['facebook_esteticista']); ?></a></p>
                    <p><strong>LinkedIn:</strong> <a href="<?php echo htmlspecialchars($esteticista['linkedin_esteticista']); ?>" target="_blank"><?php echo htmlspecialchars($esteticista['linkedin_esteticista']); ?></a></p>
                </div>
            </div>
        </div>
        <div class="text-center mt-4">
            <a href="editarEsteticista.php?cpf_esteticista=<?php echo htmlspecialchars($esteticista['cpf_esteticista']); ?>" class="btn btn-primary" id="editar_perfil_button">Editar Perfil</a>
        </div>
    </div>
    &nbsp;
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
                    <a href="perfilEsteticista.php" class="footer-link">Perfil</a>
                </li>
                <li>
                    <a href="cadastroAtendente.php" class="footer-link">Editar Perfil</a>
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
                    <a href="../agendamentoAtendente/agendamento.php" class="footer-link">Agendamento</a>
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
    <!-- Link Sweet Alert -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <!-- Link Js Navbar -->
    <script src="../js/navbar.js"></script>
</body>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<!--  php da mensagem; se a mensagem não estiver vazia, ela é inserida na página  -->
  <?php if (!empty($flashMsg["msg"])): ?>
            <script>
                Swal.fire({
                       icon: "<?= $flashMsg['type'] ?>",
                       title: "<?= $flashMsg['titulo'] ?>",
                       text: "<?= $flashMsg['msg'] ?>",
                       toast: true
                    });
            </script>      
<?php endif; ?>
</html>
