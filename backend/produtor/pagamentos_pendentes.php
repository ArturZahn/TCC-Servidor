<?php

    header("Access-Control-Allow-Origin: *");

    include_once ("../conexao.php");

    session_start();
    $query = mysqli_query($con, "SELECT SUM(itempedido_precounitariopago * itempedido_quantidade * (1-pedido_taxa)) AS totalItem, produto_nome, produto_foto, SUM(itempedido_quantidade) AS quantidade, itempedido_precounitariopago FROM itempagamento RIGHT JOIN itempedido USING(itempedido_cod) JOIN produto USING(produto_cod) JOIN pedido USING(pedido_cod) WHERE pagamento_cod IS NULL AND produtor_cod = $_SESSION[produtor_cod] GROUP BY produto_cod;");

    if($query == false)
    {
        echo json_encode(Array("success"=> false)); 
        die();
    }

    $pagamentos = [];
    while($pagamento = mysqli_fetch_object($query)){
        $pagamentos[] = array(
            'pagamento_total'=> $pagamento->totalItem,
            'quantidade'=> $pagamento->quantidade,
            'produto_nome'=> $pagamento->produto_nome,
            'produto_foto'=> "$pagamento->produto_foto"
        );
    }

    echo json_encode(array(
        'pagamentos'=>$pagamentos
    ));

?>