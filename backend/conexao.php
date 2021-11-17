<?php
    
    include("conexao_dados.php");
    
    
    header("Access-Control-Allow-Origin: *");
    // header("Access-Control-Allow-Headers: *");

    if(!isset($mysql_endereco)) die('CONFIGURE O ARQUIVO "conexao_dados.php", leia mais em "conexao_dados_template.php"');

    $con = mysqli_connect($mysql_endereco, $mysql_usuario, $mysql_senha, "coopaftcc") or die("FALHA AO CONECTAR COM O BANCO");
    mysqli_set_charset($con, "utf8");

    mysqli_query($con, "SET lc_time_names = 'pt_BR';");

?>