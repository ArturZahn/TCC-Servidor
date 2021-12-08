<?php

    header("Access-Control-Allow-Origin: *");

    include_once ("../conexao.php");
    session_start();
    $query = mysqli_query($con, "SELECT produto_quantidadeemestoque, itemcarrinho_quantidade, produto_cod, produto_nome, produto_precoantigo, produto_foto, produto_tipocontagem FROM itemcarrinho JOIN produto USING(produto_cod) WHERE cliente_cod = $_SESSION[cliente_cod];");

    if($query == false)
    {
        echo json_encode(Array("success"=> false)); 
        die();
    }

    $itens = [];
    while($produto = mysqli_fetch_object($query)){
        $itens[] = array(
            'produtoCod' => intval($produto->produto_cod),
            'produtoFoto' => "$produto->produto_foto",
            'produtoNome' => "$produto->produto_nome",
            'quantidade' => intval($produto->itemcarrinho_quantidade),
            'precoUnidade' => floatval($produto->produto_precoantigo),
            'itemQuantidadeEmEstoque' => intval($produto->produto_quantidadeemestoque)
        );
    }

    echo json_encode(array('itens'=> $itens));

?>