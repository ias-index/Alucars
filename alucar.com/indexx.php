<?php

if(isset($_POST['email']) && isset($_POST['senha'])) {

    include('conexao.php');

    $email = $mysqli->escape_string($_POST['email']);
    $senha = $_POST['senha'];

    $sql_code = "SELECT * FROM clientes WHERE email = '$email'";
    $sql_query = $mysqli->query($sql_code) or die($mysqli->error);

    if($sql_query->num_rows == 0) {
        echo "O e-mail informado é incorreto";
    } else {
        $usuario = $sql_query->fetch_assoc();
        if($senha!=$usuario['senha']) {
            echo "A senha informada está incorreta";
        } else {
            if(!isset($_SESSION))
                session_start();
            $_SESSION['usuario'] = $usuario['id'];
            $_SESSION['admin'] = $usuario['admin'];
            header("Location: clientes.php");
        }
    }

}

?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ALUCAR.COM</title>
    <link rel="stylesheet" href="Login.css">
</head>
<body style="background-image: url(alucar.png);">


  <a href="cadastrar_cliente.php"><button class="cadastro">Cadastro</button></a>

  <div class="container">

    <h1>ENTER</h1>

    <form action="" method="POST">
        <p>
            <label for=""></label>
            <input type="text" name="email" id="email" placeholder="Email...">
        </p>

        <p>
            <label for=""></label>
            <input type="password" name="senha" id="senha" placeholder="Senha...">
        </p>
        
        <button class="button" type="submit">Entrar</button>

        <div class="span">
        <a href=""><span class="span">Esqueceu sua senha? </span></a>
        </div>

    </form>

    </div>

</body>
</html>