<?php
session_start();
if (!isset($_SESSION["username"])) {
    header("Location: login.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $valor = $_POST["valor"];
    $data = $_POST["data"];
    $descricao = $_POST["descricao"];
    
    try {
        // Conectar ao banco de dados usando PDO
        $conn = new PDO("mysql:host=localhost;dbname=fluxo", "root", "");
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // Preparar a instrução SQL usando placeholders para prevenir SQL injection
        $sql = "INSERT INTO saidas (valor, data, descricao) VALUES (:valor, :data, :descricao)";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':valor', $valor);
        $stmt->bindParam(':data', $data);
        $stmt->bindParam(':descricao', $descricao);

        // Executar a consulta
        $stmt->execute();

        // Redirecionar para a página de saídas novamente ou exibir uma mensagem de sucesso
        header("Location: saidas.php?success=1");
        exit();
    } catch (PDOException $e) {
        echo "Erro ao inserir saída: " . $e->getMessage();
    }
}
?>
