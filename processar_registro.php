<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Credenciais do banco de dados
    $hostname = "localhost";
    $username_db = "root"; // Substitua pelo seu nome de usuário do banco de dados
    $password_db = ""; // Substitua pela sua senha do banco de dados
    $dbname = "fluxo";

    try {
        // Conexão com o banco de dados usando PDO
        $pdo = new PDO("mysql:host=$hostname;dbname=$dbname", $username_db, $password_db);

        // Defina o modo de erro PDO para exceção
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // Dados do formulário
        $nome_completo = $_POST["nome_completo"];
        $telefone = $_POST["telefone"];
        $username_registro_reg = $_POST["username_registro"];
        $password_reg = password_hash($_POST["password_reg"], PASSWORD_DEFAULT); // Hash da senha
        $tipo_conta = $_POST["tipo_conta"]; // Pega o valor do campo de seleção

        // Define os direitos com base no tipo de conta escolhido
        if ($tipo_conta == 1) {
            $direitos = 1; // Usuário
        } elseif ($tipo_conta == 2) {
            $direitos = 2; // Administrador
        } else {
            $direitos = 1; // Padrão para usuário
        }

        // Consulta SQL para inserir dados na tabela de usuários com os direitos determinados
        $sql = "INSERT INTO usuarios (nome_completo, telefone, username, password, direitos) VALUES (?, ?, ?, ?, ?)";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$nome_completo, $telefone, $username_registro_reg, $password_reg, $direitos]);

        // Verifica se o registro foi bem-sucedido
        if ($stmt->rowCount() > 0) {
            // Registro bem-sucedido, redireciona para a página de "home"
            header("Location: home.php");
            exit();
        } else {
            // O registro falhou, redireciona de volta para a página de registro com uma mensagem de erro
            header("Location: registro.php?erro=1");
            exit();
        }
    } catch (PDOException $e) {
        echo "Erro ao registrar: " . $e->getMessage();
    }
}
?>
