<?php
require_once $_SERVER['DOCUMENT_ROOT'] . "/glow_schedule/controller/global.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/glow_schedule/model/esteticista/esteticista.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/glow_schedule/model/message.php";

class EsteticistaController {
    private $esteticista;
    private $mensagem;

    public function __construct() {
        $this->esteticista = new Esteticista();

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
            } catch (Exception $e) {
                header("Location:  /glow_schedule/esteticista/esteticistas.php?status=error&message=" . urlencode($e->getMessage()));
                exit();
            }
        } elseif (isset($_GET['token'])) {
            $this->buscarPorToken($_GET['token']); // Chama a função de busca por token
        } else {
            $this->listar(); // Chama a função de listagem de esteticistas
        }
    }

    private function inserir() {
        $fotoPath = null;

        if (isset($_FILES['foto_esteticista']) && $_FILES['foto_esteticista']['error'] == 0) {
            $fotoPath = $this->uploadFoto();
            $this->esteticista->setFoto($fotoPath);
        }

        $this->mapEsteticistaFromPost();
        $this->esteticista->setToken($this->esteticista->gerarToken());

        try {
            if ($this->esteticista->inserir($this->esteticista, $this->esteticista->getSenha())) { 
                $this->mensagem->setMessage("Perfil Atualizado", "esteticista inserido com sucesso!", "success", "../esteticistas.php");
                exit();
            } else {
                throw new Exception("Erro ao inserir esteticista.");
            }

        $token = $this->esteticista->gerarToken(); 
        $esteticistaEncontrado = $this->esteticista->buscarPorToken($token);

        if ($esteticistaEncontrado) {
            var_dump("esteticista encontrado:", $esteticistaEncontrado);
        } else {
         echo "Erro: esteticista não encontrado para o token fornecido.";
        }
        } catch (Exception $e) {
            die("Erro ao inserir: " . $e->getMessage());
        }
} 


    private function listar() {
        $esteticistas = $this->esteticista->listar();
        include $_SERVER['DOCUMENT_ROOT'] . '../glow_schedule/esteticista/esteticistas.php';
    }

    private function buscarPorToken($token) {
        $esteticista = $this->esteticista->buscarPorToken($token);
        include $_SERVER['DOCUMENT_ROOT'] . '../glow_schedule/esteticista/editarEsteticista.php';
    }

    private function atualizar() {
        $this->mapEsteticistaFromPost();  

            $token = $_POST['token_esteticista'];
            $esteticistaAtual = $this->esteticista->buscarPorToken($token);

            if (isset($_FILES['foto_esteticista']) && $_FILES['foto_esteticista']['error'] == 0) {
                $fotoPath = $this->uploadFoto();
                $this->esteticista->setFoto($fotoPath);
            } else {
                $this->esteticista->setFoto($esteticistaAtual['foto_esteticista']);
            }

           $senha_atual_esteticista = filter_input(INPUT_POST, "senha_esteticista");
            $nova_senha = filter_input(INPUT_POST, "nova_senha");

            if (!empty($senha_atual_esteticista) && !empty($nova_senha)) {
                if(password_verify($senha_atual_esteticista, $esteticistaAtual['senha_esteticista'])) {
                    echo("password verify sucesso");
                    $hash_nova_senha = $this->esteticista->gerarSenha($nova_senha);
                    $this->esteticista->setSenha($hash_nova_senha);
                } else {
                    echo("password verify fracasso");
                    $this->mensagem->setMessage("Erro", "Senha atual incorreta, não foi possível atualiza-la!", "error", "back");
                    return;
                }
            }

            $this->esteticista->setToken($token);
            if ($this->esteticista->atualizar()) {
                $this->mensagem->setMessage("Sucesso", "Perfil atualizado com sucesso", "success", "../../esteticista/esteticistas.php");
            } else {
                throw new Exception("Erro ao atualizar perfil.");
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
        return null; 
    }

    private function mapEsteticistaFromPost() {
        $this->esteticista->setCpf($_POST['cpf_esteticista'] ?? '');
        $this->esteticista->setNome($_POST['nome_esteticista'] ?? '');
        $this->esteticista->setApelido($_POST['apelido_esteticista'] ?? '');
        $this->esteticista->setEmail($_POST['email_esteticista'] ?? '');
        $this->esteticista->setTelefone($_POST['telefone_esteticista'] ?? '');
        $this->esteticista->setFormacao($_POST['formacao_esteticista'] ?? '');
        $this->esteticista->setDescricaoP($_POST['descricao_p_esteticista'] ?? '');
        $this->esteticista->setDescricaoG($_POST['descricao_g_esteticista'] ?? '');
        $this->esteticista->setInstagram($_POST['instagram_esteticista'] ?? '');
        $this->esteticista->setFacebook($_POST['facebook_esteticista'] ?? '');
        $this->esteticista->setLinkedin($_POST['linkedin_esteticista'] ?? '');
        $this->esteticista->setSenha($_POST['senha_esteticista'] ?? '');
    }
}
new EsteticistaController();
?>
