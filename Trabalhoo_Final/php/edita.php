<?php
session_start();

// Impede o acesso direto pela URL caso o usuário não seja administrador
if (!isset($_SESSION['adm']) || $_SESSION['adm'] != 1) {
    echo "<script>
            alert('Acesso negado! Recurso exclusivo para Administradores.');
            window.location.href = '../html/login.html';
          </script>";
    exit;
}

require_once(__DIR__ . "/conexao.php");

// Inicialização das variáveis
$pk_codigo_aluno = "";
$nome = "";
$sobrenome = "";
$idade = "";
$email = "";

// Captura o código do aluno via GET ou POST
$COD_ALUNO = isset($_REQUEST['pk_codigo_aluno']) ? (int)$_REQUEST['pk_codigo_aluno'] : 0;

if ($COD_ALUNO > 0) {

    // Consulta direta sanitizada com (int) para garantir compatibilidade total no PHP
    $sql = "SELECT * FROM aluno WHERE pk_codigo_aluno = $COD_ALUNO";
    $resultado = mysqli_query($conexao, $sql);

    if ($resultado && $linha = mysqli_fetch_assoc($resultado)) {
        $pk_codigo_aluno = $linha['pk_codigo_aluno'];
        $nome            = $linha['nome'];
        $sobrenome       = $linha['sobrenome'];
        $idade           = $linha['idade'];
        $email           = $linha['email'];
    }
}

mysqli_close($conexao);
?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Aluno</title>
    <link rel="stylesheet" type="text/css" href="../css/style.css">
</head>

<body>
    <nav id="fixed-menu">
        <ul>
            <li><a href="../index.html">Home</a></li>
            <li><a href="../html/cadastro_aluno.html">Cadastro</a></li>
            <li><a href="../html/login.html">Login</a></li>
            <li><a href="lista.php">Lista</a></li>
            <li><a href="#contact">Info</a></li>
        </ul>
    </nav>
    <div>
        <form action="lista.php" method="POST">
            <input id="inputb" class="large" type="submit" name="exibe" value="Listar Alunos" tabindex="10">
        </form>
        <br>

        <form name="cadastro" action="edita_ok.php" method="POST">
            <h2>Formulário de Edição de Aluno</h2>

            <!-- Campo oculto transportando a chave primária -->
            <input type="hidden" name="pk_codigo_aluno" value="<?php echo $pk_codigo_aluno; ?>">

            <!-- Campo Nome -->
            <label for="nome">Nome:</label>
            <input type="text" class="large" value="<?php echo $nome; ?>" maxlength="25" name="nome" autocomplete="on" autofocus tabindex="1" required />
            <br><br>

            <!-- Campo Sobrenome -->
            <label for="sobrenome">Sobrenome:</label>
            <input type="text" id="sobrenome" name="sobrenome" value="<?php echo $sobrenome; ?>" maxlength="20" required>
            <br><br>

            <!-- Campo Idade -->
            <label for="idade">Idade:</label>
            <input type="number" id="idade" name="idade" value="<?php echo $idade; ?>" min="1" required>
            <br><br>

            <!-- Campo E-mail -->
            <label for="email">E-mail:</label>
            <input type="email" id="email" name="email" value="<?php echo $email; ?>" maxlength="50" required>
            <br><br>

            <!-- Botões -->
            <input type="submit" value="Salvar Alterações">
            <input type="reset" value="Limpar">
            <input type="button" value="Lista de Alunos" onclick="window.location.href='lista.php'">
        </form>
    </div>
    <footer class="rodape">
        <p>
            &copy; 2026 Prof. Marlon Minussi - Trabalho Final. Todos os direitos reservados.
        </p>
    </footer>
</body>

</html>