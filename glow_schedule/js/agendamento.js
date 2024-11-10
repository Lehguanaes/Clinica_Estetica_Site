// Função para habilitar a seleção de data após escolher o profissional
function habilitarData() {
    var profissional = document.getElementById("preferencia_profissional").value;
    var dataInput = document.getElementById("data-selecionada");

    if (profissional && profissional !== "Selecionar") {
        dataInput.disabled = false; // Habilita a seleção de data
    } else {
        dataInput.disabled = true; // Mantém desabilitada se não houver profissional
    }
}

// Função para verificar se o procedimento foi selecionado
function verificarSelecao() {
    // Obtém os valores selecionados
    var procedimento = document.getElementById("procedimento_desejado").value;
    var data = document.getElementById("data-selecionada").value;
    var profissional = document.getElementById("preferencia_profissional").value;

    // Se um procedimento e uma data foram selecionados, carrega os horários
    if (procedimento && data) {
        carregarHorarios(procedimento, data, profissional);
    }
}

// Função para selecionar a data no calendário
function selecionarData(data, elemento) {
    var profissional = document.getElementById("preferencia_profissional").value;

    // Verifica se o profissional foi selecionado
    if (!profissional || profissional === "Selecionar") {
        alert("Por favor, selecione um profissional antes de escolher uma data.");
        return; // Interrompe a função se o profissional não for selecionado
    }

    // Atualiza o campo de data selecionada
    document.getElementById("data-selecionada").value = data;
    document.getElementById("texto-data-selecionada").textContent = data;

    // Remove a classe "selected" de qualquer data previamente selecionada
    var diasSelecionados = document.querySelectorAll(".selected");
    diasSelecionados.forEach(function(dia) {
        dia.classList.remove("selected");
    });

    // Adiciona a classe "selected" à nova data selecionada
    elemento.classList.add("selected");

    // Carrega os horários após selecionar a data
    var procedimento = document.getElementById("procedimento_desejado").value;
    carregarHorarios(procedimento, data, profissional);
}

// Função para carregar os horários disponíveis
function carregarHorarios(procedimento, data, profissional) {
    var xhr = new XMLHttpRequest(); // Cria um novo objeto XMLHttpRequest
    xhr.onreadystatechange = function() {
        // Quando a requisição for concluída
        if (xhr.readyState == 4 && xhr.status == 200) {
            // Atualiza a div de horários com a resposta do servidor
            document.getElementById('horarios').innerHTML = xhr.responseText;
        }
    };

    // Faz a requisição GET para buscar os horários
    xhr.open('GET', 'carregarHorarios.php?procedimento=' + procedimento + '&data=' + data + '&profissional=' + profissional, true);
    xhr.send(); // Envia a requisição
}

// Função AJAX para carregar o calendário dinamicamente
function carregarMes(mes, ano) {
    var xhr = new XMLHttpRequest(); // Cria um novo objeto XMLHttpRequest
    xhr.onreadystatechange = function() {
        // Quando a requisição for concluída
        if (xhr.readyState == 4 && xhr.status == 200) {
            // Atualiza a div do calendário com a resposta do servidor
            document.getElementById('calendario-dinamico').innerHTML = xhr.responseText;
        }
    };
    // Faz a requisição GET para buscar o calendário do mês e ano especificados
    xhr.open('GET', 'carregarCalendario.php?mes=' + mes + '&ano=' + ano, true);
    xhr.send(); // Envia a requisição
}

// Carrega o calendário inicial ao abrir a página
window.onload = function() {
    var mesAtual = new Date().getMonth() + 1; // Obtém o mês atual (0-11, então adiciona 1)
    var anoAtual = new Date().getFullYear(); // Obtém o ano atual
    carregarMes(mesAtual, anoAtual); // Carrega o calendário do mês atual
};

function mostrarResumo(procedimentoId, profissionalCpf, data, horario) {
    // Faz uma requisição para o PHP
    fetch(`getDadosResumo.php?procedimento=${procedimentoId}&profissional=${profissionalCpf}&data=${data}&horario=${horario}`)
        .then(response => response.json())
        .then(dados => {

            // Armazena os valores em variáveis
            const nomeProcedimento = dados.nome_procedimento;
            const apelidoEsteticista = dados.apelido_esteticista;
            const dataConsulta = dados.data;
            const horarioConsulta = dados.horario;

            // Cria um bloco de resumo para exibir os dados
            const resumoDiv = document.createElement('div');
            resumoDiv.id = 'resumo-agendamento';
            resumoDiv.style.marginTop = '20px';

            // Define o conteúdo do resumo
            resumoDiv.innerHTML = `
                <h3>Confirmação do agendamento da consulta:</h3>
                <p><strong>Procedimento:</strong> ${nomeProcedimento}</p>
                <p><strong>Profisional:</strong> ${apelidoEsteticista}</p>
                <p><strong>Data:</strong> ${dataConsulta}</p>
                <p><strong>Horário:</strong> ${horarioConsulta}</p>
                <button id="confirmar-btn" onclick="confirmarAgendamento('${nomeProcedimento}', '${apelidoEsteticista}', '${dataConsulta}', '${horarioConsulta}')">Confirmar Agendamento</button>
            `;

            // Exibe o resumo na página
            const resumoContainer = document.getElementById('resumo-container');
            resumoContainer.innerHTML = ''; // Limpa o conteúdo anterior
            resumoContainer.appendChild(resumoDiv);
        })
        .catch(error => console.error('Erro ao buscar dados do resumo:', error));
}