<?php
session_start();
if (!isset($_SESSION["username"])) {
    header("Location: login.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Processar o formulário de edição da saída
    $id_saida = $_POST["id"];
    $valor_saida = $_POST["valor"];
    $data_saida = $_POST["data"];
    $descricao_saida = $_POST["descricao"];

    try {
        // Conectar ao banco de dados usando PDO
        $conn = new PDO("mysql:host=localhost;dbname=fluxo", "root", "");
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // Preparar a instrução SQL usando placeholders para prevenir SQL injection
        $sql = "UPDATE saidas SET valor = :valor, data = :data, descricao = :descricao WHERE id = :id";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':valor', $valor_saida);
        $stmt->bindParam(':data', $data_saida);
        $stmt->bindParam(':descricao', $descricao_saida);
        $stmt->bindParam(':id', $id_saida);

        // Executar a consulta
        $stmt->execute();

        // Redirecionar para a página de saídas com mensagem de sucesso
        header("Location: saidas.php?success=3");
        exit();
    } catch (PDOException $e) {
        echo "Erro ao atualizar saída: " . $e->getMessage();
    }
} else {
    // Carregar dados da saída para edição
    if (isset($_GET["id"])) {
        $id_saida = $_GET["id"];

        try {
            // Conectar ao banco de dados usando PDO
            $conn = new PDO("mysql:host=localhost;dbname=fluxo", "root", "");
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            // Consulta SQL para obter os dados da saída
            $sql = "SELECT * FROM saidas WHERE id = :id";
            $stmt = $conn->prepare($sql);
            $stmt->bindParam(':id', $id_saida);
            $stmt->execute();
            $result = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($result) {
                $valor_saida = $result["valor"];
                $data_saida = $result["data"];
                $descricao_saida = $result["descricao"];
            } else {
                // Saída não encontrada
                header("Location: saidas.php");
                exit();
            }
        } catch (PDOException $e) {
            echo "Erro ao obter dados da saída: " . $e->getMessage();
        }
    } else {
        // ID da saída não fornecido
        header("Location: saidas.php");
        exit();
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Editar Saída</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css">
    <style>
        body {
            background-color: #f8f9fa;
        }
        .container {
            margin-top: 50px;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2 class="text-center mb-4">Editar Saída</h2>
        <form action="editar_saida.php" method="post">
            <input type="hidden" name="id" value="<?php echo $id_saida; ?>">
            <div class="mb-3">
                <label for="valor" class="form-label">Valor:</label>
                <input type="text" class="form-control" id="valor" name="valor" value="<?php echo $valor_saida; ?>" required>
            </div>
            <div class="mb-3">
                <label for="data" class="form-label">Data:</label>
                <input type="date" class="form-control" id="data" name="data" value="<?php echo $data_saida; ?>" required>
            </div>
            <div class="mb-3">
                <label for="descricao" class="form-label">Descrição:</label>
                <input type="text" class="form-control" id="descricao" name="descricao" value="<?php echo $descricao_saida; ?>" required>
            </div>
            <button type="submit" class="btn btn-primary">Salvar Alterações</button>
            <a href="saidas.php" class="btn btn-secondary">Cancelar</a>
        </form>

        <a href="home.php" class="btn btn-danger position-absolute top-0 end-0 m-4">
            <i class="fas fa-home"></i>
        </a>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
