<?php

require_once $_SERVER['DOCUMENT_ROOT'] . "/glow_schedule/controller/conexao.php";

class Esteticista {

    private $cpf_esteticista;
    private $nome_esteticista;
    private $apelido_esteticista;
    private $email_esteticista;
    private $telefone_esteticista;
    private $formacao_esteticista;
    private $descricao_p_esteticista;
    private $descricao_g_esteticista;
    private $instagram_esteticista;
    private $facebook_esteticista;
    private $linkedin_esteticista;
    private $foto_esteticista; 
    private $senha_esteticista;
    private $token;

    private $conexao;


    public function __construct() {
        $this->conexao = new Conexao();
    }


    public function setCpf($cpf_esteticista) { $this->cpf_esteticista = $cpf_esteticista; }
    public function setNome($nome_esteticista) { $this->nome_esteticista = $nome_esteticista; }
    public function setApelido($apelido_esteticista) { $this->apelido_esteticista = $apelido_esteticista; }
    public function setEmail($email_esteticista) { $this->email_esteticista = $email_esteticista; }
    public function setTelefone($telefone_esteticista) { $this->telefone_esteticista = $telefone_esteticista; }
    public function setFormacao($formacao_esteticista) { $this->formacao_esteticista = $formacao_esteticista; }
    public function setDescricaoP($descricao_p_esteticista) { $this->descricao_p_esteticista = $descricao_p_esteticista; }
    public function setDescricaoG($descricao_g_esteticista) { $this->descricao_g_esteticista = $descricao_g_esteticista; }
    public function setInstagram($instagram_esteticista) { $this->instagram_esteticista = $instagram_esteticista; }
    public function setFacebook($facebook_esteticista) { $this->facebook_esteticista = $facebook_esteticista; }
    public function setLinkedin($linkedin_esteticista) { $this->linkedin_esteticista = $linkedin_esteticista; }
    public function setFoto($foto_esteticista) { $this->foto_esteticista = $foto_esteticista; } 
    public function getSenha(){return $this->senha_esteticista;}
    public function setSenha($senha_esteticista) { $this->senha_esteticista = $senha_esteticista; }
    public function gerarSenha($senha_esteticista){  return password_hash($senha_esteticista, PASSWORD_DEFAULT); }
    public function setToken($token){ $this->token = $token;} 
    public function gerarToken(){ return bin2hex(random_bytes(50));}


    public function inserir($esteticista, $senha_esteticista) {

        $token = $esteticista->gerarToken();
        $esteticista->setToken($token);  
        $senha_esteticista = $esteticista->gerarSenha($senha_esteticista);

        $sql = "INSERT INTO esteticista (cpf_esteticista, nome_esteticista, apelido_esteticista, email_esteticista, telefone_esteticista, formacao_esteticista, descricao_p_esteticista, descricao_g_esteticista, instagram_esteticista, facebook_esteticista, linkedin_esteticista, foto_esteticista, senha_esteticista, token_esteticista) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
    
        try {            
            $conexao = $this->conexao->getConexao();
            if ($conexao->connect_error) { 
                throw new Exception("Falha na conexão: " . $conexao->connect_error);
             } 
            $stmt = $conexao->prepare($sql);

            if ($stmt === false) { throw new Exception("Erro na preparação da consulta: " . $conexao->error); }  

            $stmt->bind_param(
                "ssssssssssssss", 
                $this->cpf_esteticista, 
                $this->nome_esteticista, 
                $this->apelido_esteticista, 
                $this->email_esteticista, 
                $this->telefone_esteticista, 
                $this->formacao_esteticista, 
                $this->descricao_p_esteticista, 
                $this->descricao_g_esteticista, 
                $this->instagram_esteticista, 
                $this->facebook_esteticista, 
                $this->linkedin_esteticista,
                $this->foto_esteticista,
                $senha_esteticista,
                $token
            );
    
            if ($stmt->execute()) {
                header("Location: /glow_schedule/esteticista/consultarEsteticista.php?status=success");
                exit();
            } else {
                throw new Exception("Falha ao inserir os dados: " . $stmt->error);
            }
            } catch (Exception $e) {
            echo "Erro ao inserir: " . $e->getMessage();
        }
    }
    

    public function atualizar() {
        $senha_esteticista = $this->senha_esteticista;
        var_dump( $this->nome_esteticista, $this->apelido_esteticista, $this->email_esteticista, $this->telefone_esteticista, $this->formacao_esteticista, $this->descricao_p_esteticista, $this->descricao_g_esteticista, $this->instagram_esteticista, $this->facebook_esteticista, $this->linkedin_esteticista, $this->foto_esteticista, $senha_esteticista, $this->token);

        $sql = "UPDATE esteticista SET nome_esteticista = ?, apelido_esteticista = ?, email_esteticista = ?, telefone_esteticista = ?, formacao_esteticista = ?, descricao_p_esteticista = ?, descricao_g_esteticista = ?, instagram_esteticista = ?, facebook_esteticista = ?, linkedin_esteticista = ?, foto_esteticista = ?, senha_esteticista = ? WHERE token_esteticista = ?";
        
        try {
            $stmt = $this->conexao->getConexao()->prepare($sql);
            $stmt->bind_param("sssssssssssss", 

            $this->nome_esteticista, 
            $this->apelido_esteticista, 
            $this->email_esteticista, 
            $this->telefone_esteticista, 
            $this->formacao_esteticista, 
            $this->descricao_p_esteticista, 
            $this->descricao_g_esteticista, 
            $this->instagram_esteticista, 
            $this->facebook_esteticista, 
            $this->linkedin_esteticista,
            $this->foto_esteticista,
            $senha_esteticista,
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
            return false; // Retorna false se houve um erro
        }
    }


    public function buscarPorToken($token) {
        $sql = "SELECT * FROM esteticista WHERE token_esteticista = ?";
        
        try {
            $stmt = $this->conexao->getConexao()->prepare($sql);
            $stmt->bind_param("s", $token);
    
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
        return password_verify($senha, $this->senha_esteticista);
    }

    public function listar() {
        $sql = "SELECT * FROM esteticista";
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