<?php

    header("Access-Control-Allow-Origin: *");

    include("../conexao.php");

    $query = mysqli_query($con, "SELECT produto_cod, itemPedido_precoUnitarioPago * itemPedido_quantidade AS precoItem, produtor_cod FROM itempedido JOIN produto USING (produto_cod) WHERE produtor_cod = $_SESSION[produtor_cod]");

    if($query == false)
    {
        echo json_encode(Array("success"=> false)); 
        die();
    }
    
    if(mysqli_num_rows($query) < 1)
    {
        echo json_encode(Array("success"=> false, "errorMessage"=> "Nenhum produto foi encontrado.")); 
        die();
    }

    $produtos = [];
    while($produto = mysqli_fetch_object($query)){
        $produtos[] = array(
            'produtoPagina'=> "produto.html?p=$produto->produto_cod",
            'produtoFoto'=> "data:image/gif;base64,$produto->produto_foto",
            'produtoNome'=> "$produto->produto_nome",
            'produtoPreco'=> $produto->produto_preco,
            'produtorNome'=> "$produto->produtor_nome"
        );
    }

    echo json_encode(array(
        'produtos'=>$produtos
    ));

?>