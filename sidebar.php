<?php

// os icones originais do menu estão no arquivo "icones.html"

$menu = array(
    array(
        "titulo" => "Painel",
        "url" => "painel.php",
        "icone" => '<i class="fas fa-home"></i>'
    ),
    array(
        "titulo" => "Produtor",
        "url" => "produtor.php",
        "icone" => '<i class="fas fa-user-alt"></i>'
    ),
    array(
        "titulo" => "Produtos",
        "url" => "produtos.php",
        "icone" => '<i class="fas fa-apple-crate"></i>'
    ),
    array(
        "titulo" => "Pedidos",
        "url" => "pedidos.php",
        "icone" => '<i class="fas fa-list"></i>'
    ),
    array(
        "titulo" => "Pagamentos",
        "url" => "pagamentos.php",
        "icone" => '<i class="fas fa-money-check-alt"></i>'
    ),
);

$posicaoBarra = strripos($_SERVER['PHP_SELF'], "/");
$url;
if($posicaoBarra == -1) $url = $_SERVER['PHP_SELF'];
else $url = substr($_SERVER['PHP_SELF'], $posicaoBarra+1);


function itemMenuEstaSelecionado($urlItemMenu)
{
    if($urlItemMenu == $GLOBALS["url"]) return true;
    else return false;
}

?>

<!-- Desktop sidebar -->
<aside class="z-20 hidden w-64 overflow-y-auto bg-white bg-verdecoopaf-300 dark:bg-gray-800 md:block flex-shrink-0">
    <!-- @@ -->
    <div class="py-4 xtext-gray-700 text-white dark:text-gray-400">
        <a class="ml-6 text-lg font-bold text-white dark:text-gray-200">
            CoopAF
        </a>
        <ul class="mt-6">

            <?php
                foreach ($menu as $keyItemMenu => $itemMenu)
                {
                    $itemEstaSelecionado = itemMenuEstaSelecionado($itemMenu["url"]);
            ?>

            <li class="relative">

                <?php if($itemEstaSelecionado) { ?>
                    <span class="absolute inset-y-0 left-0 w-1 bg-verdecoopaf-600 rounded-tr-lg rounded-br-lg" aria-hidden="true"></span>
                <?php } ?>
                
                <a class="px-6 py-3 focus:outline-none focus-visible:shadow-outline-gray inline-flex items-center w-full text-sm font-semibold transition-colors duration-150 XXXXX_hover:text-gray-800 dark:hover:text-gray-200 <?php if($itemEstaSelecionado) echo "XXXXX_hover:text-gray-800 dark:text-gray-100"; ?>" href="<?php echo $itemMenu["url"]; ?>">
                    <?php echo $itemMenu["icone"]?>
                    <span class="ml-4"><?php echo $itemMenu["titulo"] ?></span>
                </a>
            </li>

            <?php } ?>
            
            <!-- <li class="relative px-6 py-3">
                <button class="inline-flex items-center justify-between w-full text-sm font-semibold transition-colors duration-150 hover:text-gray-800 dark:hover:text-gray-200" @click="togglePagesMenu" aria-haspopup="true">
                    <span class="inline-flex items-center">
                        <svg class="w-5 h-5" aria-hidden="true" fill="none" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" viewBox="0 0 24 24" stroke="currentColor">
                            <path
                                d="M4 5a1 1 0 011-1h14a1 1 0 011 1v2a1 1 0 01-1 1H5a1 1 0 01-1-1V5zM4 13a1 1 0 011-1h6a1 1 0 011 1v6a1 1 0 01-1 1H5a1 1 0 01-1-1v-6zM16 13a1 1 0 011-1h2a1 1 0 011 1v6a1 1 0 01-1 1h-2a1 1 0 01-1-1v-6z"
                            ></path>
                        </svg>
                        <span class="ml-4">Pages</span>
                    </span>
                    <svg class="w-4 h-4" aria-hidden="true" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                    </svg>
                </button>
                <template x-if="isPagesMenuOpen">
                    <ul
                        x-transition:enter="transition-all ease-in-out duration-300"
                        x-transition:enter-start="opacity-25 max-h-0"
                        x-transition:enter-end="opacity-100 max-h-xl"
                        x-transition:leave="transition-all ease-in-out duration-300"
                        x-transition:leave-start="opacity-100 max-h-xl"
                        x-transition:leave-end="opacity-0 max-h-0"
                        class="p-2 mt-2 space-y-2 overflow-hidden text-sm font-medium text-gray-500 rounded-md shadow-inner bg-gray-50 dark:text-gray-400 dark:bg-gray-900"
                        aria-label="submenu"
                    >
                        <li class="px-2 py-1 transition-colors duration-150 hover:text-gray-800 dark:hover:text-gray-200">
                            <a class="w-full" href="index.php">Login</a>
                        </li>
                        <li class="px-2 py-1 transition-colors duration-150 hover:text-gray-800 dark:hover:text-gray-200">
                            <a class="w-full" href="create-account.php">
                                Create account
                            </a>
                        </li>
                        <li class="px-2 py-1 transition-colors duration-150 hover:text-gray-800 dark:hover:text-gray-200">
                            <a class="w-full" href="forgot-password.php">
                                Forgot password
                            </a>
                        </li>
                        <li class="px-2 py-1 transition-colors duration-150 hover:text-gray-800 dark:hover:text-gray-200">
                            <a class="w-full" href="404.php">404</a>
                        </li>
                        <li class="px-2 py-1 transition-colors duration-150 hover:text-gray-800 dark:hover:text-gray-200">
                            <a class="w-full" href="blank.php">Blank</a>
                        </li>
                    </ul>
                </template>
            </li> -->
        </ul>
        <!-- <div class="px-6 my-6">
            <button
                class="flex items-center justify-between w-full px-4 py-2 text-sm font-medium leading-5 text-white transition-colors duration-150 bg-verdecoopaf-600 border border-transparent rounded-lg active:bg-verdecoopaf-600 hover:bg-verdecoopaf-700 focus:outline-none focus:shadow-outline-verdecoopaf"
            >
                Create account
                <span class="ml-2" aria-hidden="true">+</span>
            </button>
        </div> -->
    </div>
