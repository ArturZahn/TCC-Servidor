<?php
    
    include("conexao_dados.php");
    if(!isset($mysql_endereco)) die('CONFIGURE O ARQUIVO "conexao_dados.php", leia mais em "conexao_dados_template.php"');

    $con = mysqli_connect($mysql_endereco, $mysql_usuario, $mysql_senha, "tcc") or die("FALHA AO CONECTAR COM O BANCO");

?>