<?php
session_start();

require_once(__DIR__ . "/conexao.php");

// Captura o nome do usuário salvo na sessão (caso exista)
$nomeUsuario = isset($_SESSION['nome']) ? $_SESSION['nome'] : '';
?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lista de Alunos</title>
    <link rel="stylesheet" type="text/css" href="../css/style.css">
</head>

<body>
    <nav id="fixed-menu">
        <ul>
            <li><a href="../index.html">Home</a></li>
            <li><a href="../html/cadastro_aluno.html">Cadastro</a></li>
            <?php if (!empty($nomeUsuario)): ?>
                <li><a href="lista.php">Lista</a></li>
                <li><a href="logout.php">Logout (<?php echo htmlspecialchars($nomeUsuario); ?>)</a></li>
            <?php else: ?>
                <li><a href="../html/login.html">Login</a></li>
                <li><a href="lista.php">Lista</a></li>
            <?php endif; ?>
        </ul>
    </nav>

    <div>
        <h1>Lista de Alunos Cadastrados</h1>

        <?php
        // Consulta todos os alunos cadastrados no MariaDB
        $sql = "SELECT * FROM aluno";
        $resultado = mysqli_query($conexao, $sql);

        if ($resultado && mysqli_num_rows($resultado) > 0) {
            echo "<table border='1'>";
            echo "<tr>";
            echo "<th>Código</th>";
            echo "<th>Nome</th>";
            echo "<th>Sobrenome</th>";
            echo "<th>Idade</th>";
            echo "<th>E-mail</th>";

            // Verifica se o usuário logado é Administrador (adm = 1)
            $isAdmin = isset($_SESSION['adm']) && $_SESSION['adm'] == 1;

            if ($isAdmin) {
                echo "<th>Alterar</th>";
                echo "<th>Excluir</th>";
            }
            echo "</tr>";

            while ($linha = mysqli_fetch_assoc($resultado)) {
                echo "<tr>";
                echo "<td>" . $linha['pk_codigo_aluno'] . "</td>";
                echo "<td>" . $linha['nome'] . "</td>";
                echo "<td>" . $linha['sobrenome'] . "</td>";
                echo "<td>" . $linha['idade'] . "</td>";
                echo "<td>" . $linha['email'] . "</td>";

                if ($isAdmin) {
                    echo "<td><a href='edita.php?pk_codigo_aluno=" . $linha['pk_codigo_aluno'] . "'>Alterar</a></td>";
                    echo "<td><a href='deleta.php?pk_codigo_aluno=" . $linha['pk_codigo_aluno'] . "'>Excluir</a></td>";
                }
                echo "</tr>";
            }

            echo "</table>";
        } else {
            echo "<p>Nenhum aluno encontrado no banco de dados.</p>";
        }

        mysqli_close($conexao);
        ?>
    </div>

    <footer class="rodape">
        <p>&copy; 2026 Prof. Marlon Minussi - Trabalho Final. Todos os direitos reservados.</p>
    </footer>
</body>

</html>