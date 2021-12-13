<?php
    session_start();
    // session_destroy();
    // $_SESSION['cliente_cod'] = null;
    unset($_SESSION['cliente_cod']);
    echo json_encode(Array("success"=> true)); 
?>