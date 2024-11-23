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
    const apelidoEsteticista = this.value; // Captura o apelido
    if (!apelidoEsteticista) {
        // Exibe alerta com SweetAlert2
        Swal.fire({
            icon: 'warning',
            iconColor: '#CF6F7A',
            title: 'Seleção inválida!',
            confirmButtonColor: '#1A7F83',
            text: 'Por favor, selecione um esteticista válido.',
        });
        return;
    }

    // Envia a solicitação AJAX com o apelido do esteticista
    fetch('/glow_schedule/atendente/getAvaliacoes.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
        },
        body: JSON.stringify({ apelido_esteticista: apelidoEsteticista }), // Envia o apelido
    })
    .then(response => response.json())
    .then(data => {
        const container = document.getElementById('avaliacoes-container');
        container.innerHTML = ''; // Limpa o container de avaliações

        if (data.error) {
            // Exibe mensagem de erro com SweetAlert2
            Swal.fire({
                icon: 'error',
                iconColor: '#CF6F7A',
                title: 'Erro!',
                iconColor: '#CF6F7A',
                text: data.error,
            });

            container.innerHTML = `
                <div class="swiper-slide">
                    <div class="card-review">
                        <p class="card-text text-muted">${data.error}</p>
                    </div>
                </div>`;
        } else if (data.length > 0) {
            // Exibe as avaliações
            data.forEach(avaliacao => {
                const slide = document.createElement('div');
                slide.classList.add('swiper-slide');
                slide.innerHTML = `
                    <div class="card-review">
                        <img src="${avaliacao.foto_cliente}" alt="Foto do Cliente" class="avatar mb-3">
                        <p class="text-muted small">${avaliacao.data_criacao_avaliacao}</p>
                        <h5 class="card-title">${avaliacao.nome_cliente}</h5>
                        <p class="card-text">${avaliacao.comentario_avaliacao}</p>
                        <div class="star-rating mb-2">
                            ${'★'.repeat(avaliacao.estrelas_avaliacao).split('').map(() => '<span class="fa fa-star"></span>').join('')}
                            ${'☆'.repeat(5 - avaliacao.estrelas_avaliacao).split('').map(() => '<span class="fa fa-star"></span>').join('')}
                        </div>
                        <!-- Botão para deletar -->
                        <button class="btn delete-btn" data-id="${avaliacao.id_avaliacao}">Deletar</button>
                    </div>`;
                container.appendChild(slide);
            });
        } else {
            // Caso não haja avaliações
            Swal.fire({
                icon: 'info',
                title: 'Nenhuma avaliação encontrada!',
                iconColor: '#CF6F7A',
                text: 'Este esteticista ainda não possui avaliações.',
            });

            container.innerHTML = `
                <p class="card-text text-muted">Nenhuma avaliação disponível para este esteticista.</p>
            `;
        }
    })
    .catch(error => {
        // Exibe erro genérico com SweetAlert2
        Swal.fire({
            icon: 'error',
            iconColor: '#CF6F7A',
            iconColor: '#CF6F7A',
            title: 'Erro ao buscar avaliações!',
            text: 'Ocorreu um problema ao buscar as avaliações. Por favor, tente novamente mais tarde.',
        });
        console.error('Erro ao buscar avaliações:', error);
    });
});
