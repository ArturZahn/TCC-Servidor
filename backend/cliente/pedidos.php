<?php

    header("Access-Control-Allow-Origin: *");
    session_start();
    include("../conexao.php");

    $query = mysqli_query($con, "SELECT pedido_cod, pedido_dataCompra, estadoPedido_estado, SUM(itemPedido_quantidade * itemPedido_precoUnitarioPago) AS precoTotal FROM pedido JOIN itemPedido USING(pedido_cod) JOIN estadopedido USING(estadoPedido_cod) WHERE cliente_cod = $_SESSION[cliente_cod] GROUP BY pedido_cod ORDER BY pedido_dataCompra DESC;");

    if($query == false || mysqli_num_rows($query) < 1)
    {
        echo json_encode(Array("success"=> false)); 
        die();
    }

    $pedidos = Array();
    while($e = mysqli_fetch_object($query))
    {
        $pedidos[] = array(
            'dataCompra' => date("d/m/Y", strtotime($e->pedido_dataCompra)),
            'precoTotal' => floatval($e->precoTotal),
            'estadoPedido' => $e->estadoPedido_estado,
            'numPedido' => $e->pedido_cod
        );
    }

    echo json_encode($pedidos);


?>