<?php
// Configurações do banco de dados
$host = 'localhost';
$dbname = 'fluxo';
$username = 'root';
$password = '';

try {
    // Conectar ao banco de dados usando PDO
    $conn = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    
    // Configurar o PDO para lançar exceções em caso de erros
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Consulta para verificar registros de saída
    $consultaSaidas = "SELECT * FROM lancamentos WHERE tipo = 'saida'";
    
    // Preparar e executar a consulta
    $stmt = $conn->prepare($consultaSaidas);
    $stmt->execute();
    
    // Verificar se existem registros de saída
    if ($stmt->rowCount() > 0) {
        echo "Existem registros de saída na tabela 'lancamentos'.";
    } else {
        echo "Não existem registros de saída na tabela 'lancamentos'.";
    }
    
    // Fechar a conexão
    $conn = null;
} catch (PDOException $e) {
    die("Erro de conexão: " . $e->getMessage());
}
?>
