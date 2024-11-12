<?php
// Incluir o arquivo de conexão com o banco de dados
include('conectaBD.php');

// Variáveis para mensagens de erro e sucesso
$mensagem = '';
$erro = false;

// Buscar usuários cadastrados para popular o select
$query_usuarios = "SELECT id_usuario, nome FROM usuario";
$result_usuarios = pg_query($conn, $query_usuarios);

// Verificar se o formulário foi enviado
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Captura os dados do formulário
    $id_usuario = $_POST['id_usuario'];
    $descricao = $_POST['descricao'];
    $setor = $_POST['setor'];
    $prioridade = $_POST['prioridade'];

    // Validação simples dos campos
    if (empty($id_usuario) || empty($descricao) || empty($setor) || empty($prioridade)) {
        $mensagem = 'Todos os campos são obrigatórios!';
        $erro = true;
    }

    // Se não houver erro, tentar inserir no banco de dados
    if (!$erro) {
        // Inserir dados na tabela tarefa
        $query_tarefa = "INSERT INTO tarefa (id_usuario, descricao, setor, prioridade) 
                         VALUES ($1, $2, $3, $4)";
        $result_tarefa = pg_query_params($conn, $query_tarefa, array($id_usuario, $descricao, $setor, $prioridade));

        // Verificar se a inserção foi bem-sucedida
        if ($result_tarefa) {
            $mensagem = 'Tarefa cadastrada com sucesso!';
        } else {
            $mensagem = 'Erro ao cadastrar a tarefa. Tente novamente.';
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
    <title>Cadastro de Tarefa</title>
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
        <h2>Cadastro de Tarefa</h2>

        <!-- Exibir mensagem de sucesso ou erro -->
        <?php if ($mensagem != ''): ?>
            <p style="color: <?php echo $erro ? 'red' : 'green'; ?>;"><?php echo $mensagem; ?></p>
        <?php endif; ?>

        <!-- Formulário de cadastro -->
        <form method="POST" action="cadastroTarefa.php">
      
            <div class="form-group">
                <label for="descricao">Descrição da Tarefa:</label>
                <textarea id="descricao" name="descricao" required></textarea>
            </div>
            <div class="form-group">
                <label for="prioridade">Prioridade:</label>
                <select id="prioridade" name="prioridade" required>
                    <option value="">Selecione a prioridade</option>
                    <option value="baixa">Baixa</option>
                    <option value="média">Média</option>
                    <option value="alta">Alta</option>
                </select>
            </div>

            <div class="form-group">
                <label for="setor">Setor:</label>
                <input type="text" id="setor" name="setor" required>
            </div>
            <div class="form-group">
                <label for="id_usuario">Usuário:</label>
                <select id="id_usuario" name="id_usuario" required>
                    <option value="">Selecione o usuário</option>
                    <?php while ($row = pg_fetch_assoc($result_usuarios)): ?>
                        <option value="<?php echo $row['id_usuario']; ?>"><?php echo $row['nome']; ?></option>
                    <?php endwhile; ?>
                </select>
            </div>
            
          

            <div class="form-group">
                <button type="submit">Cadastrar Tarefa</button>
            </div>
        </form>
    </div>
</body>
</html>
