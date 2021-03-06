<?php

include("global.php");
include("./backend/conexao.php");

if(!empty($_POST))
{
  var_dump($_POST, "@", empty($_POST["taxa"]));

  if(!is_numeric($_POST["taxa"]))
  {
    echo "erro";
    die();
  }

  $taxa = floatval($_POST["taxa"])/100;

  $q = mysqli_query($con, "UPDATE cooperativa SET cooperativa_taxa_vendas = $taxa WHERE cooperativa_cod = 1");

  header("location: ./painel.php");
  die();
}

$q = mysqli_query($con, "SELECT cooperativa_taxa_vendas FROM cooperativa WHERE cooperativa_cod = 1");
$taxa = floatval(mysqli_fetch_array($q)["cooperativa_taxa_vendas"])*100;

?>
<!DOCTYPE html>
<html :class="{ 'theme-dark': dark }" x-data="data()" lang="pt-BR">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Painel - CoopAF</title>

    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet"/>
    <link rel="stylesheet" href="./assets/css/tailwind.output.css" /><link rel="stylesheet" href="./assets/css/corescustomizadas.css" />
    <script src="https://cdn.jsdelivr.net/gh/alpinejs/alpine@v2.x.x/dist/alpine.min.js" defer></script>
    <script src="./assets/js/init-alpine.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.3/Chart.min.css"/>
    <link rel="stylesheet" href="./assets/css/fontawesome/css/all.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.3/Chart.min.js" defer></script>

    
    <!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.5.0/Chart.bundle.js"></script> -->

    <?php
    include("./backend/conexao.php");

    $q = mysqli_query($con, "SELECT valor, CONCAT(UPPER(SUBSTRING(_mesano,1,1)),LOWER(SUBSTRING(_mesano,2))) AS mesano FROM ( SELECT SUM(itempedido_precounitariopago*itempedido_quantidade*pedido_taxa) AS valor, DATE_FORMAT(pedido_datacompra,'%M %Y') AS _mesano FROM itempedido JOIN pedido USING(pedido_cod) GROUP BY EXTRACT(YEAR_MONTH FROM pedido_datacompra) ORDER BY EXTRACT(YEAR_MONTH FROM pedido_datacompra) LIMIT 7 ) AS tabela");
    $lucro_labels = "";
    $lucro_data = "";
    $lucro_formatedData = "";
    while($e = mysqli_fetch_array($q))
    {
      $lucro_labels .= "'$e[mesano]',";
      $lucro_data .= "'$e[valor]',";
      $lucro_formatedData .= "'". formatPreco($e["valor"])  ."',";
    }

    $q = mysqli_query($con, "SELECT qtd, CONCAT(UPPER(SUBSTRING(_mesano,1,1)),LOWER(SUBSTRING(_mesano,2))) AS mesano FROM ( SELECT COUNT(DISTINCT pedido_cod) AS qtd, DATE_FORMAT(pedido_datacompra,'%M %Y') AS _mesano FROM pedido GROUP BY EXTRACT(YEAR_MONTH FROM pedido_datacompra) ORDER BY EXTRACT(YEAR_MONTH FROM pedido_datacompra) LIMIT 7 ) AS tabela");
    $pedidos_labels = "";
    $pedidos_data = "";
    $pedidos_formatedData = "";
    while($e = mysqli_fetch_array($q))
    {
      $pedidos_labels .= "'$e[mesano]',";
      $pedidos_data .= "'$e[qtd]',";
      $pedidos_formatedData .= "'$e[qtd]',";
    }
    ?>

<script>
  var lucro_dadosformatado = [<?php echo $lucro_formatedData ?>];
  var lucro_dadoslabel = [<?php echo $lucro_labels ?>];
  var lucro_dados = [<?php echo $lucro_data ?>];

  var pedidos_dadosformatado = [<?php echo $pedidos_formatedData ?>];
  var pedidos_dadoslabel = [<?php echo $pedidos_labels ?>];
  var pedidos_dados = [<?php echo $pedidos_data ?>];
