<?php
include("global.php");
include("./backend/conexao.php");

$cod_produtor = $_GET["cod"];

$q1 = mysqli_query($con, "INSERT INTO pagamento (pagamento_data) VALUES ('".date("Y-m-d h:i:s")."')");

if($q1 === false)
{
    include("./msg.php");
    msg("Erro", "Não foi possível realizar pagamento (erro 1)", "Ok", "./pagamento_pagar.php?cod=$cod_produtor");
    die();
}

$pagamento_cod = mysqli_insert_id($con);

$q2 = mysqli_query($con, "SELECT itempedido_cod FROM itempedido LEFT JOIN itempagamento USING(itempedido_cod) JOIN produto USING(produto_cod) WHERE pagamento_cod IS NULL AND produtor_cod = $cod_produtor");

$num_rows = mysqli_num_rows($q2);

$sqlInsert = "INSERT INTO itempagamento (pagamento_cod, itempedido_cod) VALUES ";

$i = 0;
while($e2 = mysqli_fetch_array($q2))
{
    $i++;
    $sqlInsert .= "($pagamento_cod,$e2[itempedido_cod])".($i!=$num_rows?",":";");
}

$q3 = mysqli_query($con, $sqlInsert);

if($q3 === false)
{
    include("./msg.php");
    msg("Erro", "Não foi possível realizar pagamento (erro 1)", "Ok", "./pagamento_pagar.php?cod=$cod_produtor");
    die();
}

header("location: ./pagamentos.php");

?>