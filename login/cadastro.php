<?php

include("conexao.php");


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="./style.css">
</head>
<body>
    <div class="page">
    <form action="#" method="POST" class="formLogin">
        <label for="nomeUsuario">Nome de Usuario</label>
        <input type="text"
        name="nomeUsuario"
        id="nomeUsuario"
        placeholder="Crie um nome de usuário"
        required>

        <label for="email">E-mail</label>
        <input  type="email"
          name="email"
          id="email"
          placeholder="Digite seu e-mail"
          required
        >
        
        <label for="password">Nova senha</label>
        <input type="password"
        name="senha"
        id="senha"
        placeholder="Crie uma senha"
        required
        >

        <!-- <label for="confirmPassword">Informe a senha novamente</label>
        <input type="password"
        name="confirmSenha"
        id="confirmSenha"
        placeholder="Digite novamente sua senha"
        required
        > -->
       
        <button type="submit" class="btn">Cadastrar</button>
    </form>
    </div>
</body>
</html>

