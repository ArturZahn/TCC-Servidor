<?php

include("./backend/conexao.php");

$q = mysqli_query($con, "SELECT paginasparapesquisar_titulo, paginasparapesquisar_endereco FROM paginasparapesquisar");

$pags = [];

while($e = mysqli_fetch_array($q))
{
    $pags[] = Array(
        "titulo" => $e["paginasparapesquisar_titulo"],
        "url" => $e["paginasparapesquisar_endereco"]
    );
}

echo json_encode($pags);

?>