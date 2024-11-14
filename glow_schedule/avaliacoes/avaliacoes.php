<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Avaliação</title>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css">
    <!-- Font Awesome para ícones de estrela -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css">
    <!-- SweetAlert2 para alertas estilizados -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <!-- Estilização padrão do web site -->
    <link rel="stylesheet" href="../css/style.css">
    <!-- Estilização do formulário de avaliação --> 
    <link rel="stylesheet" href="../css/avaliacao.css">
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
    <div class="container_avaliacao">
        <h2>Avaliar Serviço</h2>
        <label for="avaliacaoTipo">* Deseja avaliar:</label>
        <select id="avaliacaoTipo" class="input-esteticista" onchange="mostrarProfissionalSelect()">
            <option value="">* Escolha...</option>
            <option value="clinica">A Clínica</option>
            <option value="profissional">Profissional da Clínica</option>
        </select>

        <div id="profissionalSelect" class="profissional-select">
            <label for="esteticista">* Escolha o Profissional:</label>
            <select id="esteticista" class="input-esteticista">
                <!-- Opções carregadas dinamicamente -->
            </select>
        </div>

        <div class="stars"> 
            <input type="radio" name="star" id="star5" value="5"><label for="star5">★</label>
            <input type="radio" name="star" id="star4" value="4"><label for="star4">★</label>
            <input type="radio" name="star" id="star3" value="3"><label for="star3">★</label>
            <input type="radio" name="star" id="star2" value="2"><label for="star2">★</label>
            <input type="radio" name="star" id="star1" value="1"><label for="star1">★</label>
        </div>
        
        <input type="hidden" id="cpf_cliente" name="cpf_cliente" value="">

        <textarea id="review-text" class="review-text" placeholder="* Escreva sua avaliação aqui..."></textarea>
        <button class="submit-btn" onclick="cadastrarAvaliacao()">Enviar Avaliação</button>
    </div>
            <!-- Início do Footer-->
            <footer>
            <div id="footer_content">
                <div id="footer_contacts">
                    <a class="navbar-brand"><img class="rounded-circle ms-4" src="../logo/Logo.png" alt="Logo Care Tones" width="69px"></a>
                    <h3>Care Tones</h3>
                    <div id="footer_social_media">
                        <a href="#" class="footer-link" id="instagram"><i class="fa-brands fa-instagram"></i></a>
                        <a href="#" class="footer-link" id="facebook"><i class="fa-brands fa-facebook-f"></i></a>
                        <a href="#" class="footer-link" id="whatsapp"><i class="fa-brands fa-whatsapp"></i></a>
                        <a href="#" class="footer-link" id="localizacao"><i class="fa-solid fa-location-dot"></i></a>
                    </div>
                </div>
                <ul class="footer-list">
                    <li><h4 id="subtitulo-footer">Quem somos?</h4></li>
                    <li><a href="#" class="footer-link">Sobre nós</a></li>
                    <li><a href="#" class="footer-link">Clínica</a></li>
                    <li><a href="#" class="footer-link">Profissionais</a></li>
                </ul>
                <ul class="footer-list">
                    <li><h4 id="subtitulo-footer">Interesses</h4></li>
                    <li><a href="#" class="footer-link">Curiosidades</a></li>
                    <li><a href="#" class="footer-link">Promoções</a></li>
                    <li><a href="#" class="footer-link">Avaliações</a></li>
                </ul>
                <div id="footer_subscribe">
                    <h4 id="subtitulo-footer">Cadastre-se</h4>
                    <p>Cadastre-se, venha conhecer nosso trabalho e saber das novidades.</p>
                    <p>Estamos sempre disponiveis!</p>
                </div>
            </div>
            <div id="footer_copyright">
                &#169 2024 all rights reserved
            </div>
    </footer>
<script>
    // Carregar apelidos dos profissionais
    function carregarEsteticistas() {
        var xhr = new XMLHttpRequest();
        xhr.open('GET', 'buscarEsteticistas.php', true);
        
        xhr.onload = function() {
            if (xhr.status === 200) {
                var select = document.getElementById('esteticista');
                select.innerHTML = xhr.responseText;
            } else {
                Swal.fire({
                    icon: 'error',
                    title: 'Erro',
                    text: 'Erro ao carregar esteticistas.'
                });
            }
        };
        xhr.send();
    }

    // Mostrar ou ocultar o seletor de profissionais
    function mostrarProfissionalSelect() {
        var tipo = document.getElementById('avaliacaoTipo').value;
        var profissionalSelect = document.getElementById('profissionalSelect');
        profissionalSelect.classList.toggle('show', tipo === 'profissional');
    }

    // Captura o CPF do cliente da URL
    const cpf_cliente = new URLSearchParams(window.location.search).get('cpf_cliente');
    document.getElementById('cpf_cliente').value = cpf_cliente || '';

    // Função de cadastro da avaliação com SweetAlert e redirecionamento condicional
    function cadastrarAvaliacao() {
    var tipo = document.getElementById('avaliacaoTipo').value;
    var esteticistaSelect = document.getElementById('esteticista');
    var esteticista = (tipo === 'profissional') ? esteticistaSelect.value : 'Clínica';
    var stars = document.querySelector('input[name="star"]:checked');
    var reviewText = document.getElementById('review-text').value;

    // Verificação para todos os campos obrigatórios
    if (!tipo || tipo === 'Escolha uma opção' || !stars || reviewText.trim() === '' || (tipo === 'profissional' && (!esteticista || esteticista === 'Escolha o Profissional'))) {
        Swal.fire({
            icon: 'warning',
            title: 'Campos incompletos',
            text: 'Por favor, preencha todos os campos obrigatórios!\n Selecione quem deseja avaliar, a nota com estrelas e escreva um comentário.',
            confirmButtonText: 'OK'
        });
        return;
    }

        var xhr = new XMLHttpRequest();
        xhr.open('POST', 'cadastrarAvaliacao.php', true);
        xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');

        xhr.onload = function () {
            if (xhr.status === 200) {
                var redirecionamento;
                if (tipo === 'clinica') {
                    redirecionamento = '/glow_schedule/cliente/sobreNos.php';
                } else if (tipo === 'profissional') {
                    redirecionamento = `/glow_schedule/esteticista/esteticistasInfo.php?apelido_esteticista=${encodeURIComponent(esteticista)}`;
                }

                Swal.fire({
                    icon: xhr.responseText === 'Obrigada pela avaliação!' ? 'success' : 'error',
                    title: xhr.responseText === 'Obrigada pela avaliação!' ? 'Avaliação enviada!' : 'Erro ao enviar a avaliação',
                    text: xhr.responseText,
                    confirmButtonText: 'OK'
                }).then((result) => {
                    if (result.isConfirmed && redirecionamento) {
                        // Redirecionar após o alerta
                        window.location.href = redirecionamento;
                    }
                });
            } else {
                Swal.fire({
                    icon: 'error',
                    title: 'Erro',
                    text: 'Erro na requisição: Status ' + xhr.status,
                    confirmButtonText: 'OK'
                });
            }
        };

        xhr.send('tipo=' + tipo + '&stars=' + stars.value + '&reviewText=' + encodeURIComponent(reviewText) + '&cpf_cliente=' + cpf_cliente + '&avaliado=' + encodeURIComponent(esteticista));
        document.querySelector('input[name="star"]:checked').checked = false;
        document.getElementById('review-text').value = '';
        document.getElementById('avaliacaoTipo').value = 'clinica';
        mostrarProfissionalSelect();
    }

    // Inicializa a lista de esteticistas
    carregarEsteticistas();
</script>
</body>
</html>
