<?php

if(!isset($verificarLogin)) $verificarLogin = true;
session_start();
// var_dump($_SESSION, "@", $verificarLogin);
if($verificarLogin)
{
    if(empty($_SESSION["admin_cod"]))
    {
        // echo "n ta logado";
        header("location: login.php");
        die();
    }
}

function formatPreco($valor)
{
    return "R$ ".number_format($valor, 2, ',', ' ');
}

function formatData($data)
{
    return date("d/m/Y", strtotime($data));
}
function formatData2($data)
{
    return date("d/m/Y h:i", strtotime($data));
}

?>