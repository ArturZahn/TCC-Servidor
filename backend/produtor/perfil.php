<?php

    header("Access-Control-Allow-Origin: *");

    include("../conexao.php");

    session_start();
    $query = mysqli_query($con, "SELECT cliente_nome, cliente_fotoDePerfil FROM cliente WHERE cliente_cod = $_SESSION[cliente_cod]");

    if($query == false || mysqli_num_rows($query) < 1)
    {
        echo json_encode(Array("success"=> false)); 
        die();
    }

    $exibe = mysqli_fetch_object($query);

    echo json_encode(array(
        'nome'=> $exibe->cliente_nome,
        'fotoDePerfil'=> "data:image/gif;base64,$exibe->cliente_fotoDePerfil"
    ));

?>