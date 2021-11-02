<?php
include("global.php");
include("tabletemplate.php");
include("./backend/conexao.php");

if(!empty($_POST)) // se tiver post, entra no if para editar dados do produtor
{
  $qt = "UPDATE produtor JOIN endereco USING(endereco_cod) SET produtor_nome='$_POST[produtor_nome]', produtor_email='$_POST[produtor_email]', produtor_telefone='$_POST[produtor_telefone]', produtor_cpfcnpj='$_POST[produtor_cpfcnpj]', endereco_cidade = '$_POST[endereco_cidade]', endereco_bairro = '$_POST[endereco_bairro]', endereco_rua = '$_POST[endereco_rua]', endereco_estado = '$_POST[endereco_estado]', endereco_numero = '$_POST[endereco_numero]', endereco_cep = '$_POST[endereco_cep]', endereco_complemento = '$_POST[endereco_complemento]', endereco_informacoesadicinais = '$_POST[endereco_informacoesadicinais]' WHERE produtor_cod = '$_POST[cod]';";

  $query = mysqli_query($con, $qt);
  // var_dump($qt, $query);
  header("location: ./produtor.php");
  die(); // para de executar antes de rodar o resto do arquivo
}


if(empty($_GET["cod"]))
{
  echo "Erro, produtor não informado.";
  die();
}

$produtor_cod = $_GET["cod"];

