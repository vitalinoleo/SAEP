<?php
// functions.php - Arquivo com funções e cabeçalho HTML com links

// Função para exibir uma saudação simples
function saudacao($nome) {
    return "Olá, $nome! Bem-vindo ao nosso site!";
}

// Função para somar dois números
function somar($a, $b) {
    return $a + $b;
}

// Função para calcular a diferença entre dois números
function subtrair($a, $b) {
    return $a - $b;
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Exemplo de Funções com Cabeçalho</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }
        header {
            background-color: #333;
            color: white;
            padding: 15px;
            text-align: center;
        }
        header a {
            color: white;
            text-decoration: none;
            margin: 0 10px;
            font-weight: bold;
        }
        header a:hover {
            text-decoration: underline;
        }
        .content {
            padding: 20px;
            text-align: center;
        }
    </style>
</head>
<body>

<!-- Cabeçalho com links para 3 sites -->
<header>
    <h1>Bem-vindo ao Site de Exemplos</h1>
    <nav>
        <a href="https://www.google.com" target="_blank">Google</a>
        <a href="https://www.wikipedia.org" target="_blank">Wikipedia</a>
        <a href="https://www.youtube.com" target="_blank">YouTube</a>
    </nav>
</header>

<div class="content">
    <h2>Funções de Exemplo</h2>
    <p>
        <?php
        // Chamando a função saudacao
        echo saudacao("João");
        ?>
    </p>
    
    <h3>Exemplo de Cálculos</h3>
    <p>
        Soma de 10 e 5: <?php echo somar(10, 5); ?><br>
        Diferença entre 10 e 5: <?php echo subtrair(10, 5); ?>
    </p>
</div>

</body>
</html>
