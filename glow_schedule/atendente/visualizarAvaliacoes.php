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
    <!-- Links externos -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css" integrity="sha512-MV7K8+y+gLIBoVD59lQIYicR65iaqukzvf/nwasF0nqhPay5w/9lJmVM2hMDcnK1OnMGCdVK+iQrJ7lzPJQd1w==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <!-- Estilização padrão do web site -->
    <link rel="stylesheet" href="../css/style.css">
    <!-- Estilização formulários de Perfis -->
    <link rel="stylesheet" href="../css/perfil.css">
    <!-- Estilização Filtro -->
    <link rel="stylesheet" href="../css/filtro.css">
    <!-- Estilização Avaliações -->
    <link rel="stylesheet" href="../css/carrosselAvaliacoes.css">
    <!-- Estilização Navbar -->
    <link rel="stylesheet" href="../css/navbar.css">
</head>
<body>
    <!-- Início da Navbar -->
    <header>
        <nav class="nav-bar">
            <a class="logo" href="#"><img src="../logo/Logo.png" class="logoIMG">Care Tones</a>
            <ul class="nav-list">
                <li><a href="visualizarDuvidas.php" class="nav">Dúvidas</a></li>
                <li><a href="visualizarAvaliacoes.php" class="nav">Avaliações</a></li>
                <li><a href="../procedimento/consultarProcedimento.php" class="nav">Procedimentos</a></li>
                <li><a href="visualizarConsultas.php" class="nav">Agenda</a></li>
                <li><a href="../agendamentoAtendente/agendamento.php" class="nav">Agendamento</a></li>
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
                        <a href="../atendente/consultarEsteticista.php"><i class="fa-solid fa-user-doctor" style="color: #cf6f7a;"></i> Profissionais </a>
                        <a href="../procedimento/consultarProcedimento.php"><i class="fa-brands fa-shopify" style="color: #cf6f7a;"></i> Procedimentos </a>
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
    <!-- Título -->
    <h2>Avaliações da Clínica</h2>
        <!-- Swiper para avaliações -->
        <div class="swiper">
        <div class="swiper-wrapper">
            <?php
            require_once $_SERVER['DOCUMENT_ROOT'] . '/glow_schedule/controller/conexao.php';

            $conexao = new Conexao();
            $conn = $conexao->getConexao();

            function formatarData($data) {
                $meses = [
                    '01' => 'janeiro', '02' => 'fevereiro', '03' => 'março',
                    '04' => 'abril', '05' => 'maio', '06' => 'junho',
                    '07' => 'julho', '08' => 'agosto', '09' => 'setembro',
                    '10' => 'outubro', '11' => 'novembro', '12' => 'dezembro'
                ];
                $dia = date('d', strtotime($data));
                $mes = $meses[date('m', strtotime($data))];
                $ano = date('Y', strtotime($data));
                return "{$dia} de {$mes} de {$ano}";
            }

            $sql_avaliacoes = "
                SELECT a.id_avaliacao, a.estrelas_avaliacao, a.comentario_avaliacao, a.data_criacao_avaliacao, 
                    c.nome_cliente, c.foto_cliente
                FROM Avaliacoes a
                JOIN Cliente c ON a.cpf_cliente = c.cpf_cliente
                WHERE a.avaliado = 'clinica'";

            $stmt_avaliacoes = $conn->prepare($sql_avaliacoes);

            if ($stmt_avaliacoes) {
                $stmt_avaliacoes->execute();
                $result_avaliacoes = $stmt_avaliacoes->get_result();

                if ($result_avaliacoes->num_rows > 0) {
                    while ($avaliacao = $result_avaliacoes->fetch_assoc()) {
                        echo '<div class="swiper-slide">';
                        echo '    <div class="card-review">';
                        echo '        <img src="' . 
                        (isset($avaliacao['foto_cliente']) && file_exists($_SERVER['DOCUMENT_ROOT'] . "/glow_schedule/uploads/" . $avaliacao['foto_cliente']) 
                            ? "/glow_schedule/uploads/" . htmlspecialchars($avaliacao['foto_cliente']) 
                            : "../iconesPerfil/perfilPadrao.png") . 
                        '" alt="Foto do Cliente" class="avatar mb-3">';
                        echo '        <p class="text-muted small">' . formatarData($avaliacao['data_criacao_avaliacao']) . '</p>';
                        echo '        <h5 class="card-title">' . htmlspecialchars($avaliacao['nome_cliente']) . '</h5>';
                        echo '        <p class="card-text">' . htmlspecialchars($avaliacao['comentario_avaliacao']) . '</p>';
                        echo '        <div class="star-rating mb-2">';
                        for ($i = 0; $i < 5; $i++) {
                            echo $i < $avaliacao['estrelas_avaliacao'] ? '<span class="fa fa-star"></span>' : '<span class="fa fa-star-o"></span>';
                        }
                        echo '        </div>';
                        echo '        <button class="btn delete-btn" data-id="' . $avaliacao['id_avaliacao'] . '">Deletar</button>';
                        echo '    </div>';
                        echo '</div>';
                    }
                } else {
                    echo '<div class="swiper-slide">';
                    echo '    <div class="card-review">';
                    echo '        <p class="card-text text-muted">Nenhuma avaliação disponível no momento.</p>';
                    echo '    </div>';
                    echo '</div>';
                }

                $stmt_avaliacoes->close();
            } else {
                echo "Erro ao preparar a consulta: " . $conn->error;
            }

            $conn->close();
            ?>
        </div>
    </div>
    <h2>Avaliações dos Profissionais</h2>
    <!-- Formulário para seleção de esteticista -->
    <form id="form-selecao-esteticista">
        <label for="apelido_esteticista">Por favor, selecione o Profissional:</label>
        <select name="apelido_esteticista" id="apelido_esteticista" required>
            <option value="" disabled selected>Escolha...</option>
            <?php
            require_once $_SERVER['DOCUMENT_ROOT'] . '/glow_schedule/controller/conexao.php';
            
            try {
                $conexao = new Conexao();
                $conn = $conexao->getConexao();

                // Recupera os esteticistas e exibe no select
                $sql_esteticistas = "SELECT apelido_esteticista, nome_esteticista FROM esteticista";
                $result_esteticistas = $conn->query($sql_esteticistas);

                if ($result_esteticistas && $result_esteticistas->num_rows > 0) {
                    while ($esteticista = $result_esteticistas->fetch_assoc()) {
                        echo '<option value="' . htmlspecialchars($esteticista['apelido_esteticista'], ENT_QUOTES, 'UTF-8') . '">'
                            . htmlspecialchars($esteticista['nome_esteticista'], ENT_QUOTES, 'UTF-8') . '</option>';
                    }
                } else {
                    echo '<option value="" disabled>Nenhum esteticista encontrado</option>';
                }
            } catch (Exception $e) {
                echo '<option value="" disabled>Erro ao carregar esteticistas</option>';
            } finally {
                if (isset($conn)) {
                    $conn->close();
                }
            }
            ?>
        </select>
    </form>
    <!-- Swiper para exibir as avaliações -->
    <div class="swiper">
        <div class="swiper-wrapper" id="avaliacoes-container">
            <div class="swiper-slide">
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
    <!-- SwiperJS Script -->
    <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
    <!-- Link Sweet Alert -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <!-- Link Js Carrossel -->
    <script src="../js/carrosselAvaliacao.js"></script>
    <!-- Link Js Navbar -->
    <script src="../js/navbar.js"></script>
    <script>
        $(document).on('click', '.delete-btn', function() {
            const idAvaliacao = $(this).data('id');
            Swal.fire({
                width: '450px',
                title: 'Tem certeza?',
                text: "Você não poderá reverter essa ação!",
                icon: 'warning',
                iconColor: '#CF6F7A',
                showCancelButton: true,
                showCancelButton: true,
                confirmButtonColor: '#1A7F83',
                cancelButtonColor: '#CF6F7A',
                confirmButtonText: 'Sim, deletar!',
                cancelButtonText: 'Cancelar',
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: 'deletarAvaliacao.php',
                        type: 'POST',
                        data: { id: idAvaliacao },
                        success: function(response) {
                            if (response === 'sucesso') {
                                Swal.fire(
                                    'Deletado!',
                                    'A avaliação foi deletada.',
                                    'success'
                                ).then(() => location.reload());
                            } else {
                                Swal.fire(
                                    'Erro!',
                                    'Não foi possível deletar a avaliação.',
                                    'error'
                                );
                            }
                        },
                        error: function() {
                            Swal.fire(
                                'Erro!',
                                'Houve um problema com a solicitação.',
                                'error'
                            );
                        }
                    });
                }
            });
        });
    </script>
</body>
</html>
