<?php

    header("Access-Control-Allow-Origin: *");

    include("../conexao.php");

    session_start();
    $query = mysqli_query($con, "SELECT SUM(itemPedido_precoUnitarioPago * itemPedido_quantidade) AS totalItem, produto_nome, produto_foto, SUM(itemPedido_quantidade) AS quantidade FROM itempagamento RIGHT JOIN itempedido USING(itemPedido_cod) JOIN produto USING(produto_cod) WHERE pagamento_cod IS NULL AND produtor_cod = $_SESSION[produtor_cod] GROUP BY produto_cod;");

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
            'produto_foto'=> "data:image/gif;base64,$pagamento->produto_foto"
        );
    }

    echo json_encode(array(
        'pagamentos'=>$pagamentos
    ));

?>