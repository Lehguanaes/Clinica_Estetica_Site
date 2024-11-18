<?php

require_once $_SERVER['DOCUMENT_ROOT'] . "/glow_schedule/controller/conexao.php";

class Cliente {
    private $cpf_cliente;
    private $nome_cliente;
    private $foto_cliente;
    private $telefone_cliente;
    private $email_cliente;
    private $senha_cliente;
    private $token;

    private $conexao;


    public function __construct() {
        $this->conexao = new Conexao();
    }


    public function setCpf($cpf_cliente) { $this->cpf_cliente = $cpf_cliente; }
    public function setNome($nome_cliente) { $this->nome_cliente = $nome_cliente; }
    public function setFoto($foto_cliente) { $this->foto_cliente = $foto_cliente; }
    public function setTelefone($telefone_cliente) { $this->telefone_cliente = $telefone_cliente; }
    public function setEmail($email_cliente) { $this->email_cliente = $email_cliente; }
    public function getSenha(){return $this->senha_cliente;}
    public function setSenha($senha_cliente) { $this->senha_cliente = $senha_cliente; }
    public function gerarSenha($senha_cliente){  return password_hash($senha_cliente, PASSWORD_DEFAULT); }
    public function setToken($token){ $this->token = $token;} 
    public function gerarToken(){ return bin2hex(random_bytes(50));}


    public function inserir($cliente, $senha_cliente) {
        
        $token = $cliente->gerarToken();
        $cliente->setToken($token); 
        $senha_cliente = $cliente->gerarSenha($senha_cliente);  

        $sql = "INSERT INTO cliente (cpf_cliente, nome_cliente, foto_cliente, telefone_cliente, email_cliente, senha_cliente, token_cliente) VALUES (?, ?, ?, ?, ?, ?, ?)";
       
        try {
            $conexao = $this->conexao->getConexao();
            if ($conexao->connect_error) {
                 throw new Exception("Falha na conexão: " . $conexao->connect_error); 
            }
            $stmt = $conexao->prepare($sql);
             if ($stmt === false) { 
                throw new Exception("Erro na preparação da consulta: " . $conexao->error); 
            }
            
             $stmt->bind_param( "sssssss",
              $this->cpf_cliente,
              $this->nome_cliente,
              $this->foto_cliente, 
              $this->telefone_cliente, 
              $this->email_cliente, 
              $senha_cliente, 
              $token);

              var_dump("Token antes do INSERT:", $this->token); 
              if ($stmt->execute()) {
                  echo "Cliente inserido com sucesso.";
                  $stmt->close();
                  return true;
              } else {
                  echo "Erro ao inserir: " . $stmt->error;
                  return false;
              }


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


    public function atualizar() {

        $senha_cliente = $this->senha_cliente;
        
        var_dump($this->nome_cliente, $this->foto_cliente, $this->telefone_cliente, $this->email_cliente, $senha_cliente, $this->token);

        $sql = "UPDATE cliente SET nome_cliente = ?, foto_cliente = ?, telefone_cliente = ?, email_cliente = ?, senha_cliente = ? WHERE token_cliente = ?";
        try {
            $stmt = $this->conexao->getConexao()->prepare($sql);
            $stmt->bind_param("ssssss", 
            $this->nome_cliente, 
            $this->foto_cliente, 
            $this->telefone_cliente, 
            $this->email_cliente, 
            $senha_cliente,
            $this->token
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

    
    public function buscarPorToken($token) {
        $sql = "SELECT * FROM cliente WHERE token_cliente = ?";
        
        try {
            $stmt = $this->conexao->getConexao()->prepare($sql);
            $stmt->bind_param("s", 
                $token
            );
            
            if ($stmt->execute()) {
                $resultado = $stmt->get_result();
              
                return $resultado->fetch_assoc(); // Retorna os resultados do sql se a atualização for bem-sucedida
            } else {
                throw new Exception("Falha ao atualizar os dados: " . $stmt->error);
            }
        } catch (Exception $e) {
            echo "Erro ao atualizar: " . $e->getMessage();
            return null; 
        }
    }
    public function verificarSenha($senha) {
        return password_verify($senha, $this->senha_cliente); 
    }

    
    public function listar() {
        $sql = "SELECT * FROM cliente";
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

    public function atualizarAt() {

        $senha_cliente = $this->senha_cliente;
        
        var_dump($this->nome_cliente, $this->foto_cliente, $this->telefone_cliente, $this->email_cliente, $senha_cliente, $this->token);

        $sql = "UPDATE cliente SET nome_cliente = ?, foto_cliente = ?, telefone_cliente = ?, email_cliente = ?, senha_cliente = ? WHERE token_cliente = ?";
        try {
            // Associa os atributos "s", com os valores
            $stmt = $this->conexao->getConexao()->prepare($sql);
            $stmt->bind_param("ssssss", 
            $this->nome_cliente, 
            $this->foto_cliente, 
            $this->telefone_cliente, 
            $this->email_cliente, 
            $senha_cliente,
            $this->token
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

    public function __destruct() {
        $this->conexao->getConexao()->close();
    }
}
?>
