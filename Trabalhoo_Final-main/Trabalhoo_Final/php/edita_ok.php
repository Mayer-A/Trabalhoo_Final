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
?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Aluno</title>
    <link href="../css/index.css" rel="stylesheet">

    <!-- JavaScript responsável pelo redirecionamento automático -->
    <script>
        function cadastrosuccessfuly() {
            setTimeout(() => {
                window.location.href = 'lista.php';
            }, 3000);
        }

        function cadastrofailed() {
            setTimeout(() => {
                window.location.href = 'lista.php';
            }, 3000);
        }
    </script>
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
        <h1>Aluno Editado</h1>
        <?php
        /* ==============================================================================
           1. VALIDAÇÃO DOS CAMPOS RECEBIDOS VIA POST
           ============================================================================== */
        if (
            isset($_POST['pk_codigo_aluno'], $_POST['nome'], $_POST['sobrenome'], $_POST['idade'], $_POST['email']) &&
            !empty($_POST['pk_codigo_aluno']) && !empty($_POST['nome']) &&
            !empty($_POST['sobrenome']) && !empty($_POST['idade']) && !empty($_POST['email'])
        ) {
            // Atribuição direta em variáveis simples
            $COD_ALUNO = $_POST['pk_codigo_aluno'];
            $NOME      = $_POST['nome'];
            $SOBRENOME = $_POST['sobrenome'];
            $IDADE     = (int)$_POST['idade'];
            $EMAIL     = $_POST['email'];

            /* ==============================================================================
               2. CONSULTA PREPARADA (UPDATE com Prepared Statement)
               ============================================================================== */
            $sql = "UPDATE aluno
                    SET
                        nome = ?,
                        sobrenome = ?,
                        idade = ?,
                        email = ?
                    WHERE pk_codigo_aluno = ?";

            $stmt = mysqli_prepare($conexao, $sql);

            if ($stmt) {
                // Associação dos parâmetros: "ssisi" -> string, string, int, string, int
                mysqli_stmt_bind_param($stmt, "ssisi", $NOME, $SOBRENOME, $IDADE, $EMAIL, $COD_ALUNO);

                $retornoUpdate = mysqli_stmt_execute($stmt);

                if ($retornoUpdate) {
                    echo "<p class='p'>Registro atualizado com sucesso!</p><br>";
                    echo "<script>cadastrosuccessfuly();</script>";
                } else {
                    echo "<p class='p'>Erro ao atualizar registro: " . mysqli_error($conexao) . "</p><br>";
                    echo "<script>cadastrofailed();</script>";
                }

                mysqli_stmt_close($stmt);
            } else {
                echo "<p class='p'>Erro ao preparar a consulta no banco de dados!</p><br>";
                echo "<script>cadastrofailed();</script>";
            }

            mysqli_close($conexao);
        } else {
            echo "<p class='p'>Opss! Tente novamente preenchendo todos os campos!</p><br>";
        }
        ?>
        <br>
        <form action="lista.php" method="POST">
            <input id="inputb" class="large" type="submit" name="exibe" value="Listar Alunos" tabindex="10" />
        </form>
    </div>
    <rodape class="rodape">
        <p>R. Silveira Martins - Venâncio Aires - Rio Grandd do Sul - telefone: <a
                href="https://web.whatsapp.com/">51-98732-8921</a></p>
    </rodape>
</body>

</html>