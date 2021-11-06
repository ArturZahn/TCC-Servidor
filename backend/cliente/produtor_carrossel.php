<?php

header("Access-Control-Allow-Origin: *");
include_once ("../conexao.php");


if(empty($_GET["cp"]))
{
    echo json_encode(Array("success"=> false));
    die();
}

$query = mysqli_query($con, "SELECT produtorimagem_foto FROM produtorimagem WHERE produtor_cod = $_GET[cp]");

if($query == false)
{
    echo json_encode(Array("success"=> false));
    die();
}

$imgs = [];
while($e = mysqli_fetch_object($query))
{
    $imgs[] = $e->produtorimagem_foto;
}

echo json_encode(array('fotos' => $imgs));

?>