<?php
// Incluir o arquivo de conexão com o banco de dados
include('conectaBD.php');

// Verificar se uma ação foi realizada (concluir, editar ou remover)
if (isset($_GET['action'])) 
    $id_tarefa = $_GET['id_tarefa'];

    switch ($_GET['action']) {
        case 'concluir':
            // Atualizar o status da tarefa para 'pronto'
            $query_concluir = "UPDATE tarefa SET status = 'pronto' WHERE id_tarefa = $1";
            pg_query_params($conn, $query_concluir, array($id_tarefa));
            break;

        case 'remover':
            // Remover a tarefa
            $query_remover = "DELETE FROM tarefa WHERE id_tarefa = $1";
            pg_query_params($conn, $query_remover, array($id_tarefa));
            break;

        case 'editar':
            // Exibir a tela de edição de tarefa
            header("Location: editarTarefa.php?id_tarefa=$id_tarefa");
            exit;
            break;
    }


// Buscar as tarefas por status (a fazer, fazendo e pronto)
$query_tarefas = "SELECT t.id_tarefa, t.descricao, t.setor, t.prioridade, t.status, u.nome 
                  FROM tarefa t
                  JOIN usuario u ON t.id_usuario = u.id_usuario
                  ORDER BY t.status, t.data_cadastro";

$result_tarefas = pg_query($conn, $query_tarefas);

// Separar as tarefas por status
$afazer = [];
$fazendo = [];
$pronto = [];

while ($row = pg_fetch_assoc($result_tarefas)) {
    if ($row['status'] == 'a fazer') {
        $afazer[] = $row;
    } elseif ($row['status'] == 'fazendo') {
        $fazendo[] = $row;
    } elseif ($row['status'] == 'pronto') {
        $pronto[] = $row;
    }
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gerenciamento de Tarefas</title>
    <link rel="stylesheet" href="css/styles.css">
</head>
<body>
<header>
    <h1>Lista de Tarefas</h1>
    
        <a href="telaGerenciamento.php" target="_blank">Gerenciar Tarefas</a>
        <a href="cadastroTarefa.php" target="_blank">Novas Tarefas</a>
        <a href="cadastroFuncionario.php" target="_blank">Cadastrar Tarefas</a>
   
</header>
    <div class="container">

        <!-- Tarefas a Fazer -->
        <h3>A Fazer</h3>
        <?php if (count($afazer) > 0): ?>
            <ul>
                <?php foreach ($afazer as $tarefa): ?>
                    <li>
                        <strong><?php echo $tarefa['descricao']; ?></strong> (<?php echo $tarefa['setor']; ?>)
                        <br>
                        Prioridade: <?php echo ucfirst($tarefa['prioridade']); ?> | Atribuída a: <?php echo $tarefa['nome']; ?>
                        <br>
                        <a href="telaGerenciamento.php?action=concluir&id_tarefa=<?php echo $tarefa['id_tarefa']; ?>" id="concluir">Concluir</a> | 
                        <a href="telaGerenciamento.php?action=editar&id_tarefa=<?php echo $tarefa['id_tarefa']; ?>"id="editar">Editar</a> | 
                        <a href="telaGerenciamento.php?action=remover&id_tarefa=<?php echo $tarefa['id_tarefa']; ?>" id="remover">Remover</a>
                    </li>
                <?php endforeach; ?>
            </ul>
        <?php else: ?>
            <p>Não há tarefas a fazer.</p>
        <?php endif; ?>

        <!-- Tarefas Fazendo -->
        <h3>Fazendo</h3>
        <?php if (count($fazendo) > 0): ?>
            <ul>
                <?php foreach ($fazendo as $tarefa): ?>
                    <li>
                        <strong><?php echo $tarefa['descricao']; ?></strong> (<?php echo $tarefa['setor']; ?>)
                        <br>
                        Prioridade: <?php echo ucfirst($tarefa['prioridade']); ?> | Atribuída a: <?php echo $tarefa['nome']; ?>
                        <br>
                        <a href="telaGerenciamento.php?action=concluir&id_tarefa=<?php echo $tarefa['id_tarefa']; ?>" id="concluir">Concluir</a> | 
                        <a href="telaGerenciamento.php?action=editar&id_tarefa=<?php echo $tarefa['id_tarefa']; ?>" id="editar">Editar</a> | 
                        <a href="telaGerenciamento.php?action=remover&id_tarefa=<?php echo $tarefa['id_tarefa']; ?>"id="remover">Remover</a>
                    </li>
                <?php endforeach; ?>
            </ul>
        <?php else: ?>
            <p>Não há tarefas em andamento.</p>
        <?php endif; ?>

        <!-- Tarefas Prontas -->
        <h3>Pronto</h3>
        <?php if (count($pronto) > 0): ?>
            <ul>
                <?php foreach ($pronto as $tarefa): ?>
                    <li>
                        <strong><?php echo $tarefa['descricao']; ?></strong> (<?php echo $tarefa['setor']; ?>)
                        <br>
                        Prioridade: <?php echo ucfirst($tarefa['prioridade']); ?> | Atribuída a: <?php echo $tarefa['nome']; ?>
                        <br>
                        <a href="telaGerenciamento.php?action=remover&id_tarefa=<?php echo $tarefa['id_tarefa']; ?>">Remover</a>
                    </li>
                <?php endforeach; ?>
            </ul>
        <?php else: ?>
            <p>Não há tarefas concluídas.</p>
        <?php endif; ?>
    </div>
</body>
</html>
