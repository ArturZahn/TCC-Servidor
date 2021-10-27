<?php
include("backend/conexao.php");
echo $_POST ['cod'];
echo $_POST ['status'];
$q = mysqli_query($con, "UPDATE pedido SET estadopedido_cod = $_POST[status] WHERE pedido_cod = $_POST[cod]");

header("Location: pedidos_detalhes.php?cod=$_POST[cod]");
?> 