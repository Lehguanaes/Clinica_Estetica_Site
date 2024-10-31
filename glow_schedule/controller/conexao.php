<?php
class Conexao {
    private $host = 'localhost'; // ou o seu host
    private $db = 'glow_schedule'; // nome do banco de dados
    private $user = 'root'; // nome do usuário
    private $pass = ''; // senha do usuário
    private $conexao;

    public function __construct() {
        $this->conexao = new mysqli($this->host, $this->user, $this->pass, $this->db);
        if ($this->conexao->connect_error) {
            die("Conexão falhou: " . $this->conexao->connect_error);
        }
    }

    public function getConexao() {
        return $this->conexao;
    }
}

?>
