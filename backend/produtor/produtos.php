<?php

    header("Access-Control-Allow-Origin: *");

    include("../conexao.php");

    if(!empty($_GET['s'])) $sqlQuery = "SELECT produto_nome, produto_cod, produto_preco, produto_foto, produtor_nome FROM produto JOIN produtor USING(produtor_cod) WHERE produto_nome LIKE '%$_GET[s]%'";
    else $sqlQuery = "SELECT produto_nome, produto_cod, produto_preco, produto_foto, produtor_nome FROM produto JOIN produtor USING(produtor_cod)";

    $query = mysqli_query($con, $sqlQuery);

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