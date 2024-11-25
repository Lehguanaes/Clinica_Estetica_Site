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
    <!-- Estilização padrão do website -->
    <link rel="stylesheet" href="../css/style.css">
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css">
    <!-- Estilização formulários de Perfis -->
    <link rel="stylesheet" href="../css/perfil.css">
    <!-- Link para o arquivo CSS -->
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

        function confirmarOAgendamento(procedimento, apelidoProfissional, data, horario) {
            // Verifica se o usuário está logado
            if (!<?= json_encode($cpfCliente) ?>) {
                Swal.fire({
                    icon: 'warning',
                    title: 'Login Necessário',
                    text: 'Você precisa estar logado para realizar um agendamento.',
                    confirmButtonText: 'Login',
                    html: 'Novo por aqui? Cadastre-se. <a href="../cliente/cadastrarCliente.php" style="color: #3085d6; text-decoration: underline;">cadastrar</a>',
                }).then(() => {
                    window.location.href = "../login.php";
                });
                return; 
            }

            const cpfCliente = <?= json_encode($cpfCliente) ?>; // CPF do cliente logado

            // Busca o CPF do profissional pelo apelido
            fetch('obterCpfProfissional.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify({ apelido: apelidoProfissional }),
            })
            .then(response => response.json())
            .then(profData => {
                if (profData.success) {
                    const cpfProfissional = profData.cpf;

                    // Agora envia os dados para cadastrar o agendamento
                    return fetch('cadastrarAgendamento.php', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                        },
                        body: JSON.stringify({
                            procedimento,
                            profissional: cpfProfissional,
                            data,
                            horario,
                            cliente: cpfCliente // CPF do cliente logado
                        }),
                    });
                } else {
                    throw new Error("Profissional não encontrado.");
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Consulta Marcada!',
                        text: 'Preencha seu prontuário para maior precisão da consulta!',
                        html: 'Novo por aqui? Cadastre seu prontuário. <a href="../prontuario/cadastroProntuario.php" style="color: #3085d6; text-decoration: underline;">cadastrar</a>',
                        confirmButtonText: 'Ok'
                    }).then(() => {
                    window.location.href = "../prontuario/editarProntuario.php";
                });
                } else {
                    console.error("Erro no agendamento:", data.message);
                    Swal.fire({
                        icon: 'error',
                        title: 'Erro no Agendamento',
                        text: 'Ocorreu um erro ao confirmar o agendamento. Tente novamente.',
                        confirmButtonText: 'Ok'
                    });
                }
            })
            .catch(error => {
                console.error('Erro detalhado:', error);
                Swal.fire({
                    icon: 'error',
                    title: 'Erro ao efetuar o agendamento!',
                    text: 'Ocorreu um erro: ' + error.message,
                    confirmButtonText: 'Ok'
                });
            });
        }
    </script>
</head>
<body>
    <!-- Início da Navbar -->
    <nav class="navbar navbar-expand-lg">
        <div class="container-fluid">
            <a class="navbar-brand"><img class="rounded-circle ms-4" src="../logo/Logo.png" alt="Logo care tones" width="69px"></a>
            <div class="logo">
                <a class="nav-link active" aria-current="page" href="Home.html">Care Tones</a>
            </div>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav w-auto">
                    <li class="nav-item pe-4 ps-4"><a class="nav-link active" aria-current="page" href="Home.html">Home</a></li>
                    <li class="nav-item pe-4 ps-4"><a class="nav-link active" aria-current="page" href="Sobre_nos.html">Sobre nós</a></li>
                    <li class="nav-item pe-4 ps-4"><a class="nav-link active" aria-current="page" href="Procedimentos.html">Procedimentos</a></li>
                    <li class="nav-item pe-4 ps-4"><a class="nav-link active" aria-current="page" href="Profissionais.html">Profissionais</a></li>
                </ul>
                <button type="button" class="btn btn-sm btn-link me-4 ms-4"><a href="Agendamentos.html" id="link_agendamentos">Agendamentos</a></button>
            </div>
        </div>
    </nav>
    <!-- Fim da Navbar -->
    <h2>Agendamento</h2>
    <div class="container">
        <div class="calendar">
            <h3>Selecione o procedimento desejado, o profissional e a data:</h3>
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
            <input type="hidden" id="Adata-selecionada" disabled>
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
