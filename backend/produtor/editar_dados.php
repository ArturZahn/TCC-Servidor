<?php

    header("Access-Control-Allow-Origin: *");
    session_start();

    if(empty($_SESSION['cliente_cod'])) {
        echo json_encode(Array("success"=> false));
        die();
    }

    if(empty($_POST['nome']) || empty($_POST['email']) || empty($_POST['telefone']) || empty($_POST['cpf'])) {
        echo json_encode(Array("success"=> false, "errorMessage"=> "Preencha todos os campos")); 
        die();
    }

    include_once ("../conexao.php");

    $query = mysqli_query($con, "SELECT COUNT(cliente_cod) FROM cliente WHERE cliente_cod <> $_SESSION[cliente_cod] AND cliente_email = '$_POST[email]'");
    
    if(mysqli_fetch_array($query)[0] != 0)
    {
        echo json_encode(Array("success"=> false, "errorMessage"=> "Digite outro email, esse já pertence a uma conta. "."SELECT COUNT(cliente_cod) FROM cliente WHERE cliente_cod <> $_SESSION[cliente_cod] AND cliente_email = '$_POST[email]'")); 
        die();
    }

    $query = mysqli_query($con, "UPDATE cliente SET cliente_nome = '$_POST[nome]', cliente_email = '$_POST[email]', cliente_telefone = '$_POST[telefone]', cliente_cpf = '$_POST[cpf]' WHERE cliente_cod = '$_SESSION[cliente_cod]'");  
    
    if($query != true)
    {
        echo json_encode(Array("success"=> false, "a" => "UPDATE cliente SET cliente_nome = '$_POST[nome]', cliente_email = '$_POST[email]', cliente_telefone = '$_POST[telefone]', cliente_cpf = '$_POST[cpf]' WHERE cliente_cod = '$_SESSION[cliente_cod]'"));  
        die();
    }
    
    echo json_encode(Array("success"=> true));

?>