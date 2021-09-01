<?php
    session_start();
    session_destroy();
    echo json_encode(Array("success"=> true)); 
?>