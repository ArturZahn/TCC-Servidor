<?php

    header("Access-Control-Allow-Origin: *");

    include_once ("../conexao.php");

    session_start();

    $query = mysqli_query($con, "SELECT produtor_nome, produtor_fotodeperfil, endereco_estado, endereco_cidade, endereco_bairro, endereco_cod, produtor_sobre FROM produtor LEFT JOIN endereco USING(endereco_cod) WHERE produtor_cod = $_GET[cp]");

    if($query == false || mysqli_num_rows($query) < 1)
    {
        echo json_encode(Array("success"=> false, "a" => $_GET["cp"]));
        die();
    }

    $e = mysqli_fetch_object($query);

    $resposta = array(
        'produtor_nome' => $e->produtor_nome,
        'produtor_sobre' => $e->produtor_sobre,
        'produtor_fotodeperfil' => "$e->produtor_fotodeperfil",
    );

    $resposta["endereco"] = empty($e->endereco_cod)?"Nenhum endereco cadastrado":"$e->endereco_bairro, $e->endereco_cidade-$e->endereco_estado";

    echo json_encode($resposta);

?>