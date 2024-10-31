<?php

require_once $_SERVER['DOCUMENT_ROOT'] . "/glow_schedule/controller/conexao.php";

class Atendente {
    private $cpf_atendente;
    private $nome_atendente;
    private $foto_atendente;
    private $telefone_atendente;
    private $email_atendente;
    private $senha_atendente;

    private $conexao;

    public function __construct() {
        $this->conexao = new Conexao();
    }

    // Getters e Setters para os campos
    public function setCpf($cpf_atendente) { $this->cpf_atendente = $cpf_atendente; }
    public function setNome($nome_atendente) { $this->nome_atendente = $nome_atendente; }
    public function setFoto($foto_atendente) { $this->foto_atendente = $foto_atendente; }
    public function setTelefone($telefone_atendente) { $this->telefone_atendente = $telefone_atendente; }
    public function setEmail($email_atendente) { $this->email_atendente = $email_atendente; }
    public function setSenha($senha_atendente) { $this->senha_atendente = $senha_atendente; }

    // Método para inserir atendente
    public function inserir() {
        $sql = "INSERT INTO atendente (cpf_atendente, nome_atendente, foto_atendente, telefone_atendente, email_atendente, senha_atendente) VALUES (?, ?, ?, ?, ?, ?)";
        try {
            $stmt = $this->conexao->getConexao()->prepare($sql);
            
            // Associa os parâmetros com os valores
            $stmt->bind_param(
                "ssssss", 
                $this->cpf_atendente, 
                $this->nome_atendente, 
                $this->foto_atendente, 
                $this->telefone_atendente, 
                $this->email_atendente, 
                $this->senha_atendente
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

    // Método para atualizar atendente
    public function atualizar() {
        $sql = "UPDATE atendente SET nome_atendente = ?, foto_atendente = ?, telefone_atendente = ?, email_atendente = ?, senha_atendente = ? WHERE cpf_atendente = ?";
        try {
            $stmt = $this->conexao->getConexao()->prepare($sql);
            $stmt->bind_param("ssssss", 
                $this->nome_atendente, 
                $this->foto_atendente, 
                $this->telefone_atendente, 
                $this->email_atendente, 
                $this->senha_atendente, 
                $this->cpf_atendente
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
        // Query para obter a lista de atendentes
        $sql = "SELECT * FROM atendentes";
    }

    public function __destruct() {
        $this->conexao->getConexao()->close();
    }
}
?>