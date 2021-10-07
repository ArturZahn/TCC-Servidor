<?php
include("tabletemplate.php");

include("./backend/conexao.php");
?>

<!DOCTYPE html>
<html :class="{ 'theme-dark': dark }" x-data="data()" lang="pt-BR">
  <head>
	<meta charset="UTF-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1.0" />
	<title>Detalhes do pedido - CoopAF</title>
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
		<header class="z-10 py-4 bg-white shadow-md dark:bg-gray-800">
		  <div
			class="container flex items-center justify-between h-full px-6 mx-auto text-verdecoopaf-600 dark:text-verdecoopaf-300"
		  >
			<!-- Mobile hamburger -->
			<button
			  class="p-1 -ml-1 mr-5 rounded-md md:hidden focus:outline-none focus:shadow-outline-verdecoopaf"
			  @click="toggleSideMenu"
			  aria-label="Menu"
			>
			  <svg
				class="w-6 h-6"
				aria-hidden="true"
				fill="currentColor"
				viewBox="0 0 20 20"
			  >
				<path
				  fill-rule="evenodd"
				  d="M3 5a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zM3 10a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zM3 15a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1z"
				  clip-rule="evenodd"
				></path>
			  </svg>
			</button>
			<!-- Search input -->
			<div class="flex justify-center flex-1 lg:mr-32">
			  <div
				class="relative w-full max-w-xl mr-6 focus-within:text-verdecoopaf-500"
			  >
				<div class="absolute inset-y-0 flex items-center pl-2">
				  <svg
					class="w-4 h-4"
					aria-hidden="true"
					fill="currentColor"
					viewBox="0 0 20 20"
				  >
					<path
					  fill-rule="evenodd"
					  d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z"
					  clip-rule="evenodd"
					></path>
				  </svg>
				</div>
				<input
				  class="w-full pl-8 pr-2 text-sm text-gray-700 placeholder-gray-600 bg-gray-100 border-0 rounded-md dark:placeholder-gray-500 dark:focus:shadow-outline-gray dark:focus:placeholder-gray-600 dark:bg-gray-700 dark:text-gray-200 focus:placeholder-gray-500 focus:bg-white focus:border-verdecoopaf-300 focus:outline-none focus:shadow-outline-verdecoopaf form-input"
				  type="text"
				  placeholder="Search for projects"
				  aria-label="Search"
				/>
			  </div>
			</div>
			<?php include("headeroptions.php")?>
		  </div>
		</header>
		<main class="h-full pb-16 overflow-y-auto">
		  <div class="container px-6 mx-auto grid">
			<h2 class="my-6 text-2xl font-semibold text-gray-700 dark:text-gray-200">
			  	Detalhes do pedido 
			</h2>
			<?php

				// DADOS GERAIS DO PEDIDO
				$cod_pedido = $_GET["cod"];

				$q = "SELECT pedido_cod, estadopedido_cod, pedido_datacompra, cliente_nome, estadopedido_estado, SUM(itempedido_quantidade * itempedido_precounitariopago) AS precototal from pedido  JOIN itempedido USING(pedido_cod) JOIN estadopedido USING(estadopedido_cod) JOIN cliente USING(cliente_cod) Where pedido_cod = $cod_pedido";
				$e = mysqli_fetch_array(mysqli_query($con, $q));
				
				echo "<span class='text-gray-700 dark:text-gray-400'>Código: $e[pedido_cod]</span><br>";
				echo "<span class='text-gray-700 dark:text-gray-400'>Cliente: $e[cliente_nome]</span><br>";
				echo "<span class='text-gray-700 dark:text-gray-400'>Data: ". date('d/m/Y', strtotime($e['pedido_datacompra'])) ."</span><br>";
				echo "<span class='text-gray-700 dark:text-gray-400 font-semibold'>Valor total: R$" . number_format($e['precototal'], 2, ',', ' ') . "</span><br>";

				if ($e['estadopedido_cod'] == 1){

					$classes = "text-red-700 dark:text-red-100";
				}

				else if ($e['estadopedido_cod'] == 2){

					$classes = "text-orange-700 dark:text-white";
				}

				else if ($e['estadopedido_cod'] == 3){

					$classes = "text-green-700 dark:text-green-100";
				}

				else if ($e['estadopedido_cod'] == 4){

					$classes = "text-gray-700 dark:text-gray-100";
				}

				echo "<span class='text-gray-700 dark:text-gray-400 $classes'> Status: $e[estadopedido_estado]</span><br>";

				// ========================================================================================================================================
				// DETALHES DO PEDIDO

				// se o $_GET["p"] não esta vazio, coloca ele na variavel, se nao, define numero da pagina como 1
				$numDaPag = !empty($_GET["p"])?intval($_GET["p"]):1;

				// altere esses dados ↓↓↓
				$itensPorPag = 3;
				$queryDados       = "SELECT pedido_cod, estadopedido_cod, pedido_datacompra, cliente_nome, estadopedido_estado, SUM(itempedido_quantidade * itempedido_precounitariopago) AS precototal from pedido  JOIN itempedido USING(pedido_cod) JOIN estadopedido USING(estadopedido_cod) JOIN cliente USING(cliente_cod) Where pedido_cod = $cod_pedido GROUP BY pedido_cod ORDER BY pedido_datacompra DESC  LIMIT $itensPorPag OFFSET ".($numDaPag-1)*$itensPorPag;
				$queryQtdDeLinhas = "SELECT count(pedido_cod) from pedido";
				// altere esses dados ↑↑↑

				// não precisa alterar essa linha ↓↓↓
				$qtdDeLinhas = mysqli_fetch_array(mysqli_query($con, $queryQtdDeLinhas))[0];

				tabela(array(
				"titulo" => "Produtos do pedido",
				"nomeColunas" => array(
					"Código do pedido",
					"Cliente",
					"Valor total",
					"Data",
					"Status",
					"Ver mais"
				),

				"templateColunas" => array(
					function($exibe){return "$exibe[pedido_cod]";},
					function($exibe){return "$exibe[cliente_nome]";},

					// valor total
					function($exibe){
					
					return "R$ " . number_format($exibe['precototal'], 2, ',', ' ');
					},
					function($exibe){return date("d/m/Y", strtotime($exibe["pedido_datacompra"]));},

					// status
					function($exibe){
					
					if ($exibe['estadopedido_cod'] == 1){
						// pendente
						$classes = "text-red-700 bg-red-100 dark:text-red-100 dark:bg-red-700";
					}

					else if ($exibe['estadopedido_cod'] == 2){
						// pronto para entrega
						$classes = "text-orange-700 bg-orange-100 dark:text-white dark:bg-orange-600";
					}

					else if ($exibe['estadopedido_cod'] == 3){
						// entregue
						$classes = "text-green-700 bg-green-100 dark:bg-green-700 dark:text-green-100";
					}

					else if ($exibe['estadopedido_cod'] == 4){
						//cancelado
						$classes = "text-gray-700 bg-gray-100 dark:text-gray-100 dark:bg-gray-700";
					}

					return "<span class='px-2 py-1 font-semibold leading-tight rounded-full $classes'> $exibe[estadopedido_estado] </span>";
					
					},
					function($exibe){
					$cod = $exibe['pedido_cod'];
					return "<button class='px-3 py-1 text-sm font-medium leading-5 text-white transition-colors duration-150 bg-verdecoopaf-600 border border-transparent rounded-md active:bg-verdecoopaf-600 hover:bg-verdecoopaf-700 focus:outline-none focus:shadow-outline-verdecoopaf' onclick=window.location.href='./pedidos_detalhes.php?cod=$cod'> Ver mais </button>";},
				),

				"dados" => mysqli_query($con, $queryDados),
				"numDaPag" => $numDaPag,
				"qtdDeLinhas" => $qtdDeLinhas,
				"itensPorPag" => $itensPorPag,
				));
			?>
		  </div>
		</main>
	  </div>
	</div>
  </body>
</html>
