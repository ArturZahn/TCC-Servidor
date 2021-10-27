<?php

function msg($titulo, $txt, $bt, $link)
{

?>
<!DOCTYPE html>
<html :class="{ 'theme-dark': dark }" x-data="data()" lang="pt-BR">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Modals - Windmill Dashboard</title>
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
    <!-- You need focus-trap.js to make the modal accessible -->
    <script src="./assets/js/focus-trap.js" defer></script>
  </head>
  <body>
    <div class="flex h-screen bg-gray-50 dark:bg-gray-900" :class="{ 'overflow-hidden': isSideMenuOpen}" >
        <main class="h-full w-full overflow-y-auto" style="padding-bottom: 5rem">
          <div class="h-full flex justify-center items-center">
            <div class="container grid px-6">
              <div class="mx-auto"> 
                <h2 class="my-6 text-2xl font-semibold text-gray-700 dark:text-gray-200">
                  <?php echo $titulo ?>
                </h2>

                <div class="max-w-2xl px-4 py-3 mb-8 bg-white rounded-lg shadow-md dark:bg-gray-800">
                  <p class="mb-4 text-gray-600 dark:text-gray-400">
                    <?php echo $txt ?>
                  </p>
                </div>

                <div>
                  <button onclick="location='<?php echo $link ?>'" class="px-4 py-2 text-sm font-medium leading-5 text-white transition-colors duration-150 bg-verdecoopaf-600 border border-transparent rounded-lg active:bg-verdecoopaf-600 hover:bg-verdecoopaf-700 focus:outline-none focus:shadow-outline-verdecoopaf">
                  <?php echo $bt ?>
                  </button>
                </div>
              </div>
            </div>
          </div>
        </main> 
      </div>
    </div>
  </body>
</html>

<?php } ?>