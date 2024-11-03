<?php

require_once $_SERVER['DOCUMENT_ROOT'] . "../glow_schedule/model/esteticista/esteticista.php";

class EsteticistaController {
    private $esteticista;

    public function __construct() {
        $this->esteticista = new Esteticista();

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
                header("Location: /glow_schedule/esteticista/consultarEsteticista.php?status=success");
                exit();
            } catch (Exception $e) {
                header("Location:  /glow_schedule/esteticista/consultarEsteticista.php?status=error&message=" . urlencode($e->getMessage()));
                exit();
            }
        } elseif (isset($_GET['cpf'])) {
            $this->buscarPorCpf($_GET['cpf']);
        } else {
            $this->listar();
        }
    }

    private function inserir() {
        // Verificar se um arquivo foi enviado
        if (isset($_FILES['foto_esteticista']) && $_FILES['foto_esteticista']['error'] == 0) {
            $fotoPath = $this->uploadFoto(); // Processar o upload da foto

            if ($fotoPath) {
                $this->esteticista->setFoto($fotoPath); // Adiciona o caminho da foto
            }
        } else {
            throw new Exception("Nenhum arquivo de foto foi enviado ou ocorreu um erro.");
        }

        $this->mapEsteticistaFromPost();
        try {
            $this->esteticista->inserir();
            header("Location: /glow_schedule/esteticista/esteticistas.php");
            exit();
        } catch (Exception $e) {
            die("Erro ao inserir: " . $e->getMessage());
        }
    }

    private function listar() {
        $esteticistas = $this->esteticista->listar();
        include $_SERVER['DOCUMENT_ROOT'] . '../glow_schedule/esteticista/consultaEsteticista.php';
    }

    private function buscarPorCpf($cpf_esteticista) {
        $esteticista = $this->esteticista->buscarPorCpf($cpf_esteticista);
        include $_SERVER['DOCUMENT_ROOT'] . '../glow_schedule/esteticista/editarEsteticista.php';
    }

    private function atualizar() {
        $this->mapEsteticistaFromPost();
        try {
            $fotoPath = $this->uploadFoto(); // Processar upload da foto, se houver
            if ($fotoPath) {
                $this->esteticista->setFoto($fotoPath); // Adicionar o caminho da nova foto
            }
            $this->esteticista->atualizar($_POST['cpf_esteticista']);
            header("Location: /glow_schedule/esteticista/consultarEsteticista.php");
            exit();
        } catch (Exception $e) {
            die("Erro ao atualizar: " . $e->getMessage());
        }
    }

    private function uploadFoto() {
        if (isset($_FILES['foto_esteticista']) && $_FILES['foto_esteticista']['error'] == 0) {
            $foto = $_FILES['foto_esteticista'];

            // Verifica o tipo e o tamanho do arquivo
            $allowedTypes = ['image/jpeg', 'image/png', 'image/gif'];
            if (!in_array($foto['type'], $allowedTypes)) {
                throw new Exception("Tipo de arquivo inválido. Aceitos: JPEG, PNG, GIF.");
            }
            if ($foto['size'] > 2 * 1024 * 1024) { // Limite de 2MB
                throw new Exception("O arquivo deve ter menos de 2MB.");
            }

            $upload_dir = $_SERVER['DOCUMENT_ROOT'] . '/glow_schedule/uploads/'; // Ajuste o caminho conforme necessário
            $fotoPath = 'uploads/' . basename($foto['name']); // Caminho relativo

            // Tenta mover o arquivo para o diretório
            if (move_uploaded_file($foto['tmp_name'], $upload_dir . basename($foto['name']))) {
                return $fotoPath; // Retorna o caminho relativo da foto
            } else {
                throw new Exception("Erro ao fazer upload da foto.");
            }
        }
        return null; // Retorna null se não houver foto
    }

    private function mapEsteticistaFromPost() {
        $this->esteticista->setCpf($_POST['cpf_esteticista']);
        $this->esteticista->setNome($_POST['nome_esteticista']);
        $this->esteticista->setApelido($_POST['apelido_esteticista']);
        $this->esteticista->setEmail($_POST['email_esteticista']);
        $this->esteticista->setTelefone($_POST['telefone_esteticista']);
        $this->esteticista->setFormacao($_POST['formacao_esteticista']);
        $this->esteticista->setDescricaoP($_POST['descricao_p_esteticista']);
        $this->esteticista->setDescricaoG($_POST['descricao_g_esteticista']);
        $this->esteticista->setInstagram($_POST['instagram_esteticista']);
        $this->esteticista->setFacebook($_POST['facebook_esteticista']);
        $this->esteticista->setLinkedin($_POST['linkedin_esteticista']);
        $this->esteticista->setSenha($_POST['senha_esteticista']);
    }
}
new EsteticistaController();
?>
