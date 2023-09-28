<?php
session_start();

if (!isset($_SESSION["username"])) {
    header("Location: login.php");
    exit();
}

// Verifique se o usuário tem permissão para excluir registros (neste caso, apenas administradores)
if ($_SESSION["direitos"] != 2) {
    header("Location: dashboard.php");
    exit();
}

try {
    // Conectar ao banco de dados usando PDO
    $conn = new PDO("mysql:host=localhost;dbname=fluxo", "root", "");
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Iniciar uma transação para garantir que ambas as exclusões ocorram com sucesso
    $conn->beginTransaction();

    // Query SQL para excluir todos os registros de entradas
    $excluirEntradasSQL = "DELETE FROM entradas";
    $stmtExcluirEntradas = $conn->prepare($excluirEntradasSQL);
    $stmtExcluirEntradas->execute();

    // Query SQL para excluir todos os registros de saídas
    $excluirSaidasSQL = "DELETE FROM saidas";
    $stmtExcluirSaidas = $conn->prepare($excluirSaidasSQL);
    $stmtExcluirSaidas->execute();

    // Commit se ambas as exclusões foram bem-sucedidas
    $conn->commit();
    
    // Redirecionar de volta para o painel de administração com uma mensagem de sucesso
    header("Location: dashboard.php?success=1");
    exit();
} catch (PDOException $e) {
    // Rollback se houver algum erro e redirecionar com uma mensagem de erro
    $conn->rollBack();
    header("Location: dashboard.php?error=1");
    exit();
}
?>
