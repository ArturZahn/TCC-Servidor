<?php

    header("Access-Control-Allow-Origin: *");

    include("../conexao.php");

    session_start();
    $query = mysqli_query($con, "SELECT pagamento_data, itemPedido_precoUnitarioPago * itemPedido_quantidade AS precoItem FROM itempagamento RIGHT JOIN itempedido USING(itemPedido_cod) JOIN produto USING(produto_cod) JOIN pagamento USING(pagamento_cod) WHERE pagamento_cod = $_SESSION[produtor_cod]");

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