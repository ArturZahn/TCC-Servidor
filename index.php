<?php

if(false) // se usuario esta logado
{
  // vai para painel
  header("location: painel.php");
}
else // se usuario não esta logado
{
  // vai para login
  header("location: login.php");
}

?>