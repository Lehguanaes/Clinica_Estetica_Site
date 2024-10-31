<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
</head>
<body>
    <div>
<form  class="form-login" method="POST" action="controller/usuarioController.php">
<label>Email:</label>    
<input type="email" id="email_atendente" name="email_atendente" placeholder="Coloque seu email:" required></input>

<label>Senha:</label>
<input type="password" id="senha_atendente" name="senha_atendente" placeholder="Informe sua senha">

<input type="hidden" class="form-control" name="acao" value="login">
<button type="submit" class="botao-entrar">Entrar</button>
</form>
    </div>
</body>
</html>