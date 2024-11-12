<?php
// Incluir o arquivo de conexão com o banco de dados
include('conectaBD.php');

// Variáveis para mensagens de erro e sucesso
$mensagem = '';
$erro = false;

// Verificar se o formulário foi enviado
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Captura os dados do formulário
    $nome = $_POST['nome'];
    $email = $_POST['email'];

    // Validação simples dos campos
    if (empty($nome) || empty($email)) {
        $mensagem = 'Todos os campos são obrigatórios!';
        $erro = true;
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $mensagem = 'Por favor, insira um e-mail válido!';
        $erro = true;
    }

    // Se não houver erro, tentar inserir no banco de dados
    if (!$erro) {
        // Inserir dados na tabela usuario
        $query = "INSERT INTO usuario (nome, email) VALUES ($1, $2)";
        $result = pg_query_params($conn, $query, array($nome, $email));

        // Verificar se a inserção foi bem-sucedida
        if ($result) {
            $mensagem = 'Funcionário cadastrado com sucesso!';
        } else {
            $mensagem = 'Erro ao cadastrar o funcionário. Tente novamente.';
        }
    }
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro de Funcionário</title>
    <link rel="stylesheet" href="css/styles.css">
</head>
<body>
<header>
    <h1>Lista de Tarefas</h1>
    
        <a href="telaGerenciamento.php" target="_blank">Gerenciar Tarefas</a>
        <a href="cadastroTarefa.php" target="_blank">Novas Tarefas</a>
        <a href="cadastroFuncionario.php" target="_blank">Cadastrar Tarefas</a>
   
</header>
<nav></nav>

    <div class="container">
        <h2>Cadastro Funcionário</h2>
        
        <!-- Exibir mensagem de sucesso ou erro -->
        <?php if ($mensagem != ''): ?>
            <p style="color: <?php echo $erro ? 'red' : 'green'; ?>;"><?php echo $mensagem; ?></p>
        <?php endif; ?>

        <!-- Formulário de cadastro -->
        <form method="POST" action="cadastroFuncionario.php">
            <div class="form-group">
                <label for="nome">Nome:</label>
                <input type="text" id="nome" name="nome" required>
            </div>
            
            <div class="form-group">
                <label for="email">E-mail:</label>
                <input type="email" id="email" name="email" required>
            </div>

            <div class="form-group">
                <button type="submit">Cadastrar</button>
            </div>
        </form>
    </div>
</body>
</html>
