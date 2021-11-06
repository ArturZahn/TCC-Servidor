<?php

$login = $_POST["login"];
$senha = $_POST["senha"];
if(empty($login) && empty($senha))
{
    header("location: ./login.php?err=Digite um usuário e senha");
    die();
}
else
{
    include_once ("./backend/conexao.php");
    
    $query = mysqli_query($con, "SELECT admin_cod FROM admin WHERE admin_login='$login' AND admin_senha=MD5('$senha')");
    
    if($query->num_rows != 1)
    {
        header("location: ./login.php?err=Usuário ou senha incorretos");
        die();
    }

    session_start();
    $_SESSION["admin_cod"] = mysqli_fetch_array($query)["admin_cod"];

    header("location: ./painel.php");
}

?>