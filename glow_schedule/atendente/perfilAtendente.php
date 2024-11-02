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
    <!-- Estilização perfil de Atendente -->
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
                        <a class="nav-link active" aria-current="page" href="agenda.php">Agenda</a>
                    </li>
                    <li class="nav-item pe-4 ps-4">
                        <a class="nav-link active" aria-current="page" href="cadastroEsteticista.php">Cadastro Esteticista</a>
                    </li>
                    <li class="nav-item pe-4 ps-4">
                        <a class="nav-link active" aria-current="page" href="FormularioDuvidas.php">Formulário de dúvidas</a>
                    </li>
                </ul>
                <button type="button" class="btn btn-sm btn-link me-4 ms-4" id="link_agendamentos_ativado" > <a href="cadastrarConsulta.php" id="link_agendamentos_ativado">Agendamentos</a></button>
            </div>
        </div>
    </nav>
    <!-- Fim da Navbar -->
    <?php
    require_once $_SERVER['DOCUMENT_ROOT'] . "/glow_schedule/controller/conexao.php";
    require_once $_SERVER['DOCUMENT_ROOT'] . "/glow_schedule/model/atendente/atendente.php";

    if (isset($_GET['cpf_atendente'])) {
        $cpf_atendente = $_GET['cpf_atendente'];

        $sql = "SELECT * FROM atendente WHERE cpf_atendente = ?";
        $conn = (new Conexao())->getConexao();

        if ($stmt = $conn->prepare($sql)) {
            $stmt->bind_param("s", $cpf_atendente);
            $stmt->execute();
            $result = $stmt->get_result();

            if ($result->num_rows > 0) {
                $atendenteData = $result->fetch_assoc();
            } else {
                echo "<p>Nenhum atendente encontrado com o CPF informado.</p>";
            }
            $stmt->close();
        } else {
            echo "Erro na consulta: " . $conn->error;
        }
    } else {
        echo "<p>CPF do atendente não foi informado.</p>";
    }

    if (isset($atendenteData)) {
    ?>
    <!-- Exibição do perfil -->
    <h2>Minhas Informações</h2>
    <div class="container mt-4" id="perfil_conteiner">
        <div class="card mb-4" id="perfil_card" style="max-width: 1000px; margin: auto; border: none;">
            <div class="row g-0">
                <div class="profile-pic-container_visualizar">
                    <!-- Imagem de perfil do atendente -->
                    <img src="<?php echo file_exists($_SERVER['DOCUMENT_ROOT'] . "/glow_schedule/" . $atendenteData['foto_atendente']) ? "/glow_schedule/" . htmlspecialchars($atendenteData['foto_atendente']) : "/glow_schedule/uploads/default.jpg"; ?>" alt="Foto do Atendente" class="profile-pic" id="profile-pic-preview">
                    <p id="nome_perfil"><strong> </strong> <?php echo htmlspecialchars($atendenteData['nome_atendente']); ?></p>
                </div>
                <!-- Coluna de informações -->
                <div class="col-md-8" style="margin-top: 30px;">
                    <p><strong>Nome Completo:</strong> <?php echo htmlspecialchars($atendenteData['nome_atendente']); ?></p>
                    <p><strong>CPF:</strong> <?php echo htmlspecialchars($atendenteData['cpf_atendente']); ?></p>
                    <p><strong>Telefone:</strong> <?php echo htmlspecialchars($atendenteData['telefone_atendente']); ?></p>
                    <p><strong>Email:</strong> <?php echo htmlspecialchars($atendenteData['email_atendente']); ?></p>
                </div>
            </div>
        </div>
        <!-- Botão para editar o perfil -->
        <div class="text-center mt-4">
            <a href="http://localhost/glow_schedule/atendente/editarAtendente.php?cpf_atendente=<?php echo htmlspecialchars($atendenteData['cpf_atendente']); ?>" class="btn btn-primary" id="editar_perfil_button">Editar Perfil</a>
        </div>
    </div>
    <?php
    }
    $conn->close();
    ?>
</body>
</html>
