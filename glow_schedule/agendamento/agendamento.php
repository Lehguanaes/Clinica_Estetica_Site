<?php
require_once '../controller/conexao.php';
require_once $_SERVER['DOCUMENT_ROOT'] . "/glow_schedule/model/message.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/glow_schedule/controller/global.php";


if (session_status() == PHP_SESSION_NONE){
    session_start();
}
// Instancia a classe Conexao e obtém a conexão :D
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
$loggedIn = isset($_SESSION['usuario_token']);
$result = $conn->query("SELECT id_procedimento, nome_procedimento FROM procedimento");
$procedimentos = $result ? $result->fetch_all(MYSQLI_ASSOC) : [];
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Agendamento</title>
    <!-- Link para o arquivo CSS -->
    <link rel="stylesheet" href="../css/styleAgendamento.css">
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

        function obterCpfCliente() {
            const urlParams = new URLSearchParams(window.location.search);
            return urlParams.get('cpf_cliente');
        }

        function confirmarAgendamento(procedimento, apelidoProfissional, data, horario) {
            <?php if ($loggedIn): ?>
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
                        const cpfClienteObtido = obterCpfCliente();

                        if (!cpfClienteObtido) {
                            throw new Error("CPF do cliente não encontrado na URL.");
                        }

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
                                cliente: cpfClienteObtido
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
    <div class="container">
        <div class="calendar">
            <h4>Selecione o procedimento desejado, o profissional e a data:</h4>
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
</body>
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
