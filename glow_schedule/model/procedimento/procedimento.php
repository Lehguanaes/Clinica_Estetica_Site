<?php
require_once $_SERVER['DOCUMENT_ROOT'] . "/glow_schedule/controller/conexao.php";

class Procedimento {
    private $id_procedimento;
    private $nome_procedimento;
    private $foto_procedimento;
    private $preco_procedimento;
    private $descricao_p_procedimento;
    private $descricao_g_procedimento;
    private $manutencao_procedimento;
    private $duracao_procedimento;

    private $conexao;

    public function __construct() {
        $this->conexao = new Conexao();
    }

    // Getters e Setters para os campos
    public function setId($id_procedimento) { $this->id_procedimento = $id_procedimento; }
    public function setNome($nome_procedimento) { $this->nome_procedimento = $nome_procedimento; }
    public function setFoto($foto_procedimento) { $this->foto_procedimento = $foto_procedimento; }
    public function setPreco($preco_procedimento) { $this->preco_procedimento = $preco_procedimento; }
    public function setDescricaoP($descricao_p_procedimento) { $this->descricao_p_procedimento = $descricao_p_procedimento; }
    public function setDescricaoG($descricao_g_procedimento) { $this->descricao_g_procedimento = $descricao_g_procedimento; }
    public function setManutencao($manutencao_procedimento) { $this->manutencao_procedimento = $manutencao_procedimento; }
    public function setDuracao($duracao_procedimento) { $this->duracao_procedimento = $duracao_procedimento; }

    // Método para inserir procedimento
    public function inserir() {
        $sql = "INSERT INTO procedimento (nome_procedimento, foto_procedimento, preco_procedimento, descricao_p_procedimento, descricao_g_procedimento, manutencao_procedimento, duracao_procedimento) VALUES (?, ?, ?, ?, ?, ?, ?)";
        try {
            $stmt = $this->conexao->getConexao()->prepare($sql);

            // Associa os parâmetros com os valores
            $stmt->bind_param(
                "sssssss", 
                $this->nome_procedimento, 
                $this->foto_procedimento, 
                $this->preco_procedimento, 
                $this->descricao_p_procedimento, 
                $this->descricao_g_procedimento,
                $this->manutencao_procedimento,
                $this->duracao_procedimento
            );

            if ($stmt->execute()) {
                $stmt->close();
                return true;
            } else {
                throw new Exception("Falha ao inserir os dados: " . $stmt->error);
            }

        } catch (Exception $e) {
            echo "Erro ao inserir: " . $e->getMessage();
            return false;
        }
    }

    // Método para atualizar procedimento
    public function atualizar() {
        $sql = "UPDATE procedimento SET nome_procedimento = ?, foto_procedimento = ?, preco_procedimento = ?, descricao_p_procedimento = ?, descricao_g_procedimento = ?, manutencao_procedimento = ?, duracao_procedimento = ? WHERE id_procedimento = ?";
        try {
            $stmt = $this->conexao->getConexao()->prepare($sql);
            $stmt->bind_param(
                "sssssssi", 
                $this->nome_procedimento, 
                $this->foto_procedimento, 
                $this->preco_procedimento, 
                $this->descricao_p_procedimento, 
                $this->descricao_g_procedimento, 
                $this->manutencao_procedimento,
                $this->duracao_procedimento,
                $this->id_procedimento
            );

            if ($stmt->execute()) {
                $stmt->close();
                return true;
            } else {
                throw new Exception("Falha ao atualizar os dados: " . $stmt->error);
            }
        } catch (Exception $e) {
            echo "Erro ao atualizar: " . $e->getMessage();
            return false;
        }
    }


    public function listar() {
        $sql = "SELECT * FROM procedimento";
        try {
            $stmt = $this->conexao->getConexao()->prepare($sql);
            

            if ($stmt->execute()) {
                $resultado = $stmt->get_result();
                return $resultado->fetch_all(MYSQLI_ASSOC); // Retorna os resultados do sql em array :DD
            } else {
                throw new Exception("Falha ao atualizar os dados: " . $stmt->error);
            }
        } catch (Exception $e) {
            echo "Erro ao atualizar: " . $e->getMessage();
            return false; 
        }
    }

    // Método para buscar um procedimento pelo ID
    public function buscarPorId() {
        $sql = "SELECT * FROM procedimento WHERE id_procedimento = ?";
        try {
            $stmt = $this->conexao->getConexao()->prepare($sql);
            $stmt->bind_param("i", $this->id_procedimento);

            if ($stmt->execute()) {
                $result = $stmt->get_result();
                if ($result->num_rows > 0) {
                    return $result->fetch_assoc();
                } else {
                    return null;
                }
            } else {
                throw new Exception("Falha ao buscar os dados: " . $stmt->error);
            }
        } catch (Exception $e) {
            echo "Erro ao buscar: " . $e->getMessage();
            return null;
        }
    }

    public function __destruct() {
        $this->conexao->getConexao()->close();
    }
}
?>