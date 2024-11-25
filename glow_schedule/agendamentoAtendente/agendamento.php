<?php
require_once '../controller/conexao.php';
require_once $_SERVER['DOCUMENT_ROOT'] . "/glow_schedule/model/message.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/glow_schedule/controller/global.php";

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Instancia a classe Conexao e obtém a conexão
$conexao = new Conexao();
$conn = $conexao->getConexao();
if ($conn->connect_error) {
    die("Erro na conexão com o banco de dados: " . $conn->connect_error);
}

$message = new Message($BASE_URL);
$flashMsg = $message->getMessage();

if (!empty($flashMsg["msg"])) {
    $message->limparMessage();
}

// Verifica se o usuário está logado
$cpfCliente = null;
if (isset($_SESSION['usuario_token'])) {
    $token = $_SESSION['usuario_token'];

    // Consulta o banco de dados para obter o CPF do cliente com base no token
    $stmt = $conn->prepare("SELECT cpf_cliente FROM cliente WHERE token_cliente = ?");
    $stmt->bind_param("s", $token);
    $stmt->execute();
    $resultado = $stmt->get_result();

    if ($resultado->num_rows > 0) {
        $cliente = $resultado->fetch_assoc();
        $cpfCliente = $cliente['cpf_cliente'];  // Armazena o CPF do cliente
    }
}
$resultado2 = $conn->query("SELECT id_procedimento, nome_procedimento FROM procedimento");
$procedimentos = $resultado2 ? $resultado2->fetch_all(MYSQLI_ASSOC) : [];
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Care Tones</title>
    <!-- Ícone para navegadores modernos -->
    <link rel="icon" href="../logo/Logo.png" type="image/png">
    <!-- Ícone para navegadores antigos -->
    <link rel="shortcut icon" href="../logo/Logo.png" type="image/x-icon">
    <!-- Links externos -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css" integrity="sha512-MV7K8+y+gLIBoVD59lQIYicR65iaqukzvf/nwasF0nqhPay5w/9lJmVM2hMDcnK1OnMGCdVK+iQrJ7lzPJQd1w==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <!-- Estilização padrão do web site -->
    <link rel="stylesheet" href="../css/style.css">
    <!-- Estilização formulários de Perfis -->
    <link rel="stylesheet" href="../css/perfil.css">
    <!-- Estilização do Agendamento -->
    <link rel="stylesheet" href="../css/agendamento.css">
    <!-- Estilização Navbar -->
    <link rel="stylesheet" href="../css/navbar.css">
    <!-- Link para o arquivo JavaScript -->
    <script src="../js/agendamento.js" defer></script>
    <script>
        function carregarEsteticistas() {
            const procedimentoId = document.getElementById('procedimento_desejado').value;
            const esteticistasSelect = document.getElementById('preferencia_profissional');

            // Limpa as opções anteriores
            esteticistasSelect.innerHTML = '';
            esteticistasSelect.disabled = true;

            const optionDefault = document.createElement('option');
            optionDefault.value = '';
            optionDefault.text = 'Selecione um esteticista';
            esteticistasSelect.add(optionDefault);

            if (procedimentoId) {
                // Chama o backend para buscar os esteticistas baseados no procedimento selecionado
                fetch(`carregarEsteticistas.php?id_procedimento=${procedimentoId}`)
                    .then(response => response.json())
                    .then(data => {
                        data.forEach(est => {
                            const option = document.createElement('option');
                            option.value = est.cpf_esteticista;
                            option.text = `${est.apelido_esteticista}`;
                            esteticistasSelect.add(option);
                        });
                        esteticistasSelect.disabled = false;
                    })
                    .catch(error => console.error('Erro ao carregar esteticistas:', error));
            }
        }
    </script>
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
                        <a href="../atendente/perfilAtendente.php"><i class="fa-solid fa-user fa-sm" style="color: #cf6f7a;"></i> Perfil </a>
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
    <h2>Agendamento</h2>
    <div class="container">
        <div class="calendar">
            <h3>Selecione o procedimento desejado, o profissional e a data:</h3>
            <div class="input-box">
                <label for="cpf_cliente">CPF do Cliente:</label>
                <input type="text" id="cpf_cliente" name="cpf_cliente" placeholder="Digite o CPF do cliente" required>
            </div>
            <div class="input-box">
                <div class="select-box">
                    <label for="procedimento_desejado">Procedimento desejado:</label>
                    <select id="procedimento_desejado" name="procedimento_desejado" onchange="carregarEsteticistas()">
                        <option value="">Selecione um procedimento</option>
                        <?php foreach ($procedimentos as $procedimento): ?>
                            <option value="<?= $procedimento['id_procedimento'] ?>"><?= $procedimento['nome_procedimento'] ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
            </div>
            <div class="input-box">
                <div class="select-box">
                    <label for="preferencia_profissional">Profissional desejado:</label>
                    <select id="preferencia_profissional" name="preferencia_profissional" disabled>
                        <option value="">Selecione um esteticista</option>
                    </select>
                </div>
            </div>
            <input type="hidden" id="data-selecionada" disabled>
            <div id="calendario-dinamico">
                <!-- Calendário será carregado aqui via AJAX -->
            </div>
        </div>
        <div class="horarios">
            <h3>Horários disponíveis para a data <span id="texto-data-selecionada">...</span></h3>
            <div id="horarios">
                <!-- Horários disponíveis serão carregados aqui -->
            </div>
            <div id="resumo-container">
                <!-- Informações para Confirmar consulta serão carregados aqui-->
            </div>
        </div>
    </div>
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
                    <a href="../atendente/cadastrarClienteAtendente.php" class="footer-link">Cadastrar Cliente</a>
                </li>
                <li>
                    <a href="../atendente/cadastroAtendente.php" class="footer-link">Cadastrar Atendentes</a>
                </li>
                <li>
                    <a href="../atendente/cadastroEsteticista.php" class="footer-link">Cadastrar Profissionais</a>
                </li>
            </ul>
            <ul class="footer-list">
                <li>
                    <h4 id="subtitulo-footer">Interesses</h4>
                </li>
                <li>
                    <a href="../atendente/visualizarConsultas.php" class="footer-link">Agenda</a>
                </li>
                <li>
                    <a href="../atendente/visualizarAvaliacoes.php" class="footer-link">Avaliações</a>
                </li>
                <li>
                    <a href="../atendente/visualizarDuvidas.php" class="footer-link">Dúvidas</a>
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
</body>
<!-- Link Sweet Alert -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<!-- Link Js Navbar -->
<script src="../js/navbar.js"></script>
<?php if (!empty($flashMsg["msg"])): ?>
<script>
    Swal.fire({
        icon: "<?= $flashMsg['type'] ?>",
        title: "<?= $flashMsg['titulo'] ?>",
        text: "<?= $flashMsg['msg'] ?>"
    });
</script>      
<?php endif; ?>
</html>