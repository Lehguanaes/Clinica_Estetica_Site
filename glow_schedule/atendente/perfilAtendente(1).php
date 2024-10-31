<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Atendente</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
    <div class="container">
        <h2>Editar Atendente</h2>

        <?php
        require_once $_SERVER['DOCUMENT_ROOT'] . "/glow_schedule/controller/atendenteController.php";

        // Verifica se o CPF foi passado na URL
        if (isset($_GET['cpf_atendente'])) {
            $cpf_atendente = $_GET['cpf_atendente'];
            echo "CPF do atendente: " . htmlspecialchars($cpf_atendente); // Para debug
        } else {
            echo '<p>CPF não encontrado.</p>';
            exit();
        }

        // Cria uma nova instância do controlador e busca os dados do atendente
        $atendenteController = new AtendenteController();
        $atendente = $atendenteController->buscarPorCpfA($cpf_atendente);

        // Verifica se o atendente foi encontrado
        if ($atendente) {
            ?>
            <form method="POST" action="glow_schedule/controller/atendenteController.php">
                <div class="form-group">
                    <label for="foto_atendente">Foto do Atendente:</label>
                    <img src="<?php echo htmlspecialchars($atendente['foto_atendente']); ?>" alt="Foto do Atendente" style="width:100px;height:auto;">

                    <label for="nome_atendente">Nome:</label>
                    <input type="text" class="form-control" id="nome_atendente" name="nome_atendente" value="<?php echo htmlspecialchars($atendente['nome_atendente']); ?>" required>

                    <label for="cpf_atendente">CPF:</label>
                    <input type="text" class="form-control" id="cpf_atendente" name="cpf_atendente" value="<?php echo htmlspecialchars($atendente['cpf_atendente']); ?>" required readonly>

                    <label for="telefone_atendente">Telefone:</label>
                    <input type="text" class="form-control" id="telefone_atendente" name="telefone_atendente" value="<?php echo htmlspecialchars($atendente['telefone_atendente']); ?>" required>

                    <label for="email_atendente">Email:</label>
                    <input type="email" class="form-control" id="email_atendente" name="email_atendente" value="<?php echo htmlspecialchars($atendente['email_atendente']); ?>" required>

                    <label for="senha_atendente">Senha:</label>
                    <input type="password" class="form-control" id="senha_atendente" name="senha_atendente" value="<?php echo htmlspecialchars($atendente['senha_atendente']); ?>" required>
                </div>
                <input type="hidden" name="acaoAT" value="atualizarA">
                <button type="submit" class="btn btn-success">Atualizar Atendente</button>
            </form>
            <?php
        } else {
            echo '<p>Atendente não encontrado.</p>';
        }
        ?>
        
        <a href="index.php" class="btn btn-primary">Voltar</a>
    </div>
</body>
</html>
