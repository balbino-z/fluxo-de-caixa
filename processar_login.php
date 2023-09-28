<?php
// Verificar se o formulário foi enviado
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Recuperar os dados do formulário
    $username = $_POST["username_login"];
    $password = $_POST["password_login"];    
    
    // Informações de conexão ao banco de dados
    $host = "localhost";  
    $usuario_db = "root";      
    $senha_db = "";             
    $banco_de_dados = "fluxo";  

    try {
        // Conectar ao banco de dados usando PDO
        $conexao = new PDO("mysql:host=$host;dbname=$banco_de_dados", $usuario_db, $senha_db);

        // Definir o PDO para lançar exceções em caso de erros
        $conexao->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

       
        // Consulta SQL para verificar o login
        $sql = "SELECT * FROM usuarios WHERE username = :username";

        // Preparar a consulta
        $stmt = $conexao->prepare($sql);

        // Executar a consulta com parâmetros
        $stmt->bindParam(':username', $username, PDO::PARAM_STR);

        $stmt->execute();

        // Obter o resultado da consulta
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        // Verificar se houve um resultado
        if ($row) {
            // Verificar se a senha fornecida corresponde à senha no banco de dados
            if (password_verify($password, $row["password"])) {
                // Login bem-sucedido, obtenha os direitos do usuário do banco de dados
                $direitos = $row["direitos"];

                // Iniciar a sessão
                session_start();

                // Armazene os dados do usuário na sessão
                $_SESSION["username"] = $username;
                $_SESSION["direitos"] = $direitos;

                // Redirecionar para a página de home
                header("Location: home.php");
                exit;
            } else {
                // Login falhou, exibir mensagem de erro na página de login
                $error_message = "Nome de usuário ou senha incorretos. Tente novamente.";
                include("index.php"); // Exibe a mensagem de erro na página de login
            }
        } else {
            // Login falhou, exibir mensagem de erro na página de login
            $error_message = "Nome de usuário ou senha incorretos. Tente novamente.";
            include("index.php"); // Exibe a mensagem de erro na página de login
        }

        // Feche a conexão com o banco de dados
        $conexao = null;
    } catch (PDOException $e) {
        die("Erro na conexão com o banco de dados: " . $e->getMessage());
    }
}
?>
