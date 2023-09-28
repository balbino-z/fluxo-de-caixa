<?php
// Verifique se o tipo, valor, data e descrição foram enviados
if (isset($_POST['tipo']) && isset($_POST['valor']) && isset($_POST['data']) && isset($_POST['descricao'])) {
    // Captura os valores enviados via POST
    $tipo = $_POST['tipo'];
    $valor = $_POST['valor'];
    $data = $_POST['data'];
    $descricao = $_POST['descricao'];

    // Faça a validação dos dados, como formatos de data, valores numéricos, etc., conforme necessário

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

        // Preparar a consulta SQL para inserir um novo registro
        $consultaInserirRegistro = "INSERT INTO lancamentos (tipo, valor, data, descricao) VALUES (:tipo, :valor, :data, :descricao)";
        $stmtInserirRegistro = $conn->prepare($consultaInserirRegistro);
        $stmtInserirRegistro->bindParam(":tipo", $tipo, PDO::PARAM_STR);
        $stmtInserirRegistro->bindParam(":valor", $valor, PDO::PARAM_STR);
        $stmtInserirRegistro->bindParam(":data", $data, PDO::PARAM_STR);
        $stmtInserirRegistro->bindParam(":descricao", $descricao, PDO::PARAM_STR);

        // Executar a consulta SQL para inserir o registro
        $stmtInserirRegistro->execute();

        // Retornar uma resposta de sucesso (você pode personalizar a resposta conforme necessário)
        echo "Registro adicionado com sucesso!";
    } catch (PDOException $e) {
        // Capturar e lidar com erros de banco de dados
        echo "Erro ao adicionar registro: " . $e->getMessage();
    }
} else {
    // Se os dados não foram enviados corretamente, retorne uma mensagem de erro
    echo "Dados incompletos ou ausentes.";
}
?>
