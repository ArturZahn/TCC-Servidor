<?php

    header("Access-Control-Allow-Origin: *");

    include_once ("../conexao.php");

    session_start();
    $query = mysqli_query($con, "SELECT pagamento_data, SUM(itempedido_precounitariopago*itempedido_quantidade*(1-pedido_taxa)) AS precoItem FROM itempedido LEFT JOIN itempagamento USING(itempedido_cod) JOIN pedido USING(pedido_cod) JOIN produto USING(produto_cod) JOIN pagamento USING(pagamento_cod) WHERE itempagamento_cod IS NOT NULL AND produtor_cod = $_SESSION[produtor_cod] GROUP BY pagamento_cod ORDER BY pagamento_data DESC");

    if($query == false)
    {
        echo json_encode(Array("success"=> false)); 
        die();
    }

    $pagamentos = [];
    while($pagamento = mysqli_fetch_object($query)){
        $pagamentos[] = array(
            'pagamento_data'=> date("d/m/Y"),//$pagamento->pagamento_data,
            'pagamento_valor'=> "$pagamento->precoItem"
        );
    }

    echo json_encode(array(
        'pagamentos'=>$pagamentos
    ));

?>