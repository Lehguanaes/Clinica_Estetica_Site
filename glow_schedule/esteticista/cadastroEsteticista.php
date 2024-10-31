<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro de Esteticista - Care Tones</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css" integrity="sha512-MV7K8+y+gLIBoVD59lQIYicR65iaqukzvf/nwasF0nqhPay5w/9lJmVM2hMDcnK1OnMGCdVK+iQrJ7lzPJQd1w==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.16/jquery.mask.min.js"></script>
    <integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link rel="stylesheet" href="../css/style.css">
    <script src="../js/mascaraInput.js" defer></script>
</head>
<body>
    <!-- Navbar -->
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

    <!-- Cadastro de Esteticista -->
    <section class="container">
        <form method="POST" action="/glow_schedule/esteticista/esteticistas.php" enctype="multipart/form-data" class="form">
            <input type="hidden" name="acao" value="inserir">
            <h2 class="h2_novo">Cadastro de Esteticista</h2>

            <div class="column">
                <div class="input-box">
                    <label for="foto_esteticista">Foto:</label>
                    <input type="file" name="foto_esteticista" id="foto_esteticista" accept="image/*" required>
                </div>

                <div class="input-box">
                    <label for="cpf_esteticista">CPF:</label>
                    <input type="text" class="form-control" id="cpf_esteticista" name="cpf_esteticista" required maxlength="14" placeholder="Digite o CPF:">
                </div>
            </div>

            <div class="column">
                <div class="input-box">
                    <label for="nome_esteticista">Nome completo:</label>
                    <input type="text" class="form-control" id="nome_esteticista" name="nome_esteticista" placeholder="Digite o Nome Completo:" required>
                </div>

                <div class="input-box">
                    <label for="apelido_esteticista">Nome Profissional (apelido):</label>
                    <input type="text" class="form-control" id="apelido_esteticista" name="apelido_esteticista" placeholder="Digite o seu Nome Profissional:"required>
                </div>
            </div>

            <div class="column">
                <div class="input-box">
                    <label for="email_esteticista">Email:</label>
                    <input type="email" class="form-control" id="email_esteticista" name="email_esteticista" placeholder="Digite o E-mail:" required>
                </div>

                <div class="input-box">
                    <label for="senha_esteticista">Senha:</label>
                    <input type="text" class="form-control" id="senha_esteticista" name="senha_esteticista" placeholder="Digite a Senha:" required>
                </div>

                <div class="input-box">
                    <label for="telefone_esteticista">Telefone:</label>
                    <input type="text" class="form-control" id="telefone_esteticista" name="telefone_esteticista" placeholder="Digite o Telefone:" required maxlength="15">
                </div>
            </div>

            <div class="column">
                <div class="input-box">
                    <label for="formacao_esteticista">Formação Acadêmica:</label>
                    <input type="text" class="form-control" id="formacao_esteticista" name="formacao_esteticista" placeholder="Digite a Formação Acadêmica:" required>
                </div>

                <div class="input-box">
                    <label for="descricao_p_esteticista">Descrição Curta:</label>
                    <textarea class="form-control" id="descricao_p_esteticista" name="descricao_p_esteticista" placeholder="Digite a Pequena Descrição Profissional:" required></textarea>
                </div>
            </div>

            <div class="column">
                <div class="input-box">
                    <label for="descricao_g_esteticista">Descrição Detalhada:</label>
                    <textarea class="form-control" id="descricao_g_esteticista" name="descricao_g_esteticista" placeholder="Digite a Grande Descrição Profissional:"required></textarea>
                </div>
            </div>

            <div class="column">
                <div class="input-box">
                    <label for="instagram_esteticista">Instagram:</label>
                    <input type="text" class="form-control" id="instagram_esteticista" name="instagram_esteticista" placeholder="Digite o Instagram:" required>
                </div>

                <div class="input-box">
                    <label for="facebook_esteticista">Facebook:</label>
                    <input type="text" class="form-control" id="facebook_esteticista" name="facebook_esteticista" placeholder="Digite o Facebook:" required>
                </div>

                <div class="input-box">
                    <label for="linkedin_esteticista">Linkedin:</label>
                    <input type="text" class="form-control" id="linkedin_esteticista" name="linkedin_esteticista" placeholder="Digite o Linkedin:" required>
                </div>
            </div>
            <button id="botao_cadastrar" type="submit" class="btn btn-primary"><i id="icone_botao_cadastrar" class="fa-solid fa-right-to-bracket"></i>Cadastrar Esteticista</button>
        </form>
    </section>
</body>
</html>