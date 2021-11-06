<?php

    header("Access-Control-Allow-Origin: *");
    include_once ("../conexao.php");
    session_start();
    
    $query = mysqli_query($con, "SELECT endereco_cod, endereco_cidade, endereco_bairro, endereco_rua, endereco_estado, endereco_numero FROM cliente LEFT JOIN endereco USING(endereco_cod) WHERE cliente_cod = $_SESSION[cliente_cod] LIMIT 1;");

    if($query == false)
    {
        echo json_encode(Array("success"=> false)); 
        die();
    }

    $e = mysqli_fetch_object($query);

    if($e->endereco_cod === null)
    {
        echo json_encode(array(
            'endereco_cod' => null
        ));
        die();
    }

    echo json_encode(array(
        'endereco_cod' => $e->endereco_cod,
        'endereco' =>  "$e->endereco_rua, $e->endereco_numero - $e->endereco_bairro, $e->endereco_cidade-$e->endereco_estado"
    ));

?>