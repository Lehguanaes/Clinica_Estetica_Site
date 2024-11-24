<?php
require_once '../controller/conexao.php';
require_once $_SERVER['DOCUMENT_ROOT'] . "/glow_schedule/model/message.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/glow_schedule/controller/global.php";


if (session_status() == PHP_SESSION_NONE){
    session_start();
}
    
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
    
    $token = isset($_SESSION['usuario_token']);
     
    $result = $conn->query("SELECT id_procedimento, nome_procedimento FROM procedimento");
    $procedimentos = $result ? $result->fetch_all(MYSQLI_ASSOC) : [];
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Agendar Consultas</title>
    <!-- Links externos -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css" integrity="sha512-MV7K8+y+gLIBoVD59lQIYicR65iaqukzvf/nwasF0nqhPay5w/9lJmVM2hMDcnK1OnMGCdVK+iQrJ7lzPJQd1w==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <!-- Estilização padrão do web site -->
    <link rel="stylesheet" href="../css/style.css">
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css">
    <!-- Estilização formulários de Perfis -->
    <link rel="stylesheet" href="../css/perfil.css">
    <!-- Link para o arquivo CSS -->
    <link rel="stylesheet" href="../css/styleAgendamento.css">
    <link rel="icon" href="../logo/Logo.png" type="image/png">
    <!-- Ícone para navegadores antigos -->
    <link rel="shortcut icon" href="../logo/Logo.png" type="image/x-icon">
    <!-- Estilização padrão do web site -->
    <link rel="stylesheet" href="../css/style.css">
    <!-- Estilização formulários de Perfis -->
    <link rel="stylesheet" href="../css/perfil.css">
    <!-- Estilização Navbar -->
    <link rel="stylesheet" href="../css/navbar.css">
    <!-- Link para o arquivo JavaScript -->
    <script src="../js/agendamento.js" defer></script>
    <script>
        function carregarEsteticistas() {
            const procedimentoId = document.getElementById('procedimento_desejado').value;
            const esteticistasSelect = document.getElementById('preferencia_profissional');

            esteticistasSelect.innerHTML = '';
            esteticistasSelect.disabled = true;

            const optionDefault = document.createElement('option');
            optionDefault.value = '';
            optionDefault.text = 'Selecione um esteticista';
            esteticistasSelect.add(optionDefault);

            if (procedimentoId) {
                fetch(`carregarEsteticistas.php?id_procedimento=${procedimentoId}`)
                    .then(response => response.json())
                    .then(data => {
                        data.forEach(est => {
                            const option = document.createElement('option');
                            option.value = est.cpf_esteticista;
                            option.text = ` ${est.apelido_esteticista}`;
                            esteticistasSelect.add(option);
                        });
                        esteticistasSelect.disabled = false;
                    })
                    .catch(error => console.error('Erro:', error));
            }
        }


        function confirmarAgendamento(procedimento, apelidoProfissional, data, horario) {
            <?php if ($token): ?>
                const cpf_Cliente = document.getElementById('cpf_cliente').value;

                if (!cpfCliente) {
                   alert('Por favor, insira o CPF do cliente.');
                   return;
                }

                fetch('obterCpfProfissional.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                    },
                    body: JSON.stringify({ apelido: apelidoProfissional }),
                })
                .then(response => {
                    if (!response.ok) {
                        throw new Error("Erro ao buscar o CPF do profissional.");
                    }
                    return response.json();
                })
                .then(dataResponse => {
                    if (dataResponse.success) {
                        const cpfProfissional = dataResponse.cpf;

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
                        cliente: cpfCliente  // CPF do cliente capturado do input
                    }),
                });
            } else {
                throw new Error("Profissional não encontrado.");
            }
        })
        .then(response => {
            if (!response.ok) {
                throw new Error("Erro ao cadastrar o agendamento.");
            }
            return response.json();
        })
        .then(data => {
            if (data.success) {
                alert("Seu agendamento foi confirmado com sucesso!");
            } else {
                console.error("Erro no agendamento:", data.message);
                alert("Ocorreu um erro ao confirmar o agendamento. Tente novamente.");
            }
        })
        .catch(error => {
            console.error('Erro detalhado:', error);
            alert("Erro na comunicação com o servidor: " + error.message);
        });
    <?php else: ?>
        alert("Você precisa estar logado para realizar um agendamento.");
        window.location.href = "../login.php";
    <?php endif; ?>
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
                        <a href="../procedimento/consultarProcedimento.php"><i class="fa-brands fa-shopify" style="color: #cf6f7a;"></i> Procedimentos </a>
                        <a href="../atendente/consultarEsteticista.php"><i class="fa-solid fa-user-doctor" style="color: #cf6f7a;"></i> Profissionais  </a>
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
    <div class="container">
        <div class="calendar">
            <h4>Selecione o procedimento desejado, o profissional e a data:</h4>
            <div>
                <div class="input-box">
                    <label>CPF do Cliente:</label>
                    <input type="text" name="cpf_cliente" id="cpf_cliente" placeholder="Digite o CPF do cliente" required>
                </div>
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
            <h4>Horários disponíveis para a data <span id="texto-data-selecionada">...</span></h4>
            <div id="horarios">
                <!-- Horários disponíveis serão carregados aqui -->
            </div>
            <div id="resumo-container">
                <!-- Informações para Confirmar consulta serão carregados aqui-->
            </div>
        </div>
    </div>
</body>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.16/jquery.mask.min.js"></script>
<script>
    $(document).ready(function(){
        $('#cpf_cliente').mask('000.000.000-00');
    });
</script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
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
