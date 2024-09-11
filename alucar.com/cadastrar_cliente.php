<?php

if(!isset($_SESSION))
    session_start();

/*if(!isset($_SESSION['admin']) || !$_SESSION['admin']) {
    header("Location: clientes.php");
    die();
}*/

function limpar_texto($str){ 
    return preg_replace("/[^0-9]/", "", $str); 
}

if(count($_POST) > 0) {

    include('index.php');
    include('upload.php');
    

    $erro = false;
    $nome = $_POST['nome'];
    $email = $_POST['email'];
    $telefone = $_POST['telefone'];
    $nascimento = $_POST['nascimento'];
    $senha_descriptografada = $_POST['senha'];
    $admin = $_POST['admin'];

    if(strlen($senha_descriptografada) < 6 && strlen($senha_descriptografada) > 16) {
        $erro = "A senha deve ter entre 6 e 16 caracteres.";
    }

    if(empty($nome)) {
        $erro = "Preencha o nome";
    }
    if(empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $erro = "Preencha o e-mail";
    }

    if(!empty($nascimento)) { 
        $pedacos = explode('/', $nascimento);
        if(count($pedacos) == 3) {
            $nascimento = implode ('-', array_reverse($pedacos));
        } else {
            $erro = "A data de nascimento deve seguir o padrão dia/mes/ano.";
        }
    }

    if(!empty($telefone)) {
        $telefone = limpar_texto($telefone);
        if(strlen($telefone) != 11)
            $erro = "O telefone deve ser preenchido no padrão (11) 98888-8888";
    }

   

    if($erro) {
        echo "<p><b>ERRO: $erro</b></p>";
    } else {
        $senha = password_hash($senha_descriptografada, PASSWORD_DEFAULT);

            $sql_code = "INSERT INTO clientes (nome, email, senha, telefone, nascimento, date, foto, admin) 
        VALUES ('$nome', '$email', '$senha', '$telefone', '$nascimento', NOW(), '$path', '$admin')";
        $deu_certo = $mysqli->query ($sql_code) or die ($mysqli-> error);
        if($deu_certo) {
            
            echo "<p><b>Cliente cadastrado com sucesso!!!</b></p>";
            unset($_POST);
        }
    }

}


?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastrar Cliente</title>
    <link rel="stylesheet" href="cadastro.css">
</head>
<body style="background-image: url(alucar.png);">

  <a href="clientes.php">Voltar para a lista</a>

  <h1>CADASTRE-SE</h1>
   
    <form class="container"  method="POST" action="">
      <div class="content">
        <p>
            <input value="<?php if(isset($_POST['nome'])) echo $_POST['nome']; ?>" name="nome" type="text" id="nome" placeholder="Nome...">
        </p>

        <p>
            <input value="<?php if(isset($_POST['email'])) echo $_POST['email']; ?>" name="email" type="text" id="email" placeholder="Email...">
        </p>

        <p>
            <input value="<?php if(isset($_POST['telefone'])) echo $_POST['telefone']; ?>" name="telefone" type="text" id="telefone"  placeholder="(11) 98888-8888">
        </p>

        <p>
            <input value="<?php if(isset($_POST['nascimento'])) echo $_POST['nascimento']; ?>"  name="nascimento" type="text" id="dtnascimento" placeholder="Data de Nascimento">
        </p>

        <p>
            <input value="<?php if(isset($_POST['senha'])) echo $_POST['senha']; ?>" name="senha" type="text" id="senha" placeholder="Senha...">
        </p>

        
        </p>

        <p class="admin">
            <input name="admin" value="1" type="radio">ADMIN
            <input name="admin" value="0" checked type="radio"> CLIENTE
        </p>

            <button class="button" type="submit">CADASTRO</button>
        </div>
    </form>
     
</body>
</html>