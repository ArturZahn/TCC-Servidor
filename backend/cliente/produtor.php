<?php

    header("Access-Control-Allow-Origin: *");

    include("../conexao.php");

    session_start();

    $query = mysqli_query($con, "SELECT produtor_nome, produtor_fotoDePerfil, endereco_estado, endereco_cidade, endereco_bairro, endereco_cod FROM produtor LEFT JOIN endereco USING(endereco_cod) WHERE produtor_cod = 1");

    if($query == false || mysqli_num_rows($query) < 1)
    {
        echo json_encode(Array("success"=> false)); 
        die();
    }

    $e = mysqli_fetch_object($query);

    $resposta = array(
        'produtor_nome' => $e->produtor_nome,
        'produtor_fotoDePerfil' => "data:image/gif;base64,$e->produtor_fotoDePerfil"
    );

    if(empty($e->endereco_cod))
    {
        $resposta["endereco"] = "Nenhum endereco cadastrado";
        // $resposta['endereco'] = "$e->endereco_bairro, $e->endereco_cidade-$e->endereco_estado @";
    }

    else 
    {
        $resposta['endereco'] = "$e->endereco_bairro, $e->endereco_cidade-$e->endereco_estado";
    }


    echo json_encode($resposta);

?>