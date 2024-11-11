<?php

require_once("../controller/conexao.php");
require_once("../controller/global.php");
require_once("../controller/usuarioController.php");

if(session_status() === PHP_SESSION_NONE){
    session_start();
}
session_unset(); 
session_destroy();

header("Location: /glow_schedule/login.php")

?>