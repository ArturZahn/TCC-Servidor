<?php

if(!isset($verificarLogin)) $verificarLogin = true;
session_start();
// var_dump($_SESSION, "@", $verificarLogin);
if($verificarLogin)
{
    if(empty($_SESSION["admin_cod"]))
    {
        // echo "n ta logado";
        header("location: login.php");
        die();
    }
}

function formatPreco($valor)
{
    return "R$ ".number_format($valor, 2, ',', ' ');
}

function formatData($data)
{
    return date("d/m/Y", strtotime($data));
}
function formatData2($data)
{
    return date("d/m/Y h:i", strtotime($data));
}

function cadastrarImg($a)
{
  $imgName = $a["imgName"];
  $imgFilePath = $a["imgFilePath"];
  $lineCod = $a["lineCod"];
  $tableName = $a["tableName"];
  $tableColumn = $a["tableColumn"];
  $whereTag = $a["whereTag"];

  global $con;

  // se a imagem existe...
  if(!empty($_FILES[$imgName]) && $_FILES[$imgName]["error"] == UPLOAD_ERR_OK)
  {
    // salva ela no panco e na pasta certa:

    // imagem do upload
    $fileImg = $_FILES[$imgName];
    
    // extensoes aceitas:
    $allowed = array('png', 'jpeg', 'jpg');
    $ext = pathinfo($fileImg['name'], PATHINFO_EXTENSION);
    
    // se a extensao da imagem nao esta entre as aceitas, cancela operacao
    if (!in_array($ext, $allowed))
    {
      return false;
    }

    // gerando nome da imagem a ser salva
    $imgCompleteFileName = "$imgFilePath$lineCod.$ext";

    // consultando no banco o nome da imagem antiga
    $query = mysqli_query($con, "SELECT $tableColumn FROM $tableName $whereTag");
    $imagemAntiga = mysqli_fetch_array($query)[0];

    // atualiza o nome da imagem no banco
    mysqli_query($con, "UPDATE $tableName SET $tableColumn = '$imgCompleteFileName' $whereTag");

    // move o arquivo do upload para a pasta definitiva, e verifica se deu certo
    if (move_uploaded_file($fileImg['tmp_name'], __DIR__."/$imgCompleteFileName"))
    {
      // se deu certo...
      
      // verifica se antes havia uma imagem e o nome dela é diferente da atual
      if(!empty($imagemAntiga) && $imagemAntiga != $imgCompleteFileName) 
      {
        // se sim, deleta imagem antiga
        if(file_exists(__DIR__."/$imagemAntiga")) unlink(__DIR__."/$imagemAntiga");
      }

      // informa que operacao foi realizada com sucesso
      return true;
    }

    // informa que a operacao deu erro (erro ao mover imagem para pasta definitiva)
    return false;
  }
}

function cadastrarImgProdutor($lineCod, $imgName)
{
  cadastrarImg(Array(
    "imgName" => $imgName,
    "imgFilePath" => "images/produtor/",
    "lineCod" => $lineCod,
  
    "tableName" => "produtor",
    "tableColumn" => "produtor_fotodeperfil",
    "whereTag" => "WHERE produtor_cod = $lineCod",
  ));
} 

function cadastrarImgProduto($lineCod, $imgName)
{
  cadastrarImg(Array(
    "imgName" => $imgName,
    "imgFilePath" => "images/produto/",
    "lineCod" => $lineCod,
  
    "tableName" => "produto",
    "tableColumn" => "produto_foto",
    "whereTag" => "WHERE produto_cod = $lineCod",
  ));
} 

?>
