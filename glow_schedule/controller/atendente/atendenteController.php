<?php

require_once $_SERVER['DOCUMENT_ROOT'] . "/glow_schedule/model/atendente/atendente.php";

class AtendenteController {
    private $atendente;

    public function __construct() {
        $this->atendente = new Atendente();

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
        } elseif (isset($_GET['cpf'])) {
            $this->buscarPorCpf($_GET['cpf']);
        } else {
            $this->listar();
        }
    }

    private function inserir() {
        $fotoPath = null;
    
        // Tenta fazer o upload da foto, se houver uma imagem enviada
        if (isset($_FILES['foto_atendente']) && $_FILES['foto_atendente']['error'] == 0) {
            $fotoPath = $this->uploadFoto();
            
            if ($fotoPath) {
                // Atribui o caminho da foto ao objeto antes de salvar
                $this->atendente->setFoto($fotoPath);
            } else {
                throw new Exception("Erro ao fazer upload da foto.");
            }
        }
    
        // Mapeia os outros campos
        $this->mapAtendenteFromPost();
    
        try {
            // Chama o método de inserção na classe Atendente
            $this->atendente->inserir();
            header("Location: /glow_schedule/atendente/consultarAtendente.php");
            exit();
        } catch (Exception $e) {
            die("Erro ao inserir: " . $e->getMessage());
        }
    }
      

    private function listar() {
        $atendentes = $this->atendente->listar();
        include $_SERVER['DOCUMENT_ROOT'] . '../glow_schedule/atendente/consultarAtendente.php';
    }

    private function buscarPorCpf($cpf_atendente) {
        $atendente = $this->atendente->buscarPorCpf($cpf_atendente);
        include $_SERVER['DOCUMENT_ROOT'] . '../glow_schedule/atendente/editarAtendente.php';
    }

    private function atualizar() {
        $this->mapAtendenteFromPost();
        try {
            $fotoPath = $this->uploadFoto();
            if ($fotoPath) {
                $this->atendente->setFoto($fotoPath);
            }
            $this->atendente->atualizar($_POST['cpf_atendente']);
            header("Location: /glow_schedule/atendente/consultarAtendente.php");
            exit();
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

            $upload_dir = $_SERVER['DOCUMENT_ROOT'] . '/glow_schedule/uploads/';
            $fotoPath = 'uploads/' . basename($foto['name']);

            if (move_uploaded_file($foto['tmp_name'], $upload_dir . basename($foto['name']))) {
                return $fotoPath;
            } else {
                throw new Exception("Erro ao fazer upload da foto.");
            }
        }
        return null;
    }

    private function mapAtendenteFromPost() {
        $this->atendente->setCpf($_POST['cpf_atendente']);
        $this->atendente->setNome($_POST['nome_atendente']);
        $this->atendente->setTelefone($_POST['telefone_atendente']);
        $this->atendente->setEmail($_POST['email_atendente']);
        $this->atendente->setSenha($_POST['senha_atendente']);
        // Não define a foto aqui, pois é feita no método inserir()
    }
    
}

new AtendenteController();
?>