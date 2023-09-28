<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Fluxo de Caixa - Nossos Serviços</title>
    <link href="https://fonts.googleapis.com/css2?family=Circular&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="style.css">
    <style>
        /* CSS personalizado para esta tela */
        .gallery {
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
            gap: 20px;
            padding: 20px;
        }

        .gallery a {
            text-decoration: none;
            color: white;
            transition: transform 0.3s ease, opacity 0.3s ease;
            text-align: center;
            display: block;
            position: relative;
        }

        .gallery a:hover {
            transform: scale(1.05);
            opacity: 0.8;
        }

        .gallery img {
            width: 200px; /* Diminua o tamanho das imagens */
            height: 200px; /* Diminua o tamanho das imagens */
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.5);
        }

        /* Animação de fundo sutil */
        @keyframes backgroundAnimation {
            0% {
                background-position: 0 0;
            }
            100% {
                background-position: 100% 0;
            }
        }

        body {
            animation: backgroundAnimation 10s linear infinite alternate;
            overflow-y: auto;
        }

        /* Centralizar o título e o subtítulo */
        header {
            text-align: center;
            padding: 20px 0;
        }

        .title {
            font-size: 40px;
            margin: 0;
        }

        .subtitle {
            font-size: 24px;
            margin-top: 10px;
        }

        .message {
            text-align: center; /* Centralizar o texto */
            font-size: 24px; /* Tamanho maior de fonte */
            margin-top: 330px; /* Posição mais abaixo das imagens */
        }
    </style>
</head>
<body>
<div id="stars"></div>
<div id="stars2"></div>
<div id="stars3"></div>
    <header>
        <h1 class="title">Bem-vindo ao nosso site de Fluxo de Caixa</h1>
        <br>
        <p class="subtitle">Nossos Serviços</p>
        <br>
        <br>
    </header>
    <section class="gallery">
        <a href="dashboard.php">
            <img src="dash.png" alt="Dashboard">
        </a>
        <a href="entradas.php">
            <img src="entrada.png" alt="Fazer Entradas">
        </a>
        <a href="saidas.php">
            <img src="saida.png" alt="Fazer Saídas">
        </a>
        <a href="verificar_direitos.php">
            <img src="user.png" alt="Acessar Usuário">
        </a>
        <a href="index.php">
            <img src="sair.png" alt="Sair">
        </a>
    </section>
    <div class="message">
    Obrigado por usar nossos serviços!
</div>

</body>
</html>
