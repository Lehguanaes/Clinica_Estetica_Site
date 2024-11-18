<?php

require_once $_SERVER['DOCUMENT_ROOT'] . "/glow_schedule/model/procedimento/procedimento.php";

if(session_status() === PHP_SESSION_NONE){
    session_start();
}


class ProcedimentoController {
    private $procedimento;

    public function __construct() {
        $this->procedimento = new Procedimento();

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
                header("Location: /glow_schedule/procedimento/consultarProcedimento.php?status=success");
                exit();
            } catch (Exception $e) {
                header("Location: /glow_schedule/procedimento/consultarProcedimento.php?status=error&message=" . urlencode($e->getMessage()));
                exit();
            }
        } elseif (isset($_GET['id_procedimento'])) {
            $this->buscarPorId($_GET['id_procedimento']);
        } else {
            $this->listar();
        }
    }

    private function inserir() {
        $fotoPath = null;
    
        // Upload da foto do procedimento, se houver
        if (isset($_FILES['foto_procedimento']) && $_FILES['foto_procedimento']['error'] == 0) {
            $fotoPath = $this->uploadFoto();
            
            if ($fotoPath) {
                $this->procedimento->setFoto($fotoPath);
            } else {
                throw new Exception("Erro ao fazer upload da foto.");
            }
        }
    
        // Mapeia os campos do formulário
        $this->mapProcedimentoFromPost();
    
        try {
            $this->procedimento->inserir();
            header("Location: /glow_schedule/procedimento/consultarProcedimento.php");
            exit();
        } catch (Exception $e) {
            die("Erro ao inserir: " . $e->getMessage());
        }
    }

    private function listar() {
        $procedimentos = $this->procedimento->listar();
        include $_SERVER['DOCUMENT_ROOT'] . '../glow_schedule/procedimento/consultarProcedimento.php';
    }

    private function buscarPorId($id_procedimento) {
        $procedimento = $this->procedimento->buscarPorId($id_procedimento);
        include $_SERVER['DOCUMENT_ROOT'] . '../glow_schedule/procedimento/editarProcedimento.php';
    }

    private function atualizar() {
        $this->mapProcedimentoFromPost();
        try {
            $fotoPath = $this->uploadFoto();
            if ($fotoPath) {
                $this->procedimento->setFoto($fotoPath);
            }
            $this->procedimento->atualizar($_POST['id_procedimento']);
            header("Location: /glow_schedule/procedimento/consultarProcedimento.php");
            exit();
        } catch (Exception $e) {
            die("Erro ao atualizar: " . $e->getMessage());
        }
    }

    private function uploadFoto() {
        if (isset($_FILES['foto_procedimento']) && $_FILES['foto_procedimento']['error'] == 0) {
            $foto = $_FILES['foto_procedimento'];

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

    private function mapProcedimentoFromPost() {
        $this->procedimento->setId($_POST['id_procedimento'] ?? null);
        $this->procedimento->setNome($_POST['nome_procedimento']);
        $this->procedimento->setDescricaoP($_POST['descricao_p_procedimento']);  // Correção aqui
        $this->procedimento->setDescricaoG($_POST['descricao_g_procedimento']);  // Correção aqui
        $this->procedimento->setPreco($_POST['preco_procedimento']);
        $this->procedimento->setDuracao($_POST['duracao_procedimento']);
        $this->procedimento->setManutencao($_POST['manutencao_procedimento']); // Correção do nome do campo
    }    
}

new ProcedimentoController();
?>