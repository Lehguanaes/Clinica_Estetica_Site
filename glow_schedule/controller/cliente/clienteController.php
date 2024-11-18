/<?php

require_once $_SERVER['DOCUMENT_ROOT'] . "/glow_schedule/model/cliente/cliente.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/glow_schedule/model/message.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/glow_schedule/controller/global.php";

class ClienteController {
    private $cliente;
    private $mensagem;

    public function __construct() {
        $this->cliente = new Cliente(); 

        // Inicializa a variável $mensagem com o $BASE_URL
        global $BASE_URL;
        $this->mensagem = new Message($BASE_URL); 

        // Verifica se a ação foi passada via POST
        if (isset($_POST['acao'])) {
                switch ($_POST['acao']) {
                    case "inserir":
                        $this->inserir(); // Chama a função de inserção
                        break;
                    case "atualizar":
                        $this->atualizar(); // Chama a função de atualização
                        break;

                    default:
                        throw new Exception("Ação inválida.");
                }
                header("Location: /glow_schedule/cliente/consultarCliente.php?status=success");
        } elseif (isset($_GET['token'])) {
            $this->buscarPorToken($_GET['token']); // Chama a função de busca por token
        } else {
            $this->listar(); // Chama a função de listagem de clientes
        }
    }

    private function inserir() {
        $fotoPath = null;

        // Tenta fazer o upload da foto, se houver uma imagem enviada
        if (isset($_FILES['foto_cliente']) && $_FILES['foto_cliente']['error'] == 0) {
            $fotoPath = $this->uploadFoto(); // Chama a função de upload de foto

            if ($fotoPath) {
                $this->cliente->setFoto($fotoPath); // Atribui o caminho da foto ao objeto cliente
            } else {
                throw new Exception("Erro ao fazer upload da foto.");
            }
        }

        $this->mapClienteFromPost(); 
        $this->cliente->setToken($this->cliente->gerarToken()); 
        try {
            if ($this->cliente->inserir($this->cliente, $this->cliente->getSenha())) { 
                $this->mensagem->setMessage("Perfil Atualizado", "Cliente inserido com sucesso!", "success", "../consultarCliente");
                header("Location: /glow_schedule/cliente/consultarCliente.php?status=success");
                exit();
            } else {
                throw new Exception("Erro ao inserir cliente.");
            }

        $token = $this->cliente->gerarToken(); 
        $clienteEncontrado = $this->cliente->buscarPorToken($token);

        if ($clienteEncontrado) {
            var_dump("Cliente encontrado:", $clienteEncontrado);
        } else {
         echo "Erro: Cliente não encontrado para o token fornecido.";
        }
        } catch (Exception $e) {
            die("Erro ao inserir: " . $e->getMessage());
        }
} 


    private function listar() {
        $clientes = $this->cliente->listar();  
        include $_SERVER['DOCUMENT_ROOT'] . '/glow_schedule/cliente/consultarCliente.php';  
    }


    private function buscarPorToken($token) {
            $cliente = $this->cliente->buscarPorToken($token); 
            include $_SERVER['DOCUMENT_ROOT'] . '/glow_schedule/cliente/consultarCliente.php';  
        }


        private function atualizar() {
            
            $this->mapClienteFromPost();  
            try {
                if (empty($_POST['token_cliente'])) {
                    throw new Exception("Token de cliente não fornecido.");
                }

                $clienteAtual = $this->cliente->buscarPorToken($_POST['token_cliente']);
                $this->cliente->setFoto($clienteAtual['foto_cliente']);
            
                $fotoPath = $this->uploadFoto();
                if ($fotoPath) {
                $this->cliente->setFoto($fotoPath); 
                }
              
                $senha_atual_cliente = filter_input(INPUT_POST, "senha_cliente");
                $nova_senha = filter_input(INPUT_POST, "nova_senha");
        
                $token = $_POST['token_cliente']; 
                $cliente3 = $this->cliente->buscarPorToken($token);

                if (!$cliente3) {
                    throw new Exception("Cliente não encontrado para o token fornecido.");
                }

                if (!empty($nova_senha)) {
                if(password_verify($senha_atual_cliente, $cliente3['senha_cliente'])) {
                    $hash_nova_senha = $this->cliente->gerarSenha($nova_senha);
        
                    // Debug
                    var_dump('Senha atual verificada', $senha_atual_cliente, $nova_senha, $hash_nova_senha);
        
                    $this->cliente->setSenha($hash_nova_senha); // atribui o hash da nova senha no obj cliente
                    $this->cliente->setToken($token); // atribui o token no obj cliente
                } else {
                    throw new Exception("Senha atual incorreta.");
                }}
        
                // Chama o método atualizar
                if ($this->cliente->atualizar()) {
                    echo "Atualização concluída com sucesso";
                } else {
                    echo "Falha ao atualizar o cliente";
                }
            } catch (Exception $e) {
                die("Erro ao atualizar: " . $e->getMessage());
            }
        }
        
    
// ver pq a ft n ta atualizando
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
                    return $fotoPath; // Retorna o caminho da foto se o upload for bem-sucedido
                } else {
                    throw new Exception("Erro ao fazer upload da foto.");
                }
            }
            return null;
        }
    
        private function mapClienteFromPost() {
            $this->cliente->setCpf($_POST['cpf_cliente'] );
            $this->cliente->setNome($_POST['nome_cliente']);
            $this->cliente->setTelefone($_POST['telefone_cliente']);
            $this->cliente->setEmail($_POST['email_cliente']);
            $this->cliente->setSenha($_POST['senha_cliente']);
        }


        private function atualizar2() {
            
            $this->mapClienteFromPost();  
            try {
                if (empty($_POST['token_cliente'])) {
                    throw new Exception("Token de cliente não fornecido.");
                }

                $clienteAtual = $this->cliente->buscarPorToken($_POST['token_cliente']);
                $this->cliente->setFoto($clienteAtual['foto_cliente']);
            
                $fotoPath = $this->uploadFoto();
                if ($fotoPath) {
                $this->cliente->setFoto($fotoPath); 
                }
              
                $senha_atual_cliente = filter_input(INPUT_POST, "senha_cliente");
                $nova_senha = filter_input(INPUT_POST, "nova_senha");
        
                $token = $_POST['token_cliente']; 
                $cliente3 = $this->cliente->buscarPorToken($token);

                if (!$cliente3) {
                    throw new Exception("Cliente não encontrado para o token fornecido.");
                }

                if (!empty($nova_senha)) {
                if(password_verify($senha_atual_cliente, $cliente3['senha_cliente'])) {
                    $hash_nova_senha = $this->cliente->gerarSenha($nova_senha);
        
                    // Debug
                    var_dump('Senha atual verificada', $senha_atual_cliente, $nova_senha, $hash_nova_senha);
        
                    $this->cliente->setSenha($hash_nova_senha); // atribui o hash da nova senha no obj cliente
                    $this->cliente->setToken($token); // atribui o token no obj cliente
                } else {
                    throw new Exception("Senha atual incorreta.");
                }}
        
                // Chama o método atualizar
                if ($this->cliente->atualizar()) {
                    echo "Atualização concluída com sucesso";
                } else {
                    echo "Falha ao atualizar o cliente";
                }
            } catch (Exception $e) {
                die("Erro ao atualizar: " . $e->getMessage());
            }
        }
    }
    
    new ClienteController();
    ?>
