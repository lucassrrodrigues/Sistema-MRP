<?php
// Inicia a sessão
session_start();

// Destrói todas as variáveis de sessão
$_SESSION = array();

// Se necessário, destrói a sessão
if (session_id() != "" || isset($_COOKIE[session_name()])) {
    setcookie(session_name(), '', time() - 3600, '/');
}

// Finaliza a sessão
session_destroy();

// Redireciona para a página de login
header("Location: login.php");
exit;
?>
