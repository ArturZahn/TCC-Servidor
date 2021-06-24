<?php


session_start();
if(empty($_SESSION["cliente_cod"])) {
    echo json_encode(Array("success"=> false)); 
    die();
}


$json = json_decode(file_get_contents('php://input'));

if(empty($json)) {
    echo json_encode(Array("success"=> false)); 
    die();
}

include("../conexao.php");

foreach ($json as $item) {
    if(!empty($item->produtoCod))
    {
        if(empty($item->quantidade))
        {
            $query = mysqli_query($con, "DELETE FROM itemcarrinho WHERE produto_cod = $item->produtoCod AND cliente_cod = $_SESSION[cliente_cod];");
        }
        else
        {
            $query = mysqli_query($con, "UPDATE itemcarrinho SET itemCarrinho_quantidade = $item->quantidade WHERE produto_cod = $item->produtoCod AND cliente_cod = $_SESSION[cliente_cod];");
        }
    }
}



// include("log.php");

// clog(var_export($json, true));

?>