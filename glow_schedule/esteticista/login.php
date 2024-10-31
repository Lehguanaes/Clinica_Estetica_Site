<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
</head>
<body>
    <div>
<form  class="form-login" method="POST" action="/cadastroesteticista/controller/esteticistaController.php">
<label>Email:</label>    
<input type="email" id="emailEst" name="emailEst" placeholder="Coloque seu email:" required></input>

<label>Senha:</label>
<input type="password" id="senhaEst" name="senhaEst" placeholder="Informe sua senha">

<input type="hidden" class="form-control" name="crud" value="SELECT">
<button type="submit" class="botao-entrar">Entrar</button>
</form>
    </div>
</body>
</html>