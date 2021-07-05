<?php

    header("Access-Control-Allow-Origin: *");

    include("../conexao.php");

    session_start();

    $query = mysqli_query($con, "SELECT endereco_cidade, endereco_cep, endereco_estado, endereco_bairro, endereco_rua, endereco_numero, endereco_complemento, endereco_informacoesAdicinais FROM cliente JOIN endereco USING(endereco_cod) WHERE cliente_cod = $_SESSION[cliente_cod]");

    if($query == false || mysqli_num_rows($query) < 1)
    {
        echo json_encode(Array("success"=> false, "a" => "nop")); 
        die();
    }

    $e = mysqli_fetch_object($query);

    $resposta = array(
        'endereco_cidade' => $e->endereco_cidade,
        'endereco_cep' => $e->endereco_cep,
        'endereco_estado' => $e->endereco_estado,
        'endereco_bairro' => $e->endereco_bairro,
        'endereco_rua' => $e->endereco_rua,
        'endereco_numero' => $e->endereco_numero,
        'endereco_complemento' => $e->endereco_complemento,
        'endereco_informacoesAdicinais' => $e->endereco_informacoesAdicinais
    );

    echo json_encode($resposta);

?>