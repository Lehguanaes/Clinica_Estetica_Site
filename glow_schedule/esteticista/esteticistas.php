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
    <!-- Estilização padrão do website -->
    <link rel="stylesheet" href="../css/style.css">
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css">
    <!-- Estilização formulários de Perfis -->
    <link rel="stylesheet" href="../css/perfil.css">
    <!-- Link para o arquivo CSS -->
    <link rel="stylesheet" href="../css/styleAgendamento.css">
    <!-- Link para o arquivo JavaScript -->
    <!-- Estilização Navbar -->
    <link rel="stylesheet" href="../css/navbar.css">
    <!-- Link Js Navbar -->
    <script src="../js/navbar.js"></script>
    <!-- Estilização form duvidas -->
    <script src="../js/agendamento.js" defer></script>
</head>
<body>
        <!-- Início da Navbar -->
        <header>
        <nav class="nav-bar">
          <a class="logo" href="Home.html"><img src="../logo/Logo.png" class="logoIMG">Care Tones</a>
          <ul class="nav-list">
            <li><a href="../atendente/visualizarConsultas.php" class="nav">Consultas</a></li>
            <li><a href="../atendente/visualizarDuvidas.php" class="nav">Dúvidas</a></li>
            <li><a href="../avaliacoes/avaliacoes.php" class="nav">Avaliações</a></li>
            <li><a href="../agendamento/agendamentoAtendente.php" class="nav">Agendar Consulta</a></li>
            <li><a href="esteticistas.php" class="nav">Esteticistas</a></li>
            <li><a href="../atendente/cadastroAtendente.php" class="nav">Novos Atendentes</a></li>
          </ul>
          <div class="dropdown">
            <div class="login-icon">
                <a href="perfilAtendente.php">
                <i class="fa-solid fa-circle-user fa-xl" style="color: #fff;"></i>
                </a>
                <div class="dropdown-content">
                    <a href="../atendente/perfilAtendente.php"><i class="fa-solid fa-right-to-bracket" style="color: #cf6f7a;"></i> Perfil </a>
                    <a href="cadastroEsteticista.php"><i class="fa-solid fa-address-card" style="color: #cf6f7a;"></i> Cadastrar Esteticista </a>
                    <a href="../cliente/cadastrarClienteAtendente.php"><i class="fa-solid fa-address-card" style="color: #cf6f7a;"></i> Cadastrar Cliente </a>
                    <a href="../procedimento/cadastrarProcedimento.php"><i class="fa-solid fa-address-card" style="color: #cf6f7a;"></i> Cadastrar Procedimento </a>
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
    <div id="Profissionais">
        <h2>Profissionais</h2>
        <div class="container-cards-home">
        <div class="container">
    <div class="row">
        <?php
        // Atualize o caminho do arquivo de conexão com o banco de dados
        require_once $_SERVER['DOCUMENT_ROOT'] . "/glow_schedule/controller/conexao.php";
        require_once $_SERVER['DOCUMENT_ROOT'] . "/glow_schedule/model/message.php";
        require_once $_SERVER['DOCUMENT_ROOT'] . "/glow_schedule/controller/global.php";

        // Cria uma nova instância da classe Conexao e obtém a conexão
        $conexao = new Conexao();
        $conn = $conexao->getConexao();

        $message = new Message($BASE_URL);
        $flashMsg = $message->getMessage();

        // Consulta SQL para buscar todos os esteticistas
        $sql = "SELECT * FROM esteticista";
        $result = $conn->query($sql);

        // Verifica se há resultados
        if ($result->num_rows > 0) {
            // Itera pelos resultados e exibe os dados dinamicamente
            while ($row = $result->fetch_assoc()) {
                echo '<div class="col-md-4 mb-4">';
                echo '<div class="card">';
                echo '<img src="' . (file_exists($_SERVER['DOCUMENT_ROOT'] . "/glow_schedule/" . $row['foto_esteticista']) ? "/glow_schedule/" . htmlspecialchars($row['foto_esteticista']) : "/glow_schedule/uploads/default.jpg") . '" alt="Foto do Esteticista" class="card-img-top" style="height: 200px; object-fit: cover;">';
                echo '<div class="card-content p-3">';
                echo '<h5 class="titulo-card">' . htmlspecialchars($row['nome_esteticista']) . '</h5>';
                echo '<p class="mais-texto">Saiba mais ⬇️</p>';
                echo '<p>' . htmlspecialchars($row['descricao_p_esteticista']) . '</p>';
                echo '<div class="position-button text-center">';
                echo '<a href="esteticistasInfo.php?apelido_esteticista=' . urlencode($row['apelido_esteticista']) . '" class="btn btn-primary">Perfil</a>';
                echo '</div>';
                echo '</div>';
                echo '</div>';
                echo '</div>';
            }
        } else {
            echo '<p class="text-center">Nenhum esteticista encontrado.</p>';
        }

        // Fecha a conexão com o banco de dados
        $conn->close();
        ?>
        <button type="submit"><a href="cadastroEsteticista.php">Cadastrar Esteticistas</a></button>
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
