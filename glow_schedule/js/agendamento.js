// Agendamento Cliente
// Função para habilitar a seleção de data após escolher o profissional
function habilitarAData() {
    var profissional = document.getElementById("preferencia_profissional").value;
    var dataInput = document.getElementById("Adata-selecionada");

    if (profissional && profissional !== "Selecionar") {
        dataInput.disabled = false; // Habilita a seleção de data
    } else {
        dataInput.disabled = true; // Mantém desabilitada se não houver profissional
    }
}

// Adiciona eventos para verificar alterações no CPF e no profissional
document.addEventListener("DOMContentLoaded", function () {
    var cpfInput = document.getElementById("cpf_cliente");
    var profissionalSelect = document.getElementById("preferencia_profissional");
    var dataInput = document.getElementById("Adata-selecionada");

    // Garante que o campo de data esteja desabilitado inicialmente
    dataInput.disabled = true;

    // Adiciona eventos de escuta para habilitar o campo de data
    cpfInput.addEventListener("input", habilitarData);
    profissionalSelect.addEventListener("change", habilitarData);
});

// Função para verificar se o procedimento foi selecionado
function verificarSelecao() {
    // Obtém os valores selecionados
    var procedimento = document.getElementById("procedimento_desejado").value;
    var data = document.getElementById("Adata-selecionada").value;
    var profissional = document.getElementById("preferencia_profissional").value;
    // Se um procedimento e uma data foram selecionados, carrega os horários
    if (procedimento && data) {
        carregarHorarios(procedimento, data, profissional);
    }
}

// Função para formatar a data no padrão DD/MM/YYYY
function formatarData(data) {
    const dia = String(data.getDate()).padStart(2, '0');
    const mes = String(data.getMonth() + 1).padStart(2, '0'); // Mês começa em 0
    const ano = data.getFullYear();
    return `${dia}/${mes}/${ano}`;
}

