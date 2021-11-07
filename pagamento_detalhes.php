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
    <title>Detalhes do pagamento - CoopAF</title>
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
          <div class="container px-6 mx-auto grid">
            <h2 class="my-6 text-2xl font-semibold text-gray-700 dark:text-gray-200">
              Detalhes do pagamento
            </h2>
            <?php
                // DADOS GERAIS
                $cod_pagamento = $_GET["cod"];

                $q1 = mysqli_query($con, "SELECT produtor_nome, pagamento_data FROM itempagamento JOIN itempedido USING(itempedido_cod) JOIN produto USING(produto_cod) JOIN produtor USING(produtor_cod) JOIN pagamento USING(pagamento_cod) WHERE pagamento_cod = $cod_pagamento LIMIT 1;");
                $e1 = mysqli_fetch_array($q1);
                
                echo "<span class='mb-4 text-gray-700 dark:text-gray-400'>Produtor: $e1[produtor_nome]</span>";
                echo "<span class='mb-4 text-gray-700 dark:text-gray-400'>Data do pagamento: ".formatData2($e1["pagamento_data"])."</span>";

                // se o $_GET["p"] não esta vazio, coloca ele na variavel, se nao, define numero da pagina como 1
                $numDaPag = !empty($_GET["p"])?intval($_GET["p"]):1;
                // altere esses dados ↓↓↓
                $itensPorPag = 15;
                $queryDados       = "SELECT produto_cod, SUM(itempedido_precounitariopago*itempedido_quantidade*(1-pedido_taxa)) AS itemvalor, SUM(itempedido_quantidade) AS itemquantidade, produto_nome FROM itempagamento JOIN itempedido USING(itempedido_cod) JOIN pedido USING(pedido_cod) JOIN produto USING(produto_cod) JOIN produtor USING(produtor_cod) WHERE pagamento_cod = $cod_pagamento GROUP BY produto_cod LIMIT $itensPorPag OFFSET ".($numDaPag-1)*$itensPorPag;
                $queryQtdDeLinhas = "SELECT COUNT(DISTINCT produto_cod) FROM itempagamento JOIN itempedido USING(itempedido_cod) JOIN produto USING(produto_cod) JOIN produtor USING(produtor_cod) WHERE pagamento_cod = $cod_pagamento";
                // altere esses dados ↑↑↑

                // não precisa alterar essa linha ↓↓↓
                $qtdDeLinhas = mysqli_fetch_array(mysqli_query($con, $queryQtdDeLinhas))[0];

                tabela(array(
                "titulo" => "Produtos pagos:",
                "nomeColunas" => array(
                    "Código",
                    "Produto",
                    "Quantidade",
                    "Valor",
                ),

                "templateColunas" => array(
                  function($exibe){return $exibe["produto_cod"];},
                  function($exibe){return $exibe["produto_nome"];},
                  function($exibe){return $exibe["itemquantidade"];},
                  function($exibe){return formatPreco($exibe["itemvalor"]);},
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
