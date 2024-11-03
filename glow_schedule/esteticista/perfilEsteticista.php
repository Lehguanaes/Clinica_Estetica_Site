<?php
    require_once $_SERVER['DOCUMENT_ROOT'] . "/glow_schedule/controller/usuarioController.php";
    require_once $_SERVER['DOCUMENT_ROOT'] . "/glow_schedule/controller/conexao.php";

    $conexaoMini = new Conexao();
    $conexao = $conexaoMini->getConexao();

    $cpf = $_SESSION['usuario_cpf'];
    //smt com placeholder ?, pq o método ':cpf', $cpf não funcionou
    $stmt = $conexao->prepare("SELECT * FROM esteticista WHERE cpf_esteticista = ?");
    // um if para a verificação se o statement resulta em algo
    if ($stmt === false) {
        // Exibe o erro da preparação da consulta
        die('Erro no sql: ' . $conexao->error);
    }
    //smt com placeholder ?, pq o método ':cpf', $cpf não funcionou
    $stmt->bind_param("s", $cpf);
    $stmt->execute();
    
    // atribui o resultado da consulta  do stmt ao vetor $resultado
    $resultado = $stmt->get_result();
    // atribui o $cliente a uma linha do $resultado
    $esteticista = $resultado->fetch_assoc();
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Perfil do Esteticista</title>
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
            <div class="logo">
                <a class="nav-link active" aria-current="page" href="home.php">Care Tones</a>
            </div>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav w-auto">
                    <li class="nav-item pe-4 ps-4">
                        <a class="nav-link active" aria-current="page" href="agenda.php">Agenda</a>
                    </li>
                    <li class="nav-item pe-4 ps-4">
                        <a class="nav-link active" aria-current="page" href="cadastroEsteticista.php">Cadastro Esteticista</a>
                    </li>
                    <li class="nav-item pe-4 ps-4">
                        <a class="nav-link active" aria-current="page" href="FormularioDuvidas.php">Formulário de dúvidas</a>
                    </li>
                </ul>
                <button type="button" class="btn btn-sm btn-link me-4 ms-4" id="link_agendamentos_ativado"> <a href="cadastrarConsulta.php" id="link_agendamentos_ativado">Agendamentos</a></button>
            </div>
        </div>
    </nav>
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
</body>
</html>
