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

$asd = "";

$itemCarrinho_quantidade = intval($_POST['produtoQuantidade']);

$asd .= $itemCarrinho_quantidade."\n";

include("../conexao.php");

$query = mysqli_query($con, "SELECT itemCarrinho_quantidade FROM itemCarrinho WHERE produto_cod = $_POST[produtoCod] AND cliente_cod = $_SESSION[cliente_cod] ORDER BY itemCarrinho_cod DESC;");

if(mysqli_num_rows($query) > 0)
{
    $asd .= "ja tem\n";
    $itemCarrinho_quantidade += intval(mysqli_fetch_object($query)->itemCarrinho_quantidade);
    $query = mysqli_query($con, "UPDATE itemCarrinho SET itemCarrinho_quantidade = $itemCarrinho_quantidade WHERE produto_cod = $_POST[produtoCod] AND cliente_cod = $_SESSION[cliente_cod];");
}
else
{
    $asd .= "nao tem\n";
    $query = mysqli_query($con, "INSERT INTO itemCarrinho (itemCarrinho_quantidade, cliente_cod, produto_cod) VALUES ($itemCarrinho_quantidade, $_SESSION[cliente_cod], $_POST[produtoCod])");
}

$asd .= $itemCarrinho_quantidade."\n";

if($query != true)
{
    echo json_encode(Array("success"=> false)); 
    die();
}

echo json_encode(Array("success" => true, "log" => $asd));

?>