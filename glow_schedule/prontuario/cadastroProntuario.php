<?php
    require_once $_SERVER["DOCUMENT_ROOT"] . "/glow_schedule/controller/global.php";
    require_once $_SERVER['DOCUMENT_ROOT'] . "/glow_schedule/controller/usuarioController.php";
    require_once $_SERVER['DOCUMENT_ROOT'] . "/glow_schedule/controller/conexao.php";
    require_once $_SERVER['DOCUMENT_ROOT'] . "/glow_schedule/controller/prontuario/prontuarioController.php";
    require_once $_SERVER["DOCUMENT_ROOT"] . "/glow_schedule/model/message.php";

    $conexaoMini = new Conexao();
    $conexao = $conexaoMini->getConexao();

    $message = new Message($BASE_URL);
    $flashMsg = $message->getMessage();

   if (!empty($flashMsg["msg"])) {
    $message->limparMessage();
    }

    $token = $_SESSION['usuario_token'];
    $stmt = $conexao->prepare("SELECT * FROM cliente WHERE token_cliente = ?");
    // um if para a verificação se o statement resulta em algo
    if ($stmt === false) {
        // Exibe o erro da preparação da consulta
        die('Erro no sql: ' . $conexao->error);
    }
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
    <title>Perfil do Atendente</title>
    <!-- Links externos -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css" integrity="sha512-MV7K8+y+gLIBoVD59lQIYicR65iaqukzvf/nwasF0nqhPay5w/9lJmVM2hMDcnK1OnMGCdVK+iQrJ7lzPJQd1w==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <!-- Estilização padrão do web site -->
    <link rel="stylesheet" href="../css/style.css">
    <!-- Estilização formulários de Perfis -->
    <link rel="stylesheet" href="../css/perfil.css">
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
                <a class="nav-link active" aria-current="page" href="home.php">Care Tones</a>
            </div>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent" >
                <ul class="navbar-nav w-auto">
                    <li class="nav-item pe-4 ps-4">
                        <a class="nav-link active" aria-current="page" href="">Alguma Coisa</a>
                    </li>
                    <li class="nav-item pe-4 ps-4">
                        <a class="nav-link active" aria-current="page" href="">Coisas</a>
                    </li>
                    <li class="nav-item pe-4 ps-4">
                        <a class="nav-link active" aria-current="page" href="">Algo Ai</a>
                    </li>
                </ul>
                <button type="button" class="btn btn-sm btn-link me-4 ms-4" id="link_agendamentos_ativado" > <a href="cadastrarConsulta.php" id="link_agendamentos_ativado">Agendamentos</a></button>
            </div>
        </div>
    </nav>
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



        <section class="container">

        <form method="POST" action="../controller/prontuario/prontuarioController.php" class="form" id="form_perfil">
            <input type="hidden" name="acao" value="inserir">
            <div class="column">
            
            <div class="column">
                <div class="input-box">
                <label for="cor_pele">*Cor da pele:</label>
                    <select name="cor_pele" id="cor_pele">
                            <option value="Albino">Albino</option>
                            <option value="Amarelo">Amarelo</option>
                            <option value="Branco">Branco</option>
                            <option value="Virtiligo">Com Virtiligo</option>
                            <option value="Negro">Negro</option>
                            <option value="Pardo">Pardo</option>
                            <option value="Vermelho">Vermelho</option>
                        </select>             
              </div>
            </div>
            <div class="column">
                <div class="input-box">
                    <label for="tipo_pele">*Tipo de Pele:</label>
                        <select name="tipo_pele" id="tipo_pele">
                            <option value="Oleosa">Oleosa</option>
                            <option value="Mista">Mista</option>
                            <option value="Seca">Seca</option>
                        </select>
                  </div>
                <div class="input-box">
                    <label for="observacoes">*Observações:</label>
                    <textarea type="text" class="form-control" id="observacoes_cliente" name="observacoes_cliente" placeholder="Digite observações importantes sobre você:" required></textarea>
                </div>
            </div>
            
            <button type="submit" class="btn btn-primary">Cadastrar</button>
        </form>

    </section>
     
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
