<?php
// Verifique se o ID do registro a ser excluído foi enviado via POST
if (isset($_POST['id'])) {
    // Captura o ID do registro
    $idRegistro = $_POST['id'];

    // Informações de conexão ao banco de dados
    $host = "localhost";
    $usuario_db = "root";
    $senha_db = "";
    $banco_de_dados = "fluxo";

    try {
        // Conectar ao banco de dados usando PDO
        $conn = new PDO("mysql:host=$host;dbname=$banco_de_dados", $usuario_db, $senha_db);

        // Definir o PDO para lançar exceções em caso de erros
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // Preparar a consulta SQL para excluir o registro com base no ID
        $consultaExcluirRegistro = "DELETE FROM lancamentos WHERE id = :id";
        $stmtExcluirRegistro = $conn->prepare($consultaExcluirRegistro);
        $stmtExcluirRegistro->bindParam(":id", $idRegistro, PDO::PARAM_INT);

        // Executar a consulta SQL para excluir o registro
        $stmtExcluirRegistro->execute();

        // Retornar uma resposta de sucesso (você pode personalizar a resposta conforme necessário)
        echo "Registro excluído com sucesso!";
    } catch (PDOException $e) {
        // Capturar e lidar com erros de banco de dados
        echo "Erro ao excluir registro: " . $e->getMessage();
    }
} else {
    // Se o ID do registro não foi enviado corretamente, retorne uma mensagem de erro
    echo "ID do registro não especificado.";
}
?>
