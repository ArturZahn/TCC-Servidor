<?php

    header("Access-Control-Allow-Origin: *");

    include("../conexao.php");

    if(!empty($_GET['s'])) $sqlQuery = "SELECT produtor_cod, produto_cod, produto_foto, produto_nome, produto_quantidadeEmEstoque FROM produto JOIN produtor USING(produtor_cod) WHERE produto_nome LIKE '%$_GET[s]%'";
    else $sqlQuery = "SELECT produtor_cod, produto_cod, produto_foto, produto_nome, produto_quantidadeEmEstoque FROM produto JOIN produtor USING(produtor_cod) WHERE produtor_cod = $_SESSION[produtor_cod]";

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
            'produtoQuantidadeEmEstoque'=> $produto->produto_quantidadeEmEstoque
        );
    }

    echo json_encode(array(
        'produtos'=>$produtos
    ));

?>