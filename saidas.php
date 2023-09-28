<?php
session_start();
if (!isset($_SESSION["username"])) {
    header("Location: login.php");
    exit();
}

$mensagem_sucesso = ""; // Inicializa a mensagem de sucesso vazia

if (isset($_GET["success"]) && $_GET["success"] == "1") {
    $mensagem_sucesso = "Valor registrado com sucesso!";
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Registrar Saída</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css">
    <link rel="stylesheet" href="style.css">
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
<div id="stars"></div>
<div id="stars2"></div>
<div id="stars3"></div>
    <div class="container">
        <h2 class="text-center mb-4">Registrar Saída</h2>
        <form action="processar_saida.php" method="post">
            <div class="mb-3">
                <label for="valor" class="form-label">Valor:</label>
                <input type="text" class="form-control" id="valor" name="valor" required>
            </div>
            <div class="mb-3">
                <label for="data" class="form-label">Data:</label>
                <input type="date" class="form-control" id="data" name="data" required>
            </div>
            <div class="mb-3">
                <label for="descricao" class="form-label">Descrição:</label>
                <input type="text" class="form-control" id="descricao" name="descricao" required>
            </div>
            <button type="submit" class="btn btn-primary">Registrar Saída</button>
            <a href="dashboard.php" class="btn btn-success">Voltar para o Dashboard</a>
        </form>

        <h3 class="mt-4">Registros de Saídas</h3>
        <table class="table table-striped mt-2">
            <thead>
                <tr>
                    <th>Data</th>
                    <th>Descrição</th>
                    <th>Valor</th>
                    <th>Ações</th>
                </tr>
            </thead>
            <tbody>
                <?php
                try {
                    // Conectar ao banco de dados usando PDO
                    $conn = new PDO("mysql:host=localhost;dbname=fluxo", "root", "");
                    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

                    // Consulta SQL para recuperar registros de saída
                    $sql = "SELECT * FROM saidas";
                    $stmt = $conn->query($sql);

                    foreach ($stmt as $row) {
                        echo "<tr>";
                        echo "<td>{$row['data']}</td>";
                        echo "<td>{$row['descricao']}</td>";
                        echo "<td>{$row['valor']}</td>";
                        echo "<td>";
                        echo "<a href='editar_saida.php?id={$row['id']}' class='btn btn-primary'>Editar</a> "; // Adiciona botão de edição
                        echo "<a href='saidas.php?delete=1&id={$row['id']}' class='btn btn-danger'>Excluir</a>"; // Adiciona botão de exclusão
                        echo "</td>";
                        echo "</tr>";
                    }
                } catch (PDOException $e) {
                    echo "Erro de conexão: " . $e->getMessage();
                }
                ?>
            </tbody>
        </table>

        <a href="home.php" class="btn btn-danger position-absolute top-0 end-0 m-4">
            <i class="fas fa-home"></i>
        </a>
    </div>

    <!-- Scripts do Bootstrap e do jQuery no final do corpo -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <!-- Script para exibir a caixa de diálogo após o registro -->
    <script>
        $(document).ready(function() {
            <?php if (!empty($mensagem_sucesso)) { ?>
                $('#successModal').modal('show');
            <?php } ?>
        });
    </script>

   <!-- Modal de sucesso -->
<div class="modal fade" id="successModal" tabindex="-1" aria-labelledby="successModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content" style="background-color: #17202C; color: #FFECAC;">
            <div class="modal-header">
                <h5 class="modal-title" id="successModalLabel">Sucesso</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fechar"></button>
            </div>
            <div class="modal-body">
                <?php echo $mensagem_sucesso; ?>
            </div>
            <div class="modal-footer">
                <a href="dashboard.php" class="btn btn-secondary">Ir para o Dashboard</a>
                <a href="saidas.php" class="btn btn-primary">Registrar Nova Saida</a>
            </div>
        </div>
    </div>
</div>
</body>
</html>
