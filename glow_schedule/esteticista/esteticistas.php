<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Care Tones</title>
    <link rel="stylesheet" href="../css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css" integrity="sha512-MV7K8+y+gLIBoVD59lQIYicR65iaqukzvf/nwasF0nqhPay5w/9lJmVM2hMDcnK1OnMGCdVK+iQrJ7lzPJQd1w==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.16/jquery.mask.min.js"></script>
    <integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
</head>
<body>
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
    <div id="Profissionais">
        <h2>Profissionais</h2>
        <div class="container-cards-home">
                <?php
                // Atualize o caminho do arquivo de conexão com o banco de dados
                require_once $_SERVER['DOCUMENT_ROOT'] . "/glow_schedule/controller/conexao.php";

                // Cria uma nova instância da classe Conexao e obtém a conexão
                $conexao = new Conexao();
                $conn = $conexao->getConexao();

                // Consulta SQL para buscar todos os esteticistas
                $sql = "SELECT * FROM esteticista";
                $result = $conn->query($sql);

                // Verifica se há resultados
                if ($result->num_rows > 0) {
                    // Exibe os dados de cada esteticista em formato de cartão
                    while ($row = $result->fetch_assoc()) {
                        echo '<div class="col-md-4 mb-4">';
                        echo '<div class="card-corpo-dicas">';
                        echo '<div class="imagem-card-home">';
                        echo '<img src="' . (file_exists($_SERVER['DOCUMENT_ROOT'] . "/glow_schedule/" . $row['foto_esteticista']) ? "/glow_schedule/" . htmlspecialchars($row['foto_esteticista']) : "/glow_schedule/uploads/default.jpg") . '" alt="Foto do Esteticista" style="width:100%; height:auto;">';
                        echo '</div>';
                        echo '<div class="card-texto-home p-3">';
                        echo '<h5>' . htmlspecialchars($row['apelido_esteticista']) . '</h5>'; // Apelido do esteticista
                        echo '<p>' . htmlspecialchars($row['descricao_p_esteticista']) . '</p>'; // Descrição do esteticista
                        echo '<div class="botao-card">';
                        echo '<a href="esteticistasInfo.php?cpf_esteticista=' . urlencode($row['cpf_esteticista']) . '" class="btn btn-primary">Saiba mais</a>';
                        echo '</div>';
                        echo '</div>';
                        echo '</div>'; // Fecha card
                        echo '</div>'; // Fecha coluna
                    }
                } else {
                    echo '<p>Nenhum esteticista encontrado.</p>';
                }
                // Fecha a conexão com o banco de dados
                $conn->close();
                ?>
        </div>
    </div>

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
                <p>Cadastre-se, venha conhecer nosso trabalho e saber das novidades!</p>
                <div id="input_group">
                    <input type="email" id="email">
                    <button><i class="fa-regular fa-envelope"></i></button>
                </div>
            </div>
        </div>
        <div id="footer_copyright">
            &#169 2023 all rights reserved
        </div>
    </footer>
</body>
</html>