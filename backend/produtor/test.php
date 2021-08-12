<?php

    header("Access-Control-Allow-Origin: *");
    session_start();
    var_dump($_SESSION);
    echo "path: ".session_save_path();

?>