<?php
$host = "localhost";
$usuario_db = "root";
$senha_db = "";
$banco_de_dados = "fluxo";

try {
    $conn = new PDO("mysql:host=$host;dbname=$banco_de_dados", $usuario_db, $senha_db);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Erro na conexão com o banco de dados: " . $e->getMessage());
}
?>