</script>
<script src="./assets/js/chart-lucro.js"></script>
<script src="./assets/js/chart-pedidos.js"></script>

  </head>
  <body>
    <div
      class="flex h-screen bg-gray-50 dark:bg-gray-900"
      :class="{ 'overflow-hidden': isSideMenuOpen}">

    <?php
    include("./sidebar.php");
    ?>
      <div class="flex flex-col flex-1">
        <?php include("header.php") ?>
        <main class="h-full pb-16 overflow-y-auto">
          <div class="container px-6 mx-auto grid">
            <h2 class="my-6 text-2xl font-semibold text-gray-700 dark:text-gray-200">
              Painel
            </h2>
            <!-- <button @click="openModal" class="px-4 py-2 text-sm font-medium leading-5 text-white transition-colors duration-150 bg-verdecoopaf-600 border border-transparent rounded-lg active:bg-verdecoopaf-600 hover:bg-verdecoopaf-700 focus:outline-none focus:shadow-outline-verdecoopaf">
              Open Modal
            </button> -->
            <!-- CTA -->
            <span class="mb-4 text-gray-700 dark:text-gray-400">Taxa atual de vendas: <?php echo $taxa; ?>%</span>
            <button @click="openModal" class="flex items-center justify-between p-4 mb-8 text-sm font-semibold text-verdecoopaf-100 bg-verdecoopaf-600 rounded-lg shadow-md focus:outline-none focus:shadow-outline-verdecoopaf">
              <div class="flex items-center">
                <i class="fas fa-money-bill-wave-alt mr-2"></i>
                <span>Alterar taxa</span>
              </div>
              <!-- <span>Alterar taxa &RightArrow;</span> -->
            </button>

            <div class="grid gap-6 mb-8 md:grid-cols-2">


              <!-- Grafico lucro -->
              <div class="min-w-0 p-4 bg-white rounded-lg shadow-xs dark:bg-gray-800">
                <h4 class="mb-4 font-semibold text-gray-800 dark:text-gray-300">
                  Lucro mensal
                </h4>
                <canvas id="chartLucro"></canvas>
                <div class="flex justify-center mt-4 space-x-3 text-sm text-gray-600 dark:text-gray-400"></div>
              </div>
              
              <!-- Grafico pedidos -->
              <div class="min-w-0 p-4 bg-white rounded-lg shadow-xs dark:bg-gray-800">
                <h4 class="mb-4 font-semibold text-gray-800 dark:text-gray-300">
                  Quantidade de pedios mensal
                </h4>
                <canvas id="chartPedidos"></canvas>
                <div class="flex justify-center mt-4 space-x-3 text-sm text-gray-600 dark:text-gray-400"></div>
              </div>


            </div>
          </div>
        </main>
      </div>
    </div>

    <!-- Modal backdrop. This what you want to place close to the closing body tag -->
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
      <div x-show="isModalOpen"
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
        id="modal">
        
        <form action="./painel.php" method="post">
          <!-- Remove header if you don't want a close icon. Use modal body to place modal tile. -->
          <header class="flex justify-end">
            <button class="inline-flex items-center justify-center w-6 h-6 text-gray-400 transition-colors duration-150 rounded dark:hover:text-gray-200 hover: hover:text-gray-700" aria-label="close" @click="closeModal">
              <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20" role="img" aria-hidden="true">
                <path d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd" fill-rule="evenodd"></path>
              </svg>
            </button>
          </header>
          <!-- Modal body -->
          <div class="mt-4 mb-6">
            <!-- Modal title -->
            <p class="mb-2 text-lg font-semibold text-gray-700 dark:text-gray-300">
              Alterar taxa de vendas
            </p>
            <!-- Modal description -->
            <!-- <p class="text-sm text-gray-700 dark:text-gray-400">
              Lorem, ipsum dolor sit amet consectetur adipisicing elit. Nostrum et
              eligendi repudiandae voluptatem tempore!
            </p> -->
            <label class="block text-sm">
                <span class="text-gray-700 dark:text-gray-400">Digite o valor em porcentagem</span>
                <input max="100" min="0" value="<?php echo $taxa; ?>" placeholder="<?php echo $taxa; ?>%" type="number" name="taxa" step="0.01" class="block w-full mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-verdecoopaf-400 focus:outline-none focus:shadow-outline-verdecoopaf dark:text-gray-300 dark:focus:shadow-outline-gray form-input">
              </label>
          </div>
          <footer class="flex flex-col items-center justify-end px-6 py-3 -mx-6 -mb-4 space-y-4 sm:space-y-0 sm:space-x-6 sm:flex-row bg-gray-50 dark:bg-gray-800">
            <button @click="closeModal" class="w-full px-5 py-3 text-sm font-medium leading-5 text-white text-gray-700 transition-colors duration-150 border border-gray-300 rounded-lg dark:text-gray-400 sm:px-4 sm:py-2 sm:w-auto active:bg-transparent hover:border-gray-500 focus:border-gray-500 active:text-gray-500 focus:outline-none focus:shadow-outline-gray">
              Cancelar
            </button>
            <button type="submit" class="w-full px-5 py-3 text-sm font-medium leading-5 text-white transition-colors duration-150 bg-verdecoopaf-600 border border-transparent rounded-lg sm:w-auto sm:px-4 sm:py-2 active:bg-verdecoopaf-600 hover:bg-verdecoopaf-700 focus:outline-none focus:shadow-outline-verdecoopaf">
              Confirmar
            </button>
          </footer>
        </form>
      </div>
    </div>
    <!-- End of modal backdrop -->
  </body>
</html>
