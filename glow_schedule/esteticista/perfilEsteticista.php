<?php
    require_once $_SERVER['DOCUMENT_ROOT'] . "/glow_schedule/controller/usuarioController.php";
    require_once $_SERVER['DOCUMENT_ROOT'] . "/glow_schedule/controller/conexao.php";

    $conexaoMini = new Conexao();
    $conexao = $conexaoMini->getConexao();

    $cpf = $_SESSION['usuario_cpf'];
    //smt com placeholder ?, pq o método ':cpf', $cpf não funcionou
    $stmt = $conexao->prepare("SELECT * FROM esteticista WHERE cpf_esteticista = ?");
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
    $esteticista = $resultado->fetch_assoc();
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

        <form method="POST"  enctype="multipart/form-data">

                <div class="form-group">
                    <label for="foto_esteticista">Foto:</label><br>
                    <img src="<?php echo ($esteticista['foto_esteticista']); ?>" alt="Foto do Esteticista" style="width:100px;height:100px;"><br>
                    <input type="file" name="foto_esteticista" id="foto_esteticista" accept="image/*">
                </div>

                <div class="form-group">
                    <label for="nome_esteticista">Nome:</label>
                    <input type="text" class="form-control" id="nome_esteticista" name="nome_esteticista" value="<?php echo ($esteticista['nome_esteticista']); ?>" disabled>
                </div>

                <div class="form-group">
                    <label for="apelido_esteticista">Apelido:</label>
                    <input type="text" class="form-control" id="apelido_esteticista" name="apelido_esteticista" value="<?php echo ($esteticista['apelido_esteticista']); ?>" required>
                </div>

                <div class="form-group">
                    <label for="email_esteticista">Email:</label>
                    <input type="email" class="form-control" id="email_esteticista" name="email_esteticista" value="<?php echo ($esteticista['email_esteticista']); ?>" required>
                </div>

                <div class="form-group">
                    <label for="telefone_esteticista">Telefone:</label>
                    <input type="text" class="form-control" id="telefone_esteticista" name="telefone_esteticista" value="<?php echo ($esteticista['telefone_esteticista']); ?>" required>
                </div>

                <button type="submit" class="btn btn-primary">Atualizar</button>
            </form>
    </div>
</body>
</html>