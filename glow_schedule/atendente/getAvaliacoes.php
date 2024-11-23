<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/glow_schedule/controller/conexao.php';

header('Content-Type: application/json');

try {
    // Obtém os dados do AJAX (apelido do esteticista)
    $dados = json_decode(file_get_contents('php://input'), true);
    $apelido_esteticista = $dados['apelido_esteticista'] ?? null;

    if (!$apelido_esteticista) {
        echo json_encode(['error' => 'Apelido do esteticista não informado.']);
        exit;
    }

    // Conexão com o banco de dados
    $conexao = new Conexao();
    $conn = $conexao->getConexao();

    // Consulta SQL para obter as avaliações (onde 'avaliado' é igual ao apelido do esteticista)
    $sql_avaliacoes = "
        SELECT a.id_avaliacao, a.estrelas_avaliacao, a.comentario_avaliacao, a.data_criacao_avaliacao, 
            c.nome_cliente, c.foto_cliente
        FROM Avaliacoes a
        JOIN Cliente c ON a.cpf_cliente = c.cpf_cliente
        WHERE a.avaliado = ?"; // Filtra pelo apelido do esteticista

    // Prepara a consulta
    $stmt = $conn->prepare($sql_avaliacoes);

    if (!$stmt) {
        throw new Exception("Erro ao preparar a consulta: " . $conn->error);
    }

    // Bind e execução da consulta
    $stmt->bind_param("s", $apelido_esteticista);
    $stmt->execute();
    $result = $stmt->get_result();

    // Função para formatar a data
    function formatarData($data) {
        $meses = [
            '01' => 'janeiro', '02' => 'fevereiro', '03' => 'março',
            '04' => 'abril', '05' => 'maio', '06' => 'junho',
            '07' => 'julho', '08' => 'agosto', '09' => 'setembro',
            '10' => 'outubro', '11' => 'novembro', '12' => 'dezembro'
        ];
        
        $dia = date('d', strtotime($data));
        $mes = $meses[date('m', strtotime($data))];
        $ano = date('Y', strtotime($data));
        
        return "{$dia} de {$mes} de {$ano}";
    }

    // Array para armazenar as avaliações
    $avaliacoes = [];
    while ($avaliacao = $result->fetch_assoc()) {
        // Formatando a data usando a função
        $data_formatada = formatarData($avaliacao['data_criacao_avaliacao']);

        // Verificar se a foto do cliente existe
        $foto_cliente = $avaliacao['foto_cliente'] && file_exists($_SERVER['DOCUMENT_ROOT'] . "/glow_schedule/uploads/" . $avaliacao['foto_cliente'])
            ? "/glow_schedule/uploads/" . $avaliacao['foto_cliente']
            : "../iconesPerfil/perfilPadrao.png"; // Foto padrão caso não exista

        // Adiciona a avaliação ao array
        $avaliacoes[] = [
            'id_avaliacao' => $avaliacao['id_avaliacao'],
            'estrelas_avaliacao' => (int) $avaliacao['estrelas_avaliacao'],
            'comentario_avaliacao' => htmlspecialchars($avaliacao['comentario_avaliacao']),
            'data_criacao_avaliacao' => $data_formatada, // Usando a data formatada
            'nome_cliente' => htmlspecialchars($avaliacao['nome_cliente']),
            'foto_cliente' => $foto_cliente,  // Foto tratada
        ];
    }

    // Retorna as avaliações como JSON
    echo json_encode($avaliacoes);

    // Fecha a conexão
    $stmt->close();
    $conn->close();
} catch (Exception $e) {
    // Caso ocorra algum erro, retorna a mensagem de erro em JSON
    echo json_encode(['error' => $e->getMessage()]);
}
?>