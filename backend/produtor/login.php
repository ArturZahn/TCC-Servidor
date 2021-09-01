<?php

    header("Access-Control-Allow-Origin: *");

    if(empty($_POST['email']) || empty($_POST['senha'])) {
        echo json_encode(Array("success"=> false, "errorMessage"=> "Campos incorretos ou vazios")); 
        die();
    }

    include("../conexao.php");

    $query = mysqli_query($con, "SELECT produtor_cod FROM produtor WHERE produtor_email = '$_POST[email]' AND produtor_senha = '".MD5($_POST['senha'])."'");
    
    if(mysqli_num_rows($query) != 1)
    {
        echo json_encode(Array("success"=> false, "errorMessage"=> "Email e/ou senha inválidos.")); 
        die();
    }

    session_start();
    $_SESSION['produtor_cod'] = mysqli_fetch_array($query)[0];

    echo json_encode(Array("success"=> true));    

?>