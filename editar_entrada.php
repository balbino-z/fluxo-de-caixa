<?php
session_start();
if (!isset($_SESSION["username"])) {
    header("Location: login.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Processar o formulário de edição da entrada
    $id_entrada = $_POST["id"];
    $valor_entrada = $_POST["valor"];
    $data_entrada = $_POST["data"];
    $descricao_entrada = $_POST["descricao"];

    try {
        // Conectar ao banco de dados usando PDO
        $conn = new PDO("mysql:host=localhost;dbname=fluxo", "root", "");
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // Preparar a instrução SQL usando placeholders para prevenir SQL injection
        $sql = "UPDATE entradas SET valor = :valor, data = :data, descricao = :descricao WHERE id = :id";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':valor', $valor_entrada);
        $stmt->bindParam(':data', $data_entrada);
        $stmt->bindParam(':descricao', $descricao_entrada);
        $stmt->bindParam(':id', $id_entrada);

        // Executar a consulta
        $stmt->execute();

        // Redirecionar para a página de entradas com mensagem de sucesso
        header("Location: entradas.php?success=3");
        exit();
    } catch (PDOException $e) {
        echo "Erro ao atualizar entrada: " . $e->getMessage();
    }
} else {
    // Carregar dados da entrada para edição
    if (isset($_GET["id"])) {
        $id_entrada = $_GET["id"];

        try {
            // Conectar ao banco de dados usando PDO
            $conn = new PDO("mysql:host=localhost;dbname=fluxo", "root", "");
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            // Consulta SQL para obter os dados da entrada
            $sql = "SELECT * FROM entradas WHERE id = :id";
            $stmt = $conn->prepare($sql);
            $stmt->bindParam(':id', $id_entrada);
            $stmt->execute();
            $result = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($result) {
                $valor_entrada = $result["valor"];
                $data_entrada = $result["data"];
                $descricao_entrada = $result["descricao"];
            } else {
                // Entrada não encontrada
                header("Location: entradas.php");
                exit();
            }
        } catch (PDOException $e) {
            echo "Erro ao obter dados da entrada: " . $e->getMessage();
        }
    } else {
        // ID da entrada não fornecido
        header("Location: entradas.php");
        exit();
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Editar Entrada</title>
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
        <h2 class="text-center mb-4">Editar Entrada</h2>
        <form action="editar_entrada.php" method="post">
            <input type="hidden" name="id" value="<?php echo $id_entrada; ?>">
            <div class="mb-3">
                <label for="valor" class="form-label">Valor:</label>
                <input type="text" class="form-control" id="valor" name="valor" value="<?php echo $valor_entrada; ?>" required>
            </div>
            <div class="mb-3">
                <label for="data" class="form-label">Data:</label>
                <input type="date" class="form-control" id="data" name="data" value="<?php echo $data_entrada; ?>" required>
            </div>
            <div class="mb-3">
                <label for="descricao" class="form-label">Descrição:</label>
                <input type="text" class="form-control" id="descricao" name="descricao" value="<?php echo $descricao_entrada; ?>" required>
            </div>
            <button type="submit" class="btn btn-primary">Salvar Alterações</button>
            <a href="entradas.php" class="btn btn-secondary">Cancelar</a>
        </form>

        <a href="home.php" class="btn btn-danger position-absolute top-0 end-0 m-4">
            <i class="fas fa-home"></i>
        </a>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
