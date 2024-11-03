<?php

require_once $_SERVER['DOCUMENT_ROOT'] . "/glow_schedule/model/cliente/cliente.php";

class ClienteController {
    private $cliente;

    public function __construct() {
        $this->cliente = new Cliente();

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
                header("Location: /glow_schedule/cliente/consultarCliente.php?status=success");
                exit();
            } catch (Exception $e) {
                header("Location: /glow_schedule/cliente/consultarCliente.php?status=error&message=" . urlencode($e->getMessage()));
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
        if (isset($_FILES['foto_cliente']) && $_FILES['foto_cliente']['error'] == 0) {
            $fotoPath = $this->uploadFoto();
            
            if ($fotoPath) {
                // Atribui o caminho da foto ao objeto antes de salvar
                $this->cliente->setFoto($fotoPath);
            } else {
                throw new Exception("Erro ao fazer upload da foto.");
            }
        }
    
        // Mapeia os outros campos
        $this->mapClienteFromPost();
    
        try {
            // Chama o método de inserção na classe cliente
            $this->cliente->inserir();
            header("Location: /glow_schedule/cliente/consultarCliente.php");
            exit();
        } catch (Exception $e) {
            die("Erro ao inserir: " . $e->getMessage());
        }
    }

    private function listar() {
        $clientes = $this->cliente->listar();
        include $_SERVER['DOCUMENT_ROOT'] . '../glow_schedule/cliente/consultarCliente.php';
    }

    private function buscarPorCpf($cpf_cliente) {
        $cliente = $this->cliente->buscarPorCpf($cpf_cliente);
        include $_SERVER['DOCUMENT_ROOT'] . '../glow_schedule/cliente/consultarCliente.php';
    }

    private function atualizar() {
        $this->mapClienteFromPost();
        try {
            $fotoPath = $this->uploadFoto();
            if ($fotoPath) {
                $this->cliente->setFoto($fotoPath);
            }
            $this->cliente->atualizar($_POST['cpf_cliente']);
            header("Location: /glow_schedule/cliente/consultarCliente.php");
            exit();
        } catch (Exception $e) {
            die("Erro ao atualizar: " . $e->getMessage());
        }
    }

    private function uploadFoto() {
        if (isset($_FILES['foto_cliente']) && $_FILES['foto_cliente']['error'] == 0) {
            $foto = $_FILES['foto_cliente'];

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

    private function mapClienteFromPost() {
        $this->cliente->setCpf($_POST['cpf_cliente']);
        $this->cliente->setNome($_POST['nome_cliente']);
        $this->cliente->setTelefone($_POST['telefone_cliente']);
        $this->cliente->setEmail($_POST['email_cliente']);
        $this->cliente->setSenha($_POST['senha_cliente']);
    }
    
}

new ClienteController();
?>
