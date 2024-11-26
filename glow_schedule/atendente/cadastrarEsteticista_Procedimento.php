<?php
// Inclua o arquivo de conexão
require_once '../controller/conexao.php';

// Instancia a classe Conexao e obtém a conexão
$conexao = new Conexao();
$conn = $conexao->getConexao();
if ($conn->connect_error) {
    die("Erro na conexão com o banco de dados: " . $conn->connect_error);
}

// Consulta para obter todos os procedimentos
$consultaProcedimentos = "SELECT id_procedimento, nome_procedimento FROM procedimento";
$resultadoProcedimentos = $conn->query($consultaProcedimentos);

// Consulta para obter todos os esteticistas
$consultaEsteticistas = "SELECT cpf_esteticista, apelido_esteticista FROM esteticista";
$resultadoEsteticistas = $conn->query($consultaEsteticistas);

if (!$resultadoProcedimentos || !$resultadoEsteticistas) {
    die("Erro ao executar as consultas: " . $conn->error);
}

$procedimentos = [];
while ($procedimento = $resultadoProcedimentos->fetch_assoc()) {
    $procedimentos[] = $procedimento;
}

$esteticistas = [];
while ($esteticista = $resultadoEsteticistas->fetch_assoc()) {
    $esteticistas[] = $esteticista;
}

// Inicialização de variáveis para o JavaScript
$statusMsg = "";
$procedimentoNome = "";
$esteticistaApelido = "";

// Verifique se o formulário foi submetido
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['acao']) && $_POST['acao'] === 'inserir') {
    $cpfEsteticista = $_POST['cpf_esteticista'];
    $idProcedimento = $_POST['id_procedimento'];

    // Obtenha o nome do procedimento e o apelido do esteticista para o alerta
    $consultaNomeEsteticista = $conn->prepare("SELECT apelido_esteticista FROM esteticista WHERE cpf_esteticista = ?");
    $consultaNomeEsteticista->bind_param("s", $cpfEsteticista);
    $consultaNomeEsteticista->execute();
    $consultaNomeEsteticista->bind_result($esteticistaApelido);
    $consultaNomeEsteticista->fetch();
    $consultaNomeEsteticista->close();

    $consultaNomeProcedimento = $conn->prepare("SELECT nome_procedimento FROM procedimento WHERE id_procedimento = ?");
    $consultaNomeProcedimento->bind_param("i", $idProcedimento);
    $consultaNomeProcedimento->execute();
    $consultaNomeProcedimento->bind_result($procedimentoNome);
    $consultaNomeProcedimento->fetch();
    $consultaNomeProcedimento->close();

    // Verifique se o esteticista já está atribuído ao procedimento
    $consultaDuplicidade = $conn->prepare("SELECT 1 FROM esteticista_procedimento WHERE cpf_esteticista = ? AND id_procedimento = ?");
    $consultaDuplicidade->bind_param("si", $cpfEsteticista, $idProcedimento);
    $consultaDuplicidade->execute();
    $consultaDuplicidade->store_result();

    if ($consultaDuplicidade->num_rows > 0) {
        // Já existe, exibir mensagem de aviso
        $statusMsg = "duplicate";
    } else {
        // Não existe, inserir os dados na tabela
        $insercao = $conn->prepare("INSERT INTO esteticista_procedimento (cpf_esteticista, id_procedimento) VALUES (?, ?)");
        $insercao->bind_param("si", $cpfEsteticista, $idProcedimento);

        if ($insercao->execute()) {
            $statusMsg = "success";
        } else {
            $statusMsg = "error";
        }

        $insercao->close();
    }

    $consultaDuplicidade->close();
}
// Feche a conexão com o banco de dados
$conn->close();
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Care Tones</title>
    <!-- Ícones -->
    <link rel="icon" href="../logo/Logo.png" type="image/png">
    <link rel="shortcut icon" href="../logo/Logo.png" type="image/x-icon">
    <!-- Links externos -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.16/jquery.mask.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css" integrity="sha512-MV7K8+y+gLIBoVD59lQIYicR65iaqukzvf/nwasF0nqhPay5w/9lJmVM2hMDcnK1OnMGCdVK+iQrJ7lzPJQd1w==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <!-- SweetAlert2 para alertas estilizados -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <!-- Estilização padrão do web site -->
    <link rel="stylesheet" href="../css/style.css">
    <!-- Estilização formulários de Perfis -->
    <link rel="stylesheet" href="../css/perfil.css">
    <!-- Estilização Filtro -->
    <link rel="stylesheet" href="../css/filtro.css">
    <!-- Estilização Navbar -->
    <link rel="stylesheet" href="../css/navbar.css">
