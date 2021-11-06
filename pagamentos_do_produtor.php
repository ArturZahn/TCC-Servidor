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
    <title>Pagamentos do produtor - CoopAF</title>
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
                Pagamentos do produtor
            </h2>
            <?php
                // DADOS GERAIS
                $cod_produtor = $_GET["cod"];

                include("./backend/taxaatual.php");

                $q1 = mysqli_query($con, "SELECT count(DISTINCT pagamento_cod) AS num, produtor_nome FROM pagamento JOIN itempagamento USING(pagamento_cod) JOIN itempedido USING(itempedido_cod) JOIN produto USING(produto_cod) JOIN produtor USING(produtor_cod) WHERE produtor_cod = $cod_produtor");
                $e1 = mysqli_fetch_array($q1);
                
                echo "<span class='mb-4 text-gray-700 dark:text-gray-400'>Produtor: $e1[produtor_nome]</span>";

                // se o $_GET["p"] não esta vazio, coloca ele na variavel, se nao, define numero da pagina como 1
                $numDaPag = !empty($_GET["p"])?intval($_GET["p"]):1;

                // altere esses dados ↓↓↓
                $itensPorPag = 15;
                $queryDados       = "SELECT SUM(itempedido_precounitariopago*itempedido_quantidade)*".(1-$taxaAtual)." AS precoItem, pagamento_data, pagamento_cod FROM itempedido JOIN produto USING(produto_cod) JOIN itempagamento USING(itempedido_cod) JOIN pagamento USING(pagamento_cod) WHERE produtor_cod = $cod_produtor GROUP BY pagamento_cod ORDER BY pagamento_data DESC LIMIT $itensPorPag OFFSET ".($numDaPag-1)*$itensPorPag;
                $queryQtdDeLinhas = "SELECT count(DISTINCT pagamento_cod) FROM pagamento JOIN itempagamento USING(pagamento_cod) JOIN itempedido USING(itempedido_cod) JOIN produto USING(produto_cod) JOIN produtor USING(produtor_cod) WHERE produtor_cod = $cod_produtor";
                // altere esses dados ↑↑↑

                // não precisa alterar essa linha ↓↓↓
                $qtdDeLinhas = mysqli_fetch_array(mysqli_query($con, $queryQtdDeLinhas))[0];

                tabela(array(
                "titulo" => "Todos os pagamentos ($e1[num]):",
                "nomeColunas" => array(
                  "Código",
                  "Data",
                  "Valor do pagamento",
                  "",
                ),

                "templateColunas" => array(
                  function($exibe){return $exibe["pagamento_cod"];},
                  function($exibe){return formatData($exibe["pagamento_data"]);},
                  function($exibe){return formatPreco("$exibe[precoItem]");},
									function($exibe){
										return "<button class='px-3 py-1 text-sm font-medium leading-5 text-white transition-colors duration-150 bg-verdecoopaf-600 border border-transparent rounded-md active:bg-verdecoopaf-600 hover:bg-verdecoopaf-700 focus:outline-none focus:shadow-outline-verdecoopaf' onclick=\"window.location.href='./pagamento_detalhes.php?cod=$exibe[pagamento_cod]'\"> Ver detalhes </button>";
									},
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
