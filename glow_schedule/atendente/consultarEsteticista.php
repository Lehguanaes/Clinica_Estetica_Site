<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Consultar Esteticistas</title>
    <!-- Links externos -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.16/jquery.mask.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css" integrity="sha512-MV7K8+y+gLIBoVD59lQIYicR65iaqukzvf/nwasF0nqhPay5w/9lJmVM2hMDcnK1OnMGCdVK+iQrJ7lzPJQd1w==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <!-- Estilização padrão do web site -->
    <link rel="stylesheet" href="../css/style.css">
    <!-- Estilização formulários de Perfis -->
    <link rel="stylesheet" href="../css/perfil.css">
    <!-- Estilização Navbar -->
    <link rel="stylesheet" href="../css/navbar.css">
    <!-- Link Js Navbar -->
    <script src="../js/navbar.js"></script>
</head>
<body>
<!-- Início da Navbar -->
<header>
        <nav class="nav-bar">
          <a class="logo" href="Home.html"><img src="../logo/Logo.png" class="logoIMG">Care Tones</a>
          <ul class="nav-list">
            <li><a href="visualizarConsultas.php" class="nav">Agenda</a></li>
            <li><a href="visualizarDuvidas.php" class="nav">Dúvidas</a></li>
            <li><a href="../avaliacoes/avaliacoes.php" class="nav">Avaliações</a></li>
            <li><a href="../agendamento/agendamentoAtendente.php" class="nav">Agendar Consulta</a></li>
            <li><a href="../esteticista/esteticistas.php" class="nav">Esteticistas</a></li>
          </ul>
          <div class="dropdown">
            <div class="login-icon">
                <a href="perfilAtendente.php">
                <i class="fa-solid fa-circle-user fa-xl" style="color: #fff;"></i>
                </a>
                <div class="dropdown-content">
                    <a href="perfilAtendente.php"><i class="fa-solid fa-right-to-bracket" style="color: #cf6f7a;"></i> Perfil </a>
                    <a href="../esteticista/cadastroEsteticistaAtendente.php"><i class="fa-solid fa-address-card" style="color: #cf6f7a;"></i> Cadastrar Esteticista </a>
                    <a href="../cliente/cadastrarClienteAtendente.php"><i class="fa-solid fa-address-card" style="color: #cf6f7a;"></i> Cadastrar Cliente </a>
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
    <!-- Fim da Navbar -->
    <div class="container">
        <h2>Esteticistas Cadastrados</h2>
        <?php
        // Atualize o caminho do arquivo de conexão com o banco de dados
        require_once $_SERVER['DOCUMENT_ROOT'] . "/glow_schedule/controller/conexao.php";
        require_once $_SERVER['DOCUMENT_ROOT'] . "/glow_schedule/model/message.php";
        require_once $_SERVER['DOCUMENT_ROOT'] . "/glow_schedule/controller/global.php";
     
        $conexaoMini = new Conexao();
        $conexao = $conexaoMini->getConexao();
        $message = new Message($BASE_URL);
        $flashMsg = $message->getMessage();
     
       if (!empty($flashMsg["msg"])) {
        $message->limparMessage();
        }
        
        $token = $_SESSION['usuario_token'];
        $stmt = $conexao->prepare("SELECT * FROM atendente WHERE token_atendente = ?");
     
        if ($stmt === false) {
            die('Erro no sql: ' . $conexao->error);
        }
        
        $stmt->bind_param("s", $token);
        $stmt->execute();
        
        $resultado = $stmt->get_result();
        $atendente = $resultado->fetch_assoc();
        
        $sql = "SELECT * FROM esteticista";
        $result = $conexao->query($sql);

        // Verifica se há resultados
        if ($result->num_rows > 0) {
            echo '<table class="table table-bordered">';
            echo '<thead>';
            echo '<tr>';
            echo '<th>Foto</th>';
            echo '<th>CPF</th>';
            echo '<th>Nome</th>';
            echo '<th>Apelido</th>';
            echo '<th>Email</th>';
            echo '<th>Telefone</th>';
            echo '<th>Ações</th>';
            echo '</tr>';
            echo '</thead>';
            echo '<tbody>';
            // Exibe os dados de cada esteticista
            while ($row = $result->fetch_assoc()) {
                echo '<tr>';
                echo '<tr>';
                // Verifica se a foto do atendente existe
                $fotoPath = $_SERVER['DOCUMENT_ROOT'] . "/glow_schedule/" . $row['foto_esteticista'];
                $foto = file_exists($fotoPath) && !empty($row['foto_esteticista']) 
                ? "/glow_schedule/" . htmlspecialchars($row['foto_esteticista']) 
                : "../iconesPerfil/perfilPadrao.png"; // URL da imagem padrão
                // Exibe a foto do atendente com formatação
                echo '<td class="text-center align-middle"><img src="' . $foto . '" alt="Foto do Atendente" id="consultar_fotos"></td>';
                echo '<td>' . htmlspecialchars($row['cpf_esteticista']) . '</td>';
                echo '<td>' . htmlspecialchars($row['nome_esteticista']) . '</td>';
                echo '<td>' . htmlspecialchars($row['apelido_esteticista']) . '</td>';
                echo '<td>' . htmlspecialchars($row['email_esteticista']) . '</td>';
                echo '<td>' . htmlspecialchars($row['telefone_esteticista']) . '</td>';
                echo '<td>';
                echo '<a href="../esteticista/editarEsteticistaAtendente.php?token_esteticista=' . urlencode($row['token_esteticista']) . '" class="btn btn-primary" id="editar_consultar_button">Editar</a> ';
                echo '</td>';
                echo '</tr>';
            }
            echo '</tbody>';
            echo '</table>';
        } else {
            echo '<p>Nenhum esteticista encontrado.</p>';
        }
        // Fecha a conexão com o banco de dados
        $conexao->close();
        ?>
        <a href="../esteticista/cadastroEsteticista.php" class="btn btn-success" class="btn btn-success" id="editar_perfil_button"><i class="fa fa-plus"></i> Adicionar Novo Esteticista</a>
    </div>
    <script src="../js/navbar.js">
</body>
</html>
