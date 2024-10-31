<?php
    require_once $_SERVER['DOCUMENT_ROOT'] . "/cadastroEsteticista/controller/esteticistaController.php";

$idEst = $_GET['idEst'];

$esteticistacontroller =  new esteticistaController();
$esteticistas = $esteticistacontroller->buscarPorId($idEst);

?>
<!DOCTYPE html>
<html>
<head>
    <title>Consulta de Esteticista</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</head>
<body>
<div class="container">
        <div>&nbsp;</div>
        <h2>Editar</h2>
        <div>&nbsp;</div>

        <form method="POST" action="controller/esteticistacontroller.php">
            <div class="form-group">
                <label for="nomeEst">Nome:</label>
                <input type="text" class="form-control" id="nomeEst" name="nomeEst" value="<?php echo htmlspecialchars($esteticistas['nomeEst']); ?>" required>
                
                <label for="descEst">Breve descrição:</label>
                <input type="text" class="form-control" id="descEst" name="descEst" value="<?php echo htmlspecialchars($esteticistas['descEst']); ?>" required>
                
                <label for="formEst">Formações:</label>
                <input type="text" class="form-control" id="formEst" name="formEst" value="<?php echo htmlspecialchars($esteticistas['formEst']); ?>" required>
                
                <label for="emailEst">Email:</label>
                <input type="text" class="form-control" id="emailEst" name="emailEst" value="<?php echo htmlspecialchars($esteticistas['emailEst']); ?>" required>
        
                <label for="telEst">Telefone:</label>
                <input type="text" class="form-control" id="telEst" name="telEst" value="<?php echo htmlspecialchars($esteticistas['telEst']); ?>" required>
       
                <label for="cpfEst">CPF:</label>
                <input type="text" class="form-control" id="cpfEst" name="cpfEst" value="<?php echo htmlspecialchars($esteticistas['cpfEst']); ?>" required>
       
                <label for="senhaE">Senha:</label>
                <input type="text" class="form-control" id="senhaE" name="senhaE" value="<?php echo htmlspecialchars($esteticistas['senhaE']); ?>" required>
                
            </div>
            <input type="hidden" class="form-control" name="idEst" value="<?= $esteticistas['idEst'] ?>">
        </form>
    </div>
</body>
</html>