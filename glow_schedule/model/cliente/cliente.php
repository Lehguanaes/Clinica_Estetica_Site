<?php

require_once $_SERVER['DOCUMENT_ROOT'] . "/glow_schedule/controller/conexao.php";

class Cliente {
    private $cpf_cliente;
    private $nome_cliente;
    private $foto_cliente;
    private $telefone_cliente;
    private $email_cliente;
    private $senha_cliente;

    private $conexao;

    public function __construct() {
        $this->conexao = new Conexao();
    }

    // Getters e Setters para os campos
    public function setCpf($cpf_cliente) { $this->cpf_cliente = $cpf_cliente; }
    public function setNome($nome_cliente) { $this->nome_cliente = $nome_cliente; }
    public function setFoto($foto_cliente) { $this->foto_cliente = $foto_cliente; }
    public function setTelefone($telefone_cliente) { $this->telefone_cliente = $telefone_cliente; }
    public function setEmail($email_cliente) { $this->email_cliente = $email_cliente; }
    public function setSenha($senha_cliente) { $this->senha_cliente = $senha_cliente; }

    // Método para inserir cliente
    public function inserir() {
        $sql = "INSERT INTO cliente (cpf_cliente, nome_cliente, foto_cliente, telefone_cliente, email_cliente, senha_cliente) VALUES (?, ?, ?, ?, ?, ?)";
        try {
            $stmt = $this->conexao->getConexao()->prepare($sql);
            
            // Associa os parâmetros com os valores
            $stmt->bind_param(
                "ssssss", 
                $this->cpf_cliente, 
                $this->nome_cliente, 
                $this->foto_cliente, 
                $this->telefone_cliente, 
                $this->email_cliente, 
                $this->senha_cliente
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

    // Método para atualizar cliente
    public function atualizar() {
        $sql = "UPDATE cliente SET nome_cliente = ?, foto_cliente = ?, telefone_cliente = ?, email_cliente = ?, senha_cliente = ? WHERE cpf_cliente = ?";
        try {
            $stmt = $this->conexao->getConexao()->prepare($sql);
            $stmt->bind_param("ssssss", 
            $this->nome_cliente, 
            $this->foto_cliente, 
            $this->telefone_cliente, 
            $this->email_cliente, 
            $this->senha_cliente,
            $this->cpf_cliente
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

    public function buscarPorCpf() {
        $sql = "SELECT * FROM cliente WHERE  cpf_cliente = ?";
        
        try {
            $stmt = $this->conexao->getConexao()->prepare($sql);
            $stmt->bind_param("s", 
                $this->cpf_cliente
            );

            if ($stmt->execute()) {
                return true; // Retorna true se a atualização for bem-sucedida
            } else {
                throw new Exception("Falha ao atualizar os dados: " . $stmt->error);
            }
        } catch (Exception $e) {
            echo "Erro ao atualizar: " . $e->getMessage();
            return false; // Retorna false se houve um erro
        }
    }
    
    public function listar() {
        // Query para obter a lista de cliente
        $sql = "SELECT * FROM cliente";
    }

    public function __destruct() {
        $this->conexao->getConexao()->close();
    }
}
?>
