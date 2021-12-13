<?php

session_start();
// $_SESSION = array();
// $_SESSION["admin_cod"] = null;
unset($_SESSION["admin_cod"]);
header("location: ./login.php");

?>