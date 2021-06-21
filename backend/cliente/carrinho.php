<?php

    header("Access-Control-Allow-Origin: *");

    include("../conexao.php");
    session_start();
    $query = mysqli_query($con, "SELECT itemCarrinho_quantidade, produto_cod, produto_nome, produto_preco, produto_foto, tipocontagem_nome FROM itemcarrinho JOIN produto USING(produto_cod) JOIN tipocontagem USING(tipocontagem_cod) WHERE cliente_cod = $_SESSION[cliente_cod];");

    if($query == false)
    {
        echo json_encode(Array("success"=> false)); 
        die();
    }

    $itens = [];
    while($produto = mysqli_fetch_object($query)){
        $itens[] = array(
            'produtoCod' => $produto->produto_cod,
            'produtoFoto' => "data:image/gif;base64,$produto->produto_foto",
            'produtoNome' => "$produto->produto_nome",
            'itemQuantidade' => $produto->itemCarrinho_quantidade,
            'precoUnidade' => $produto->produto_preco
        );
    }

    echo json_encode(array('itens'=> $itens));

?>