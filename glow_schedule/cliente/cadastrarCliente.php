<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro de Clientes</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.16/jquery.mask.min.js"></script>
    <script src="js/mascaraInput.js" defer></script>
</head>
<body>
    <div class="container">
        <h2>Cadastro de Cliente</h2>
        <form method="POST" action="/glow_schedule/controller/cliente/clienteController.php" enctype="multipart/form-data">

            <div class="form-group">
              <label for="foto_cliente">Foto:</label>
              <input type="file" name="foto_cliente" id="foto_cliente" accept="image/*" required>
            </div>

            <div class="form-group">
                <label for="cpf_cliente">CPF:</label>
                <input type="text" class="form-control" id="cpf_cliente" name="cpf_cliente" required maxlength="14">
            </div>

            <div class="form-group">
                <label for="nome_cliente">Nome:</label>
                <input type="text" class="form-control" id="nome_cliente" name="nome_cliente" required>
            </div>

            <div class="form-group">
                <label for="email_cliente">Email:</label>
                <input type="email" class="form-control" id="email_cliente" name="email_cliente" required>
            </div>

            <div class="form-group">
                <label for="telefone_cliente">Telefone:</label>
                <input type="text" class="form-control" id="telefone_cliente" name="telefone_cliente" required maxlength="15">
            </div>

            <div class="form-group">
                <label for="senha_cliente">Senha:</label>
                <input type="password" class="form-control" id="senha_cliente" name="senha_cliente" required>
            </div>
            <input type="hidden" name="acao" value="inserir">
            <button type="submit" class="btn btn-primary">Cadastrar</button>
        </form>
    </div>
</body>
</html>