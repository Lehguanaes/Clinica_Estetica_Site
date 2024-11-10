function enviarDuvida() {
    // Coleta os dados do formulário
    const formData = new FormData(document.getElementById('formDuvida'));

    // Envia os dados via AJAX
    fetch('cadastrarDuvida.php', {
        method: 'POST',
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        // Exibe a mensagem de resposta ao usuário
        document.getElementById('mensagemResposta').innerText = data.message;

        if (data.success) {
            // Limpa o formulário se a inserção foi bem-sucedida
            document.getElementById('formDuvida').reset();
        }
    })
    .catch(error => {
        document.getElementById('mensagemResposta').innerText = 'Erro ao enviar a mensagem. Tente novamente.';
    });
}
// Exibir/ocultar menu de filtro
function toggleFilterOptions() {
    document.querySelector('.filter-container').classList.toggle('active');
}

// Filtrar dúvidas conforme o status selecionado
function filtrarDuvidas(status) {
    window.location.href = '?status=' + status;
}

// Exibir a mensagem completa com transição suave
function lerDuvida(id) {
    const mensagemCompleta = document.getElementById('mensagemCompleta' + id);
    mensagemCompleta.classList.toggle('show');
    document.getElementById('lerDuvida' + id).style.display = 'none';
}

function marcarComoRespondida(id) {
    if (confirm("Tem certeza que deseja marcar esta dúvida como respondida?")) {
        fetch('atualizarDuvida.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded'
            },
            body: 'id=' + id
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                document.getElementById('duvidaCard' + id).remove();
            } else {
                alert('Erro ao atualizar a dúvida.');
            }
        })
        .catch(error => {
            console.error('Erro:', error);
            alert('Erro ao atualizar a dúvida.');
        });
    }
}

// Fechar o menu de filtro ao clicar fora dele
document.addEventListener('click', function(event) {
    const filterContainer = document.querySelector('.filter-container');
    if (!filterContainer.contains(event.target)) {
        filterContainer.classList.remove('active');
    }
});