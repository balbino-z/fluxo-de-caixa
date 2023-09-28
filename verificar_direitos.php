<?php
session_start(); // Certifique-se de iniciar a sessão se ainda não estiver

// Verificar se o usuário está logado e tem direitos definidos na sessão
if (isset($_SESSION["direitos"])) {
    $direitos = $_SESSION["direitos"];

    // Verificar os direitos do usuário
    if ($direitos == 1) {
        // Redirecionar o usuário normal para a página do painel de usuário
        header("Location: painel_user.php");
        exit();
    } elseif ($direitos == 2) {
        // Redirecionar o administrador para a página do painel de administração
        header("Location: painel_adm.php");
        exit();
    }
}

// Se não houver direitos definidos na sessão, redirecione para uma página de erro ou login
header("Location: index.php");
exit();
?>
