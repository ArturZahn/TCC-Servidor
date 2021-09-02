<?php

    header("Access-Control-Allow-Origin: *");
    session_start();
    include("../conexao.php");

    if(empty($_GET['p']))
    {
        echo json_encode(Array("success"=> false)); 
        die();
    }

    $query = mysqli_query($con, "SELECT produto_nome, produto_foto, itempedido_quantidade, itempedido_quantidade * itempedido_precounitariopago AS precoItem FROM itempedido JOIN produto USING(produto_cod) WHERE pedido_cod = $_GET[p];");

    if($query == false || mysqli_num_rows($query) < 1)
    {
        echo json_encode(Array("success"=> false)); 
        die();
    }

    $pedidos = Array();
    while($e = mysqli_fetch_object($query))
    {
        $pedidos[] = array(
            'produtoFoto' => "data:image/gif;base64,$e->produto_foto",
            'itemQuantidade' => $e->itempedido_quantidade,
            'nomeProduto' => $e->produto_nome,
            'itemPreco' => $e->precoItem
        );
    }

    //////////////////////
    $query = mysqli_query($con, "SELECT pedido_cod, pedido_datacompra, estadopedido_estado FROM pedido JOIN estadopedido USING(estadopedido_cod) WHERE pedido_cod = $_GET[p];");

    if($query == false || mysqli_num_rows($query) < 1)
    {
        echo json_encode(Array("success"=> false)); 
        die();
    }
    
    $e = mysqli_fetch_object($query);

    echo json_encode(Array(
        "itens" => $pedidos,
        'pedido_cod' => $e->pedido_cod,
        'pedido_datacompra' => date("d/m/Y", strtotime($e->pedido_datacompra)),
        'estadopedido_estado' => $e->estadopedido_estado
    ));

?>