<?php
    include("global.php");
    include('./backend/conexao.php');
    
    if(empty($_GET["cod"]))
    {
    echo "Erro, produtor não informado.";
    die();
    }

    $produto_cod = $_GET["cod"];
    $query = mysqli_query($con, "DELETE FROM produto WHERE produto_cod = $produto_cod;");

    if($query === true)
    {
        header("location: ./produtos.php");
    }
    else
    {
        include("./msg.php");
        msg("Atenção!", "Não é possível deletar esse produto porque há outras informações vinculadas a ele.", "OK", "./produtos.php");
    }

    var_dump($query)

?>

