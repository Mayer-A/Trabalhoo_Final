<?php
// Inicia a sessão ANTES de qualquer envio de HTML para o navegador
session_start();

require_once(__DIR__ . "/conexao.php");
?>
<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Autenticação...</title>
    <link rel="stylesheet" href="../css/index.css">
</head>

<body>
    <nav id="fixed-menu">
        <ul>
            <li><a href="../index.html">Home</a></li>
            <li><a href="../html/cadastro_aluno.html">Cadastro</a></li>
            <li><a href="../html/login.html">Login</a></li>
            <li><a href="lista.php">Lista</a></li>
            <li><a href="logout.php">Logout</a></li>
        </ul>
    </nav>
    <div>
        <?php
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $email = $_POST['email'];
            $senha = $_POST['senha'];

            // Busca o aluno pelo e-mail
            $query = "SELECT * FROM aluno WHERE email = '$email'";
            $resultado = mysqli_query($conexao, $query);

            if ($resultado && mysqli_num_rows($resultado) > 0) {
                $aluno = mysqli_fetch_assoc($resultado);

                // Compara a senha digitada com a Hash armazenada na coluna de 255 caracteres
                if (password_verify($senha, $aluno['senha']) || $senha === $aluno['senha']) {
                 // GRAVA OS DADOS NA SESSÃO

                    // GRAVA OS DADOS NA SESSÃO
                    $_SESSION['id']   = $aluno['pk_codigo_aluno'];
                    $_SESSION['nome'] = $aluno['nome'];
                    $_SESSION['adm']  = $aluno['adm']; // Guarda 1 (Administrador) ou 0 (Aluno)

                    echo "<p>Bem-vindo(a), " . $_SESSION['nome'] . "! Login realizado como <strong>" . ($_SESSION['adm'] == 1 ? 'Administrador' : 'Aluno') . "</strong>.</p>";
                } else {
                    echo "<p>Erro: Senha incorreta!</p>";
                }
            } else {
                echo "<p>Erro: E-mail não encontrado!</p>";
            }

            mysqli_close($conexao);
        }
        ?>
        <input type="submit" value="Ir para a Lista de Alunos" onclick="window.location.href='lista.php'">
    </div>
    <rodape class="rodape">
        <p>R. Silveira Martins - Venâncio Aires - Rio Grandd do Sul - telefone: <a
                href="https://web.whatsapp.com/">51-98732-8921</a></p>
    </rodape>
</body>

</html>