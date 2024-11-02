<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro de Atendentes</title>
    <!-- Links externos -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.16/jquery.mask.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css" integrity="sha512-MV7K8+y+gLIBoVD59lQIYicR65iaqukzvf/nwasF0nqhPay5w/9lJmVM2hMDcnK1OnMGCdVK+iQrJ7lzPJQd1w==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <!-- Estilização padrão do web site -->
    <link rel="stylesheet" href="../css/style.css">
    <!-- Estilização formulário de Perfil -->
    <link rel="stylesheet" href="../css/perfil.css">
    <!-- script formulário de Perfil -->
    <script src="js/perfil.js" defer></script>
    <!-- script máscara de formulários -->
    <script src="js/mascaraInput.js" defer></script>
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
    <h2>Cadastro do Atendente</h2>
    <!-- Início formulário de cadastro -->
    <section class="container">
        <form method="POST" action="/glow_schedule/controller/atendente/atendenteController.php" enctype="multipart/form-data" class="form" id="form_perfil">
        <input type="hidden" name="acao" value="inserir"> 
            <div class="column">
                <div class="input-box">
                    <!-- Campo de Foto de Perfil -->
                    <div class="profile-pic-container">
                        <!-- Imagem de perfil padrão -->
                        <img src="../iconesPerfil/perfilPadrao.png" alt="Foto de perfil padrão" class="profile-pic" id="profile-pic-preview">
                        <!-- Botão de adicionar -->
                        <label class="upload-button" for="foto_atendente">
                            <i class="fa fa-plus"></i>
                        </label>
                        <!-- Input de arquivo escondido -->
                        <input type="file" name="foto_atendente" id="foto_atendente" accept="image/*" onchange="previewProfilePic()">
                        <label id="label_foto_perfil" for="foto_atendente">Adicione a foto aqui:</label>
                    </div>    
                </div>
            </div>
            <div class="column">
                <div class="input-box">
                    <label for="nome_atendente">Nome:</label>
                    <input type="text" class="form-control" id="nome_atendente" name="nome_atendente" required>
                </div>
            </div>
            <div class="column">
                <div class="input-box">
                    <label for="cpf_atendente">CPF:</label>
                    <input type="text" class="form-control" id="cpf_atendente" name="cpf_atendente" required maxlength="14">
                </div>
                <div class="input-box">
                    <label for="telefone_atendente">Telefone:</label>
                    <input type="text" class="form-control" id="telefone_atendente" name="telefone_atendente" required maxlength="15">
                </div>
            </div>
            <div class="column">
                <div class="input-box">
                    <label for="email_atendente">Email:</label>
                    <input type="email" class="form-control" id="email_atendente" name="email_atendente" required>
                </div>
                <div class="input-box">
                    <label for="senha_atendente">Senha:</label>
                    <input type="text" class="form-control" id="senha_atendente" name="senha_atendente" required>
                </div>
            </div>
            <button type="submit" class="btn btn-primary">Cadastrar</button>
        </form>
    </section>
    <!-- Fim formulário de cadastro -->
</body>
</html>
