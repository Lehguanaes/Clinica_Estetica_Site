<?php
require_once $_SERVER['DOCUMENT_ROOT'] . "/glow_schedule/controller/conexao.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/glow_schedule/model/message.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/glow_schedule/controller/global.php";

// Verifique se o atendente está logado
if (!isset($_SESSION['usuario_token'])) {
    header("Location: login.php"); // Redirecionar para a página de login
    exit();
}

// Conexão com o banco de dados
$conexaoMini = new Conexao();
$conexao = $conexaoMini->getConexao();
$message = new Message($BASE_URL);
$flashMsg = $message->getMessage();

if (!empty($flashMsg["msg"])) {
    $message->limparMessage();
}

// Verifique se o token do esteticista foi passado na URL
if (isset($_GET['token_esteticista'])) {
    $token_esteticista = $_GET['token_esteticista'];

    // Busque os dados do esteticista
    $sql = "SELECT * FROM esteticista WHERE token_esteticista = ?";
    $stmt = $conexao->prepare($sql);
    $stmt->bind_param("s", $token_esteticista);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $esteticistaData = $result->fetch_assoc();
    } else {
        echo "<p>Nenhum esteticista encontrado com o token informado.</p>";
        exit();
    }
} else {
    echo "<p>Token do esteticista não foi informado.</p>";
    exit();
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Perfil Esteticista</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.16/jquery.mask.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css" integrity="sha512-MV7K8+y+gLIBoVD59lQIYicR65iaqukzvf/nwasF0nqhPay5w/9lJmVM2hMDcnK1OnMGCdVK+iQrJ7lzPJQd1w==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="../css/style.css">
    <link rel="stylesheet" href="../css/perfil.css">
</head>
<body>
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
                        <a class="nav-link active" aria-current="page" href="../atendente/perfilAtendente.php">perfil</a>
                    </li>
                    <li class="nav-item pe-4 ps-4">
                        <a class="nav-link active" aria-current="page" href="../cliente/consultarCliente.php">Cadastrar Cliente</a>
                    </li>
                    <li class="nav-item pe-4 ps-4">
                        <a class="nav-link active" aria-current="page" href="FormularioDuvidas.php">Formulário de dúvidas</a>
                    </li>
                </ul>
                <button type="button" class="btn btn-sm btn-link me-4 ms-4" id="link_agendamentos_ativado"> <a href="cadastrarConsulta.php" id="link_agendamentos_ativado">Agendamentos</a></button>
            </div>
        </div>
    </nav>
    <h2>Editar Perfil</h2>
    <section class="container">
        <form method="POST" action="../controller\esteticista\esteticistaController.php" enctype="multipart/form-data" class="form" id="form_perfil">
            <input type="hidden" name="acao" value="atualizar">
            <input type="hidden" name="token_esteticista" value="<?php echo htmlspecialchars($esteticistaData['token_esteticista']); ?>">
            <input type="hidden" name="foto_atual" value="<?php echo htmlspecialchars($esteticistaData['foto_esteticista']); ?>">

            <div class="column">
                <div class="input-box">
                    <div class="profile-pic-container">
                        <?php
                        $fotoPath = "/glow_schedule/" . htmlspecialchars($esteticistaData['foto_esteticista']);
                        $fotoExibida = (file_exists($_SERVER['DOCUMENT_ROOT'] . $fotoPath) && !empty($esteticistaData['foto_esteticista']))
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

            <div class="column">
                <div class="input-box">
                    <label for="nome_esteticista">*Nome:</label>
                    <input type="text" class="form-control" id="nome_esteticista" name="nome_esteticista" placeholder="Digite o Nome Completo:" value="<?php echo htmlspecialchars($esteticistaData['nome_esteticista']); ?>" required>
                </div>
            </div>

            <div class="column">
                <div class="input-box">
                    <label for="apelido_esteticista">*Apelido:</label>
                    <input type="text" class="form-control" id="apelido_esteticista" name="apelido_esteticista" placeholder="Digite o Nome Profissional:" value="<?php echo htmlspecialchars($esteticistaData['apelido_esteticista']); ?>" required>
                </div>
                <div class="input-box">
                    <label for="telefone_esteticista">*Telefone:</label>
                    <input type="text" class="form-control" id="telefone_esteticista" name="telefone_esteticista" placeholder="Digite o Telefone:" value="<?php echo htmlspecialchars($esteticistaData['telefone_esteticista']); ?>" required>
                </div>
            </div>

            <div class="column">
                <div class="input-box">
                    <label for="email_esteticista">*E-mail:</label>
                    <input type="email" class="form-control" id="email_esteticista" name="email_esteticista" placeholder="Digite o E-mail:" value="<?php echo htmlspecialchars($esteticistaData['email_esteticista']); ?>" required>
                </div>
            </div>

            <div class="column">
                <div class="input-box">
                    <label for="formacao_esteticista">*Formação Acadêmica:</label>
                    <input type="text" class="form-control" id="formacao_esteticista" name="formacao_esteticista" placeholder="Digite a Formação:" value="<?php echo htmlspecialchars($esteticistaData['formacao_esteticista']); ?>" required>
                </div>
            </div>

            <div class="column">
                <div class="input-box">
                    <label for="descricao_p_esteticista">*Descrição Curta:</label>
                    <textarea class="form-control" id="descricao_p_esteticista" name="descricao_p_esteticista" placeholder="Digite a Pequena Descrição Profissional:" required><?php echo htmlspecialchars($esteticistaData['descricao_p_esteticista']); ?></textarea>
                </div>
            </div>

            <div class="column">
                <div class="input-box">
                    <label for="descricao_g_esteticista">*Descrição Detalhada:</label>
                    <textarea class="form-control" id="descricao_g_esteticista" name="descricao_g_esteticista" placeholder="Digite a Grande Descrição Profissional:" required><?php echo htmlspecialchars($esteticistaData['descricao_g_esteticista']); ?></textarea>
                </div>
            </div>

            <div class="column">
                <div class="input-box">
                    <label for="instagram_esteticista">*Instagram:</label>
                    <input type="text" class="form-control" id="instagram_esteticista" name="instagram_esteticista" placeholder="Digite o Instagram:" value="<?php echo htmlspecialchars($esteticistaData['instagram_esteticista']); ?>" required>
                </div>
                <div class="input-box">
                    <label for="facebook_esteticista">*Facebook:</label>
                    <input type="text" class="form-control" id="facebook_esteticista" name="facebook_esteticista" placeholder="Digite o Facebook:" value="<?php echo htmlspecialchars($esteticistaData['facebook_esteticista']); ?>" required>
                </div>
                <div class="input-box">
                    <label for="linkedin_esteticista">*LinkedIn:</label>
                    <input type="text" class="form-control" id="linkedin_esteticista" name="linkedin_esteticista" placeholder="Digite o LinkedIn:" value="<?php echo htmlspecialchars($esteticistaData['linkedin_esteticista']); ?>" required>
                </div>
            </div>
            <button type="submit" class="btn btn-primary">Atualizar</button>
        </form>
    </section>

    <script>
        // Máscara dos inputs
        $(document).ready(function() {
            $('#telefone_esteticista').mask('(00) 00000-0000');
        });

        // Função para pré-visualizar a imagem selecionada do perfil
        function previewProfilePic() {
            const input = document.getElementById("foto_esteticista");
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
    </script>
</body>
</html>