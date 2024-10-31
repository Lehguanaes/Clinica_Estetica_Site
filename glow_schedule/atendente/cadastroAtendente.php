<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro de Atendentes</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.16/jquery.mask.min.js"></script>
    <script src="js/mascaraInput.js" defer></script>
</head>
<body>
    <div class="container">
        <h2>Cadastro de Atendente</h2>
        <form method="POST" action="/glow_schedule/controller/atendente/atendenteController.php" enctype="multipart/form-data">

            <div class="form-group">
              <label for="foto_atendente">Foto:</label>
              <input type="file" name="foto_atendente" id="foto_atendente" accept="image/*" required>
            </div>

            <div class="form-group">
                <label for="cpf_atendente">CPF:</label>
                <input type="text" class="form-control" id="cpf_atendente" name="cpf_atendente" required maxlength="14">
            </div>

            <div class="form-group">
                <label for="nome_atendente">Nome:</label>
                <input type="text" class="form-control" id="nome_atendente" name="nome_atendente" required>
            </div>

            <div class="form-group">
                <label for="email_atendente">Email:</label>
                <input type="email" class="form-control" id="email_atendente" name="email_atendente" required>
            </div>

            <div class="form-group">
                <label for="telefone_atendente">Telefone:</label>
                <input type="text" class="form-control" id="telefone_atendente" name="telefone_atendente" required maxlength="15">
            </div>

            <div class="form-group">
                <label for="senha_atendente">Senha:</label>
                <input type="text" class="form-control" id="senha_atendente" name="senha_atendente" required>
            </div>
            <input type="hidden" name="acao" value="inserir">
            <button type="submit" class="btn btn-primary">Cadastrar</button>
        </form>
    </div>
</body>
</html>