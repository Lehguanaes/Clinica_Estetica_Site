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
    private $foto_esteticista; // Novo atributo para armazenar o caminho da foto
    private $senha_esteticista;


    private $conexao;

    public function __construct() {
        $this->conexao = new Conexao();
    }

    // Getters e Setters para os campos
    public function setCpfE($cpf_esteticista) { $this->cpf_esteticista = $cpf_esteticista; }
    public function setNomeE($nome_esteticista) { $this->nome_esteticista = $nome_esteticista; }
    public function setApelidoE($apelido_esteticista) { $this->apelido_esteticista = $apelido_esteticista; }
    public function setEmailE($email_esteticista) { $this->email_esteticista = $email_esteticista; }
    public function setTelefoneE($telefone_esteticista) { $this->telefone_esteticista = $telefone_esteticista; }
    public function setFormacao($formacao_esteticista) { $this->formacao_esteticista = $formacao_esteticista; }
    public function setDescricaoP($descricao_p_esteticista) { $this->descricao_p_esteticista = $descricao_p_esteticista; }
    public function setDescricaoG($descricao_g_esteticista) { $this->descricao_g_esteticista = $descricao_g_esteticista; }
    public function setInstagram($instagram_esteticista) { $this->instagram_esteticista = $instagram_esteticista; }
    public function setFacebook($facebook_esteticista) { $this->facebook_esteticista = $facebook_esteticista; }
    public function setLinkedin($linkedin_esteticista) { $this->linkedin_esteticista = $linkedin_esteticista; }
    public function setFotoE($foto_esteticista) { $this->foto_esteticista = $foto_esteticista; } // Novo setter para a foto
    public function setSenhaE($senha_esteticista) { $this->senha_esteticista = $senha_esteticista; }

    // Método para inserir esteticista
    public function inserirE() {
        $sql = "INSERT INTO esteticista (cpf_esteticista, nome_esteticista, apelido_esteticista, email_esteticista, telefone_esteticista, formacao_esteticista, descricao_p_esteticista, descricao_g_esteticista, instagram_esteticista, facebook_esteticista, linkedin_esteticista, foto_esteticista) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
    
        try {
            $stmt = $this->conexao->getConexao()->prepare($sql);
            
            // Associa os parâmetros com os valores
            $stmt->bind_param(
                "sssssssssssss", 
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
                $this->foto_esteticista
            );
    
            if ($stmt->execute()) {
                // Redirecionar após a inserção bem-sucedida
                header("Location: /glow_schedule/consultarEsteticista.php?status=success");
                exit();
            } else {
                throw new Exception("Falha ao inserir os dados: " . $stmt->error);
            }
    
            $stmt->close();
        } catch (Exception $e) {
            echo "Erro ao inserir: " . $e->getMessage();
        }
    }

    

    public function listarE(){
        $sql = "SELECT * FROM esteticista";
        $stmt = $this->conexao->getConexao()->prepare($sql);

        if (!$stmt){
            die('Erro ao preparar declaração:' . $this->conexao->getConexao()->error);
        }

        $stmt->execute();
        $result = $stmt->get_result();

        $esteticistas = [];

        while($esteticista = $result->fetch_assoc()){
            $esteticistas[] = $esteticista;
        }

        return $esteticistas;

    }
    
    public function buscarPorCpfE($cpf_esteticista){
        $sql = "SELECT * FROM esteticista WHERE `cpf_esteticista` = ?";
        $stmt = $this->conexao->getConexao()->prepare($sql);
        $stmt->bind_param('s',$cpf_esteticista);
        $stmt->execute();
        $result = $stmt->get_result();


        return $result->fetch_assoc();
    }

    // Novo método para atualizar esteticista
    public function atualizarE() {
        $sql = "UPDATE esteticista SET nome_esteticista = ?, apelido_esteticista = ?, email_esteticista = ?, telefone_esteticista = ?, foto_esteticista = ? WHERE cpf_esteticista = ?";
        
        try {
            $stmt = $this->conexao->getConexao()->prepare($sql);
            $stmt->bind_param("ssssss", 
                $this->nome_esteticista, 
                $this->apelido_esteticista, 
                $this->email_esteticista, 
                $this->telefone_esteticista, 
                $this->foto_esteticista, 
                $this->cpf_esteticista
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

    

    public function atualizarSenhaE($cpf_esteticista){
        $sql = "UPDATE esteticista SET `email_esteticista` = ?, `senha_esteticista` = ? WHERE `cpf_esteticista` = ? ";
        $stmt = $this->conexao->getConexao()->prepare($sql);

        if (!$stmt){
            die('Erro ao preparar declaração:' . $this->conexao->getConexao()->error);
        }

        $stmt->bind_param('sss', $this->email_esteticista, $this->senha_esteticista, $cpf_esteticista);

        if(!$stmt->execute()){
            die('Erro ao executar a declaração:' . $stmt->error);
          }

    }




    public function entrarE(){
        $sql = "SELECT `email_esteticista`, `senha_esteticista` FROM esteticista WHERE `email_esteticista` = ? AND `senha_esteticista`=?";
        $stmt = $this->conexao->getConexao()->prepare($sql);
        $stmt->bind_param('ss', $this->email_esteticista, $this->senha_esteticista);
        $stmt->execute();

        $resultado = $stmt->get_result();

        //verificação do login, caso o select encontre >0 retorna true

        if($resultado->num_rows>0){
            return true;
        }

    }
    public function buscarPorEmailE($email_esteticista){
        $sql = "SELECT * FROM esteticista WHERE email_esteticista = ?";
        $stmt = $this->conexao->getConexao()->prepare($sql);
        $stmt->bind_param('s', $email_esteticista);
        $stmt->execute();
        $result = $stmt->get_result();
    
        return $result->fetch_assoc();
}
    

    public function __destruct() {
        // Fechar a conexão se necessário
        $this->conexao->getConexao()->close();
    }
}
?>