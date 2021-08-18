<?php

    header("Access-Control-Allow-Origin: *");

    include("../conexao.php");

    session_start();

    $query = mysqli_query($con, "SELECT cliente_nome, cliente_fotoDePerfil, cliente_cpf, cliente_email, cliente_telefone, endereco_cod, endereco_cidade, endereco_cep, endereco_estado, endereco_bairro, endereco_rua, endereco_numero FROM cliente LEFT JOIN endereco USING(endereco_cod) WHERE cliente_cod = $_SESSION[cliente_cod]");

    if($query == false || mysqli_num_rows($query) < 1)
    {
        echo json_encode(Array("success"=> false)); 
        die();
    }

    $e = mysqli_fetch_object($query);

    $resposta = array(
        'cliente_nome' => $e->cliente_nome,
        'cliente_fotoDePerfil' => "data:image/gif;base64,$e->cliente_fotoDePerfil",
        'cliente_cpf' => $e->cliente_cpf,
        'cliente_email' => $e->cliente_email,
        'cliente_telefone' => $e->cliente_telefone
    );

    if(empty($e->endereco_cod))
    {
        $resposta['temEnderecoCadastrado'] = false;
    }
    else
    {
        $resposta['temEnderecoCadastrado'] = true;
        // $resposta['enderecoPrev'] = "$e->endereco_cidade-$e->endereco_estado, $e->endereco_";
        $resposta['enderecoPrev'] = "$e->endereco_rua, n° $e->endereco_numero - $e->endereco_bairro, $e->endereco_cidade-$e->endereco_estado, $e->endereco_cep";
    }

    echo json_encode($resposta);

?>