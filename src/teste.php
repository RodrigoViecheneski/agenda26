<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <title>Teste Docker Full Stack</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            text-align: center;
            margin-top: 50px;
        }

        .sucesso {
            color: green;
            font-weight: bold;
        }

        .erro {
            color: red;
            font-weight: bold;
        }
    </style>
</head>

<body>
    <h1>Ambiente Docker Configurado!</h1>

    <div id="php-status">
        <?php
        require_once 'classes/conexao.class.php';
        $con = new Conexao();
        $con->conectar();
        ?>
    </div>
    <p id="js-status">Carregando JavaScript...</p>

    <script>
        document.getElementById("js-status").innerText = "✔ JavaScript executado com sucesso!";
    </script>
</body>

</html>

<?php
//Seu site (HTML/PHP/JS): http://localhost:8080
//phpMyAdmin (Banco de dados): http://localhost:8081
//Login do phpMyAdmin: Usuário: root | Senha: root_password

// docker compose down
//docker compose up -d --build


//docker compose down
//docker compose build --no-cache
//docker compose up -d
?>