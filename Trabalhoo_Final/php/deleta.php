<?php
session_start();

// Impede o acesso direto pela URL caso adm não seja igual a 1
if (!isset($_SESSION['adm']) || $_SESSION['adm'] != 1) {
    echo "<script>
            alert('Acesso negado! Recurso exclusivo para Administradores.');
            window.location.href = 'login.html';
          </script>";
    exit;
}

require_once(__DIR__ . "/conexao.php");
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
	<title>Deletar Aluno</title>
	<link href="../css/index.css" rel="stylesheet">
</head>
	<script>//functions JScript
	function cadastrosuccessfuly(){
      	setTimeout("window.location='lista.php'", 1500);
    }
    function cadastrofailed(){
      	setTimeout("window.location='lista.php'", 1500);
    }
	</script>
<body>
    <h1>Aluno Deletado</h1>
	<?php
	/*Conectar no banco*/
	require_once (__DIR__."/conexao.php");
	
	if (isset($_GET['pk_codigo_aluno']) && !empty($_GET['pk_codigo_aluno'])) {//testa se o input pk_codigo_aluno foi preenchido, não aceitando nulos
		$COD_ALUNO = $_GET['pk_codigo_aluno'];// usamos o metodo GET, pois pegamos o dado de um formulário previamente cadastrado
		//usamos novamente a function mysqli_query(), os paremtros passados foram a $conexao e a consulta SQL, podendo colocar a própria consulta como parâmetro
		$sql = "DELETE FROM aluno WHERE pk_codigo_aluno = $COD_ALUNO;";
		$retornoDelete = mysqli_query($conexao, $sql);

		if ($retornoDelete) {
			echo "<p class='p'>Registro deletado com sucesso!</p></br>";
	    	echo "<script>cadastrosuccessfuly()</script>";
		} else {
			echo "<p class='p'>Registro não foi deletado!</p></br>"; 
			echo "<script>cadastrofailed()</script>"; 
		}
		mysqli_close($conexao);
	}

	?>
	<br>
	<form action="lista.php" method="POST">
        <input id="inputb"  class="large" type="submit" name="exibe" value="Listar Alunos" tabindex="10"/>
    </form> 

</body>
</html>