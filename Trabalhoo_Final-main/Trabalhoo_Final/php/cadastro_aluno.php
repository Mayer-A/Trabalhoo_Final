<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <!-- Configuração de caracteres e meta tag para responsividade -->
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dados cadastrados...</title>
    <!-- Link para o arquivo CSS externo -->
    <link rel="stylesheet" href="../css/index.css">
</head>

<body>
    <nav id="fixed-menu">
        <ul>
            <a href="../index.html">Home</a>
            <a href="../html/cadastro_aluno.html">Cadastro</a>
            <a href="../html/login.html">Login</a>
            <a href="lista.php">Lista</a>
            <a href="#contact">Info</a>
        </ul>
    </nav>
    <div>
        <?php
        // ============================================================================
        // ABORDAGEM RECOMENDADA: Importação de ficheiro externo
        // ============================================================================

        // Importa o ficheiro 'conexao.php' localizado na mesma pasta
        require_once(__DIR__ . "/conexao.php");

        /* 
- NOTA DIDÁTICA SOBRE A SUA LINHA ORIGINAL:
- $conexao = include_once "../php/conexao.php";
- 
- Se fizer a atribuição diretamente na instrução include/require, a variável 
- $conexao passará a ter o valor booleano '1' (true), indicando apenas que o 
- ficheiro foi incluído com sucesso. 
- 
- Para que a variável $conexao fique com o objeto de ligação real, o ficheiro 
- 'conexao.php' precisa de definir a variável $conexao internamente (ficando 
- automaticamente disponível aqui) ou terminar com a instrução 'return $conexao;'.
            */
        // credencias locais desativadas, pois agora estão no ficheiro externo 'conexao.php'

        /* $conexao = mysqli_connect(
            $databaseHost,
            $databaseUsuario,
            $databaseSenha,
            $databaseNome
            );
        */
        // Verifica se o formulário foi enviado pelo método POST
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Obtém os dados enviados pelo formulário
            $nome = $_POST['nome'];
            $sobrenome = $_POST['sobrenome'];
            // Tratamento da idade: se estiver vazia, envia NULL (sem aspas) para não causar erro de sintaxe no SQL
            $idade = !empty($_POST['idade']) ? $_POST['idade'] : "NULL";
            $email = $_POST['email'];

            // Criptografa a senha com hash seguro antes de salvar no banco de dados
            $senha = password_hash($_POST['senha'], PASSWORD_DEFAULT);

            // Cria a consulta SQL para inserir os dados (o campo 'adm' é omitido para assumir o valor DEFAULT 0 do banco)
            $query = "INSERT INTO aluno (nome, sobrenome, idade, email, senha)
            VALUES ('$nome', '$sobrenome', $idade, '$email', '$senha')";

            // Executa a consulta SQL e verifica se foi bem-sucedida
            if (mysqli_query($conexao, $query)) {
                echo "<p>Aluno cadastrado com sucesso!</p>";
            } else {
                // Exibe uma mensagem de erro se a inserção falhar
                echo "<p>Erro ao cadastrar aluno: " . mysqli_error($conexao) . "</p>";
            }

            // Fecha a conexão com o banco de dados
            mysqli_close($conexao);
        }
        ?>
        <!-- Botão que redireciona para a página de lista de alunos -->
        <input type="submit" value="Lista de Alunos" onclick="window.location.href='lista.php'">
    </div>
    <rodape class="rodape">
        <p>R. Silveira Martins - Venâncio Aires - Rio Grandd do Sul - telefone: <a
                href="https://web.whatsapp.com/">51-98732-8921</a></p>
    </rodape>
</body>

</html>