<?php

if(false) // se usuario esta logado
{
  header("location: painel.php");
}
else // se usuario não esta logado
{
  header("location: login.php");
}

?>