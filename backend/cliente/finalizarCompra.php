<?php

header("Access-Control-Allow-Origin: *");
session_start();
include("../conexao.php");


//========================================= endereco =========================================//

$endereco_cod = null;
if(!empty($_GET["novoEndereco"]) || !empty($_GET["endereco"]))
{
    $dds_FINAL = Array();

    if(!empty($_GET["novoEndereco"])) // novo endereco
    {
        $dds = json_decode(base64_decode($_GET["novoEndereco"]));

        $dds_FINAL = (object) Array(
            "endereco_cidade" => $dds->cidade,
            "endereco_bairro" => $dds->bairro,
            "endereco_rua" => $dds->rua,
            "endereco_estado" => $dds->estado,
            "endereco_numero" => $dds->numero,
            "endereco_cep" => $dds->cep,
            "endereco_complemento" => $dds->complemento,
            "endereco_informacoesAdicinais" => $dds->extras
        );
    }
    else if(!empty($_GET["endereco"])) // endereco cadastrado
    {
        $query = mysqli_query($con, "SELECT endereco_cidade, endereco_bairro, endereco_rua, endereco_estado, endereco_numero, endereco_cep, endereco_complemento, endereco_informacoesAdicinais FROM cliente LEFT JOIN endereco USING(endereco_cod) WHERE cliente_cod = $_SESSION[cliente_cod] LIMIT 1;");
        
        if($query == false)
        {
            echo json_encode(Array("success"=> false));
            die();
        }

        if(!$dds_FINAL = mysqli_fetch_object($query))
        {
            echo json_encode(Array("success"=> false));
            die();
        }
    }

    $query = mysqli_query($con, "INSERT INTO endereco (endereco_cidade, endereco_bairro, endereco_rua, endereco_estado, endereco_numero, endereco_cep, endereco_complemento, endereco_informacoesAdicinais) VALUES ('$dds_FINAL->endereco_cidade', '$dds_FINAL->endereco_bairro', '$dds_FINAL->endereco_rua', '$dds_FINAL->endereco_estado', '$dds_FINAL->endereco_numero', '$dds_FINAL->endereco_cep', '$dds_FINAL->endereco_complemento', '$dds_FINAL->endereco_informacoesAdicinais')");

    $query = mysqli_query($con, "SELECT LAST_INSERT_ID() as endereco_cod");
    if($query == false)
    {
        echo json_encode(Array("success"=> false));
        die();
    }

    if($e = mysqli_fetch_object($query))
    {
        $endereco_cod = $e->endereco_cod;
    }
    else
    {
        echo json_encode(Array("success"=> false));
        die();
    }
}

//============================================================================================//

//========================================= pagamento =========================================//
if(empty($_GET["tipoPagamento"]))
{
    echo json_encode(Array("success"=> false)); 
    die();
}

$pagamento = "";
switch($_GET["tipoPagamento"])
{
case "cartao":
    $pagamento = "Via cartão";
    break;
case "boleto":
    $pagamento = "Via boleto";
    break;
case "presencialCartao":
    $pagamento = "Via cartão, na hora da entrega";
    break;
case "presencialDinheiro":
    $pagamento = "Em Dinheiro, na hora da entrega";

    if(!isset($_GET["trocoPara"]))
    {
        echo json_encode(Array("success6"=> false)); 
        die();
    }

    if($_GET["trocoPara"] == "0")
    {
        $pagamento .= ", sem troco";
    }
    else
    {
        $pagamento .= ", com troco para $_GET[trocoPara]";
    }
    break;
}

$pagamento .= ".";
//=============================================================================================//

//========================================= pedido =========================================//
$query = mysqli_query($con, "INSERT INTO pedido (pedido_dataCompra, cliente_cod, estadoPedido_cod, pedido_pagamento, endereco_cod) VALUES ('".date("Y-m-d H:i:s")."', $_SESSION[cliente_cod], 1, '$pagamento', $endereco_cod)");
if($query == false)
{
    echo json_encode(Array("success"=> false)); 
    die();
}

$pedido_cod = mysqli_insert_id($con);
//============================================================================================//

//========================================= produtos =========================================//
$produtos = "";
$query = mysqli_query($con, "SELECT itemCarrinho_quantidade, produto_preco, produto_cod FROM itemcarrinho JOIN produto USING(produto_cod) WHERE cliente_cod = $_SESSION[cliente_cod];");

if($query == false || mysqli_num_rows($query) < 1)
{
    echo json_encode(Array("success"=> false)); 
    die();
}

while($e = mysqli_fetch_object($query))
{
    $query2 = mysqli_query($con, "INSERT INTO itempedido (itemPedido_quantidade, itemPedido_precoUnitarioPago, pedido_cod, produto_cod) VALUES ($e->itemCarrinho_quantidade, $e->produto_preco, $pedido_cod, $e->produto_cod)");
}

$query = mysqli_query($con, "DELETE FROM itemcarrinho WHERE cliente_cod = $_SESSION[cliente_cod];");

//============================================================================================//

echo json_encode(Array("success" => true, "pedido_cod" => $pedido_cod));

?>