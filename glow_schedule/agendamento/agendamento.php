<?php
require_once '../controller/conexao.php';

// Instancia a classe Conexao e obtém a conexão
$conexao = new Conexao();
$conn = $conexao->getConexao();
if ($conn->connect_error) {
    die("Erro na conexão com o banco de dados: " . $conn->connect_error);
}
$cpfCliente = $_GET['cpf_cliente'] ?? '';
// Consulta para obter os procedimentos
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

            // Limpa as opções anteriores
            esteticistasSelect.innerHTML = '';
            esteticistasSelect.disabled = true; // Desativa temporariamente até carregar os esteticistas

            // Adiciona a opção padrão
            const optionDefault = document.createElement('option');
            optionDefault.value = '';
            optionDefault.text = 'Selecione um esteticista';
            esteticistasSelect.add(optionDefault);

            if (procedimentoId) {
                // Faz uma requisição AJAX para obter os esteticistas
                fetch(`carregarEsteticistas.php?id_procedimento=${procedimentoId}`)
                    .then(response => response.json())
                    .then(data => {
                        data.forEach(est => {
                            const option = document.createElement('option');
                            option.value = est.cpf_esteticista;
                            option.text = ` ${est.apelido_esteticista}`;
                            esteticistasSelect.add(option);
                        });
                        esteticistasSelect.disabled = false; // Ativa o campo do profissional
                    })
                    .catch(error => console.error('Erro:', error));
            }
        }

        function obterCpfCliente() {
        const urlParams = new URLSearchParams(window.location.search);
        const cpf = urlParams.get('cpf_cliente');
        return cpf;
        }

        function confirmarAgendamento(procedimento, apelidoProfissional, data, horario) {
            // Passo 1: Obter o CPF do profissional via fetch
            fetch('obterCpfProfissional.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify({
                    apelido: apelidoProfissional // Passa o apelido para obter o CPF
                }),
            })
            .then(response => {
                if (!response.ok) {
                    throw new Error("Erro ao buscar o CPF do profissional.");
                }
                return response.json(); // Retorna a resposta em JSON
            })
            .then(dataResponse => {

                if (dataResponse.success) {
                    const cpfProfissional = dataResponse.cpf;

                    // Passo 2: Obter o CPF do cliente via função obterCpfCliente
                    const cpfClienteObtido = obterCpfCliente(); // Captura o CPF do cliente da URL

                    if (!cpfClienteObtido) {
                        throw new Error("CPF do cliente não encontrado na URL.");
                    }

                    // Passo 3: Envia o agendamento com as informações corretas
                    return fetch('cadastrarAgendamento.php', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                        },
                        body: JSON.stringify({
                            procedimento: procedimento,
                            profissional: cpfProfissional,
                            data: data,
                            horario: horario,
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
                return response.json(); // Retorna a resposta em JSON
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
</html>