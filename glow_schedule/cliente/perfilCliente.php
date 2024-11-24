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
    $stmt = $conexao->prepare("SELECT * FROM cliente WHERE token_cliente = ?");
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
    // atribui o $cliente a uma linha do $resultado
    $cliente = $resultado->fetch_assoc();
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Perfil</title>
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
                <li><a href="../cliente/cadastrarDuvidas.php" class="nav">Dúvidas</a></li>
                <li><a href="../cliente/consultasCliente.php" class="nav">Minhas Consultas</a></li>
                <li><a href="../agendamento/agendamento.php" class="nav">Agendamento</a></li>
            </ul>
            <div class="dropdown">
                <div class="login-icon">
                    <a href="perfilAtendente.php">
                        <i class="fa-solid fa-circle-user fa-xl" style="color: #fff;"></i>
                    </a>
                    <div class="dropdown-content">
                        <a href="../cliente/editarCliente.php"><i class="fas fa-pencil-alt" style="color: #cf6f7a;"></i> Editar Perfil </a>
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
    <!-- Exibição do perfil -->
    <h2>Minhas Informações</h2>
    <div class="container mt-4" id="perfil_conteiner">
        <div class="card mb-4" id="perfil_card" style="max-width: 1000px; margin: auto; border: none;">
            <div class="row g-0">
            <div class="profile-pic-container_visualizar">
                    <!-- Imagem de perfil do atendente -->
                    <img src="<?php 
                        // Verifica se a foto do atendente existe e se o campo não está vazio
                        $fotoPath = $_SERVER['DOCUMENT_ROOT'] . "/glow_schedule/" . $cliente['foto_cliente'];
                        echo (file_exists($fotoPath) && !empty($cliente['foto_cliente'])) 
                            ? "/glow_schedule/" . htmlspecialchars($cliente['foto_cliente']) 
                            : "../iconesPerfil/perfilPadrao.png"; // Caminho para a imagem padrão
                    ?>" alt="Foto do cliente" class="profile-pic" id="profile-pic-preview">
                    <p id="nome_perfil"><strong></strong> <?php echo htmlspecialchars($cliente['nome_cliente']); ?></p>
                </div>
                <!-- Coluna de informações -->
                <div class="col-md-8" style="margin-top: 30px;">
                    <p><strong>Nome Completo:</strong> <?php echo ($cliente['nome_cliente']); ?></p>
                    <p><strong>CPF:</strong> <?php echo ($cliente['cpf_cliente']); ?></p>
                    <p><strong>Telefone:</strong> <?php echo ($cliente['telefone_cliente']); ?></p>
                    <p><strong>Email:</strong> <?php echo ($cliente['email_cliente']); ?></p>        

                </div>
            </div>
            
        </div>
        <div class="link">
        <a href="../prontuario/cadastroProntuario.php">aaaaaaa</a>  
        </div>
        <!-- Botão para editar o perfil -->
        <div>
            <a href="http://localhost/glow_schedule/cliente/editarCliente.php" class="btn btn-primary" id="editar_perfil_button">Editar Perfil</a>
        </div>
    </div>
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
