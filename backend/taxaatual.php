<?php

$qtx = mysqli_query($con, "SELECT cooperativa_taxa_vendas FROM cooperativa WHERE cooperativa_cod = 1");
$taxaAtual = mysqli_fetch_array($qtx)["cooperativa_taxa_vendas"];

?>