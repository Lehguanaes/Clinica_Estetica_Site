<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Perfil Cliente</title>
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
        <?php
        require_once $_SERVER['DOCUMENT_ROOT'] . "/glow_schedule/model/cliente/cliente.php";
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
        $resultado = $stmt->get_result(); // atribui o resultado da consulta  do stmt ao vetor $resultado
        $cliente = $resultado->fetch_assoc(); // atribui o $cliente a uma linha do $resultado
        $id_prontuario = $_SESSION['usuario_prontuario'];

        $stmt1 = $conexao->prepare("SELECT * FROM prontuario WHERE id_prontuario = ?");
        $stmt1->bind_param('i', $id_prontuario);

        $stmt1->execute();
    
        $resultado2 = $stmt1->get_result();
        $prontuario = $resultado2->fetch_assoc();

        
        $cliente = new Cliente();

        if (isset($_GET['cpf_cliente'])) {
            $cpf_cliente = $_GET['cpf_cliente'];

            $sql = "SELECT * FROM cliente WHERE cpf_cliente = ?";
            $conn = (new Conexao())->getConexao();

            if ($stmt = $conn->prepare($sql)) {
                $stmt->bind_param("s", $cpf_cliente);
                $stmt->execute();
                $result = $stmt->get_result();

                if ($result->num_rows > 0) {
                    $clienteData = $result->fetch_assoc();
                    $cliente->setCpf($clienteData['cpf_cliente']);
                    $cliente->setNome($clienteData['nome_cliente']);
                    $cliente->setEmail($clienteData['email_cliente']);
                    $cliente->setTelefone($clienteData['telefone_cliente']);
                    $cliente->setSenha($clienteData['senha_cliente']);
                    $cliente->setFoto($clienteData['foto_cliente']);
                } else {
                    echo "<p>Nenhum cliente encontrado com o CPF informado.</p>";
                }
                $stmt->close();
            } else {
                echo "Erro na consulta: " . $conn->error;
            }
        } else {
            echo "<p>CPF do cliente não foi informado.</p>";
        }

        if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['cpf_cliente'])) {
            $cliente->setCpf($_POST['cpf_cliente']);
            $cliente->setNome($_POST['nome_cliente']);
            $cliente->setEmail($_POST['email_cliente']);
            $cliente->setTelefone($_POST['telefone_cliente']);
            $cliente->setSenha($_POST['senha_cliente']);

            // Verifica se uma nova foto foi enviada
            if (isset($_FILES['foto_cliente']) && $_FILES['foto_cliente']['error'] == UPLOAD_ERR_OK) {
                $target_dir = $_SERVER['DOCUMENT_ROOT'] . "/glow_schedule/uploads/";
                $target_file = $target_dir . basename($_FILES["foto_cliente"]["name"]);

                if (move_uploaded_file($_FILES["foto_cliente"]["tmp_name"], $target_file)) {
                    $cliente->setFoto("uploads/" . basename($_FILES["foto_cliente"]["name"]));
                } else {
                    echo "<p>Erro ao fazer upload da foto.</p>";
                }
            } else {
                // Mantém a foto existente se nenhuma nova for enviada
                $cliente->setFoto($_POST['foto_atual']);
            }

            if ($cliente->atualizar()) {
                echo "<p>Cliente atualizado com sucesso.</p>";
                header("Location: consultarCliente.php");
                exit();
            } else {
                echo "<p>Erro ao atualizar cliente.</p>";
            }
        }

        if (isset($clienteData)) {
        ?>
        <!-- Início formulário de edição -->
        <form method="POST" action="" enctype="multipart/form-data" class="form" id="form_perfil">
            <!-- Definindo a ação como "atualizar" -->
            <input type="hidden" name="acao" value="atualizar">
            <!-- CPF do cliente como campo oculto -->
            <input type="hidden" name="cpf_cliente" value="<?php echo htmlspecialchars($clienteData['cpf_cliente']); ?>">
            <!-- Campo oculto para armazenar o caminho da foto atual -->
            <input type="hidden" name="foto_atual" value="<?php echo htmlspecialchars($clienteData['foto_cliente']); ?>">
            <div class="column">
                <div class="input-box">
                    <div class="profile-pic-container">
                        <?php
                        // Verifica se a foto do cliente existe e não está vazia
                        $fotoPath = "/glow_schedule/" . htmlspecialchars($clienteData['foto_cliente']);
                        $fotoExibida = (file_exists($_SERVER['DOCUMENT_ROOT'] . $fotoPath) && !empty($clienteData['foto_cliente']))
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
                    <input type="text" class="form-control" id="nome_cliente" name="nome_cliente"  placeholder="Digite o Nome Completo:" value="<?php echo htmlspecialchars($clienteData['nome_cliente']); ?>" required>
                </div>
                <div class="input-box">
                    <label for="telefone_cliente">*Telefone:</label>
                    <input type="text" class="form-control" id="telefone_cliente" name="telefone_cliente"  placeholder="Digite o Telefone:" value="<?php echo htmlspecialchars($clienteData['telefone_cliente']); ?>" required maxlength="15">
                </div>
            </div>
            <div class="column">
                <div class="input-box">
                    <label for="email_cliente">*E-mail:</label>
                    <input type="email" class="form-control" id="email_cliente" name="email_cliente" placeholder="Digite o E-mail:" value="<?php echo htmlspecialchars($clienteData['email_cliente']); ?>" required>
                </div>
                <div class="input-box">
                    <label for="senha_cliente">*Senha:</label>
                    <div class="password-container">
                        <input type="password" class="form-control" id="senha_cliente" name="senha_cliente" placeholder="Digite a Senha:" value="<?php echo htmlspecialchars($clienteData['senha_cliente']); ?>" required>
                        <span class="eye-icon" onclick="togglePasswordVisibility()">
                            <i id="eye-icon" class="fa fa-eye"></i>
                        </span>
                    </div>
                    
                    <form method="POST" action="/glow_schedule/controller/prontuario/prontuarioController.php" class="form" id="form_perfil">
            <input type="hidden" name="acao" value="atualizar">
            <div class="column">
            
            <div class="column">
                <div class="input-box">
                <label for="cor_pele">*Cor da pele:</label>
                    <select name="tipo_pele" id="tipo_pele" disabled>
                            <option ><?php echo ($prontuario['cor_pele']); ?></option>
                        </select>             
              </div>
            </div>
            <div class="column">
                <div class="input-box">
                    <label for="tipo_pele">*Tipo de Pele:</label>
                        <select name="tipo_pele" id="tipo_pele">
                        <option ><?php echo ($prontuario['tipo_pele']); ?></option>
                        </select>
                  </div>
                <div class="input-box">
                    <label for="observacoes">*Observações:</label>
                    <textarea type="text" class="form-control" id="observacoes_cliente" name="observacoes_cliente" placeholder="Digite observações importantes sobre você:" required><?php echo ($prontuario['observacoes_cliente']); ?></textarea>
                </div>
                
            </div>
            
            <button type="submit" class="btn btn-primary">editar</button>
        </form>

    </section>
                </div>
            </div>
            <button type="submit" class="btn btn-primary">Salvar</button>
        </form>
        <?php } ?>
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
            const passwordInput = document.getElementById("senha_cliente");
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
