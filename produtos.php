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
    <title>Produtos - CoopAF</title>
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
    <div class="flex h-screen bg-gray-50 dark:bg-gray-900" :class="{ 'overflow-hidden': isSideMenuOpen}">
    <?php
        include("./sidebar.php");
    ?>
        <div class="flex flex-col flex-1">
            
        <?php include("header.php") ?>

            <main class="h-full pb-16 overflow-y-auto">
                <div class="container px-6 mx-auto grid">
                    <h2 class="my-6 text-2xl font-semibold text-gray-700 dark:text-gray-200"> Produtos </h2>

                    <a class="flex items-center justify-between p-4 mb-8 text-sm font-semibold text-verdecoopaf-100 bg-verdecoopaf-600 rounded-lg shadow-md focus:outline-none focus:shadow-outline-verdecoopaf" href="produtos_adicionar.php">
                    <div class="flex items-center">
                    <i class="fas fa-pumpkin w-5 h-4 mr-2"></i>
                        <span>Adicionar novo produto</span>
                    </div>
                    </a>

                    <?php
                        // se o $_GET["p"] não esta vazio, coloca ele na variavel, se nao, define numero da pagina como 1
                        $numDaPag = !empty($_GET["p"])?intval($_GET["p"]):1;

                        // altere esses dados ↓↓↓
                        $itensPorPag = 15;
                        $queryDados       = "SELECT produto_cod, produto_nome, produto_quantidadeemestoque, produto_precoantigo, produto_tipocontagem, produtor_nome from produto join produtor using(produtor_cod) limit $itensPorPag offset ".($numDaPag-1)*$itensPorPag;
                        $queryQtdDeLinhas = "SELECT count(produto_cod) from produto";

                        // não precisa alterar essa linha ↓↓↓
                        $qtdDeLinhas = mysqli_fetch_array(mysqli_query($con, $queryQtdDeLinhas))[0];

                        tabela(array(
                        "titulo" => "Produtos",
                        "nomeColunas" => array(
                            "Código",
                            "Produto",
                            "Produtor",
                            "Quantidade em estoque",
                            "Preço",
                            "Ações"
                        ),
                        "templateColunas" => array(
                            function($exibe){return "<span>$exibe[produto_cod]</span>";},
                            function($exibe){return "<span>$exibe[produto_nome]</span>";},
                            function($exibe){return "<span>$exibe[produtor_nome]</span>";},

                            function($exibe){return "<span>$exibe[produto_quantidadeemestoque] $exibe[produto_tipocontagem]</span>";},

                            function($exibe){
                            return formatPreco($exibe["produto_precoantigo"]);
                            },

                            function($exibe){
                            return "
                            <div class='flex items-center space-x-4 text-sm'>
                                <a href='produtos_editar.php?cod=$exibe[produto_cod]'>
                                <button class='flex items-center justify-between px-2 py-2 text-sm font-medium leading-5 text-verdecoopaf-600 rounded-lg dark:text-gray-400 focus:outline-none focus:shadow-outline-gray' aria-label='Edit'>
                                    <svg class='w-5 h-5' aria-hidden='true' fill='currentColor' viewBox='0 0 20 20'>
                                    <path d='M13.586 3.586a2 2 0 112.828 2.828l-.793.793-2.828-2.828.793-.793zM11.379 5.793L3 14.172V17h2.828l8.38-8.379-2.83-2.828z'></path>
                                    </svg>
                                </button>
                                </a>
                                <a href='produtos_excluir.php?cod=$exibe[produto_cod]'>
                                <button class='flex items-center justify-between px-2 py-2 text-sm font-medium leading-5 text-verdecoopaf-600 rounded-lg dark:text-gray-400 focus:outline-none focus:shadow-outline-gray' aria-label='Delete'>
                                    <svg class='w-5 h-5' aria-hidden='true' fill='currentColor' viewBox='0 0 20 20'>
                                    <path fill-rule='evenodd' d='M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z' clip-rule='evenodd'></path>
                                    </svg>
                                </button>
                                </a>
                            </div>
                            ";},
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
