<?php
include("global.php");
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
        <?php include("header.php") ?>
		<main class="h-full pb-16 overflow-y-auto">
		  <div class="container px-6 mx-auto grid">
			<h2 class="my-6 text-2xl font-semibold text-gray-700 dark:text-gray-200">
			  	Detalhes do pedido 
			</h2>
			<?php

				// DADOS GERAIS DO PEDIDO
				$cod_pedido = $_GET["cod"];

				$q = "SELECT pedido_cod, estadopedido_cod, pedido_datacompra, cliente_nome, estadopedido_estado, SUM(itempedido_quantidade * itempedido_precounitariopago) AS precototal, pedido.endereco_cod, endereco_cidade, endereco_bairro, endereco_rua, endereco_estado, endereco_numero, endereco_cep FROM pedido JOIN itempedido USING(pedido_cod) JOIN estadopedido USING(estadopedido_cod) JOIN cliente USING(cliente_cod) JOIN endereco ON pedido.endereco_cod = endereco.endereco_cod WHERE pedido_cod = $cod_pedido";
				$e = mysqli_fetch_array(mysqli_query($con, $q));
				
				echo "<span class='mb-4 text-gray-700 dark:text-gray-400'>Código: $e[pedido_cod]</span>";
				echo "<span class='mb-4 text-gray-700 dark:text-gray-400'>Cliente: $e[cliente_nome]</span>";
				echo "<span class='mb-4 text-gray-700 dark:text-gray-400'>Data: ". formatData2($e['pedido_datacompra']) ."</span>";
				echo "<span class='mb-4 text-gray-700 dark:text-gray-400'>Endereço: $e[endereco_rua], $e[endereco_numero] - $e[endereco_bairro], $e[endereco_cidade] - $e[endereco_estado], $e[endereco_cep]</span>";

				if ($e['estadopedido_cod'] == 1){
					// pendente
					$classes = "text-red-700 bg-red-100 dark:text-red-100 dark:bg-red-700";
				}

				else if ($e['estadopedido_cod'] == 2){
					// pronto para entrega
					$classes = "text-orange-700 bg-orange-100 dark:text-white dark:bg-orange-600";
				}

				else if ($e['estadopedido_cod'] == 3){
					// entregue
					$classes = "text-green-700 bg-green-100 dark:bg-green-700 dark:text-green-100";
				}

				else if ($e['estadopedido_cod'] == 4){
					//cancelado
					$classes = "text-gray-700 bg-gray-100 dark:text-gray-100 dark:bg-gray-700";
				}

					         //   "px-2 py-1 font-semibold leading-tight rounded-full"
				echo "<div class='mb-4'><span class='px-3 py-1 font-semibold leading-tight rounded-full font-semibold $classes'> Status: $e[estadopedido_estado]</span></div>";

				
				?>
				
				<form action='editar.php' method='POST'>
					<input type='hidden' name='cod' value='<?php echo $e["pedido_cod"] ?>' />
					<div class="mb-4 relative text-gray-500 focus-within:text-verdecoopaf-600">
						<select type='submit' name='status' class="block w-full pr-20 mt-1 text-sm text-black dark:text-gray-300 dark:border-gray-600 dark:bg-gray-700 focus:border-verdecoopaf-400 focus:outline-none focus:shadow-outline-verdecoopaf dark:focus:shadow-outline-gray form-input">
						<?php 		
							$q2 = mysqli_query($con, "SELECT * FROM estadopedido");
							while($e2 = mysqli_fetch_array($q2))
							{
								$s = ($e2['estadopedido_cod'] == $e['estadopedido_cod']) ? ("selected") : (""); 
								echo "<option $s value='$e2[estadopedido_cod]'>$e2[estadopedido_estado]</option>";
							}
							?>
						</select>
						<button class="absolute inset-y-0 right-0 px-4 text-sm font-medium leading-5 text-white transition-colors duration-150 bg-verdecoopaf-600 border border-transparent rounded-r-md active:bg-verdecoopaf-600 hover:bg-verdecoopaf-700 focus:outline-none focus:shadow-outline-verdecoopaf">
							Salvar
							<div style="margin-left: -1.5rem;" class="absolute inset-y-0 left-0 flex items-center pointer-events-none">
								<i class="fas fa-angle-down dark:text-gray-400 fas fa-angle-down"></i>
							</div>
						</button>
					</div>
						
				</form>
				<?php
				
				echo "<span class='mb-4 text-gray-700 dark:text-gray-400 font-semibold'>Valor do pedido: " . formatPreco($e['precototal']) . "</span>";

				// ========================================================================================================================================

				// se o $_GET["p"] não esta vazio, coloca ele na variavel, se nao, define numero da pagina como 1
				$numDaPag = !empty($_GET["p"])?intval($_GET["p"]):1;

				// altere esses dados ↓↓↓
				$itensPorPag = 15;
				$queryDados       = "SELECT produto_cod, produto_nome, itempedido_precounitariopago, itempedido_quantidade, itempedido_quantidade * itempedido_precounitariopago AS precototal FROM itempedido JOIN produto USING(produto_cod) WHERE pedido_cod = $cod_pedido LIMIT $itensPorPag OFFSET ".($numDaPag-1)*$itensPorPag;
				$queryQtdDeLinhas = "SELECT count(pedido_cod) FROM itempedido WHERE pedido_cod = $cod_pedido";
				// altere esses dados ↑↑↑

				// não precisa alterar essa linha ↓↓↓
				$qtdDeLinhas = mysqli_fetch_array(mysqli_query($con, $queryQtdDeLinhas))[0];

				tabela(array(
				"titulo" => "Produtos do pedido",
				"nomeColunas" => array(
					"Código",
					"Produto",
					"Quantidade",
					"Valor unitário",
					"Valor total"
				),

				"templateColunas" => array(
					function($exibe){return "$exibe[produto_cod]";},
					function($exibe){return "$exibe[produto_nome]";},
					function($exibe){return "$exibe[itempedido_quantidade]";},
					function($exibe){return formatPreco("$exibe[itempedido_precounitariopago]");},
					function($exibe){return formatPreco("$exibe[precototal]");}	
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
