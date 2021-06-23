<?php

function clog($msg)
{
    $time = date("H:i:s");

    include("../conexao.php");

    $t = base64_encode("$time > $msg");
    $query = mysqli_query($con, "INSERT INTO console (log) VALUES ('$t')");
}

?>