// Carrossel de Avaliações com Swiper
const swiper = new Swiper('.swiper', {
    slidesPerView: 3,
    spaceBetween: 20,
    navigation: {
        nextEl: '.swiper-button-next',
        prevEl: '.swiper-button-prev',
    },
    pagination: {
        el: '.swiper-pagination',
        clickable: true,
    },
    breakpoints: {
        0:{
            slidesPerView:1
        },
        685: {
            slidesPerView: 2,
        },
        1024: {
            slidesPerView: 3,
        },
        1400: {
            slidesPerView: 4,
        },
    }
});

// Evento para capturar a seleção do esteticista
document.getElementById('apelido_esteticista').addEventListener('change', function () {
    const apelidoEsteticista = this.value; // Captura o apelido do esteticista

    if (!apelidoEsteticista) {
        // Alerta de seleção inválida
        Swal.fire({
            icon: 'warning',
            iconColor: '#CF6F7A',
            title: 'Seleção inválida!',
            confirmButtonColor: '#1A7F83',
            text: 'Por favor, selecione um esteticista válido.',
        });
        return;
    }

    // Envia a solicitação para buscar avaliações do esteticista selecionado
    fetch('/glow_schedule/atendente/getAvaliacoes.php', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify({ apelido_esteticista: apelidoEsteticista }),
    })
        .then(response => response.json())
        .then(data => {
            const container = document.getElementById('avaliacoes-container');
            container.innerHTML = ''; // Limpa o container de avaliações

            if (data.error) {
                // Alerta de erro com mensagem personalizada
                Swal.fire({
                    icon: 'error',
                    iconColor: '#CF6F7A',
                    title: 'Erro!',
                    text: data.error,
                });

                container.innerHTML = `
                    <div class="swiper-slide">
                        <div class="card-review">
                            <p class="card-text text-muted">${data.error}</p>
                        </div>
                    </div>`;
                return;
            }

            if (data.length > 0) {
                // Renderiza as avaliações
                data.forEach(avaliacao => {
                    const slide = document.createElement('div');
                    slide.classList.add('swiper-slide');

                    // Calcula estrelas
                    const estrelasCheias = '<span class="fa fa-star"></span>'.repeat(avaliacao.estrelas_avaliacao);
                    const estrelasVazias = '<span class="fa fa-star-o"></span>'.repeat(5 - avaliacao.estrelas_avaliacao);

                    slide.innerHTML = `
                        <div class="card-review">
                            <img src="${avaliacao.foto_cliente || '../iconesPerfil/perfilPadrao.png'}" 
                                alt="Foto do Cliente" class="avatar mb-3">
                            <p class="text-muted small">${formatarData(avaliacao.data_criacao_avaliacao)}</p>
                            <h5 class="card-title">${avaliacao.nome_cliente}</h5>
                            <p class="card-text">${avaliacao.comentario_avaliacao}</p>
                            <div class="star-rating mb-2">
                                ${estrelasCheias + estrelasVazias}
                            </div>
                            <button class="btn delete-btn" data-id="${avaliacao.id_avaliacao}">Deletar</button>
                        </div>`;
                    container.appendChild(slide);
                });
            } else {
                // Alerta para quando não há avaliações
                Swal.fire({
                    icon: 'info',
                    title: 'Nenhuma avaliação encontrada!',
                    iconColor: '#CF6F7A',
                    confirmButtonColor: '#CF6F7A',
                    text: 'Este esteticista ainda não possui avaliações.',
                });

                container.innerHTML = `
                    <p class="card-text text-muted" style="color: #cf6f7a; font-size:18px; text-align:center;">Nenhuma avaliação disponível para este esteticista.</p>
                `;
            }
        })
        .catch(error => {
            // Alerta de erro genérico
            Swal.fire({
                icon: 'error',
                iconColor: '#CF6F7A',
                confirmButtonColor: '#CF6F7A',
                title: 'Erro ao buscar avaliações!',
                text: 'Ocorreu um problema ao buscar as avaliações. Por favor, tente novamente mais tarde.',
            });
            console.error('Erro ao buscar avaliações:', error);
        });
});

// Função para formatar a data
function formatarData(data) {
    // Cria um objeto Date a partir da string da data
    const date = new Date(data);

    // Verifica se a data é válida
    if (isNaN(date)) {
        console.error('Data inválida:', data);
        return 'Data inválida'; // Retorna uma mensagem de erro, se a data for inválida
    }

    // Mapeamento dos meses em português
    const meses = [
        'janeiro', 'fevereiro', 'março', 'abril', 'maio', 'junho',
        'julho', 'agosto', 'setembro', 'outubro', 'novembro', 'dezembro'
    ];

    // Obtém o dia, mês e ano
    const dia = date.getDate();
    const mes = meses[date.getMonth()];
    const ano = date.getFullYear();

    // Retorna a data formatada no formato "dia de mês de ano"
    return `${dia} de ${mes} de ${ano}`;
}
