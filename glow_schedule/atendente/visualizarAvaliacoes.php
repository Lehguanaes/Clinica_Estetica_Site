<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Consultas Agendadas</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="../css/style.css">
    <link rel="stylesheet" href="../css/perfil.css">
    <link rel="stylesheet" href="../css/filtro.css">
    <link rel="stylesheet" href="../css/carrosselAvaliacoes.css">
    <link rel="stylesheet" href="../css/navbar.css">
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="../js/navbar.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body>
    <!-- Navbar -->
    <header>
        <nav class="nav-bar">
            <a class="logo" href="Home.html"><img src="../logo/Logo.png" class="logoIMG">Care Tones</a>
            <ul class="nav-list">
                <li><a href="visualizarConsultas.php" class="nav">Agenda</a></li>
                <li><a href="visualizarDuvidas.php" class="nav">Dúvidas</a></li>
                <li><a href="visualizarAvaliacoes.php" class="nav">Avaliações</a></li>
                <li><a href="../agendamentoAtendente/cadastrarAgendamentoAtendente.php" class="nav">Agendar Consulta</a></li>
                <li><a href="../esteticista/esteticistas.php" class="nav">Esteticistas</a></li>
            </ul>
            <div class="dropdown">
                <div class="login-icon">
                    <a href="perfilAtendente.php">
                        <i class="fa-solid fa-circle-user fa-xl" style="color: #fff;"></i>
                    </a>
                    <div class="dropdown-content">
                        <a href="perfilAtendente.php"><i class="fa-solid fa-right-to-bracket" style="color: #cf6f7a;"></i> Perfil </a>
                        <a href="../esteticista/cadastroEsteticista.php"><i class="fa-solid fa-address-card" style="color: #cf6f7a;"></i> Cadastrar Esteticista </a>
                        <a href="../cliente/cadastrarCliente.php"><i class="fa-solid fa-address-card" style="color: #cf6f7a;"></i> Cadastrar Cliente </a>
                        <a href="../procedimento/cadastrarProcedimento.php"><i class="fa-solid fa-address-card" style="color: #cf6f7a;"></i> Cadastrar Procedimento </a>
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
        <div class="swiper-pagination"></div>
        <div>&nbsp;</div>
    </div>
    <!-- SwiperJS Script -->
    <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
    <script src="../js/carrosselAvaliacao.js"></script>
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
