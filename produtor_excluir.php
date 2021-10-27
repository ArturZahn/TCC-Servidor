<?php

include("global.php");
include("./backend/conexao.php");



if(empty($_GET["cod"]))
{
  echo "Erro, produtor não informado.";
  die();
}

$produtor_cod = $_GET["cod"];

$query = mysqli_query($con, "DELETE FROM produtor WHERE produtor_cod = $produtor_cod");

if($query === true)
{
    header("location: ./produtor.php");
}
else
{
    include("./msg.php");
    msg("Atenção!", "Não é possível deletar esse produtor porque há outras informações vinculadas a ele.", "OK", "./produtor.php");
}

?>