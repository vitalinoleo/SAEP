<?php
// Incluir o arquivo de conexão com o banco de dados
include('conectaBD.php');

// Verificar se o id_tarefa foi passado na URL
if (!isset($_GET['id_tarefa'])) {
    echo "Tarefa não encontrada.";
    exit;
}

$id_tarefa = $_GET['id_tarefa'];

// Buscar a tarefa no banco de dados para exibir os dados no formulário
$query_tarefa = "SELECT t.id_tarefa, t.descricao, t.setor, t.prioridade, t.status, u.id_usuario, u.nome 
                 FROM tarefa t
                 JOIN usuario u ON t.id_usuario = u.id_usuario
                 WHERE t.id_tarefa = $1";

$result_tarefa = pg_query_params($conn, $query_tarefa, array($id_tarefa));

if (pg_num_rows($result_tarefa) == 0) {
    echo "Tarefa não encontrada.";
    exit;
}

$tarefa = pg_fetch_assoc($result_tarefa);

// Caso o formulário seja submetido, processa a atualização
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $descricao = $_POST['descricao'];
    $setor = $_POST['setor'];
    $prioridade = $_POST['prioridade'];
    $status = $_POST['status'];

    // Atualizar os dados da tarefa
    $query_atualizar = "UPDATE tarefa SET descricao = $1, setor = $2, prioridade = $3, status = $4 WHERE id_tarefa = $5";
    pg_query_params($conn, $query_atualizar, array($descricao, $setor, $prioridade, $status, $id_tarefa));

    // Redirecionar de volta para a tela principal
    header("Location: telasTarefas.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Tarefa</title>
    <link rel="stylesheet" href="css/styles.css">
</head>
<body>
<header>
    <h1>Editar Tarefa</h1>
    <nav>
        <a href="telasTarefas.php">Gerenciar Tarefas</a>
        <a href="cadastroTarefa.php">Nova Tarefa</a>
        <a href="cadastroFuncionario.php">Cadastrar Funcionário</a>
    </nav>
</header>

<div class="container">
    <h2>Editar Tarefa: <?php echo $tarefa['descricao']; ?></h2>
    
    <!-- Formulário de edição da tarefa -->
    <form method="POST">
        <label for="descricao">Descrição:</label>
        <textarea id="descricao" name="descricao" required><?php echo htmlspecialchars($tarefa['descricao']); ?></textarea><br>

        <label for="setor">Setor:</label>
        <input type="text" id="setor" name="setor" value="<?php echo htmlspecialchars($tarefa['setor']); ?>" required><br>

        <label for="prioridade">Prioridade:</label>
        <select id="prioridade" name="prioridade" required>
            <option value="baixa" <?php echo $tarefa['prioridade'] == 'baixa' ? 'selected' : ''; ?>>Baixa</option>
            <option value="média" <?php echo $tarefa['prioridade'] == 'média' ? 'selected' : ''; ?>>Média</option>
            <option value="alta" <?php echo $tarefa['prioridade'] == 'alta' ? 'selected' : ''; ?>>Alta</option>
        </select><br>

        <label for="status">Status:</label>
        <select id="status" name="status" required>
            <option value="a fazer" <?php echo $tarefa['status'] == 'a fazer' ? 'selected' : ''; ?>>A Fazer</option>
            <option value="fazendo" <?php echo $tarefa['status'] == 'fazendo' ? 'selected' : ''; ?>>Fazendo</option>
            <option value="pronto" <?php echo $tarefa['status'] == 'pronto' ? 'selected' : ''; ?>>Pronto</option>
        </select><br>

        <input type="submit" value="Atualizar Tarefa">
    </form>
</div>

</body>
</html>
