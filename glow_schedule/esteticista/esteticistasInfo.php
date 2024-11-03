<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Care Tones</title>
    <!-- Links externos -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css" integrity="sha512-MV7K8+y+gLIBoVD59lQIYicR65iaqukzvf/nwasF0nqhPay5w/9lJmVM2hMDcnK1OnMGCdVK+iQrJ7lzPJQd1w==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.16/jquery.mask.min.js"></script>
    <integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <!-- Estilização padrão do web site -->
    <link rel="stylesheet" href="../css/style.css">
</head>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.min.js" integrity="sha384-cuYeSxntonz0PPNlHhBs68uyIAVpIIOZZ5JqeqvYYIcEL727kskC66kF92t6Xl2V" crossorigin="anonymous"></script>
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
    <!-- Exibição do Esteticista -->
    <div id="Profissionais">
        <?php
        // Atualize o caminho do arquivo de conexão com o banco de dados
        require_once $_SERVER['DOCUMENT_ROOT'] . "/glow_schedule/controller/conexao.php";

        // Obtém o cpf_esteticista da URL
        $cpf_esteticista = isset($_GET['cpf_esteticista']) ? $_GET['cpf_esteticista'] : '';

        // Cria uma nova instância da classe Conexao e obtém a conexão
        $conexao = new Conexao();
        $conn = $conexao->getConexao(); // Certifique-se de que isso retorna um objeto de conexão válido

        // Consulta SQL para buscar as informações do esteticista específico
        $sql = "SELECT * FROM esteticista WHERE cpf_esteticista = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("s", $cpf_esteticista);
        $stmt->execute();
        $result = $stmt->get_result();

        // Verifica se há resultados
        if ($result->num_rows > 0) {
            // Obtém as informações do esteticista
            $row = $result->fetch_assoc();
            echo '<h2 style="color: #CF6F7A; text-align: center; margin-top:10px; margin-bottom: 35px;">' . htmlspecialchars($row['nome_esteticista']) . '</h2>';
            echo '<div class="card mb-1" style="max-width: 1000px; margin-left: 10%; border: none;";>';
            echo '<div class="row g-0">';
            echo '<div class="col-md-3" style="margin-bottom: 50px;">';
            echo '<img src="' . (file_exists($_SERVER['DOCUMENT_ROOT'] . "/glow_schedule/" . $row['foto_esteticista']) ? "/glow_schedule/" . htmlspecialchars($row['foto_esteticista']) : "/glow_schedule/uploads/default.jpg") . '" alt="Foto do Esteticista" style="width:100%; height:auto;">';
            echo '</div>';
            echo '<div class="col-md-8" style="margin-top: 30px; margin-left: 3%;">';
            echo '<p style="margin-bottom: 1px;"><img src="../iconesProfissionais/Graduado.png" alt="Graduado" width="25px"> ' . htmlspecialchars($row['formacao_esteticista']) . '</p>'; 
            echo '<p style="margin-top: 3px; margin-left: 2px; margin-bottom: 4px;"><img src="../iconesProfissionais/Insta.png" alt="instagram" width="16px" style="margin-right: 5px;"> ' . htmlspecialchars($row['instagram_esteticista']) . '</p>'; 
            echo '<p style="margin-top: 3px; margin-left: 2px; margin-bottom: 4px;"><img src="../iconesProfissionais/Link.png" alt="Linkedin" width="16px" style="margin-right: 5px;"> ' . htmlspecialchars($row['linkedin_esteticista']) . '</p>'; 
            echo '<p style="margin-top: 3px; margin-left: 2px; margin-bottom: 4px;"><img src="../iconesProfissionais/Link.png" alt="Facebook" width="16px" style="margin-right: 5px;"> ' . htmlspecialchars($row['facebook_esteticista']) . '</p>';
            echo '&nbsp;';
            echo '<p class="card-text" style="color: black;">' . htmlspecialchars($row['descricao_g_esteticista']) . '</p>';
            echo '</div>';
            echo '</div>';
            echo '</div>';   
        } else {
            echo '<h2 style="color: #CF6F7A; text-align: center; margin-top:10px; margin-bottom: 35px;">Esteticista não encontrado</h2>';
        }
        // Fecha a conexão com o banco de dados
        $stmt->close();
        $conn->close();
        ?>
    </div>
    <h4 style="color: #18676C;margin-top: 20px; margin-left: 75px;">Avaliações</h4>
    <div class="container mt-5 mb-5">
        <div class="row">
            <div class="col-md-3">
                <div class="card text-center">
                    <div class="card-body" style="background-color: #EDF0F2;">
                        <h5 class="card-title">João Flausino</h5>
                        <p class="card-text">Me ajudaram com a minha flacidez, obrigado!</p>
                        <span class="fa fa-star checked"></span>
                        <span class="fa fa-star checked"></span>
                        <span class="fa fa-star checked"></span>
                        <span class="fa fa-star"></span>
                        <span class="fa fa-star"></span>
                    </div>
                </div>
                <br>
            </div>
            <div class="col-md-3">
                <div class="card text-center">
                    <div class="card-body" style="background-color: #EDF0F2;">
                        <h5 class="card-title">Carol Feitosa</h5>
                        <p class="card-text">Tomaram cuidado comigo, muito bom.</p>
                        <span class="fa fa-star checked"></span>
                        <span class="fa fa-star checked"></span>
                        <span class="fa fa-star checked"></span>
                        <span class="fa fa-star checked"></span>
                        <span class="fa fa-star"></span>
                    </div>
                </div>
                <br>
            </div>
            <div class="col-md-3">
                <div class="card text-center">
                    <div class="card-body" style="background-color: #EDF0F2;">
                        <h5 class="card-title">Ana Paula</h5>
                        <p class="card-text">Ótima experiência, super recomendo!</p>
                        <span class="fa fa-star checked"></span>
                        <span class="fa fa-star checked"></span>
                        <span class="fa fa-star checked"></span>
                        <span class="fa fa-star checked"></span>
                        <span class="fa fa-star checked"></span>
                    </div>
                </div>
                <br>
            </div>
            <div class="col-md-3">
                <div class="card text-center">
                    <div class="card-body" style="background-color: #EDF0F2;">
                        <h5 class="card-title">Luciana Silva</h5>
                        <p class="card-text">Ambiente agradável e profissionais atenciosos.</p>
                        <span class="fa fa-star checked"></span>
                        <span class="fa fa-star checked"></span>
                        <span class="fa fa-star checked"></span>
                        <span class="fa fa-star checked"></span>
                        <span class="fa fa-star checked"></span>
                    </div>
                </div>
                <br>
            </div>
        </div>
    </div>
</body>
</html>
