<?php

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

class Message {

    private $url;

    public function __construct($url) {
        $this->url = $url;
    }

    
    public function setMessage($titulo, $msg, $type, $redirect = "../html/index.php" /* trocar pra página principal do projeto dps */) {
        $_SESSION["titulo"] = $titulo;
        $_SESSION["msg"] = $msg;
        $_SESSION["type"] = $type;
    
        if($redirect != "back"){
            header("Location: $this->url" . $redirect); 
        }  else {
            header("Location:" . $_SERVER["HTTP_REFERER"]);
        }
    }
    public function getMessage() {
        if (!empty($_SESSION["msg"])) {
            return [
                "msg" => $_SESSION["msg"],
                "type" => $_SESSION["type"],
                "titulo" => $_SESSION["titulo"]
            ];
        } else {
            return false;
        }
    }

    public function limparMessage() {
        $_SESSION["msg"] = "";
        $_SESSION["type"] = "";
        $_SESSION["titulo"] = "";
    }
}