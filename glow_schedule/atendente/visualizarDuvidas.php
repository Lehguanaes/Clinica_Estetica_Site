<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dúvidas Recebidas</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="../css/style.css">
    <link rel="stylesheet" href="../css/perfil.css">
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <style> 
        /* Ajustes para o ícone e opções do filtro */
        .filter-container {
            position: relative;
            display: inline-block;
            margin: 15px;
            font-size: 1.5em;
            color: #1A7F83;
        }

        /* Adiciona transição suave ao exibir as opções */
        .filter-container:hover .filter-options {
            display: block;
            opacity: 1;
            transform: translateY(0); /* Move para a posição final */
            transition: opacity 0.6s ease, transform 0.9s ease; /* Controla a transição */
        }

        .filter-options {
            display: none;
            position: absolute;
            top: 100%;
            left: 0;
            background-color:  #1A7F83;
            box-shadow: 0px 8px 16px rgba(0, 0, 0, 0.2);
            border-radius: 5px;
            overflow: hidden;
            width: 140px; /* Aumenta o tamanho do menu */
            transition: opacity 0.3s ease, transform 0.3s ease;
            transform: translateY(-10px);
            opacity: 0;
            z-index: 1;
        }

        .filter-container.active .filter-options {
            display: block;
            opacity: 1;
            transform: translateY(0);
        }

        .filter-options button {
            width: 100%;
            padding: 15px; /* Aumenta o tamanho do botão */
            text-align: left;
            background: none;
            border: none;
            font-size: 16px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        .filter-options button:hover {
            opacity: 1;
        }

        /* Estilo para o card e transição */
        .card-corpo-dicas {
            margin: 15px 0;
            padding: 20px;
            border: 1px solid #ddd;
            border-radius: 8px;
            box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.1);
        }

        .mensagem-expandida {
            max-height: 0;
            overflow: hidden;
            transition: max-height 0.5s ease;
        }

        .mensagem-expandida.show {
            max-height: 500px;
        }
    </style>
</head>
<body>
    <div id="Duvidas">
        <h2>Dúvidas Recebidas</h2>
        <!-- Mensagem de instruções do filtro -->
        <div class="container">
            <!-- Container de filtro com ícone e opções -->
            <div class="filter-container">
                <i class="fas fa-filter" onclick="toggleFilterOptions()" title="Filtrar dúvidas"> </i>Filtrar dúvidas
                <div class="filter-options">
                    <button onclick="filtrarDuvidas('ativado')" class="btn btn-info">Dúvidas Não Respondidas</button>
                    <button onclick="filtrarDuvidas('desativado')" class="btn btn-secondary">Dúvidas Respondidas</button>
                </div>
            </div>
        </div>

        <div class="container-cards-home" id="duvidasContainer">
            <?php
                require_once $_SERVER['DOCUMENT_ROOT'] . "/glow_schedule/controller/conexao.php";
                $conexao = new Conexao();
                $conn = $conexao->getConexao();
                $status = $_GET['status'] ?? 'ativado';
                $status_escaped = mysqli_real_escape_string($conn, $status);
                $sql_duvidas = "
                    SELECT id, nome, telefone, objetivo, mensagem, data_envio, status
                    FROM duvidas 
                    WHERE status = '$status_escaped' 
                    ORDER BY data_envio DESC
                ";
                $result_duvidas = mysqli_query($conn, $sql_duvidas);

                if ($result_duvidas && mysqli_num_rows($result_duvidas) > 0) {
                    while ($duvida = mysqli_fetch_assoc($result_duvidas)) {
                        echo "
                        <div class='card-corpo-dicas' id='duvidaCard{$duvida['id']}'>
                            <h5 class='card-title'>Dúvida de {$duvida['nome']}</h5>
                            <p>Telefone: {$duvida['telefone']}</p>
                            <p>Objetivo: {$duvida['objetivo']}</p>
                            <p>Data de Envio: {$duvida['data_envio']}</p>
                            <button onclick='lerDuvida({$duvida['id']})' class='btn-leitura' id='lerDuvida{$duvida['id']}'>Ler Dúvida</button>
                            <div id='mensagemCompleta{$duvida['id']}' class='mensagem-expandida'>
                                <p>{$duvida['mensagem']}</p>";
                                
                        if ($duvida['status'] === 'ativado') {
                            echo "<button onclick='marcarComoRespondida({$duvida['id']})' class='btn-respondida'>Marcar como Respondida</button>";
                        }
                        echo "</div>&nbsp;</div>";
                    }
                } else {
                    echo "<p>Não há dúvidas nesta categoria.</p>";
                }
                mysqli_close($conn);
            ?>
        </div>
    </div>

    <script>
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
    </script>
</body>
</html>