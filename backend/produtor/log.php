<?php

function clog($msg)
{
    $time = date("H:i:s");

    include_once ("../conexao.php");

    $t = base64_encode("$time > $msg");
    $query = mysqli_query($con, "INSERT INTO console (log) VALUES ('$t')");
}

?>