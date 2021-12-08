<?php

    header("Access-Control-Allow-Origin: *");

    include_once ("../conexao.php");

    if(!empty($_GET['s'])) $sqlQuery = "SELECT produtor_cod, produtor_nome, produtor_fotodeperfil, endereco_cidade, endereco_estado FROM produtor JOIN endereco USING(endereco_cod) WHERE produtor_nome LIKE '%$_GET[s]%' ORDER BY RAND() ASC";
    else $sqlQuery = "SELECT produtor_cod, produtor_nome, produtor_fotodeperfil, endereco_cidade, endereco_estado FROM produtor JOIN endereco USING(endereco_cod) ORDER BY RAND() ASC";

    $query = mysqli_query($con, $sqlQuery);

    if($query == false)
    {
        echo json_encode(Array("success"=> false)); 
        die();
    }

    $produtores = [];
    while($produtor = mysqli_fetch_object($query)){
        $produtores[] = array(
            'produtorCod'=> $produtor->produtor_cod,
            'produtorNome'=> "$produtor->produtor_nome",
            'produtorCidade'=> "$produtor->endereco_cidade",
            'produtorEstado'=> "$produtor->endereco_estado",
            'produtorFoto'=> "$produtor->produtor_fotodeperfil",
        );
    }

    echo json_encode(array(
        'produtores'=>$produtores
    ));

?>