<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Consultar Atendentes</title>
    <!-- Links externos -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.16/jquery.mask.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css" integrity="sha512-MV7K8+y+gLIBoVD59lQIYicR65iaqukzvf/nwasF0nqhPay5w/9lJmVM2hMDcnK1OnMGCdVK+iQrJ7lzPJQd1w==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <!-- Estilização padrão do web site -->
    <link rel="stylesheet" href="../css/style.css">
    <!-- Estilização formulários de Perfis -->
    <link rel="stylesheet" href="../css/perfil.css">
</head>
<body>
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
                        <a class="nav-link active" aria-current="page" href="../atendente/perfilAtendente.php">perfil</a>
                    </li>
                    <li class="nav-item pe-4 ps-4">
                        <a class="nav-link active" aria-current="page" href="../esteticista/consultarEsteticista.php">Cadastrar Esteticista</a>
                    </li>
                    <li class="nav-item pe-4 ps-4">
                        <a class="nav-link active" aria-current="page" href="../controller/logout.php">sair</a>
                    </li>
                </ul>
                <button type="button" class="btn btn-sm btn-link me-4 ms-4" id="link_agendamentos_ativado" > <a href="cadastrarConsulta.php" id="link_agendamentos_ativado">Agendamentos</a></button>
            </div>
        </div>
    </nav>
    <div class="container">
        <h2>Atendentes Cadastrados</h2>
        <?php
        require_once $_SERVER['DOCUMENT_ROOT'] . "/glow_schedule/controller/conexao.php";
        require_once $_SERVER['DOCUMENT_ROOT'] . "/glow_schedule/model/message.php";
        require_once $_SERVER['DOCUMENT_ROOT'] . "/glow_schedule/controller/global.php";
        require_once $_SERVER['DOCUMENT_ROOT'] . "/glow_schedule/controller/conexao.php";
        require_once $_SERVER['DOCUMENT_ROOT'] . "/glow_schedule/model/atendente/atendente.php";


          $conexaoMini = new Conexao();
          $conexao = $conexaoMini->getConexao();
          $message = new Message($BASE_URL);
          $flashMsg = $message->getMessage();

           if (!empty($flashMsg["msg"])) {
            $message->limparMessage();
           }
    
        $token = $_SESSION['usuario_token'];
        $stmt = $conexao->prepare("SELECT * FROM atendente WHERE token_atendente = ?");

           if ($stmt === false) {
            die('Erro no sql: ' . $conexao->error);
            }
    
            $stmt->bind_param("s", $token);
            $stmt->execute();
            $resultado = $stmt->get_result();
            $atendenteSessao = $resultado->fetch_assoc();

            $stmt2 = $conexao->prepare("SELECT * FROM atendente");

           if ($stmt === false) {
            die('Erro no sql: ' . $conexao->error);
            }
            $stmt2->execute();
            $resultado2 = $stmt2->get_result();
       

            if ($resultado2->num_rows > 0) {
                echo '<table class="table table-bordered">';
                echo '<thead>';
                echo '<tr>';
                echo '<th>Foto</th>';
                echo '<th>CPF</th>';
                echo '<th>Nome</th>';
                echo '<th>Email</th>';
                echo '<th>Telefone</th>';
                echo '<th>Ações</th>';
                echo '</tr>';
                echo '</thead>';
                echo '<tbody>';
                // Exibe os dados de cada atendente
                while ($row = $resultado2->fetch_assoc()) {
                    echo '<tr>';
                    // Verifica se a foto do atendente existe
                    $fotoPath = $_SERVER['DOCUMENT_ROOT'] . "/glow_schedule/" . $row['foto_atendente'];
                    $foto = file_exists($fotoPath) && !empty($row['foto_atendente']) 
                            ? "/glow_schedule/" . htmlspecialchars($row['foto_atendente']) 
                            : "../iconesPerfil/perfilPadrao.png"; // URL da imagem padrão
                    // Exibe a foto do atendente com formatação
                    echo '<td class="text-center align-middle"><img src="' . $foto . '" alt="Foto do Atendente" id="consultar_fotos"></td>';
                    echo '<td>' . htmlspecialchars($row['cpf_atendente']) . '</td>';
                    echo '<td>' . htmlspecialchars($row['nome_atendente']) . '</td>';
                    echo '<td>' . htmlspecialchars($row['email_atendente']) . '</td>';
                    echo '<td>' . htmlspecialchars($row['telefone_atendente']) . '</td>';
                    echo '<td>';
                    echo '<a href="editarAtendente.php?token_atendente=' . urlencode($row['token_atendente']) . '" class="btn btn-primary" id="editar_consultar_button">Editar</a>';
                    echo '</td>';
                    echo '</tr>';
                }
                echo '</tbody>';
                echo '</table>';
            } else {
                echo '<p>Nenhum atendente encontrado.</p>';
            }
            // Fecha a conexão com o banco de dados
            $conexao->close();
            ?>
        <a href="cadastroAtendente.php" class="btn btn-success" id="editar_perfil_button"><i class="fa fa-plus"></i> Adicionar Novo Atendente</a>
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
