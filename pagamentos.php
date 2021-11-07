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
        <title>Pagamentos - CoopAF</title>
        <link
            href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap"
            rel="stylesheet"
        />
        
        <link rel="stylesheet" href="./assets/css/fontawesome/css/all.css">

        
        <link rel="stylesheet" href="./assets/css/tailwind.output.css" /><link rel="stylesheet" href="./assets/css/corescustomizadas.css" />
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
                        <h2 class="my-6 text-2xl font-semibold text-gray-700 dark:text-gray-200"> Detalhes do pagamento </h2>
                        <?php

                            // se o $_GET["p"] não esta vazio, coloca ele na variavel, se nao, define numero da pagina como 1
                            $numDaPag = !empty($_GET["p"])?intval($_GET["p"]):1;


                            // altere esses dados ↓↓↓
                            $itensPorPag = 15;
                            $queryDados       = "SELECT produtor_cod, produtor_nome, case when _valordevendo IS NULL then 0 ELSE _valordevendo END AS valordevendo FROM produtor LEFT JOIN (SELECT produtor_cod, SUM(itempedido_precounitariopago*itempedido_quantidade*(1-pedido_taxa)) AS _valordevendo FROM itempedido JOIN pedido USING(pedido_cod) LEFT JOIN itempagamento USING(itempedido_cod) JOIN produto USING(produto_cod) JOIN produtor USING(produtor_cod) WHERE pagamento_cod IS NULL GROUP BY produtor_cod) tbA USING(produtor_cod) ORDER BY valordevendo DESC LIMIT $itensPorPag OFFSET ".($numDaPag-1)*$itensPorPag;
                            $queryQtdDeLinhas = "SELECT count(produtor_cod) FROM produtor";
                            // altere esses dados ↑↑↑

                            // não precisa alterar essa linha ↓↓↓
                            $qtdDeLinhas = mysqli_fetch_array(mysqli_query($con, $queryQtdDeLinhas))[0];

                            tabela(array(
                                "titulo" => "",
                                "nomeColunas" => array(
                                    "Código",
                                    "Produtor",
                                    "Valor devendo",
                                    "", // "Ver mais"
                                    "" // "Ver mais"
                                ),

                                "templateColunas" => array(
                                    function($exibe){return "$exibe[produtor_cod]";},
                                    function($exibe){return "$exibe[produtor_nome]";},
                                    function($exibe){

                                        if ($exibe['valordevendo'] == 0){
                                            $classes = "text-green-700 bg-green-100 dark:bg-green-700 dark:text-green-100";
                                            $txt = "Nada";
                                        } else {
                                            $classes = "text-red-700 bg-red-100 dark:text-red-100 dark:bg-red-700";
                                            $txt = formatPreco($exibe["valordevendo"]);
                                        }

                                        return "<span class='px-2 py-1 font-semibold leading-tight rounded-full $classes'> $txt </span>";
                                    },
									function($exibe){
										return "<button class='px-3 py-1 text-sm font-medium leading-5 text-white transition-colors duration-150 bg-verdecoopaf-600 border border-transparent rounded-md active:bg-verdecoopaf-600 hover:bg-verdecoopaf-700 focus:outline-none focus:shadow-outline-verdecoopaf' onclick=\"window.location.href='./pagamento_pagar.php?cod=$exibe[produtor_cod]'\"> Pagar </button>";
									},
									function($exibe){
										return "<button class='px-3 py-1 text-sm font-medium leading-5 text-white transition-colors duration-150 bg-verdecoopaf-600 border border-transparent rounded-md active:bg-verdecoopaf-600 hover:bg-verdecoopaf-700 focus:outline-none focus:shadow-outline-verdecoopaf' onclick=window.location.href='./pagamentos_do_produtor.php?cod=$exibe[produtor_cod]'> Ver pagamentos </button>";
									},
                                    
									),
									"dados" => mysqli_query($con, $queryDados),
                                    "numDaPag" => $numDaPag,
                                    "qtdDeLinhas" => $qtdDeLinhas,
                                    "itensPorPag" => $itensPorPag
                            ))
                        ?>
                    </div>
                </main>
            </div>
        </div>
    </body>
</html>
