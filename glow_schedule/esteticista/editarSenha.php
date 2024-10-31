<?php

require_once $_SERVER['DOCUMENT_ROOT'] . "/cadastroesteticista/controller/esteticistaController.php";

$idEst = $_GET['idEst'];

$esteticistacontroller =  new esteticistaController();
$esteticistas = $esteticistacontroller->buscarPorId($idEst);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar senha</title>
</head>
<body>
    <div class="container">
        <h2>Editar Senha</h2>

        <form  class="form-login" method="POST" action="controller/esteticistaController.php">
            <br>
            <label>Email:</label>
            <input type="email" id="emailEst" name="emailEst" value="<?= $esteticistas['emailEst'] ?>" placeholder="Digite seu email:"><br>
            
            <label>Senha:</label>
            <input type="text" id="senhaE" name="senhaE" value="<?= $esteticistas['senhaE'] ?>" placeholder="Digite sua senha:"><br>
            
            
            <input type="hidden" class="form-control" name="crud" value="UPDATE2">
            <input type="hidden" class="form-control" name="idEst" value="<?= $esteticistas['idEst'] ?>">
            <!-- botão q envia o formulário -->
            <button type="submit" class="btn btn-primary">Editar</button>
            
        </form>
    </div>
</body>
</html>