<?php

    header("Access-Control-Allow-Origin: *");

    include("../conexao.php");

    if(empty($_GET['produtoCod']))
    {
        echo json_encode(Array("success"=> false)); 
        die();
    }

    $query = mysqli_query($con, "SELECT produto_nome, produto_descricao, produto_preco, produto_tipoContagem, produto_foto, produtor_nome, produtor_fotoDePerfil FROM produto JOIN(produtor) USING(produtor_cod) WHERE produto_cod = $_GET[produtoCod];");

    if($query == false || mysqli_num_rows($query) < 1)
    {
        echo json_encode(Array("success"=> false)); 
        die();
    }

    $exibe = mysqli_fetch_object($query);

    echo json_encode(array(
        'produtoNome' => $exibe->produto_nome,
        'produtoDescricao' => $exibe->produto_descricao,
        'produtoFoto' => "data:image/gif;base64,$exibe->produto_foto",
        'produtoPreco' => $exibe->produto_preco,
        'produtoTipoContagem' => $exibe->produto_tipoContagem,
        'produtorNome' => $exibe->produtor_nome,
        'produtorFotoDePerfil' => "data:image/gif;base64,$exibe->produtor_fotoDePerfil"
    ));

?>