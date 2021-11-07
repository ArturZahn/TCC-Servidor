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
    <title>Pagar produtor - CoopAF</title>
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
              Pagar produtor
            </h2>
            <?php
                // DADOS GERAIS
                $cod_produtor = $_GET["cod"];

                $q1 = mysqli_query($con, "SELECT produtor_cod, produtor_nome, case when _valordevendo IS NULL then 0 ELSE _valordevendo END AS valordevendo FROM produtor LEFT JOIN (SELECT produtor_cod, SUM(itempedido_precounitariopago*itempedido_quantidade*(1-pedido_taxa)) AS _valordevendo FROM itempedido LEFT JOIN itempagamento USING(itempedido_cod) JOIN pedido USING(pedido_cod) JOIN produto USING(produto_cod) JOIN produtor USING(produtor_cod) WHERE pagamento_cod IS NULL GROUP BY produtor_cod) tabelaA USING(produtor_cod) WHERE produtor_cod = $cod_produtor");
                $e1 = mysqli_fetch_array($q1);
                
                echo "<span class=' mb-4 text-gray-700 dark:text-gray-400'>Produtor: $e1[produtor_nome]</span>";
                
                // se o $_GET["p"] não esta vazio, coloca ele na variavel, se nao, define numero da pagina como 1
                $numDaPag = !empty($_GET["p"])?intval($_GET["p"]):1;
                // altere esses dados ↓↓↓
                $itensPorPag = 15;
                $queryDados       = "SELECT produto_nome, SUM(itempedido_quantidade) AS itemquantidade, SUM(itempedido_quantidade*itempedido_precounitariopago*(1-pedido_taxa)) AS itemvalor FROM itempedido JOIN pedido USING(pedido_cod) LEFT JOIN itempagamento USING(itempedido_cod) JOIN produto USING(produto_cod) WHERE pagamento_cod IS NULL AND produtor_cod = $cod_produtor GROUP BY produto_cod LIMIT $itensPorPag OFFSET ".($numDaPag-1)*$itensPorPag;
                $queryQtdDeLinhas = "SELECT COUNT(distinct produto_cod) FROM itempedido LEFT JOIN itempagamento USING(itempedido_cod) JOIN produto USING(produto_cod) WHERE pagamento_cod IS NULL AND produtor_cod = $cod_produtor";
                // altere esses dados ↑↑↑

                // não precisa alterar essa linha ↓↓↓
                $qtdDeLinhas = mysqli_fetch_array(mysqli_query($con, $queryQtdDeLinhas))[0];
                
                tabela(array(
                  "titulo" => "Produtos à serem pagos:",
                  "nomeColunas" => array(
                    "Produto",
                    "Quantidade",
                    "Valor",
                  ),
                  
                  "templateColunas" => array(
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

              <div class="flex items-center mt-4">
                <span class='mb-4 text-gray-700 dark:text-gray-200 mr-4'>Valor total: <?php echo formatPreco($e1["valordevendo"]); ?></span>
                <div style="flex-grow: 1"></div>
                <div>
                  
                  <button @click="openModal" class="px-4 py-2 text-sm font-medium leading-5 text-white transition-colors duration-150 bg-verdecoopaf-600 border border-transparent rounded-lg active:bg-verdecoopaf-600 hover:bg-verdecoopaf-700 focus:outline-none focus:shadow-outline-verdecoopaf">
                    Pagar
                  </button>
                </div>
              </div>
          </div>
        </main>
      </div>
    </div>

    <div
      x-show="isModalOpen"
      x-transition:enter="transition ease-out duration-150"
      x-transition:enter-start="opacity-0"
      x-transition:enter-end="opacity-100"
      x-transition:leave="transition ease-in duration-150"
      x-transition:leave-start="opacity-100"
      x-transition:leave-end="opacity-0"
      class="fixed inset-0 z-30 flex items-end bg-black bg-opacity-50 sm:items-center sm:justify-center"
    >
      <!-- Modal -->
      <div
        x-show="isModalOpen"
        x-transition:enter="transition ease-out duration-150"
        x-transition:enter-start="opacity-0 transform translate-y-1/2"
        x-transition:enter-end="opacity-100"
        x-transition:leave="transition ease-in duration-150"
        x-transition:leave-start="opacity-100"
        x-transition:leave-end="opacity-0  transform translate-y-1/2"
        @click.away="closeModal"
        @keydown.escape="closeModal"
        class="w-full px-6 py-4 overflow-hidden bg-white rounded-t-lg dark:bg-gray-800 sm:rounded-lg sm:m-4 sm:max-w-xl"
        role="dialog"
        id="modal"
      >
        
        <!-- Modal body -->
        <div class="mt-4 mb-6">
          <!-- Modal title -->
          <p
            class="mb-2 text-lg font-semibold text-gray-700 dark:text-gray-300"
          >
            Atenção
          </p>
          <!-- Modal description -->
          <p class="text-sm text-gray-700 dark:text-gray-400">
            Tem certeza que deseja pagar o valor de <?php echo formatPreco($e1["valordevendo"]) ?> ao produtor(a) <?php echo $e1["produtor_nome"] ?>?
          </p>
        </div>
        <footer
          class="flex flex-col items-center justify-end px-6 py-3 -mx-6 -mb-4 space-y-4 sm:space-y-0 sm:space-x-6 sm:flex-row bg-gray-50 dark:bg-gray-800"
        >
          <button
            @click="closeModal"
            class="w-full px-5 py-3 text-sm font-medium leading-5 text-white text-gray-700 transition-colors duration-150 border border-gray-300 rounded-lg dark:text-gray-400 sm:px-4 sm:py-2 sm:w-auto active:bg-transparent hover:border-gray-500 focus:border-gray-500 active:text-gray-500 focus:outline-none focus:shadow-outline-gray"
          >
            Cancelar
          </button>
          <a href="./pagamento_pagar_produtor.php?cod=<?php echo $cod_produtor ?>">
            <button class="w-full px-5 py-3 text-sm font-medium leading-5 text-white transition-colors duration-150 bg-verdecoopaf-600 border border-transparent rounded-lg sm:w-auto sm:px-4 sm:py-2 active:bg-verdecoopaf-600 hover:bg-verdecoopaf-700 focus:outline-none focus:shadow-outline-verdecoopaf">
              Sim
            </button>
          </a>
        </footer>
      </div>
    </div>
    <!-- End of modal backdrop -->
  </body>
</html>
