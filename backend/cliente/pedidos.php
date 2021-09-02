<?php

    header("Access-Control-Allow-Origin: *");
    session_start();
    include("../conexao.php");

    $query = mysqli_query($con, "SELECT pedido_cod, pedido_datacompra, estadopedido_estado, SUM(itempedido_quantidade * itempedido_precounitariopago) AS precoTotal FROM pedido JOIN itempedido USING(pedido_cod) JOIN estadopedido USING(estadopedido_cod) WHERE cliente_cod = $_SESSION[cliente_cod] GROUP BY pedido_cod ORDER BY pedido_datacompra DESC;");

    if($query == false || mysqli_num_rows($query) < 1)
    {
        echo json_encode(Array("success"=> false)); 
        die();
    }

    $pedidos = Array();
    while($e = mysqli_fetch_object($query))
    {
        $pedidos[] = array(
            'dataCompra' => date("d/m/Y", strtotime($e->pedido_datacompra)),
            'precoTotal' => floatval($e->precoTotal),
            'estadopedido' => $e->estadopedido_estado,
            'numPedido' => $e->pedido_cod
        );
    }

    echo json_encode($pedidos);


?>