// Função para selecionar a data no calendário
function selecionarAData(data, elemento) {
    var profissional = document.getElementById("preferencia_profissional").value;

    // Verifica se o profissional foi selecionado
    if (!profissional || profissional === "Selecionar") {
        Swal.fire({
            icon: 'warning',
            title: 'Atenção',
            text: 'Por favor, selecione um profissional antes de escolher uma data.',
        });
        return; // Interrompe a função se o profissional não for selecionado
    }

    // Formata a data no padrão DD/MM/YYYY
    const dataFormatada = formatarData(new Date(data)); // Converte a data e formata
    document.getElementById("Adata-selecionada").value = dataFormatada; // Atualiza o campo de data selecionada
    document.getElementById("texto-data-selecionada").textContent = dataFormatada; // Atualiza o texto da data selecionada

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


// Agendamento Cliente e Atendente
// Função para carregar os horários disponíveis
function carregarHorarios(procedimento, data, profissional) {
    var xhr = new XMLHttpRequest();
    xhr.onreadystatechange = function () {
        if (xhr.readyState == 4) {
            if (xhr.status == 200) {
                document.getElementById('horarios').innerHTML = xhr.responseText;
            } else {
                Swal.fire({
                    width: '450px',
                    icon: 'error',
                    iconColor: '#CF6F7A',
                    title: 'Erro!',
                    text: 'Erro ao carregar os horários disponíveis. Tente novamente mais tarde.',
                    confirmButtonColor: '#1A7F83',
                    confirmButtonText: 'OK'
                });
            }
        }
    };

    xhr.open('GET', 'carregarHorarios.php?procedimento=' + procedimento + '&data=' + data + '&profissional=' + profissional, true);
    xhr.send();
}
// Agendamento Cliente
function mostrarResumo(procedimentoId, profissionalCpf, data, horario) {
    // Faz uma requisição para o PHP
    fetch(`getDadosResumo.php?procedimento=${procedimentoId}&profissional=${profissionalCpf}&data=${data}&horario=${horario}`)
        .then(response => response.json())
        .then(dados => {

            // Armazena os valores em variáveis
            const nomeProcedimento = dados.nome_procedimento;
            const apelidoEsteticista = dados.apelido_esteticista;
            const dataConsulta = formatarData(new Date(dados.data)); // Usa a função para formatar a data
            const horarioConsulta = dados.horario;

            // Cria um bloco de resumo para exibir os dados
            const resumoDiv = document.createElement('div');
            resumoDiv.id = 'resumo-agendamento';
            resumoDiv.style.marginTop = '20px';

            // Define o conteúdo do resumo
            resumoDiv.innerHTML = `
                <h3>Confirmação do agendamento da consulta:</h3>
                <p><strong>Procedimento:</strong> ${nomeProcedimento}</p>
                <p><strong>Profissional:</strong> ${apelidoEsteticista}</p>
                <p><strong>Data:</strong> ${dataConsulta}</p>
                <p><strong>Horário:</strong> ${horarioConsulta}</p>
                <button id="confirmar-btn" onclick="confirmarOAgendamento('${nomeProcedimento}', '${apelidoEsteticista}', '${dataConsulta}', '${horarioConsulta}')">Confirmar Agendamento</button>
            `;

            // Exibe o resumo na página
            const resumoContainer = document.getElementById('resumo-container');
            resumoContainer.innerHTML = ''; // Limpa o conteúdo anterior
            resumoContainer.appendChild(resumoDiv);
        })
        .catch(error => console.error('Erro ao buscar dados do resumo:', error));
}
// Agendamento Cliente e Atendente
// Função AJAX para carregar o calendário dinamicamente com efeitos
function carregarMes(mes, ano) {
    var calendario = document.getElementById('calendario-dinamico');

    // Adiciona uma classe para animar o desaparecimento
    calendario.style.transition = 'opacity 0.5s ease, transform 0.5s ease';
    calendario.style.opacity = '0';
    calendario.style.transform = 'translateY(-20px)';

    setTimeout(() => {
        // Faz a requisição AJAX após o desaparecimento
        var xhr = new XMLHttpRequest();
        xhr.onreadystatechange = function () {
            if (xhr.readyState == 4) {
                if (xhr.status == 200) {
                    // Atualiza o calendário com o conteúdo recebido
                    calendario.innerHTML = xhr.responseText;

                    // Restaura a animação de entrada
                    calendario.style.transition = 'opacity 0.5s ease, transform 0.5s ease';
                    calendario.style.opacity = '1';
                    calendario.style.transform = 'translateY(0)';
                } else {
                    Swal.fire({
                        width: '450px',
                        icon: 'error',
                        iconColor: '#CF6F7A',
                        title: 'Erro!',
                        text: 'Erro ao carregar o calendário. Tente novamente mais tarde.',
                        confirmButtonColor: '#1A7F83',
                        confirmButtonText: 'OK'
                    });
                }
            }
        };

        xhr.open('GET', 'carregarCalendario.php?mes=' + mes + '&ano=' + ano, true);
        xhr.send();
    }, 500); // Tempo da animação de desaparecimento
}
// Carrega o calendário inicial ao abrir a página
window.onload = function () {
    var mesAtual = new Date().getMonth() + 1;
    var anoAtual = new Date().getFullYear();
    carregarMes(mesAtual, anoAtual);
};

// Agendamento Atendente
// Função para habilitar a seleção de data após verificar CPF e profissional
function habilitarData() {
    var cpfCliente = document.getElementById("cpf_cliente").value.trim(); // Obtém o valor do input CPF e remove espaços extras
    var profissional = document.getElementById("preferencia_profissional").value; // Obtém o valor do select do profissional
    var dataInput = document.getElementById("data-selecionada"); // Campo de data

    // Habilita o campo de data apenas se CPF e profissional forem preenchidos
    if (cpfCliente !== "" && profissional && profissional !== "Selecionar") {
        dataInput.disabled = false; // Habilita a seleção de data
    } else {
        dataInput.disabled = true; // Desabilita se alguma das condições não for atendida
    }
}

// Função para selecionar a data no calendário
function selecionarData(data, elemento) {
    var profissional = document.getElementById("preferencia_profissional").value;
    var cpfCliente = document.getElementById("cpf_cliente").value;

    // Verificar se o CPF do cliente está preenchido
    if (!cpfCliente || cpfCliente.trim() === "") {
        Swal.fire({
            width: '450px',
            icon: 'warning',
            iconColor: '#CF6F7A',
            title: 'Atenção',
            text: 'Por favor, informe o CPF do cliente, procedimento e profissional antes de escolher uma data.',
            confirmButtonColor: '#1A7F83',
            confirmButtonText: 'OK'
        });
        return;
    }

    // Faz a verificação se o CPF está cadastrado
    fetch(`verificarCpfCliente.php?cpf=${cpfCliente}`)
        .then(response => response.json())
        .then(dataResposta => {
            if (dataResposta.cadastrado) {
                // CPF está cadastrado, prossegue com a seleção de data
                if (!profissional || profissional === "Selecionar") {
                    Swal.fire({
                        width: '450px',
                        icon: 'warning',
                        iconColor: '#CF6F7A',
                        title: 'Atenção',
                        text: 'Por favor, informe o CPF do cliente, procedimento e profissional antes de escolher uma data.',
                        confirmButtonColor: '#1A7F83',
                        confirmButtonText: 'OK'
                    });
                    return;
                }

                var partesData = data.split('-');
                var dataFormatada = `${partesData[2]}/${partesData[1]}/${partesData[0]}`;

                document.getElementById("data-selecionada").value = data;
                document.getElementById("texto-data-selecionada").textContent = dataFormatada;

                var diasSelecionados = document.querySelectorAll(".selected");
                diasSelecionados.forEach(function (dia) {
                    dia.classList.remove("selected");
                });

                elemento.classList.add("selected");

                var procedimento = document.getElementById("procedimento_desejado").value;

                // Carregar horários disponíveis
                carregarHorarios(procedimento, data, profissional);

                // Alterar layout para exibir lado a lado
                var container = document.querySelector(".container");
                container.classList.remove("container-centralizado");
                container.classList.add("container-lado-a-lado");

                var horarios = document.querySelector(".horarios");
                horarios.classList.add("horarios-ativo");

            } else {
                // CPF não cadastrado
                Swal.fire({
                    width: '450px',
                    icon: 'error',
                    iconColor: '#CF6F7A',
                    title: 'CPF não cadastrado',
                    text: 'O CPF informado não está cadastrado. Por favor, cadastre o cliente antes de continuar.',
                    confirmButtonColor: '#1A7F83',
                    confirmButtonText: 'Cadastrar Cliente'
                }).then((result) => {
                    if (result.isConfirmed) {
                        // Redireciona para a página de cadastro de cliente
                        window.location.href = "../atendente/cadastrarClienteAtendente.php";
                    }
                });
            }
        })
        .catch(error => {
            Swal.fire({
                width: '450px',
                icon: 'error',
                iconColor: '#CF6F7A',
                title: 'Erro ao verificar CPF',
                text: 'Ocorreu um problema ao verificar o CPF. Tente novamente mais tarde.',
                confirmButtonColor: '#1A7F83',
                confirmButtonText: 'OK'
            });
            console.error('Erro ao verificar o CPF:', error);
        });
}

function mostrarResumoAtendente(procedimentoId, profissionalCpf, data, horario) {
    const cpfCliente = document.getElementById('cpf_cliente').value;

    if (!cpfCliente) {
        Swal.fire({
            width: '450px',
            icon: 'warning',
            iconColor: '#CF6F7A',
            title: 'Atenção!',
            text: 'Por favor, insira o CPF do cliente antes de continuar.',
            confirmButtonColor: '#1A7F83',
            confirmButtonText: 'OK'
        });
        return;
    }

    fetch(`getDadosResumo.php?procedimento=${procedimentoId}&profissional=${encodeURIComponent(profissionalCpf)}&data=${data}&horario=${horario}&cpf_cliente=${encodeURIComponent(cpfCliente)}`)
        .then(response => {
            if (!response.ok) {
                throw new Error(`Erro HTTP: ${response.status}`);
            }
            return response.json();
        })
        .then(dados => {
            if (dados.error) {
                Swal.fire({
                    width: '450px',
                    icon: 'error',
                    iconColor: '#CF6F7A',
                    title: 'Erro!',
                    text: `Erro ao buscar os dados: ${dados.error}`,
                    confirmButtonColor: '#1A7F83',
                    confirmButtonText: 'OK'
                });
                return;
            }

            const partesData = dados.data.split('-');
            const dataFormatada = `${partesData[2]}/${partesData[1]}/${partesData[0]}`;

            const resumoDiv = document.createElement('div');
            resumoDiv.id = 'resumo-agendamento';
            resumoDiv.style.marginTop = '20px';

            resumoDiv.innerHTML = `
                <h3>Confirmação do agendamento:</h3>
                <p><strong>Cliente:</strong> ${dados.nome_cliente}</p>
                <p><strong>CPF do Cliente:</strong> ${dados.cpf_cliente}</p>
                <p><strong>Procedimento:</strong> ${dados.nome_procedimento}</p>
                <p><strong>Profissional:</strong> ${dados.apelido_esteticista}</p>
                <p><strong>Data:</strong> ${dataFormatada}</p>
                <p><strong>Horário:</strong> ${dados.horario}</p>
                <button id="confirmar-btn" onclick="confirmarAgendamento('${dados.nome_procedimento}', '${dados.apelido_esteticista}', '${dataFormatada}', '${dados.horario}')">Confirmar Agendamento</button>
            `;

            const resumoContainer = document.getElementById('resumo-container');
            resumoContainer.innerHTML = '';
            resumoContainer.appendChild(resumoDiv);
        })
        .catch(error => {
            Swal.fire({
                width: '450px',
                icon: 'error',
                iconColor: '#CF6F7A',
                title: 'Erro!',
                text: 'Erro ao buscar os dados do resumo. Verifique os detalhes no console.',
                confirmButtonColor: '#1A7F83',
                confirmButtonText: 'OK'
            });
            console.error('Erro ao buscar dados do resumo:', error);
        });
}

// Função para Confirmar Agendamento
function confirmarAgendamento(procedimento, profissional, data, horario) {
    const cpfClienteInput = document.getElementById('cpf_cliente');
    const cpfCliente = cpfClienteInput ? cpfClienteInput.value : '';

    if (!cpfCliente) {
        Swal.fire({
            width: '450px',
            icon: 'error',
            iconColor: '#CF6F7A',
            title: 'Erro!',
            confirmButtonColor: '#1A7F83',
            text: 'O CPF do cliente é obrigatório para confirmar o agendamento.',
            confirmButtonText: 'OK'
        });
        return;
    }

    const dadosAgendamento = {
        procedimento,
        profissional,
        data,
        horario,
        cliente: cpfCliente
    };

    fetch('cadastrarAgendamento.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify(dadosAgendamento)
    })
        .then(response => {
            if (!response.ok) {
                throw new Error(`Erro HTTP: ${response.status}`);
            }
            return response.json();
        })
        .then(data => {
            if (data.success) {
                Swal.fire({
                    width: '450px',
                    icon: 'success',
                    iconColor: '#1A7F83',
                    title: 'Sucesso!',
                    text: data.message,
                    confirmButtonColor: '#1A7F83',
                    confirmButtonText: 'OK'
                });
            } else {
                Swal.fire({
                    width: '450px',
                    icon: 'error',
                    iconColor: '#CF6F7A',
                    title: 'Erro no agendamento!',
                    text: data.message,
                    confirmButtonColor: '#1A7F83',
                    confirmButtonText: 'OK'
                });
            }
        })
        .catch(error => {
            Swal.fire({
                width: '450px',
                icon: 'error',
                iconColor: '#CF6F7A',
                title: 'Erro!',
                text: 'Erro ao processar o agendamento. Verifique os detalhes no console.',
                confirmButtonColor: '#1A7F83',
                confirmButtonText: 'OK'
            });
            console.error('Erro ao processar agendamento:', error);
        });
}
