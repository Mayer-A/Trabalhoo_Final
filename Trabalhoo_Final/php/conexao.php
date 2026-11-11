<?php
// php/conexao.php - Arquivo de conexão centralizado
$SERVIDOR   = "localhost";
$USUARIO    = "root";
$SENHA      = "";           // Senha padrão do XAMPP é vazia
$NOME_BANCO = "aluno";

// Conexão MySQLi
$conexao = mysqli_connect($SERVIDOR, $USUARIO, $SENHA, $NOME_BANCO);

// Verifica se ocorreu algum erro na conexão
if (!$conexao) {
    die("Erro ao conectar com a base de dados: " . mysqli_connect_error());
}

// Configuração do charset para UTF-8 completo
mysqli_set_charset($conexao, "utf8mb4");

// Mensagem de sucesso na conexão
//echo "Conexão com a base de dados '<strong>$NOME_BANCO</strong>' realizada com sucesso!";
