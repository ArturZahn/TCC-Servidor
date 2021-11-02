<?php include("global.php"); ?>
<?php
include("tabletemplate.php");

include("./backend/conexao.php");
?>

<!DOCTYPE html>
<html :class="{ 'theme-dark': dark }" x-data="data()" lang="pt-BR">
	<head>
		<meta charset="UTF-8" />
		<meta name="viewport" content="width=device-width, initial-scale=1.0" />
		<title>Pedidos - CoopAF</title>
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
						<h2 class="my-6 text-2xl font-semibold text-gray-700 dark:text-gray-200"> Pedidos </h2>
						
						<?php

								// se o $_GET["p"] não esta vazio, coloca ele na variavel, se nao, define numero da pagina como 1
								$numDaPag = !empty($_GET["p"])?intval($_GET["p"]):1;


								// altere esses dados ↓↓↓
								$itensPorPag = 15;
								$queryDados       = "SELECT pedido_cod, estadopedido_cod, pedido_datacompra, cliente_nome, estadopedido_estado, SUM(itempedido_quantidade * itempedido_precounitariopago) AS precototal  from pedido JOIN itempedido USING(pedido_cod) JOIN estadopedido USING(estadopedido_cod) JOIN cliente USING(cliente_cod) GROUP BY pedido_cod ORDER BY estadopedido_cod ASC, pedido_datacompra DESC LIMIT $itensPorPag OFFSET ".($numDaPag-1)*$itensPorPag;
								$queryQtdDeLinhas = "SELECT count(pedido_cod) from pedido";
								// altere esses dados ↑↑↑


								// não precisa alterar essa linha ↓↓↓
								$qtdDeLinhas = mysqli_fetch_array(mysqli_query($con, $queryQtdDeLinhas))[0];

								tabela(array(
								 	"titulo" => "",
									"nomeColunas" => array(
										"Código",
										"Cliente",
										"Valor total",
										"Data",
										"Status",
										""// "Ver mais"
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
											return "<button class='px-3 py-1 text-sm font-medium leading-5 text-white transition-colors duration-150 bg-verdecoopaf-600 border border-transparent rounded-md active:bg-verdecoopaf-600 hover:bg-verdecoopaf-700 focus:outline-none focus:shadow-outline-verdecoopaf' onclick=window.location.href='./pedidos_detalhes.php?cod=$cod'> Ver mais </button>";
										},
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