</head>
<body>
    <!-- Início da Navbar -->
    <header>
        <nav class="nav-bar">
            <a class="logo" href="#"><img src="../logo/Logo.png" class="logoIMG">Care Tones</a>
            <ul class="nav-list">
                <li><a href="../atendente/visualizarDuvidas.php" class="nav">Dúvidas</a></li>
                <li><a href="../atendente/visualizarAvaliacoes.php" class="nav">Avaliações</a></li>
                <li><a href="../procedimento/consultarProcedimento.php" class="nav">Procedimentos</a></li>
                <li><a href="../atendente/visualizarConsultas.php" class="nav">Agenda</a></li>
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
    <!-- Fim da Navbar -->
    <h2>Credenciar Profissionais</h2>
    <section class="container">
    <form method="POST" class="form" id="form_perfil">
    <h4 id="titulo-form-est">Por favor, escolha o profissional e qual procedimento ele poderá fazer.</h4>
        <input type="hidden" name="acao" value="inserir">

        <!-- Select de Esteticista -->
        <div class="column">
            <div class="input-box">
                <label for="cpf_esteticista">Profissionais:</label>
                <select name="cpf_esteticista" id="cpf_esteticista" required>
                    <option value="" disabled selected>Selecione um profissional</option>
                    <?php foreach ($esteticistas as $esteticista): ?>
                        <option value="<?= htmlspecialchars($esteticista['cpf_esteticista']) ?>">
                            <?= htmlspecialchars($esteticista['apelido_esteticista']) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
        </div>

        <!-- Select de Procedimento -->
        <div class="column">
            <div class="input-box">
                <label for="id_procedimento">Procedimento:</label>
                <select name="id_procedimento" id="id_procedimento" required>
                    <option value="" disabled selected>Selecione um procedimento</option>
                    <?php foreach ($procedimentos as $procedimento): ?>
                        <option value="<?= htmlspecialchars($procedimento['id_procedimento']) ?>">
                            <?= htmlspecialchars($procedimento['nome_procedimento']) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
        </div>
        <!-- Botão de submissão -->
            <button type="submit" class="btn  btn-form-est">Cadastrar</button>
    </form>
</section>

<!-- Inicio Footer -->
<footer>
        <div id="footer_content">
            <div id="footer_contacts">
                <a class="navbar-brand" href="#"> <img class="rounded-circle ms-4" src="../logo/Logo.png" alt="Logo care tones" width="69px"></a>
                <h3>Care Tones</h3>  
                <div id="footer_social_media">
                    <a href="#" class="footer-link" id="instagram">
                        <i class="fa-brands fa-instagram"></i>
                    </a>
                    <a href="#" class="footer-link" id="facebook">
                        <i class="fa-brands fa-facebook-f fa-xs"></i>
                    </a>
                    <a href="#" class="footer-link" id="whatsapp">
                        <i class="fa-brands fa-whatsapp"></i>
                    </a>
                    <a href="#" class="footer-link" id="localizacao">
                        <i class="fa-solid fa-location-dot"></i>
                    </a>
                </div>
            </div>
            <ul class="footer-list">
                <li>
                    <h4 id="subtitulo-footer">Cadastros</h4>
                </li>
                <li>
                    <a href="cadastrarClienteAtendente.php" class="footer-link">Cadastrar Cliente</a>
                </li>
                <li>
                    <a href="cadastroAtendente.php" class="footer-link">Cadastrar Atendentes</a>
                </li>
                <li>
                    <a href="cadastroEsteticista.php" class="footer-link">Cadastrar Profissionais</a>
                </li>
            </ul>
            <ul class="footer-list">
                <li>
                    <h4 id="subtitulo-footer">Interesses</h4>
                </li>
                <li>
                    <a href="visualizarConsultas.php" class="footer-link">Agenda</a>
                </li>
                <li>
                    <a href="visualizarAvaliacoes.php" class="footer-link">Avaliações</a>
                </li>
                <li>
                    <a href="visualizarDuvidas.php" class="footer-link">Dúvidas</a>
                </li>
            </ul>
            <div id="footer_subscribe">
                <h4 id="subtitulo-footer">Clínica</h4>
                <p>
                    Venha visualizar o que temos!
                </p>
                <ul class="footer-list">
                <li>
                    <a href="../esteticista/esteticistas.php" class="footer-link">Profissionais</a>
                </li>
                <li>
                    <a href="../procedimento/procedimentos.php" class="footer-link">Procedimentos</a>
                </li>
                </ul>
            </div>
        </div>
        <div id="footer_copyright">
            &#169
            2024 all rights reserved
        </div>
    </footer>
    <!-- Link Js Navbar -->
    <script src="../js/navbar.js"></script>
    <script>
    <?php if (!empty($statusMsg)): ?>
        <?php if ($statusMsg === "success"): ?>
            Swal.fire({
                icon: 'success',
                iconColor: '#1A7F83',
                title: 'Cadastro realizado!',
                text: 'O procedimento <?= htmlspecialchars($procedimentoNome) ?> foi atribuído ao profissional <?= htmlspecialchars($esteticistaApelido) ?> com sucesso.',
                confirmButtonColor: '#1A7F83',
                confirmButtonText: 'Ok'
            });
        <?php elseif ($statusMsg === "duplicate"): ?>
            Swal.fire({
                icon: 'info',
                iconColor: '#CF6F7A',
                title: 'Atenção',
                text: 'Este procedimento já está atribuído ao profissional selecionado.',
                confirmButtonColor: '#1A7F83',
                confirmButtonText: 'Entendi'
            });
        <?php elseif ($statusMsg === "error"): ?>
            Swal.fire({
                icon: 'error',
                iconColor: '#CF6F7A',
                title: 'Erro',
                text: 'Ocorreu um erro ao tentar realizar o cadastro. Por favor, tente novamente.',
                confirmButtonColor: '#1A7F83',
                confirmButtonText: 'Ok'
            });
        <?php endif; ?>
    <?php endif; ?>
</script>
</body>
</html>