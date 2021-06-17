<?php

    header("Access-Control-Allow-Origin: *");

    if(empty($_POST['nome']) || empty($_POST['email']) || empty($_POST['telefone']) || empty($_POST['cpf']) || empty($_POST['senha'])) {
        echo json_encode(Array("success"=> false, "errorMessage"=> "Campos incorretos ou vazios")); 
        die();
    }

    include("../conexao.php");

    $query = mysqli_query($con, "SELECT COUNT(cliente_cod) FROM cliente WHERE cliente_email = '$_POST[email]'");
    
    if(mysqli_fetch_array($query)[0] != 0)
    {
        echo json_encode(Array("success"=> false, "errorMessage"=> "Digite outro email, esse já pertence a uma conta.")); 
        die();
    }

    $query = mysqli_query($con, "INSERT INTO cliente (cliente_nome, cliente_email, cliente_telefone, cliente_cpf, cliente_senha) VALUES ('$_POST[nome]', '$_POST[email]', '$_POST[telefone]', '$_POST[cpf]', '".md5($_POST['senha'])."')");
    
    if($query != true)
    {
        echo json_encode(Array("success"=> false)); 
        die();
    }

    $query = mysqli_query($con, "SELECT LAST_INSERT_ID()");

    session_start();
    $_SESSION['cliente_cod'] = mysqli_fetch_array($query)[0];

    echo json_encode(Array("success"=> true));

?>