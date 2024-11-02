<?php
    require_once $_SERVER['DOCUMENT_ROOT'] . "/glow_schedule/controller/usuarioController.php";
    require_once $_SERVER['DOCUMENT_ROOT'] . "/glow_schedule/controller/conexao.php";

    $conexaoMini = new Conexao();
    $conexao = $conexaoMini->getConexao();

    $cpf = $_SESSION['usuario_cpf'];
    //smt com placeholder ?, pq o método ':cpf', $cpf não funcionou
    $stmt = $conexao->prepare("SELECT * FROM cliente WHERE cpf_cliente = ?");
    // um if para a verificação se o statement resulta em algo
    if ($stmt === false) {
        // Exibe o erro da preparação da consulta
        die('Erro no sql: ' . $conexao->error);
    }
    //smt com placeholder ?, pq o método ':cpf', $cpf não funcionou
    $stmt->bind_param("s", $cpf);
    $stmt->execute();
    
    // atribui o resultado da consulta  do stmt ao vetor $resultado
    $resultado = $stmt->get_result();
    // atribui o $cliente a uma linha do $resultado
    $cliente = $resultado->fetch_assoc();
?>
<!DOCTYPE html>
<html>
<head>
    <title>Consulta de Perfil</title>
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

              <label for="foto_atendente">Foto:</label><br>
              <img src="<?php echo ($cliente['foto_cliente']); ?>" alt="Foto do cliente" style="width:100px;height:100px;"><br>
                <input type="file" name="foto_cliente" id="foto_cliente" accept="image/*">
             

                <label for="nome_cliente">Nome:</label>
                <input type="text" class="form-control" id="nome_cliente" name="nome_cliente" value="<?php echo ($cliente['nome_cliente']); ?>" required>
            
                <label for="email_cliente">Email:</label>
                <input type="text" class="form-control" id="email_cliente" name="email_cliente" value="<?php echo ($cliente['email_cliente']); ?>" required>
        
                <label for="telefone_cliete">Telefone:</label>
                <input type="text" class="form-control" id="telefone_cliete" name="telefone_cliete" value="<?php echo ($cliente['telefone_cliente']); ?>" required>
       
                <label for="cpf_cliente">CPF:</label>
                <input type="text" class="form-control" id="cpf_cliente" name="cpf_cliente" value="<?php echo ($cliente['cpf_cliente']); ?>" required>
       
                <label for="senha_cliente">Senha:</label>
                <input type="text" class="form-control" id="senha_cliente" name="senhaE" value="<?php echo $cliente['senha_cliente']; ?>" required>
                
            </div>
        </form>
    </div>
</body>
</html>