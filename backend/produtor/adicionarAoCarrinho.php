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

$itemcarrinho_quantidade = intval($_POST['produtoQuantidade']);

$asd .= $itemcarrinho_quantidade."\n";

include_once ("../conexao.php");

$query = mysqli_query($con, "SELECT itemcarrinho_quantidade FROM itemcarrinho WHERE produto_cod = $_POST[produtoCod] AND cliente_cod = $_SESSION[cliente_cod] ORDER BY itemcarrinho_cod DESC;");

if(mysqli_num_rows($query) > 0)
{
    $asd .= "ja tem\n";
    $itemcarrinho_quantidade += intval(mysqli_fetch_object($query)->itemcarrinho_quantidade);
    $query = mysqli_query($con, "UPDATE itemcarrinho SET itemcarrinho_quantidade = $itemcarrinho_quantidade WHERE produto_cod = $_POST[produtoCod] AND cliente_cod = $_SESSION[cliente_cod];");
}
else
{
    $asd .= "nao tem\n";
    $query = mysqli_query($con, "INSERT INTO itemcarrinho (itemcarrinho_quantidade, cliente_cod, produto_cod) VALUES ($itemcarrinho_quantidade, $_SESSION[cliente_cod], $_POST[produtoCod])");
}

$asd .= $itemcarrinho_quantidade."\n";

if($query != true)
{
    echo json_encode(Array("success"=> false)); 
    die();
}

echo json_encode(Array("success" => true, "log" => $asd));

?>