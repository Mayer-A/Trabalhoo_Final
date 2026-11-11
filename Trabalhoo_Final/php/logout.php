<?php
// ============================================================================
// ENCERRAMENTO DE SESSÃO (LOGOUT.PHP)
// ============================================================================

// 1. Inicia a sessão para obter acesso às variáveis ativas
session_start();

// 2. Limpa todas as variáveis armazenadas na sessão ($_SESSION['adm'], $_SESSION['nome'], etc.)
$_SESSION = array();

// 3. Destrói o cookie de sessão no navegador (boa prática de segurança)
if (ini_get("session.use_cookies")) {
    $params = session_get_cookie_params();
    setcookie(
        session_name(), 
        '', 
        time() - 42000,
        $params["path"], 
        $params["domain"],
        $params["secure"], 
        $params["httponly"]
    );
}

// 4. Destrói completamente a sessão no servidor
session_destroy();

// 5. Redireciona o usuário de volta para a tela de login
header("Location: ../html/login.html");
exit;
?>