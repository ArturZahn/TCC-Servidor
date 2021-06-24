<?php

header("Access-Control-Allow-Origin: *");

session_start();
if(empty($_SESSION["cliente_cod"]))
{
    echo json_encode(Array("success"=> false)); 
    die();
}

if(empty($_POST['produtoCod']) || empty($_POST['produtoQuantidade']))
{
    echo json_encode(Array("success"=> false)); 
    die();
}

$itemCarrinho_quantidade = intval($_POST['produtoQuantidade']);

include("../conexao.php");

$query = mysqli_query($con, "SELECT itemCarrinho_quantidade FROM itemCarrinho WHERE produto_cod = $_POST[produtoCod] AND cliente_cod = $_SESSION[cliente_cod] ORDER BY itemCarrinho_cod DESC;");

if(mysqli_num_rows($query) > 0)
{
    $itemCarrinho_quantidade += intval(mysqli_fetch_object($query)->itemCarrinho_quantidade);
}

$query = mysqli_query($con, "UPDATE itemCarrinho SET itemCarrinho_quantidade = $itemCarrinho_quantidade WHERE produto_cod = $_POST[produtoCod] AND cliente_cod = $_SESSION[cliente_cod];");

// $query = mysqli_query($con, "INSERT INTO itemCarrinho (itemCarrinho_quantidade, cliente_cod, produto_cod) VALUES (, $_SESSION[cliente_cod], $_POST[produtoCod])");

echo json_encode(Array("success" => true));

?>