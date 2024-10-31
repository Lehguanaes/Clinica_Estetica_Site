<?php

// Inclui o arquivo que contém a classe Atendente
require_once $_SERVER['DOCUMENT_ROOT'] . "/glow_schedule/model/atendente.php";

class AtendenteController {
    private $atendente;

    // Construtor da classe
    public function __construct() {
        $this->atendente = new Atendente(); // Instancia um novo objeto Atendente

        // Verifica se a ação foi enviada via POST
        if (isset($_POST['acaoAT'])) {
            try {
                // Executa a ação correspondente
                switch ($_POST['acaoAT']) {
                    case "inserirA":
                        $this->inserirA(); // Chama o método para inserir um atendente
                        break;
                    case "atualizarA":
                        $this->atualizarA(); // Chama o método para atualizar um atendente
                        break;
                    case "selectA":
                        $this->entrarA(); // Chama o método para entrar no sistema
                        break;
                    default:
                        throw new Exception("Ação inválida."); // Lança uma exceção para ações inválidas
                }
                              
            } catch (Exception $e) {
                // Redireciona com uma mensagem de erro em caso de exceção
                header("Location: ../perfilAtendente.php?status=error&message=" . urlencode($e->getMessage()));
                exit();
            }
        } elseif (isset($_GET['cpf_atendente'])) {
            // Se um CPF for passado via GET, busca o atendente correspondente
            $this->buscarPorCpfA($_GET['cpf_atendente']);
        } else {
            // Caso contrário, lista todos os atendentes
            $this->listarA();
        }
    }

    // Método para inserir um atendente
    private function inserirA() {
        // Verifica se um arquivo foi enviado
        if (isset($_FILES['foto_atendente']) && $_FILES['foto_atendente']['error'] == 0) {
            $fotoPath = $this->uploadFoto(); // Processa o upload da foto

            if ($fotoPath) {
                $this->atendente->setFotoA($fotoPath); // Adiciona o caminho da foto ao objeto atendente
            }
        } else {
            throw new Exception("Nenhum arquivo de foto foi enviado ou ocorreu um erro."); // Lança uma exceção se não houver foto
        }

        // Mapeia os dados do POST para o objeto Atendente
        $this->mapAtendenteFromPost();
        try {
            $this->atendente->inserirA(); // Tenta inserir o atendente no banco de dados
            header("Location: /glow_schedule/perfilAtendente.php"); // Redireciona em caso de sucesso
            exit();
        } catch (Exception $e) {
            die("Erro ao inserir: " . $e->getMessage()); // Exibe erro caso a inserção falhe
        }
    }

    // Método para listar todos os atendentes
    private function listarA() {
        return $this->atendente->listarA(); // Retorna a lista de atendentes
    }

    // Método para buscar atendente por CPF
    public function buscarPorCpfA($cpf_atendente) {
        return $this->atendente->buscarPorCpfA($cpf_atendente); // Retorna o atendente encontrado
    }

    // Método para atualizar um atendente
    private function atualizarA() {
        $this->mapAtendenteFromPost(); // Mapeia dados do POST
        try {
            $fotoPath = $this->uploadFoto(); // Processa upload da foto, se houver
            if ($fotoPath) {
                $this->atendente->setFotoA($fotoPath); // Adiciona o caminho da nova foto
            }
            $this->atendente->atualizarA($_POST['cpf_atendente']); // Atualiza o atendente no banco de dados
            
        } catch (Exception $e) {
            die("Erro ao atualizar: " . $e->getMessage()); // Exibe erro caso a atualização falhe
        }
    }

    // Mapeia os dados do POST para o objeto Atendente
    private function mapAtendenteFromPost() {
        $this->atendente->setCpfA($_POST['cpf_atendente']);
        $this->atendente->setNomeA($_POST['nome_atendente']);
        $this->atendente->setEmailA($_POST['email_atendente']);
        $this->atendente->setTelefoneA($_POST['telefone_atendente']);
        $this->atendente->setSenhaA($_POST['senha_atendente']);
    }

    // Método para processar o upload da foto
    private function uploadFoto() {
        if (isset($_FILES['foto_atendente']) && $_FILES['foto_atendente']['error'] == 0) {
            $foto = $_FILES['foto_atendente'];

            // Verifica o tipo e o tamanho do arquivo
            $allowedTypes = ['image/jpeg', 'image/png', 'image/gif'];
            if (!in_array($foto['type'], $allowedTypes)) {
                throw new Exception("Tipo de arquivo inválido. Aceitos: JPEG, PNG, GIF."); // Lança exceção para tipos inválidos
            }
            if ($foto['size'] > 2 * 1024 * 1024) { // Limite de 2MB
                throw new Exception("O arquivo deve ter menos de 2MB."); // Lança exceção para arquivos muito grandes
            }

            $upload_dir = $_SERVER['DOCUMENT_ROOT'] . '/glow_schedule/uploads/'; // Diretório de upload
            $fotoPath = 'uploads/' . basename($foto['name']); // Caminho relativo

            // Tenta mover o arquivo para o diretório de uploads
            if (move_uploaded_file($foto['tmp_name'], $upload_dir . basename($foto['name']))) {
                return $fotoPath; // Retorna o caminho relativo da foto
            } else {
                throw new Exception("Erro ao fazer upload da foto."); // Lança exceção se o upload falhar
            }
        }
        return null; // Retorna null se não houver foto
    }

    // Método para realizar a entrada do atendente
    public function entrarA() { 
        $this->atendente->setEmailA($_POST['email_atendente']);
        $this->atendente->setSenhaA($_POST['senha_atendente']);
    
        $resultado = $this->atendente->entrarA(); // Tenta entrar no sistema
    
        if ($resultado) {
            // Se a entrada for bem-sucedida, busca os dados do atendente pelo email
            $atendenteData = $this->atendente->buscarPorEmailA($_POST['email_atendente']);
            $cpf_atendente = $atendenteData['cpf_atendente'];
    
            // Redireciona para a página de edição de senha
            header("Location: /glow_schedule/editarSenha.php?cpf_atendente=" . $cpf_atendente);
            exit();
        } else {
            throw new Exception("Email ou senha incorretos."); // Lança exceção se email ou senha forem inválidos
        }
    }
}

// Instancia o controlador ao final do arquivo
new AtendenteController();
?>
