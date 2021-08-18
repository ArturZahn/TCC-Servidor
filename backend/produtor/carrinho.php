<?php

    header("Access-Control-Allow-Origin: *");

    include("../conexao.php");
    session_start();
    $query = mysqli_query($con, "SELECT produto_quantidadeEmEstoque, itemCarrinho_quantidade, produto_cod, produto_nome, produto_preco, produto_foto, produto_tipocontagem FROM itemcarrinho JOIN produto USING(produto_cod) WHERE cliente_cod = $_SESSION[cliente_cod];");

    if($query == false)
    {
        echo json_encode(Array("success"=> false)); 
        die();
    }

    $itens = [];
    while($produto = mysqli_fetch_object($query)){
        $itens[] = array(
            'produtoCod' => intval($produto->produto_cod),
            'produtoFoto' => "data:image/gif;base64,$produto->produto_foto",
            'produtoNome' => "$produto->produto_nome",
            'quantidade' => intval($produto->itemCarrinho_quantidade),
            'precoUnidade' => floatval($produto->produto_preco),
            'itemQuantidadeEmEstoque' => intval($produto->produto_quantidadeEmEstoque)
        );
    }

    echo json_encode(array('itens'=> $itens));

?>