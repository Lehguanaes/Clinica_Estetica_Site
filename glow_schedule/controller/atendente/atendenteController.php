<?php
require_once $_SERVER['DOCUMENT_ROOT'] . "/glow_schedule/model/atendente/atendente.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/glow_schedule/model/message.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/glow_schedule/controller/global.php";

class AtendenteController {
    private $atendente;
    private $mensagem;

    public function __construct() {
        $this->atendente = new Atendente();

        global $BASE_URL;
        $this->mensagem = new Message($BASE_URL); 

        if (isset($_POST['acao'])) {
            try {
                switch ($_POST['acao']) {
                    case "inserir":
                        $this->inserir();
                        break;
                    case "atualizar":
                        $this->atualizar();
                        break;
                    default:
                        throw new Exception("Ação inválida.");
                }
                header("Location: /glow_schedule/atendente/consultarAtendente.php?status=success");
                exit();
            } catch (Exception $e) {
                header("Location: /glow_schedule/atendente/consultarAtendente.php?status=error&message=" . urlencode($e->getMessage()));
                exit();
            }
        } elseif (isset($_GET['token'])) {
            $this->buscarPorToken($_GET['token']);
        } else {
            $this->listar();
        }
    }

    private function inserir() {
        $fotoPath = null;

        if (isset($_FILES['foto_atendente']) && $_FILES['foto_atendente']['error'] == 0) {
            $fotoPath = $this->uploadFoto();
            $this->atendente->setFoto($fotoPath);
        }

        $this->mapAtendenteFromPost();
        $this->atendente->setToken($this->atendente->gerarToken());

        try {
            if ($this->atendente->inserir($this->atendente, $this->atendente->getSenha())) { 
                $this->mensagem->setMessage("Perfil Atualizado", "atendente inserido com sucesso!", "success", "../consultaratendente");
                header("Location: /glow_schedule/atendente/consultaratendente.php?status=success");
                exit();
            } else {
                throw new Exception("Erro ao inserir atendente.");
            }

        $token = $this->atendente->gerarToken(); 
        $atendenteEncontrado = $this->atendente->buscarPorToken($token);

        if ($atendenteEncontrado) {
            var_dump("atendente encontrado:", $atendenteEncontrado);
        } else {
         echo "Erro: atendente não encontrado para o token fornecido.";
        }
        } catch (Exception $e) {
            die("Erro ao inserir: " . $e->getMessage());
        }
    }

    private function listar() {
        $atendentes = $this->atendente->listar();
        include $_SERVER['DOCUMENT_ROOT'] . '../glow_schedule/atendente/consultarAtendente.php';
    }

    private function buscarPorToken($token) {
        $atendente = $this->atendente->buscarPorToken($token);

        if (!$atendente) {
            throw new Exception("Atendente não encontrado para o token fornecido.");
        }

        include $_SERVER['DOCUMENT_ROOT'] . '../glow_schedule/atendente/editarAtendente.php';
    }

    private function atualizar() {
        $this->mapAtendenteFromPost();  

        try {
            if (empty($_POST['token_atendente'])) {
                throw new Exception("Token de atendente não fornecido.");
            }

            $token = $_POST['token_atendente'];
            $atendenteAtual = $this->atendente->buscarPorToken($token);

            if (!$atendenteAtual) {
                throw new Exception("Atendente não encontrado para o token fornecido.");
            }

            $this->mapAtendenteFromPost();

            if (isset($_FILES['foto_atendente']) && $_FILES['foto_atendente']['error'] == 0) {
                $fotoPath = $this->uploadFoto();
                $this->atendente->setFoto($fotoPath);
            } else {
                $this->atendente->setFoto($atendenteAtual['foto_atendente']);
            }

            $senha_atual_atendente = filter_input(INPUT_POST, "senha_atendente");
            $nova_senha = filter_input(INPUT_POST, "nova_senha");
    
            $token = $_POST['token_atendente']; 
            $atendente3 = $this->atendente->buscarPorToken($token);

            if (!$atendente3) {
                throw new Exception("atendente não encontrado para o token fornecido.");
            }

            if (!empty($nova_senha)) {
            if(password_verify($senha_atual_atendente, $atendente3['senha_atendente'])) {
                $hash_nova_senha = $this->atendente->gerarSenha($nova_senha);
    
                var_dump('Senha atual verificada', $senha_atual_atendente, $nova_senha, $hash_nova_senha);
    
                $this->atendente->setSenha($hash_nova_senha); 
                $this->atendente->setToken($token); 
            } else {
                throw new Exception("Senha atual incorreta.");
            }
        }

            if (!$this->atendente->atualizar()) {
                throw new Exception("Falha ao atualizar o atendente.");
            }
            echo "Atualização concluída com sucesso.";
        } catch (Exception $e) {
            die("Erro ao atualizar: " . $e->getMessage());
        }
    }

    private function uploadFoto() {
        if (isset($_FILES['foto_atendente']) && $_FILES['foto_atendente']['error'] == 0) {
            $foto = $_FILES['foto_atendente'];

            $allowedTypes = ['image/jpeg', 'image/png', 'image/gif'];
            if (!in_array($foto['type'], $allowedTypes)) {
                throw new Exception("Tipo de arquivo inválido. Aceitos: JPEG, PNG, GIF.");
            }
            if ($foto['size'] > 2 * 1024 * 1024) {
                throw new Exception("O arquivo deve ter menos de 2MB.");
            }

            $uploadDir = $_SERVER['DOCUMENT_ROOT'] . '/glow_schedule/uploads/';
            $fotoPath = 'uploads/' . basename($foto['name']);

            if (move_uploaded_file($foto['tmp_name'], $uploadDir . basename($foto['name']))) {
                return $fotoPath;
            } else {
                throw new Exception("Erro ao fazer upload da foto.");
            }
        }
        return null;
    }

    private function mapAtendenteFromPost() {
        $this->atendente->setCpf($_POST['cpf_atendente'] ?? null);
        $this->atendente->setNome($_POST['nome_atendente'] ?? null);
        $this->atendente->setTelefone($_POST['telefone_atendente'] ?? null);
        $this->atendente->setEmail($_POST['email_atendente'] ?? null);
        $this->atendente->setSenha($_POST['senha_atendente'] ?? null);
    }
}

new AtendenteController();
?>