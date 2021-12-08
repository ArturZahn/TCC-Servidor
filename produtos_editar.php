<?php
    include("global.php");
    include("tabletemplate.php");
    include_once ("./backend/conexao.php");

    if(!empty($_POST)) // Se tiver post, entra no if para editar dados do produto
    {
        // var_dump($_POST);
        // echo "<br><br>";
        $query = mysqli_query($con, "UPDATE produto SET produto_nome = '$_POST[produto_nome]', produto_descricao = '$_POST[produto_descricao]', produto_quantidadeemestoque = $_POST[produto_quantidadeemestoque], produto_precoantigo = $_POST[produto_precoantigo], produto_tipocontagem ='$_POST[produto_tipocontagem]' WHERE produto_cod = $_POST[cod];");
        cadastrarImgProduto($_POST["cod"], "produto_foto");

        header("location: ./produtos.php");
        die(); // Para de executar antes de rodar o resto do arquivo
    }

    if(empty($_GET["cod"]))
    {
        echo "Erro, produto não informado.";
        die();
    }

    $produto_cod = $_GET["cod"];

    $query = mysqli_query($con, "SELECT produto_nome, produto_descricao, produto_quantidadeemestoque, produto_precoantigo, produto_tipocontagem, produtor_nome FROM produto JOIN produtor USING(produtor_cod) WHERE produto_cod = $produto_cod");

    if($query === false)
    {
        echo "Erro, não foi possível encontrar produto especificado.";
        die();
    }

    $e = mysqli_fetch_array($query);
?>

<!DOCTYPE html>
<html :class="{ 'theme-dark': dark }" x-data="data()" lang="pt-BR">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />

    <title>Produtos - CoopAF</title>

    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap"/>
    <link rel="stylesheet" href="./assets/css/tailwind.output.css" /><link rel="stylesheet" href="./assets/css/corescustomizadas.css" />
    <link rel="stylesheet" href="./assets/css/fontawesome/css/all.css">

    <script src="https://cdn.jsdelivr.net/gh/alpinejs/alpine@v2.x.x/dist/alpine.min.js" defer></script>
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

                    <h2 class="my-6 text-2xl font-semibold text-gray-700 dark:text-gray-200"> Editar Produto</h2>

                    <form role="form" action="produtos_editar.php" method="post" enctype="multipart/form-data">
                        
                        <label class="mb-4 block text-sm">
                            <span class="text-gray-700 dark:text-gray-400">Código:</span>
                            <input class="block w-full mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 dark:text-gray-300 form-input opacity-50 cursor-not-allowed" name="cod" value="<?php echo $produto_cod ?>">
                        </label>
                        <label class="mb-4 block text-sm">
                            <span class="text-gray-700 dark:text-gray-400">Foto:</span>
                            <input class="block w-full mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-verdecoopaf-400 focus:outline-none focus:shadow-outline-verdecoopaf dark:text-gray-300 dark:focus:shadow-outline-gray form-input" name="produto_foto" type="file" accept="image/png, image/jpeg">
                        </label>
                        <label class="mb-4 block text-sm">
                            <span class="text-gray-700 dark:text-gray-400">Produtor:</span>
                            <input disabled class="block w-full mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-verdecoopaf-400 focus:outline-none focus:shadow-outline-verdecoopaf dark:text-gray-300 dark:focus:shadow-outline-gray form-input opacity-50 cursor-not-allowed" value="<?php echo $e['produtor_nome'] ?>">
                        </label>
                        <label class="mb-4 block text-sm">
                            <span class="text-gray-700 dark:text-gray-400">Nome:</span>
                            <input class="block w-full mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-verdecoopaf-400 focus:outline-none focus:shadow-outline-verdecoopaf dark:text-gray-300 dark:focus:shadow-outline-gray form-input" name="produto_nome" value="<?php echo $e['produto_nome'] ?>">
                        </label>
                        <label class="mb-4 block mt-4 text-sm">
                            <span class="text-gray-700 dark:text-gray-400">Descrição:</span>
                            <textarea class="block w-full mt-1 text-sm dark:text-gray-300 dark:border-gray-600 dark:bg-gray-700 form-textarea focus:border-verdecoopaf-400 focus:outline-none focus:shadow-outline-verdecoopaf dark:focus:shadow-outline-gray" rows="3" name="produto_descricao"><?php echo $e['produto_descricao'] ?></textarea>
                        </label>
                        
                        <label class="mb-4 block text-sm">
                            <span class="text-gray-700 dark:text-gray-400">Quantidade em estoque:</span>
                            <input class="block w-full mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-verdecoopaf-400 focus:outline-none focus:shadow-outline-verdecoopaf dark:text-gray-300 dark:focus:shadow-outline-gray form-input" name="produto_quantidadeemestoque" type="number" value="<?php echo $e['produto_quantidadeemestoque'] ?>">
                        </label>

                        <label class="mb-4 block text-sm">
                            <span class="text-gray-700 dark:text-gray-400">Preço:</span>
                            <input class="block w-full mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-verdecoopaf-400 focus:outline-none focus:shadow-outline-verdecoopaf dark:text-gray-300 dark:focus:shadow-outline-gray form-input" name="produto_precoantigo" type="number" step="0.01" value="<?php echo $e['produto_precoantigo'] ?>">
                        </label>

                        <label class="mb-4 block mt-4 text-sm">
                            <span class="text-gray-700 dark:text-gray-400">Tipo de contagem:</span>
                            <select class="block w-full mt-1 text-sm dark:text-gray-300 dark:border-gray-600 dark:bg-gray-700 form-select focus:border-verdecoopaf-400 focus:outline-none focus:shadow-outline-verdecoopaf dark:focus:shadow-outline-gray" name="produto_tipocontagem">

                                <option <?php if($e["produto_tipocontagem"] == "Penca") echo "selected"; ?> value="Penca">Penca</option>
                                <option <?php if($e["produto_tipocontagem"] == "Bandeja") echo "selected"; ?> value="Bandeja">Bandeja</option>
                                <option <?php if($e["produto_tipocontagem"] == "Unidades") echo "selected"; ?> value="Unidades">Unidades</option>
                                <option <?php if($e["produto_tipocontagem"] == "Kg") echo "selected"; ?> value="Kg">Kg</option>
                                <option <?php if($e["produto_tipocontagem"] == "Pés") echo "selected"; ?> value="Pés">Pés</option>
                            </select>
                        </label>
                        
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
