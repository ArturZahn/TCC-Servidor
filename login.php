<?php 
$verificarLogin = false;
include("global.php"); 
?>
<!DOCTYPE html>
<html :class="{ 'theme-dark': dark }" x-data="data()" lang="pt-BR">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title></title>
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
    <div class="flex items-center min-h-screen p-6 bg-gray-100 dark:bg-gray-900">
      <div
        class="flex-1 h-full max-w-4xl mx-auto overflow-hidden bg-white rounded-lg shadow-xl dark:bg-gray-800"
      >
        <div class="flex flex-col overflow-y-auto md:flex-row">
          <div class="h-32 md:h-auto md:w-1/2">
            <img
              aria-hidden="true"
              class="object-cover w-full h-full dark:hidden p-4"
              src="./assets/img/logo.png"
              alt="Logo CoopAF"
            />
            <img
              aria-hidden="true"
              class="hidden object-cover w-full h-full dark:block p-4"
              src="./assets/img/logo.png"
              alt="Logo CoopAF"
            />
          </div>
          <div class="flex items-center justify-center p-6 sm:p-12 md:w-1/2">
            <div class="w-full">
              <h1 class="mb-4 text-xl font-semibold text-gray-700 dark:text-gray-200">
                Login
              </h1>
              <form action="_login.php" method="post">
                <label class="block text-sm">
                  <span class="text-gray-700 dark:text-gray-400">
                    Usuário
                  </span>
                  <input
                    class="block w-full mt-1 text-sm dark:text-gray-300 dark:bg-gray-700 focus:outline-none form-input <?php if(!empty($_GET["err"])) echo "border-red-600 focus:border-red-400 focus:shadow-outline-red" ?>"
                    name="login"
                  />  
                </label>

                <label class="block text-sm">
                  <span class="text-gray-700 dark:text-gray-400">
                    Senha
                  </span>
                  <input 
                    class="block w-full mt-1 text-sm dark:text-gray-300 dark:bg-gray-700 focus:outline-none form-input <?php if(!empty($_GET["err"])) echo "border-red-600 focus:border-red-400 focus:shadow-outline-red" ?>"
                    name="senha"
                    type="password"
                  />
                  <?php if(!empty($_GET["err"])){ ?>
                  <span class="text-xs text-red-600 dark:text-red-400">
                    <?php echo $_GET["err"] ?>
                  </span>
                  <?php } ?>
                </label>
                <!-- You should use a button here, as the anchor is only used for the example  -->
                <button class="block w-full px-4 py-2 mt-4 text-sm font-medium leading-5 text-center text-white transition-colors duration-150 bg-verdecoopaf-600 border border-transparent rounded-lg active:bg-verdecoopaf-600 hover:bg-verdecoopaf-700 focus:outline-none focus:shadow-outline-verdecoopaf" href="./painel.php">
                  Login
                </button>
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>
  </body>
</html>
