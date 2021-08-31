<?php

header("Access-Control-Allow-Origin: *");
session_start();
include("../conexao.php");

if(!empty($_POST))
{
    $query = mysqli_query($con, "SELECT endereco_cod FROM cliente WHERE cliente_cod = $_SESSION[cliente_cod]");
    $e = mysqli_fetch_object($query);
    $endereco_cod = $e->endereco_cod;
    if($endereco_cod == null)
    {
        $query = mysqli_query($con, "INSERT INTO endereco (endereco_cidade, endereco_bairro, endereco_rua, endereco_estado, endereco_numero, endereco_cep, endereco_complemento, endereco_informacoesAdicinais) VALUES ('$_POST[cidade]', '$_POST[bairro]', '$_POST[rua]', '$_POST[estado]', '$_POST[numero]', '$_POST[cep]', '$_POST[complemento]', '$_POST[extras]')");
    
        if($query == false)
        {
            echo json_encode(Array("success"=> false));
            die();
        }
    
        $endereco_cod = mysqli_insert_id($con);
        $query = mysqli_query($con, "UPDATE cliente SET endereco_cod = $endereco_cod WHERE cliente_cod = $_SESSION[cliente_cod]");
    }
    else
    {
        $query = mysqli_query($con, "UPDATE endereco SET endereco_cidade = '$_POST[cidade]', endereco_bairro = '$_POST[bairro]', endereco_rua = '$_POST[rua]', endereco_estado = '$_POST[estado]', endereco_numero = '$_POST[numero]', endereco_cep = '$_POST[cep]', endereco_complemento = '$_POST[complemento]', endereco_informacoesAdicinais = '$_POST[extras]' WHERE endereco_cod = $endereco_cod");
    
        if($query == false)
        {
            echo json_encode(Array("success"=> false));
            die();
        }
    }
    
}
else if(isset($_GET["getData"]))
{
    $query = mysqli_query($con, "SELECT endereco_cod, endereco_cidade, endereco_bairro, endereco_rua, endereco_estado, endereco_numero, endereco_cep, endereco_complemento, endereco_informacoesAdicinais FROM cliente LEFT JOIN endereco USING(endereco_cod) WHERE cliente_cod = $_SESSION[cliente_cod]");
    $e = mysqli_fetch_object($query);

    if($e->endereco_cod == null)
    {
        echo json_encode(Array("success" => true, "end" => null));
    }
    else
    {
        unset($e->endereco_cod);
        echo json_encode(Array("success" => true, "end" => $e));
    }
    die();
}

echo json_encode(Array("success" => true));

?>