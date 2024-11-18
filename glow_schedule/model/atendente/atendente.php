<?php
require_once $_SERVER['DOCUMENT_ROOT'] . "/glow_schedule/controller/conexao.php";

class Atendente {

    private $cpf_atendente;
    private $nome_atendente;
    private $foto_atendente;
    private $telefone_atendente;
    private $email_atendente;
    private $senha_atendente;
    private $token;

    private $conexao;


    public function __construct() {
        $this->conexao = new Conexao();
    }


    public function setCpf($cpf_atendente) { $this->cpf_atendente = $cpf_atendente; }
    public function setNome($nome_atendente) { $this->nome_atendente = $nome_atendente; }
    public function setFoto($foto_atendente) { $this->foto_atendente = $foto_atendente; }
    public function setTelefone($telefone_atendente) { $this->telefone_atendente = $telefone_atendente; }
    public function setEmail($email_atendente) { $this->email_atendente = $email_atendente; }
    public function getSenha(){return $this->senha_atendente;}
    public function setSenha($senha_atendente) { $this->senha_atendente = $senha_atendente; }
    public function gerarSenha($senha_atendente){  return password_hash($senha_atendente, PASSWORD_DEFAULT); }// Hash da senha com bcrypt
    public function setToken($token){ $this->token = $token;} 
    public function gerarToken(){ return bin2hex(random_bytes(50));}


    public function inserir($atendente, $senha_atendente) {

        $token = $atendente->gerarToken();
        $atendente->setToken($token); // Gera token du atendente$atendente 
        $senha_atendente = $atendente->gerarSenha($senha_atendente); // Gera hash da senha atendente$atendente 

        $sql = "INSERT INTO atendente (cpf_atendente, nome_atendente, foto_atendente, telefone_atendente, email_atendente, senha_atendente, token_atendente) VALUES (?, ?, ?, ?, ?, ?, ?)";
        
        try {
            $conexao = $this->conexao->getConexao();
            if ($conexao->connect_error) { throw new Exception("Falha na conexão: " . $conexao->connect_error); } $stmt = $conexao->prepare($sql); // Verifica se a preparação da consulta falhou if ($stmt === false) { throw new Exception("Erro na preparação da consulta: " . $conexao->error); } $token = $atendente->gerarToken(); // Gera o token para o atendente echo "Token gerado: " . $token . "<br>"
            

            $stmt = $conexao->prepare($sql);

            if ($stmt === false) { 
               throw new Exception("Erro na preparação da consulta: " . $conexao->error);
             } 
 

             $stmt->bind_param(
                "sssssss", 
                $this->cpf_atendente, 
                $this->nome_atendente, 
                $this->foto_atendente, 
                $this->telefone_atendente, 
                $this->email_atendente, 
                $senha_atendente,
                $token
            );

            var_dump("Token antes do INSERT:", $this->token); 
              if ($stmt->execute()) {
                  echo "Atendente inserido com sucesso.";
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
        $senha_atendente = $this->senha_atendente;
        var_dump($this->nome_atendente, $this->foto_atendente, $this->telefone_atendente, $this->email_atendente, $senha_atendente, $this->token);

        $sql = "UPDATE atendente SET nome_atendente = ?, foto_atendente = ?, telefone_atendente = ?, email_atendente = ?, senha_atendente = ? WHERE token_atendente = ?";
        try {
            $stmt = $this->conexao->getConexao()->prepare($sql);
            $stmt->bind_param("ssssss", 
            $this->nome_atendente, 
            $this->foto_atendente, 
            $this->telefone_atendente, 
            $this->email_atendente, 
            $senha_atendente,
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
        $sql = "SELECT * FROM atendente WHERE token_atendente = ?";
        
        try {
            $stmt = $this->conexao->getConexao()->prepare($sql);
            $stmt->bind_param("s", 
                $token
            );
            
            if ($stmt->execute()) {
                $resultado = $stmt->get_result();
              
                return $resultado->fetch_assoc(); 
            } else {
                throw new Exception("Falha ao atualizar os dados: " . $stmt->error);
            }
        } catch (Exception $e) {
            echo "Erro ao atualizar: " . $e->getMessage();
            return null; // Retorna false se houve um erro
        }
    }


    public function verificarSenha($senha) {
        return password_verify($senha, $this->senha_atendente); 
    }


    public function listar() {
        $sql = "SELECT * FROM atendente";
        try {
            $stmt = $this->conexao->getConexao()->prepare($sql);
            

            if ($stmt->execute()) {
                $resultado = $stmt->get_result();
                return $resultado->fetch_all(MYSQLI_ASSOC); 
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
