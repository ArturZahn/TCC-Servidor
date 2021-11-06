<?php
include("global.php");
include("tabletemplate.php");
include_once ("./backend/conexao.php");

if(!empty($_POST)) // se tiver post, entra no if para cadastrar dados do produtor
{

  $query = mysqli_query($con, "INSERT INTO produtor (produtor_nome, produtor_email, produtor_telefone, produtor_cpfcnpj, produtor_senha) VALUES ('$_POST[produtor_nome]', '$_POST[produtor_email]', '$_POST[produtor_telefone]', '$_POST[produtor_cpfcnpj]', '".md5($_POST["produtor_senha"])."')");
  
  header("location: ./produtor.php");
  die(); // para de executar antes de rodar o resto do arquivo
}
?>

<!DOCTYPE html>
<html :class="{ 'theme-dark': dark }" x-data="data()" lang="pt-BR">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Produtor - CoopAF</title>
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
            <h2 class="my-6 text-2xl font-semibold text-gray-700 dark:text-gray-200"> Adicionar Produtor</h2>
            <form role="form" action="./produtor_adicionar.php" method="post">
              <label class="mb-4 block text-sm">
                  <span class="text-gray-700 dark:text-gray-400">Nome:</span>
                  <input class="block w-full mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-verdecoopaf-400 focus:outline-none focus:shadow-outline-verdecoopaf dark:text-gray-300 dark:focus:shadow-outline-gray form-input" placeholder="" name="produtor_nome">
              </label>
              <label class="mb-4 block text-sm">
                  <span class="text-gray-700 dark:text-gray-400">Email:</span>
                  <input class="block w-full mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-verdecoopaf-400 focus:outline-none focus:shadow-outline-verdecoopaf dark:text-gray-300 dark:focus:shadow-outline-gray form-input" placeholder="" name="produtor_email">
              </label>
              <label class="mb-4 block text-sm">
                  <span class="text-gray-700 dark:text-gray-400">Telefone:</span>
                  <input class="block w-full mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-verdecoopaf-400 focus:outline-none focus:shadow-outline-verdecoopaf dark:text-gray-300 dark:focus:shadow-outline-gray form-input" placeholder="" name="produtor_telefone">
              </label>
              <label class="mb-4 block text-sm">
                  <span class="text-gray-700 dark:text-gray-400">Cpf/Cnpj:</span>
                  <input class="block w-full mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-verdecoopaf-400 focus:outline-none focus:shadow-outline-verdecoopaf dark:text-gray-300 dark:focus:shadow-outline-gray form-input" placeholder="" name="produtor_cpfcnpj">
              </label>
              <label class="mb-4 block text-sm">
                  <span class="text-gray-700 dark:text-gray-400">Senha:</span>
                  <input class="block w-full mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-verdecoopaf-400 focus:outline-none focus:shadow-outline-verdecoopaf dark:text-gray-300 dark:focus:shadow-outline-gray form-input" placeholder="" name="produtor_senha">
              </label>
              <button class="px-5 py-3 font-medium leading-5 text-white transition-colors duration-150 bg-verdecoopaf-600 border border-transparent rounded-lg active:bg-verdecoopaf-600 hover:bg-verdecoopaf-700 focus:outline-none focus:shadow-outline-verdecoopaf" type="submit">
                    Cadastrar
              </button>
            </form>
          </div>
        </main>
      </div>
    </div>
  </body>
</html>
