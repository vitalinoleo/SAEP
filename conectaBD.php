<?php
// Definindo as variáveis de conexão com o banco de dados
$host = "localhost";       
$port = "5432";              
$dbname = "kanban";      // Nome do banco de dados
$user = "postgres";       // Usuário do banco de dados
$password = "postgres";     // Senha do banco de dados

// Criação da string de conexão
$conn_string = "host=$host port=$port dbname=$dbname user=$user password=$password";

// Tentativa de conexão com o banco de dados
$conn = pg_connect($conn_string);

// Verificando se a conexão foi bem-sucedida
if (!$conn) {
    echo "Erro ao conectar ao banco de dados.";
    exit;
} else {
    // echo "Conexão estabelecida com sucesso!";
}
?>