$query = mysqli_query($con, "SELECT produtor_nome, produtor_email, produtor_telefone, produtor_cpfcnpj, endereco_cidade, endereco_bairro, endereco_rua, endereco_estado, endereco_numero, endereco_cep, endereco_complemento, endereco_informacoesadicinais FROM produtor JOIN endereco USING(endereco_cod) WHERE produtor_cod = $produtor_cod");

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
        
        <?php include("header.php") ?>
        <main class="h-full pb-16 overflow-y-auto">
          <!-- Remove everything INSIDE this div to a really blank page -->
          <div class="container px-6 mx-auto grid">
            <h2 class="my-6 text-2xl font-semibold text-gray-700 dark:text-gray-200"> Editar Produtor</h2>
            <form role="form" action="./produtor_editar.php" method="post">
              <label class="mb-4 block text-sm">
                  <span class="text-gray-700 dark:text-gray-400">Código:</span>
                  <input class="block w-full mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 dark:text-gray-300 form-input opacity-50 cursor-not-allowed" name="cod" value="<?php echo $produtor_cod ?>">
              </label>
              <label class="mb-4 block text-sm">
                  <span class="text-gray-700 dark:text-gray-400">Nome:</span>
                  <input class="block w-full mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-verdecoopaf-400 focus:outline-none focus:shadow-outline-verdecoopaf dark:text-gray-300 dark:focus:shadow-outline-gray form-input" name="produtor_nome" value="<?php echo $e['produtor_nome'] ?>" placeholder="<?php echo $e['produtor_nome'] ?>">
              </label>
              <label class="mb-4 block text-sm">
                  <span class="text-gray-700 dark:text-gray-400">Email:</span>
                  <input class="block w-full mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-verdecoopaf-400 focus:outline-none focus:shadow-outline-verdecoopaf dark:text-gray-300 dark:focus:shadow-outline-gray form-input" name="produtor_email" value="<?php echo $e['produtor_email'] ?>" placeholder="<?php echo $e['produtor_email'] ?>">
              </label>
              <label class="mb-4 block text-sm">
                  <span class="text-gray-700 dark:text-gray-400">Telefone:</span>
                  <input class="block w-full mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-verdecoopaf-400 focus:outline-none focus:shadow-outline-verdecoopaf dark:text-gray-300 dark:focus:shadow-outline-gray form-input" name="produtor_telefone" value="<?php echo $e['produtor_telefone'] ?>" placeholder="<?php echo $e['produtor_telefone'] ?>">
              </label>
              <label class="mb-4 block text-sm">
                  <span class="text-gray-700 dark:text-gray-400">Cpf/Cnpj:</span>
                  <input class="block w-full mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-verdecoopaf-400 focus:outline-none focus:shadow-outline-verdecoopaf dark:text-gray-300 dark:focus:shadow-outline-gray form-input" name="produtor_cpfcnpj" value="<?php echo $e['produtor_cpfcnpj'] ?>" placeholder="<?php echo $e['produtor_cpfcnpj'] ?>">
              </label>
              <label class="mb-4 block text-sm">
                  <span class="text-gray-700 dark:text-gray-400">Cidade:</span>
                  <input class="block w-full mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-verdecoopaf-400 focus:outline-none focus:shadow-outline-verdecoopaf dark:text-gray-300 dark:focus:shadow-outline-gray form-input" name="endereco_cidade" value="<?php echo $e['endereco_cidade'] ?>" placeholder="<?php echo $e['endereco_cidade'] ?>">
              </label>
              <label class="mb-4 block text-sm">
                  <span class="text-gray-700 dark:text-gray-400">Bairro:</span>
                  <input class="block w-full mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-verdecoopaf-400 focus:outline-none focus:shadow-outline-verdecoopaf dark:text-gray-300 dark:focus:shadow-outline-gray form-input" name="endereco_bairro" value="<?php echo $e['endereco_bairro'] ?>" placeholder="<?php echo $e['endereco_bairro'] ?>">
              </label>
              <label class="mb-4 block text-sm">
                  <span class="text-gray-700 dark:text-gray-400">Rua:</span>
                  <input class="block w-full mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-verdecoopaf-400 focus:outline-none focus:shadow-outline-verdecoopaf dark:text-gray-300 dark:focus:shadow-outline-gray form-input" name="endereco_rua" value="<?php echo $e['endereco_rua'] ?>" placeholder="<?php echo $e['endereco_rua'] ?>">
              </label>
              <label class="mb-4 block text-sm">
                  <span class="text-gray-700 dark:text-gray-400">Estado:</span>
                  <select class="block w-full mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-verdecoopaf-400 focus:outline-none focus:shadow-outline-verdecoopaf dark:text-gray-300 dark:focus:shadow-outline-gray form-input" name="endereco_estado">
                    <option <?php if($e['endereco_estado'] == "AC") echo "selected" ?> value="AC">AC</option>
                    <option <?php if($e['endereco_estado'] == "AL") echo "selected" ?> value="AL">AL</option>
                    <option <?php if($e['endereco_estado'] == "AP") echo "selected" ?> value="AP">AP</option>
                    <option <?php if($e['endereco_estado'] == "AM") echo "selected" ?> value="AM">AM</option>
                    <option <?php if($e['endereco_estado'] == "BA") echo "selected" ?> value="BA">BA</option>
                    <option <?php if($e['endereco_estado'] == "CE") echo "selected" ?> value="CE">CE</option>
                    <option <?php if($e['endereco_estado'] == "ES") echo "selected" ?> value="ES">ES</option>
                    <option <?php if($e['endereco_estado'] == "GO") echo "selected" ?> value="GO">GO</option>
                    <option <?php if($e['endereco_estado'] == "MA") echo "selected" ?> value="MA">MA</option>
                    <option <?php if($e['endereco_estado'] == "MT") echo "selected" ?> value="MT">MT</option>
                    <option <?php if($e['endereco_estado'] == "MS") echo "selected" ?> value="MS">MS</option>
                    <option <?php if($e['endereco_estado'] == "MG") echo "selected" ?> value="MG">MG</option>
                    <option <?php if($e['endereco_estado'] == "PA") echo "selected" ?> value="PA">PA</option>
                    <option <?php if($e['endereco_estado'] == "PB") echo "selected" ?> value="PB">PB</option>
                    <option <?php if($e['endereco_estado'] == "PR") echo "selected" ?> value="PR">PR</option>
                    <option <?php if($e['endereco_estado'] == "PE") echo "selected" ?> value="PE">PE</option>
                    <option <?php if($e['endereco_estado'] == "PI") echo "selected" ?> value="PI">PI</option>
                    <option <?php if($e['endereco_estado'] == "RJ") echo "selected" ?> value="RJ">RJ</option>
                    <option <?php if($e['endereco_estado'] == "RN") echo "selected" ?> value="RN">RN</option>
                    <option <?php if($e['endereco_estado'] == "RS") echo "selected" ?> value="RS">RS</option>
                    <option <?php if($e['endereco_estado'] == "RO") echo "selected" ?> value="RO">RO</option>
                    <option <?php if($e['endereco_estado'] == "RR") echo "selected" ?> value="RR">RR</option>
                    <option <?php if($e['endereco_estado'] == "SC") echo "selected" ?> value="SC">SC</option>
                    <option <?php if($e['endereco_estado'] == "SP") echo "selected" ?> value="SP">SP</option>
                    <option <?php if($e['endereco_estado'] == "SE") echo "selected" ?> value="SE">SE</option>
                    <option <?php if($e['endereco_estado'] == "TO") echo "selected" ?> value="TO">TO</option>
                    <option <?php if($e['endereco_estado'] == "DF") echo "selected" ?> value="DF">DF</option>
                </select>
              </label>
              <label class="mb-4 block text-sm">
                  <span class="text-gray-700 dark:text-gray-400">Número:</span>
                  <input class="block w-full mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-verdecoopaf-400 focus:outline-none focus:shadow-outline-verdecoopaf dark:text-gray-300 dark:focus:shadow-outline-gray form-input" name="endereco_numero" value="<?php echo $e['endereco_numero'] ?>" placeholder="<?php echo $e['endereco_numero'] ?>">
              </label>
              <label class="mb-4 block text-sm">
                  <span class="text-gray-700 dark:text-gray-400">CEP:</span>
                  <input class="block w-full mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-verdecoopaf-400 focus:outline-none focus:shadow-outline-verdecoopaf dark:text-gray-300 dark:focus:shadow-outline-gray form-input" name="endereco_cep" value="<?php echo $e['endereco_cep'] ?>" placeholder="<?php echo $e['endereco_cep'] ?>">
              </label>
              <label class="mb-4 block text-sm">
                  <span class="text-gray-700 dark:text-gray-400">Complemento:</span>
                  <input class="block w-full mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-verdecoopaf-400 focus:outline-none focus:shadow-outline-verdecoopaf dark:text-gray-300 dark:focus:shadow-outline-gray form-input" name="endereco_complemento" value="<?php echo $e['endereco_complemento'] ?>" placeholder="<?php echo $e['endereco_complemento'] ?>">
              </label>
              <label class="mb-4 block text-sm">
                  <span class="text-gray-700 dark:text-gray-400">Informações adicinais:</span>
                  <input class="block w-full mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-verdecoopaf-400 focus:outline-none focus:shadow-outline-verdecoopaf dark:text-gray-300 dark:focus:shadow-outline-gray form-input" name="endereco_informacoesadicinais" value="<?php echo $e['endereco_informacoesadicinais'] ?>" placeholder="<?php echo $e['endereco_informacoesadicinais'] ?>">
              </label>
              
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
