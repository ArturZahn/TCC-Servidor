<?php

header("Access-Control-Allow-Origin: *");
session_start();
include_once ("../conexao.php");

//========================================= endereco =========================================//
$endereco = "";
if(!empty($_GET["novoEndereco"])) // novo endereco
{
    $e = json_decode(base64_decode($_GET["novoEndereco"]));
    $endereco = "$e->rua, $e->numero - $e->bairro, $e->cidade - $e->estado, $e->cep";
}
else if(!empty($_GET["endereco"])) // endereco cadastrado
{
    $query = mysqli_query($con, "SELECT endereco_cod, endereco_cidade, endereco_bairro, endereco_rua, endereco_estado, endereco_numero, endereco_cep FROM cliente LEFT JOIN endereco USING(endereco_cod) WHERE cliente_cod = $_SESSION[cliente_cod] LIMIT 1;");

    if($query == false)
    {
        echo json_encode(Array("success"=> false)); 
        die();
    }

    $e = mysqli_fetch_object($query);
    $endereco = "$e->endereco_rua, $e->endereco_numero - $e->endereco_bairro, $e->endereco_cidade - $e->endereco_estado, $e->endereco_cep";
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
case "pix":
    $pagamento = "Via pix";
    break;
case "presencialCartao":
    $pagamento = "Via cartão, na hora da entrega";
    break;
case "presencialDinheiro":
    $pagamento = "Em Dinheiro, na hora da entrega";

    if(!isset($_GET["trocoPara"]))
    {
        echo json_encode(Array("success"=> false)); 
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

//========================================= produtos =========================================//
$produtos = "";
$query = mysqli_query($con, "SELECT produto_nome, itemcarrinho_quantidade FROM itemcarrinho JOIN produto USING(produto_cod) WHERE cliente_cod = $_SESSION[cliente_cod];");

if($query == false || mysqli_num_rows($query) < 1)
{
    echo json_encode(Array("success"=> false)); 
    die();
}

while($e = mysqli_fetch_object($query))
{
    $produtos .= $e->itemcarrinho_quantidade."x $e->produto_nome<br>";
}

$query = mysqli_query($con, "SELECT SUM(itemcarrinho_quantidade * produto_precoantigo) AS preco FROM itemcarrinho JOIN produto USING(produto_cod) WHERE cliente_cod = $_SESSION[cliente_cod];");

if($query == false || mysqli_num_rows($query) < 1)
{
    echo json_encode(Array("success"=> false)); 
    die();
}

$e = mysqli_fetch_object($query);

$precoTotal = $e->preco;
//============================================================================================//

echo json_encode(Array(
    "endereco" => $endereco,
    "pagamento" => $pagamento,
    "produtos" => $produtos,
    "precoTotal" => $precoTotal
));

?>