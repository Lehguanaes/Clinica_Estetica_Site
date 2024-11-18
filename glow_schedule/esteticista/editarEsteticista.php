<?php
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
            $stmt = $conexao->prepare("SELECT * FROM esteticista WHERE token_esteticista = ?");

             $stmt->bind_param("s", $token);
             $stmt->execute();
             $resultado = $stmt->get_result();
             $esteticista = $resultado->fetch_assoc();
                   
                if(!isset($_SESSION['usuario_token'])) {
                    $message->setMessage("Cpf não encontrado", "Nenhum esteticista encontrado com o CPF informado", "warning", "../login.php");
                }
      
                if (!$esteticista) {
                    $message->setMessage("esteticista não encontrado", "Não encontramos um esteticista com este token", "warning", "../login.php");
                    exit;
                }
        
        ?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Perfil esteticista</title>
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
    <h2>Editar Perfil</h2>
    <!-- Exibição do perfil para edição -->
    <section class="container">
  
    <form method="POST" action="../controller/esteticista/esteticistaController.php" enctype="multipart/form-data" class="form" id="form_perfil">
    <input type="hidden" name="acao" value="atualizar">
    <input type="hidden" name="token_esteticista" value="<?php echo htmlspecialchars($esteticista['token_esteticista']); ?>">
            <!-- Campo oculto para armazenar o caminho da foto atual -->
            <input type="hidden" name="foto_atual" value="<?php echo htmlspecialchars($esteticista['foto_esteticista']); ?>">
            
            <!-- Foto do esteticista com pré-visualização -->
            <div class="column">
                <div class="input-box">
                    <div class="profile-pic-container">
                        <?php
                            // Verifica se a foto do esteticista existe e não está vazia
                            $fotoPath = "/glow_schedule/" . htmlspecialchars($esteticista['foto_esteticista']);
                            $fotoExibida = (file_exists($_SERVER['DOCUMENT_ROOT'] . $fotoPath) && !empty($esteticista['foto_esteticista']))
                                ? $fotoPath
                                : "../iconesPerfil/perfilPadrao.png"; // Caminho da imagem padrão
                        ?>
                        <img src="<?php echo $fotoExibida; ?>" alt="Foto de perfil do esteticista" class="profile-pic" id="profile-pic-preview">
                        <label class="upload-button" for="foto_esteticista">
                            <i class="fa fa-plus"></i>
                        </label>
                        <input type="file" name="foto_esteticista" id="foto_esteticista" accept="image/*" onchange="previewProfilePic()">
                        <label id="label_foto_perfil" for="foto_esteticista">*Adicione a foto aqui:</label>
                    </div>
                </div>
            </div>
            <!-- Campos de entrada para informações do esteticista -->
            <div class="column">
                <div class="input-box">
                    <label for="nome_esteticista">*Nome:</label>
                    <input type="text" class="form-control" id="nome_esteticista" name="nome_esteticista" placeholder="Digite o Nome Completo:"  value="<?php echo htmlspecialchars($esteticista['nome_esteticista']); ?>" required>
                </div>
            </div>
            <div class="column">
                <div class="input-box">
                    <label for="apelido_esteticista">*Apelido:</label>
                    <input type="text" class="form-control" id="apelido_esteticista" name="apelido_esteticista" placeholder="Digite o Nome Profissional:"  value="<?php echo htmlspecialchars($esteticista['apelido_esteticista']); ?>" required>
                </div>
                <div class="input-box">
                    <label for="telefone_esteticista">*Telefone:</label>
                    <input type="text" class="form-control" id="telefone_esteticista" name="telefone_esteticista" placeholder="Digite o Telefone:" value="<?php echo htmlspecialchars($esteticista['telefone_esteticista']); ?>" required>
                </div>
            </div>
            <div class="column">
                <div class="input-box">
                    <label for="email_esteticista">*E-mail:</label>
                    <input type="email" class="form-control" id="email_esteticista" name="email_esteticista" placeholder="Digite o E-mail:" value="<?php echo htmlspecialchars($esteticista['email_esteticista']); ?>" required>
                </div>
            <div class="column">
                <div class="input-box">
                    <label for="formacao_esteticista">*Formação Acadêmica:</label>
                    <input type="text" class="form-control" id="formacao_esteticista" name="formacao_esteticista"  placeholder="Digite a Formação:"  value="<?php echo htmlspecialchars($esteticista['formacao_esteticista']); ?>" required>
                </div>
            </div>
            <div class="column">
                <div class="input-box">
                    <label for="descricao_p_esteticista">*Descrição Curta:</label>
                    <textarea class="form-control" id="descricao_p_esteticista" name="descricao_p_esteticista" placeholder="Digite a Pequena Descrição Profissional:" required><?php echo htmlspecialchars($esteticista['descricao_p_esteticista']); ?></textarea>
                </div>
            </div>
            <div class="column">
                <div class="input-box">
                    <label for="descricao_g_esteticista">*Descrição Detalhada:</label>
                    <textarea class="form-control" id="descricao_g_esteticista" name="descricao_g_esteticista" placeholder="Digite a Grande Descrição Profissional:" required><?php echo htmlspecialchars($esteticista['descricao_g_esteticista']); ?></textarea>
                </div>
            </div>
            <div class="column">
                <div class="input-box">
                    <label for="instagram_esteticista">*Instagram:</label>
                    <input type="text" class="form-control" id="instagram_esteticista" name="instagram_esteticista" placeholder="Digite o Instagram:" value="<?php echo htmlspecialchars($esteticista['instagram_esteticista']); ?>" placeholder="Digite o Instagram:" required>
                </div>
                <div class="column">
                <div class="input-box">
                    <label for="facebook_esteticista">*Facebook:</label>
                    <input type="text" class="form-control" id="facebook_esteticista" name="facebook_esteticista" placeholder="Digite o Facebook:" value="<?php echo htmlspecialchars($esteticista['facebook_esteticista']); ?>" placeholder="Digite o Facebook:" required>
                </div>
                </div>
                <div class="column">
                <div class="input-box">
                    <label for="linkedin_esteticista">*LinkedIn:</label>
                    <input type="text" class="form-control" id="linkedin_esteticista" name="linkedin_esteticista" placeholder="Digite o LinkedIn:" value="<?php echo htmlspecialchars($esteticista['linkedin_esteticista']); ?>" placeholder="Digite o LinkedIn:" required>
                </div>
                </div>
                <div class="column">
                <div class="input-box">
                    <label for="senha_esteticista">*Senha atual:</label>
                    <div class="password-container">
                        <input type="password" class="form-control" id="senha_esteticista" name="senha_esteticista" placeholder="Digite a senha:">
                        <span class="eye-icon" onclick="togglePasswordVisibility()">
                            <i id="eye-icon" class="fa fa-eye"></i>
                        </span>
                    </div>
                </div>
                </div>
                <div class="input-box">
                    <label for="senha_esteticista">*Senha nova:</label>
                    <div class="password-container">
                        <input type="password" class="form-control" id="nova_senha" name="nova_senha" placeholder="Digite a nova senha:"  >
                        <span class="eye-icon" onclick="togglePasswordVisibility2()">
                            <i id="eye-icon" class="fa fa-eye"></i>
                        </span>
                    </div>
                </div>
            </div>
            </div>
            <button type="submit" class="btn btn-primary">Atualizar</button>
        </form>
    </section>
    <script>
        // Máscara dos inputs
        $(document).ready(function() {
            // Aplica a máscara de telefone ao campo com ID 'telefone_esteticista'
            $('#telefone_esteticista').mask('(00) 00000-0000');
        });
        // Função para pré-visualizar a imagem selecionada do perfil
        function previewProfilePic() {
            // Obtém o elemento de input de arquivo e o elemento de imagem para pré-visualização
            const input = document.getElementById("foto_esteticista");
            const preview = document.getElementById("profile-pic-preview");
            // Pega o arquivo selecionado
            const file = input.files[0];
            const reader = new FileReader(); // Cria um novo FileReader para ler o arquivo
            // Define a função que será chamada quando a leitura do arquivo estiver concluída
            reader.onloadend = function() {
                // Define a fonte da imagem de pré-visualização como o resultado da leitura do arquivo
                preview.src = reader.result;
            };
            // Se um arquivo foi selecionado, lê como URL de dados
            if (file) {
                reader.readAsDataURL(file);
            }
        }
        // Função para alternar a visibilidade da senha
        function togglePasswordVisibility() {
            // Obtém o campo de entrada de senha e o ícone que mostra/esconde a senha
            const passwordInput = document.getElementById("senha_esteticista");
            const eyeIcon = document.getElementById("eye-icon");
            // Verifica o tipo atual do campo de senha
            if (passwordInput.type === "password") {
                passwordInput.type = "text"; // Altera para texto para mostrar a senha
                eyeIcon.classList.remove("fa-eye"); // Remove o ícone de olho aberto
                eyeIcon.classList.add("fa-eye-slash"); // Adiciona o ícone de olho fechado
            } else {
                passwordInput.type = "password"; // Altera de volta para senha
                eyeIcon.classList.remove("fa-eye-slash"); // Remove o ícone de olho fechado
                eyeIcon.classList.add("fa-eye"); // Adiciona o ícone de olho aberto
            }
        }

        function togglePasswordVisibility2() {
            // Obtém o campo de entrada de senha e o ícone que mostra/esconde a senha
            const passwordInput = document.getElementById("senha_nova");
            const eyeIcon = document.getElementById("eye-icon");
            // Verifica o tipo atual do campo de senha
            if (passwordInput.type === "password") {
                passwordInput.type = "text"; // Altera para texto para mostrar a senha
                eyeIcon.classList.remove("fa-eye"); // Remove o ícone de olho aberto
                eyeIcon.classList.add("fa-eye-slash"); // Adiciona o ícone de olho fechado
            } else {
                passwordInput.type = "password"; // Altera de volta para senha
                eyeIcon.classList.remove("fa-eye-slash"); // Remove o ícone de olho fechado
                eyeIcon.classList.add("fa-eye"); // Adiciona o ícone de olho aberto
            }
        }
    </script>
</body>
</html>
