<?php
require_once '../controller/conexao.php';

    // Instancia a classe Conexao e obtém a conexão
    $conexao = new Conexao();
    $conn = $conexao->getConexao();
    if ($conn->connect_error) {
        die("Erro na conexão com o banco de dados: " . $conn->connect_error);
    }

    try {
        // Obter o ID do procedimento da requisição
        $id_procedimento = $_GET['id_procedimento'];

        // Consultar os esteticistas que fazem o procedimento selecionado
        $stmt = $conn->prepare("
            SELECT e.cpf_esteticista, e.apelido_esteticista
            FROM esteticista e
            JOIN esteticista_procedimento ep ON e.cpf_esteticista = ep.cpf_esteticista
            WHERE ep.id_procedimento = ?
        ");
        $stmt->bind_param('i', $id_procedimento); // 'i' para um inteiro
        $stmt->execute();
        
        // Recupera os resultados
        $result = $stmt->get_result();
        $esteticistas = $result->fetch_all(MYSQLI_ASSOC);
        
        // Retornar os esteticistas como JSON
        echo json_encode($esteticistas);
        
        // Fecha as declarações e a conexão
        $stmt->close();
        $conn->close();
    } catch (Exception $e) {
        die("Erro: " . $e->getMessage());
    }
?>