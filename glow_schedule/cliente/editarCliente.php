<?php
        require_once $_SERVER['DOCUMENT_ROOT'] . "/glow_schedule/controller/conexao.php";
        require_once $_SERVER['DOCUMENT_ROOT'] . "/glow_schedule/model/cliente/cliente.php";
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
            $stmt = $conexao->prepare("SELECT * FROM cliente WHERE token_cliente = ?");

             $stmt->bind_param("s", $token);
             $stmt->execute();
             $resultado = $stmt->get_result();
             $cliente = $resultado->fetch_assoc();
                   
                if(!isset($_SESSION['usuario_token'])) {
                    $message->setMessage("Cpf não encontrado", "Nenhum cliente encontrado com o CPF informado", "warning", "../login.php");
                }
      
                if (!$cliente) {
                    $message->setMessage("Cliente não encontrado", "Não encontramos um cliente com este token", "warning", "../login.php");
                    exit;
                }
        
        ?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Início da Navbar -->
    <title>Care Tones</title>
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
                <li><a href="visualizarDuvidas.php" class="nav">Dúvidas</a></li>
                <li><a href="visualizarAvaliacoes.php" class="nav">Avaliações</a></li>
                <li><a href="../procedimento/consultarProcedimento.php" class="nav">Procedimentos</a></li>
                <li><a href="visualizarConsultas.php" class="nav">Agenda</a></li>
                <li><a href="../agendamentoAtendente/agendamento.php" class="nav">Agendamento</a></li>
            </ul>
            <div class="dropdown">
                <div class="login-icon">
                    <a href="perfilAtendente.php">
                        <i class="fa-solid fa-circle-user fa-xl" style="color: #fff;"></i>
                    </a>
                    <div class="dropdown-content">
                        <a href="perfilAtendente.php"><i class="fa-solid fa-user fa-sm" style="color: #cf6f7a;"></i> Perfil </a>
                        <a href="../atendente/consultarCliente.php"><i class="fa-solid fa-users-line" style="color: #cf6f7a;"></i> Clientes </a>
                        <a href="../atendente/consultarAtendente.php"><i class="fa-solid fa-user-tie" style="color: #cf6f7a;"></i> Atendentes</a>
                        <a href="../atendente/consultarEsteticista.php"><i class="fa-solid fa-user-doctor" style="color: #cf6f7a;"></i> Profissionais </a>
                        <a href="../procedimento/consultarProcedimento.php"><i class="fa-brands fa-shopify" style="color: #cf6f7a;"></i> Procedimentos </a>
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
    <h2>Editar Perfil</h2>
    <!-- Exibição do perfil para edição -->
    <section class="container">
        <!-- Início formulário de edição -->
        <form method="POST" action="../controller/cliente/clienteController.php" enctype="multipart/form-data" class="form" id="form_perfil">
            <!-- Definindo a ação como "atualizar" -->
            <input type="hidden" name="acao" value="atualizar">
            <!-- CPF do cliente como campo oculto -->
            <input type="hidden" name="token_cliente" value="<?php echo htmlspecialchars($cliente['token_cliente']); ?>">
            <!-- Campo oculto para armazenar o caminho da foto atual -->
            <input type="hidden" name="foto_atual" value="<?php echo htmlspecialchars($cliente['foto_cliente']); ?>">
            <div class="column">
                <div class="input-box">
                    <div class="profile-pic-container">
                        <?php
                        // Verifica se a foto do cliente existe e não está vazia
                        $fotoPath = "/glow_schedule/" . htmlspecialchars($cliente['foto_cliente']);
                        $fotoExibida = (file_exists($_SERVER['DOCUMENT_ROOT'] . $fotoPath) && !empty($cliente['foto_cliente']))
                            ? $fotoPath
                            : "../iconesPerfil/perfilPadrao.png"; // Caminho da imagem padrão
                        ?>
                        <img src="<?php echo $fotoExibida; ?>" alt="Foto de perfil do cliente" class="profile-pic" id="profile-pic-preview">
                        <label class="upload-button" for="foto_cliente">
                            <i class="fa fa-plus"></i>
                        </label>
                        <input type="file" name="foto_cliente" id="foto_cliente" accept="image/*" onchange="previewProfilePic()">
                        <label id="label_foto_perfil" for="foto_cliente">Adicione a foto aqui:</label>
                    </div>
                </div>
            </div>
            <div class="column">
                <div class="input-box">
                    <label for="nome_cliente">*Nome:</label>
                    <input type="text" class="form-control" id="nome_cliente" name="nome_cliente"  placeholder="Digite o Nome Completo:" value="<?php echo htmlspecialchars($cliente['nome_cliente']); ?>" required>
                </div>
                <div class="input-box">
                    <label for="telefone_cliente">*Telefone:</label>
                    <input type="text" class="form-control" id="telefone_cliente" name="telefone_cliente"  placeholder="Digite o Telefone:" value="<?php echo htmlspecialchars($cliente['telefone_cliente']); ?>" required maxlength="15">
                </div>
            </div>
            <div class="column">
                <div class="input-box">
                    <label for="email_cliente">*E-mail:</label>
                    <input type="email" class="form-control" id="email_cliente" name="email_cliente" placeholder="Digite o E-mail:" value="<?php echo htmlspecialchars($cliente['email_cliente']); ?>" required>
                </div>
                <button type="submit" class="btn btn-primary">Salvar</button>

                <div class="input-box">
                    <label for="senha_cliente">*Senha Atual:</label>
                    <div class="password-container">
                        <input type="password" class="form-control" id="senha_cliente" name="senha_cliente" placeholder="Digite a Senha:"  >
                        <span class="eye-icon" onclick="togglePasswordVisibility()">
                            <i id="eye-icon" class="fa fa-eye"></i>
                        </span>
                    </div>
                </div>
                <div class="input-box">
                    <label for="senha_cliente">*Senha nova:</label>
                    <div class="password-container">
                        <input type="password" class="form-control" id="nova_senha" name="nova_senha" placeholder="Digite a Senha:"  >
                        <span class="eye-icon" onclick="togglePasswordVisibility()">
                            <i id="eye-icon" class="fa fa-eye"></i>
                        </span>
                    </div>
                </div>
            </div>
        </form>
   
    </section>
    <!-- Script para visualização da imagem de perfil antes de salvar -->
    <script>
        function previewProfilePic() {
            const input = document.getElementById('foto_cliente');
            const preview = document.getElementById('profile-pic-preview');
            const label = document.getElementById('label_foto_perfil');

            if (input.files && input.files[0]) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    preview.src = e.target.result;
                    label.style.display = "none";
                }
                reader.readAsDataURL(input.files[0]);
            }
        }

        $(document).ready(function(){
            $('#telefone_cliente').mask('(00) 00000-0000');
        });

        // Função para alternar a visibilidade da senha
        function togglePasswordVisibility() {
            // Obtém o campo de entrada de senha e o ícone que mostra/esconde a senha
            const passwordInput = document.getElementById("senha_atual_cliente");
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
