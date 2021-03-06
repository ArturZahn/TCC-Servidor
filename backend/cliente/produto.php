<?php

    header("Access-Control-Allow-Origin: *");

    include_once ("../conexao.php");

    if(empty($_GET['produtoCod']))
    {
        echo json_encode(Array("success"=> false)); 
        die();
    }

    $query = mysqli_query($con, "SELECT produto_nome, produto_descricao, produto_precoantigo, produto_quantidadeemestoque, produto_tipocontagem, produto_foto, produtor_nome, produtor_fotodeperfil, produtor_cod FROM produto JOIN(produtor) USING(produtor_cod) WHERE produto_cod = $_GET[produtoCod];");

    if($query == false || mysqli_num_rows($query) < 1)
    {
        echo json_encode(Array("success"=> false)); 
        die();
    }

    $exibe = mysqli_fetch_object($query);

    echo json_encode(array(
        'produtoNome' => $exibe->produto_nome,
        'produtoDescricao' => $exibe->produto_descricao,
        'produtoFoto' => "$exibe->produto_foto",
        'produtoPreco' => floatval($exibe->produto_precoantigo),
        'produtoQuantidadeEmEstoque' => intval($exibe->produto_quantidadeemestoque),
        'produtotipocontagem' => $exibe->produto_tipocontagem,
        'produtorNome' => $exibe->produtor_nome,
        'produtorCod' => $exibe->produtor_cod,
        'produtorFotoDePerfil' => "$exibe->produtor_fotodeperfil"
    ));

?>