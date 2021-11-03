<?php
    include("global.php");
    include("tabletemplate.php");
    include("./backend/conexao.php");

    if(!empty($_POST)) // se tiver post, entra no if para cadastrar dados do produtor
    {
        $query = mysqli_query($con, "INSERT INTO produto (produto_nome, produto_descricao, produto_quantidadeemestoque, produto_preco, produto_tipocontagem, produtor_cod) VALUES ('$_POST[produto_nome]', '$_POST[produto_descricao]', $_POST[produto_quantidadeemestoque], $_POST[produto_preco], '$_POST[produto_tipocontagem]', $_POST[produtor_cod])");

        // var_dump("INSERT INTO produto (produto_nome, produto_descricao, produto_quantidadeemestoque, produto_preco, produto_tipocontagem, produtor_cod) VALUES ('$_POST[produto_nome]', '$_POST[produto_descricao]', $_POST[produto_quantidadeemestoque], $_POST[produto_preco], '$_POST[produto_tipocontagem]', $_POST[produtor_cod])",$query);
        header("location: ./produtos.php");
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
    <div class="flex h-screen bg-gray-50 dark:bg-gray-900" :class="{ 'overflow-hidden': isSideMenuOpen}">
    <?php
        include("./sidebar.php");
    ?>
        <div class="flex flex-col flex-1">
            
        <?php include("header.php") ?>
            <main class="h-full pb-16 overflow-y-auto">
                <div class="container px-6 mx-auto grid">
                    <h2 class="my-6 text-2xl font-semibold text-gray-700 dark:text-gray-200"> Adicionar Produto</h2>
                    <form role="form" action="./produtos_adicionar.php" method="post">
                    <label class="mb-4 block text-sm">
                        <span class="text-gray-700 dark:text-gray-400">Nome:</span>
                        <input class="block w-full mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-verdecoopaf-400 focus:outline-none focus:shadow-outline-verdecoopaf dark:text-gray-300 dark:focus:shadow-outline-gray form-input" name="produto_nome">
                    </label>
                    <label class="mb-4 block text-sm">
                        <span class="text-gray-700 dark:text-gray-400">Descrição:</span>
                        <textarea class="block w-full mt-1 text-sm dark:text-gray-300 dark:border-gray-600 dark:bg-gray-700 form-textarea focus:border-verdecoopaf-400 focus:outline-none focus:shadow-outline-verdecoopaf dark:focus:shadow-outline-gray" rows="3" name="produto_descricao"></textarea>
                        </label>
                    <label class="mb-4 block text-sm">
                        <span class="text-gray-700 dark:text-gray-400">Quantidade em estoque:</span>
                        <input type="number" class="block w-full mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-verdecoopaf-400 focus:outline-none focus:shadow-outline-verdecoopaf dark:text-gray-300 dark:focus:shadow-outline-gray form-input" name="produto_quantidadeemestoque">
                    </label>
                    <label class="mb-4 block text-sm">
                        <span class="text-gray-700 dark:text-gray-400">Preço:</span>
                        <input type="number" step="0.01" class="block w-full mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-verdecoopaf-400 focus:outline-none focus:shadow-outline-verdecoopaf dark:text-gray-300 dark:focus:shadow-outline-gray form-input" name="produto_preco">
                    </label>
                    <label class="mb-4 block text-sm">
                        <span class="text-gray-700 dark:text-gray-400">Tipo de contagem:</span>
                        <select class="block w-full mt-1 text-sm dark:text-gray-300 dark:border-gray-600 dark:bg-gray-700 form-select focus:border-verdecoopaf-400 focus:outline-none focus:shadow-outline-verdecoopaf dark:focus:shadow-outline-gray" name="produto_tipocontagem">
                            <option value="Penca">Penca</option>
                            <option value="Bandeja">Bandeja</option>
                            <option value="Unidades">Unidades</option>
                            <option value="Kg">Kg</option>
                            <option value="Pés">Pés</option>
                        </select>
                        </label>
                    <label class="mb-4 block text-sm">
                        <span class="text-gray-700 dark:text-gray-400">Produtor:</span>
                        <select class="block w-full mt-1 text-sm dark:text-gray-300 dark:border-gray-600 dark:bg-gray-700 form-select focus:border-verdecoopaf-400 focus:outline-none focus:shadow-outline-verdecoopaf dark:focus:shadow-outline-gray" name="produtor_cod">
                            <?php
                            
                            $q2 = mysqli_query($con, "SELECT produtor_cod, produtor_nome FROM produtor");
                            while($e2 = mysqli_fetch_array($q2))
                            {
                                echo "<option value='$e2[produtor_cod]'>$e2[produtor_cod]: $e2[produtor_nome]</option>";
                            }

                            ?>
                        </select>
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
