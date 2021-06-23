<?php

// esse arquivo ainda nao foi programado, foi apenas usado para alguns testes...

$json = json_decode(file_get_contents('php://input'));

include("log.php");

clog(var_export($json, true));

?>