<?php

include("global.php");
include("tabletemplate.php");
include_once ("./backend/conexao.php");


?>

<!DOCTYPE html>
<html :class="{ 'theme-dark': dark }" x-data="data()" lang="pt-BR">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Blank - Windmill Dashboard</title>
    <link
      href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap"
      rel="stylesheet"
    />
    <link rel="stylesheet" href="./assets/css/tailwind.output.css" /><link rel="stylesheet" href="./assets/css/corescustomizadas.css" />
    
    <link rel="stylesheet" href="./assets/css/fontawesome/css/all.css">

    <script
      src="https://cdn.jsdelivr.net/gh/alpinejs/alpine@v2.x.x/dist/alpine.min.js"
      defer
    ></script>
    <script src="./assets/js/init-alpine.js"></script>
  </head>
  <body>
    <div
      class="flex h-screen bg-gray-50 dark:bg-gray-900"
      :class="{ 'overflow-hidden': isSideMenuOpen}"
    >
    <?php
    include("./sidebar.php");
      ?>
      <div class="flex flex-col flex-1">
        <?php include("header.php") ?>
        <main class="h-full pb-16 overflow-y-auto">
          <!-- Remove everything INSIDE this div to a really blank page -->
          <div class="container px-6 mx-auto grid">
            <h2 class="my-6 text-2xl font-semibold text-gray-700 dark:text-gray-200">
              Blank
            </h2>
            <?php

                // se o $_GET["p"] não esta vazio, coloca ele na variavel, se nao, define numero da pagina como 1
                $numDaPag = !empty($_GET["p"])?intval($_GET["p"]):1;


                // altere esses dados ↓↓↓
                $itensPorPag = 15;
                $queryDados       = "SELECT produto_nome, produto_precoantigo from produto limit $itensPorPag offset ".($numDaPag-1)*$itensPorPag;
                $queryQtdDeLinhas = "SELECT count(produto_cod) from produto";
                // altere esses dados ↑↑↑


                // não precisa alterar essa linha ↓↓↓
                $qtdDeLinhas = mysqli_fetch_array(mysqli_query($con, $queryQtdDeLinhas))[0];

                tabela(array(
                  "titulo" => "Titulo da tabela",
                  "nomeColunas" => array(
                    "Produto",
                    "Preço"
                  ),
                  "templateColunas" => array(
                    function($exibe){return "<span>$exibe[produto_nome]</span>";},

                    function($exibe){
                      if($exibe["produto_precoantigo"] > 8) $classes = "text-red-700 bg-red-100 dark:text-red-100 dark:bg-red-700";
                      else $classes = "text-green-700 bg-green-100 dark:bg-green-700 dark:text-green-100";

                      return "<span class='px-2 py-1 font-semibold leading-tight rounded-full $classes'>$exibe[produto_precoantigo]</span>";
                    }
                  ),
                  "dados" => mysqli_query($con, $queryDados),
                  "numDaPag" => $numDaPag,
                  "qtdDeLinhas" => $qtdDeLinhas,
                  "itensPorPag" => $itensPorPag
                ));
            ?>
          </div>
        </main>
      </div>
    </div>
  </body>
</html>
 