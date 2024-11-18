<?php
        require_once $_SERVER['DOCUMENT_ROOT'] . "/glow_schedule/controller/conexao.php";
        require_once $_SERVER['DOCUMENT_ROOT'] . "/glow_schedule/model/atendente/atendente.php";
        require_once $_SERVER['DOCUMENT_ROOT'] . "/glow_schedule/model/message.php";
        require_once $_SERVER['DOCUMENT_ROOT'] . "/glow_schedule/controller/global.php";

        if(session_status() === PHP_SESSION_NONE){
            session_start();
        }

        $conexaoMini = new Conexao();
        $conexao = $conexaoMini->getConexao();


           $message = new Message($BASE_URL);
           $flashMsg = $message->getMessage();

        if (!empty($flashMsg["msg"])) {
             $message->limparMessage();
        }
            

            $token = $_SESSION['usuario_token'];
            $stmt = $conexao->prepare("SELECT * FROM atendente WHERE token_atendente = ?");

             $stmt->bind_param("s", $token);
             $stmt->execute();
             $resultado = $stmt->get_result();
             $atendente = $resultado->fetch_assoc();
                   
                if(!isset($_SESSION['usuario_token'])) {
                    $message->setMessage("Cpf não encontrado", "Nenhum atendente encontrado com o CPF informado", "warning", "../login.php");
                }
      
                if (!$atendente) {
                    $message->setMessage("atendente não encontrado", "Não encontramos um atendente com este token", "warning", "../login.php");
                    exit;
                }
        
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro de Clientes</title>
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
            <a class="navbar-brand"><img class="rounded-circle ms-4" src="../logo/Logo.png" alt="Logo Care Tones" width="69px"></a>
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
                <button type="button" class="btn btn-sm btn-link me-4 ms-4"><a href="cadastrarConsulta.php">Agendamentos</a></button>
            </div>
        </div>
    </nav>
    <!-- Fim da Navbar -->
    <h2>Cadastro de Cliente</h2>
    <!-- Início formulário de cadastro -->
    <section class="container">
        <form method="POST" action="/glow_schedule/controller/cliente/clienteController.php" enctype="multipart/form-data" class="form" id="form_perfil">
            <input type="hidden" name="acao" value="inserir">
            <div class="column">
                <!-- Campo de Foto de Perfil -->
                <div class="profile-pic-container">
                    <img src="../iconesPerfil/perfilPadrao.png" alt="Foto de perfil padrão" class="profile-pic" id="profile-pic-preview">
                    <label class="upload-button" for="foto_cliente">
                        <i class="fa fa-plus"></i>
                    </label>
                    <input type="file" name="foto_cliente" id="foto_cliente" accept="image/*" onchange="previewProfilePic()">
                    <label id="label_foto_perfil" for="foto_cliente">Adicione a foto aqui:</label>
                </div>
            </div>
            <div class="column">
                <div class="input-box">
                    <label for="nome_cliente">*Nome:</label>
                    <input type="text" class="form-control" id="nome_cliente" name="nome_cliente" placeholder="Digite o Nome Completo:" required>
                </div>
            </div>
            <div class="column">
                <div class="input-box">
                    <label for="cpf_cliente">*CPF:</label>
                    <input type="text" class="form-control" id="cpf_cliente" name="cpf_cliente" placeholder="Digite o CPF:" required maxlength="14">
                </div>
                <div class="input-box">
                    <label for="telefone_cliente">*Telefone:</label>
                    <input type="text" class="form-control" id="telefone_cliente" name="telefone_cliente" placeholder="Digite o Telefone:" required maxlength="15">
                </div>
            </div>
            <div class="column">
                <div class="input-box">
                    <label for="email_cliente">*E-mail:</label>
                    <input type="email" class="form-control" id="email_cliente" name="email_cliente" placeholder="Digite o E-mail:" required>
                </div>
                <div class="input-box">
                    <label for="senha_cliente">*Senha:</label>
                    <div class="password-container">
                        <input type="password" class="form-control" id="senha_cliente" name="senha_cliente" placeholder="Digite a Senha:" required>
                        <span class="eye-icon" onclick="togglePasswordVisibility()">
                            <i id="eye-icon" class="fa fa-eye"></i>
                        </span>
                    </div>
                </div>
            </div>
            <button type="submit" class="btn btn-primary">Cadastrar</button>
        </form>
    </section>
    <!-- Fim formulário de cadastro -->
    <script>
        function previewProfilePic() {
            const input = document.getElementById("foto_cliente");
            const preview = document.getElementById("profile-pic-preview");

            const file = input.files[0];
            const reader = new FileReader();

            reader.onloadend = function() {
                preview.src = reader.result;
            };

            if (file) {
                reader.readAsDataURL(file);
            }
        }

        $(document).ready(function() {
            $('#telefone_cliente').mask('(00) 00000-0000');
            $('#cpf_cliente').mask('000.000.000-00');
        });

        function togglePasswordVisibility() {
            const passwordInput = document.getElementById("senha_cliente");
            const eyeIcon = document.getElementById("eye-icon");

            if (passwordInput.type === "password") {
                passwordInput.type = "text";
                eyeIcon.classList.remove("fa-eye");
                eyeIcon.classList.add("fa-eye-slash");
            } else {
                passwordInput.type = "password";
                eyeIcon.classList.remove("fa-eye-slash");
                eyeIcon.classList.add("fa-eye");
            }
        }
    </script>
</body>
</html>
