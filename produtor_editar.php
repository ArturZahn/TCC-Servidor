<?php
include("global.php");
include("tabletemplate.php");
include("./backend/conexao.php");

if(!empty($_POST)) // se tiver post, entra no if para editar dados do produtor
{

  $query = mysqli_query($con, "UPDATE produtor SET produtor_nome='$_POST[produtor_nome]', produtor_email='$_POST[produtor_email]', produtor_telefone='$_POST[produtor_telefone]', produtor_cpfcnpj='$_POST[produtor_cpfcnpj]' WHERE produtor_cod = '$_POST[cod]';");
  header("location: ./produtor.php");
  die(); // para de executar antes de rodar o resto do arquivo
}


if(empty($_GET["cod"]))
{
  echo "Erro, produtor não informado.";
  die();
}

$produtor_cod = $_GET["cod"];

$query = mysqli_query($con, "SELECT produtor_nome, produtor_email, produtor_telefone, produtor_cpfcnpj FROM produtor WHERE produtor_cod = $_GET[cod]");

if($query === false)
{
  echo "Erro, não foi possível encontrar produtor especificado.";
  die();
}

$e = mysqli_fetch_array($query);

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
          <!-- Remove everything INSIDE this div to a really blank page -->
          <div class="container px-6 mx-auto grid">
            <h2 class="my-6 text-2xl font-semibold text-gray-700 dark:text-gray-200"> Editar Produtor</h2>
            <form role="form" action="./produtor_editar.php" method="post">
            <input class="hidden" name="cod" value="<?php echo $produtor_cod ?>">
              <label class="block text-sm">
                  <span class="text-gray-700 dark:text-gray-400">Nome</span>
                  <input class="block w-full mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-verdecoopaf-400 focus:outline-none focus:shadow-outline-verdecoopaf dark:text-gray-300 dark:focus:shadow-outline-gray form-input" name="produtor_nome" value="<?php echo $e['produtor_nome'] ?>" placeholder="<?php echo $e['produtor_nome'] ?>">
              </label>
              <br>
              <label class="block text-sm">
                  <span class="text-gray-700 dark:text-gray-400">Email</span>
                  <input class="block w-full mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-verdecoopaf-400 focus:outline-none focus:shadow-outline-verdecoopaf dark:text-gray-300 dark:focus:shadow-outline-gray form-input" name="produtor_email" value="<?php echo $e['produtor_email'] ?>" placeholder="<?php echo $e['produtor_email'] ?>">
              </label>
              <br>
              <label class="block text-sm">
                  <span class="text-gray-700 dark:text-gray-400">Telefone</span>
                  <input class="block w-full mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-verdecoopaf-400 focus:outline-none focus:shadow-outline-verdecoopaf dark:text-gray-300 dark:focus:shadow-outline-gray form-input" name="produtor_telefone" value="<?php echo $e['produtor_telefone'] ?>" placeholder="<?php echo $e['produtor_telefone'] ?>">
              </label>
              <br>
              <label class="block text-sm">
                  <span class="text-gray-700 dark:text-gray-400">Cpf/Cnpj</span>
                  <input class="block w-full mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-verdecoopaf-400 focus:outline-none focus:shadow-outline-verdecoopaf dark:text-gray-300 dark:focus:shadow-outline-gray form-input" name="produtor_cpfcnpj" value="<?php echo $e['produtor_cpfcnpj'] ?>" placeholder="<?php echo $e['produtor_cpfcnpj'] ?>">
              </label>
              <br>
              <!-- <label class="block text-sm">
                  <span class="text-gray-700 dark:text-gray-400">Senha</span>
                  <input class="block w-full mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-verdecoopaf-400 focus:outline-none focus:shadow-outline-verdecoopaf dark:text-gray-300 dark:focus:shadow-outline-gray form-input" name="produtor_senha" value = ''>
              </label>
              <br> -->
              <button class="px-5 py-3 font-medium leading-5 text-white transition-colors duration-150 bg-verdecoopaf-600 border border-transparent rounded-lg active:bg-verdecoopaf-600 hover:bg-verdecoopaf-700 focus:outline-none focus:shadow-outline-verdecoopaf" type="submit">
                    Editar
              </button>
            </form>
          </div>
        </main>
      </div>
    </div>
  </body>
</html>