</aside>
<!-- Mobile sidebar -->
<!-- Backdrop -->
<div
    x-show="isSideMenuOpen"
    x-transition:enter="transition ease-in-out duration-150"
    x-transition:enter-start="opacity-0"
    x-transition:enter-end="opacity-100"
    x-transition:leave="transition ease-in-out duration-150"
    x-transition:leave-start="opacity-100"
    x-transition:leave-end="opacity-0"
    class="fixed inset-0 z-10 flex items-end bg-black bg-opacity-50 sm:items-center sm:justify-center"
></div>
<aside
    class="fixed inset-y-0 z-20 flex-shrink-0 w-64 mt-16 overflow-y-auto bg-white dark:bg-gray-800 md:hidden"
    x-show="isSideMenuOpen"
    x-transition:enter="transition ease-in-out duration-150"
    x-transition:enter-start="opacity-0 transform -translate-x-20"
    x-transition:enter-end="opacity-100"
    x-transition:leave="transition ease-in-out duration-150"
    x-transition:leave-start="opacity-100"
    x-transition:leave-end="opacity-0 transform -translate-x-20"
    @click.away="closeSideMenu"
    @keydown.escape="closeSideMenu"
>
    <!-- @@ -->
    <div class="py-4 xtext-gray-700 text-white dark:text-gray-400">
        <a class="ml-6 text-lg font-bold text-gray-800 dark:text-gray-200" href="#">
            Windmill
        </a>
        <ul class="mt-6">
            <?php
                foreach ($menu as $keyItemMenu => $itemMenu)
                {
                    $itemEstaSelecionado = itemMenuEstaSelecionado($itemMenu["url"]);
            ?>

            <li class="relative px-6 py-3">
                <?php if($itemEstaSelecionado){ ?>
                <span class="absolute inset-y-0 left-0 w-1 bg-verdecoopaf-600 rounded-tr-lg rounded-br-lg" aria-hidden="true"></span>
                <?php } ?>
                <a class="inline-flex items-center w-full text-sm font-semibold <?php if($itemEstaSelecionado) echo "text-gray-800 dark:text-gray-100" ?> transition-colors duration-150 hover:text-gray-800 dark:hover:text-gray-200" href="<?php echo $itemMenu["url"]; ?>">
                    <?php echo $itemMenu["icone"]?>
                    <span class="ml-4"><?php echo $itemMenu["titulo"]; ?></span>
                </a>
            </li>

            <?php } ?>

            <!-- <li class="relative px-6 py-3">
                <button class="inline-flex items-center justify-between w-full text-sm font-semibold transition-colors duration-150 hover:text-gray-800 dark:hover:text-gray-200" @click="togglePagesMenu" aria-haspopup="true">
                    <span class="inline-flex items-center">
                        <svg class="w-5 h-5" aria-hidden="true" fill="none" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" viewBox="0 0 24 24" stroke="currentColor">
                            <path
                                d="M4 5a1 1 0 011-1h14a1 1 0 011 1v2a1 1 0 01-1 1H5a1 1 0 01-1-1V5zM4 13a1 1 0 011-1h6a1 1 0 011 1v6a1 1 0 01-1 1H5a1 1 0 01-1-1v-6zM16 13a1 1 0 011-1h2a1 1 0 011 1v6a1 1 0 01-1 1h-2a1 1 0 01-1-1v-6z"
                            ></path>
                        </svg>
                        <span class="ml-4">Pages</span>
                    </span>
                    <svg class="w-4 h-4" aria-hidden="true" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                    </svg>
                </button>
                <template x-if="isPagesMenuOpen">
                    <ul
                        x-transition:enter="transition-all ease-in-out duration-300"
                        x-transition:enter-start="opacity-25 max-h-0"
                        x-transition:enter-end="opacity-100 max-h-xl"
                        x-transition:leave="transition-all ease-in-out duration-300"
                        x-transition:leave-start="opacity-100 max-h-xl"
                        x-transition:leave-end="opacity-0 max-h-0"
                        class="p-2 mt-2 space-y-2 overflow-hidden text-sm font-medium text-gray-500 rounded-md shadow-inner bg-gray-50 dark:text-gray-400 dark:bg-gray-900"
                        aria-label="submenu"
                    >
                        <li class="px-2 py-1 transition-colors duration-150 hover:text-gray-800 dark:hover:text-gray-200">
                            <a class="w-full" href="index.php">Login</a>
                        </li>
                        <li class="px-2 py-1 transition-colors duration-150 hover:text-gray-800 dark:hover:text-gray-200">
                            <a class="w-full" href="create-account.php">
                                Create account
                            </a>
                        </li>
                        <li class="px-2 py-1 transition-colors duration-150 hover:text-gray-800 dark:hover:text-gray-200">
                            <a class="w-full" href="forgot-password.php">
                                Forgot password
                            </a>
                        </li>
                        <li class="px-2 py-1 transition-colors duration-150 hover:text-gray-800 dark:hover:text-gray-200">
                            <a class="w-full" href="404.php">404</a>
                        </li>
                        <li class="px-2 py-1 transition-colors duration-150 hover:text-gray-800 dark:hover:text-gray-200">
                            <a class="w-full" href="blank.php">Blank</a>
                        </li>
                    </ul>
                </template>
            </li> -->
        </ul>
        <!-- <div class="px-6 my-6">
            <button class="flex items-center justify-between px-4 py-2 text-sm font-medium leading-5 text-white transition-colors duration-150 bg-verdecoopaf-600 border border-transparent rounded-lg active:bg-verdecoopaf-600 hover:bg-verdecoopaf-700 focus:outline-none focus:shadow-outline-verdecoopaf">
                Create account
                <span class="ml-2" aria-hidden="true">+</span>
            </button>
        </div> -->
    </div>
</aside>
