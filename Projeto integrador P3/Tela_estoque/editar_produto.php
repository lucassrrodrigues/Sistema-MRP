<?php
session_start(); // Inicia a sessão

// Verifica se o ID do usuário está presente na sessão
if (!isset($_SESSION['id'])) {
    header("Location: login.php"); // Redireciona para a página de login se o ID do usuário não estiver presente na sessão
    exit();
}

require_once "../conexao.php";

// Verifica se foi enviado um ID de produto válido via GET
if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    header("Location: estoque.php"); // Se o ID não for válido, redireciona de volta para a página de estoque
    exit();
}

$id_produto = $_GET['id'];

// Verifica se o produto pertence ao cliente logado
$id_cliente = $_SESSION['id'];
$sql_verifica_produto = "SELECT * FROM produtos WHERE id = '$id_produto' AND id_cliente = '$id_cliente'";
$result_verifica_produto = mysqli_query($conexao, $sql_verifica_produto);

if (mysqli_num_rows($result_verifica_produto) != 1) {
    header("Location: estoque.php"); // Se o produto não pertencer ao cliente logado, redireciona de volta para a página de estoque
    exit();
}

// Se o formulário for enviado
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Recupera os dados do formulário
    $nome = $_POST['nome'];
    $sku = $_POST['sku'];
    $preco = $_POST['preco'];
    $preco_compra = $_POST['preco_compra']; // Novo campo
    $unidade = $_POST['unidade'];
    $quantidade_estoque = $_POST['quantidade'];

    // Atualiza os dados do produto no banco de dados
    $sql_update = "UPDATE produtos SET nome = '$nome', sku = '$sku', preco = '$preco', preco_compra = '$preco_compra', unidade = '$unidade', quantidade_estoque = '$quantidade_estoque' WHERE id = '$id_produto'";
    if (mysqli_query($conexao, $sql_update)) {
        // Redireciona de volta para a página de estoque
        header("Location: estoque.php");
        exit();
    } else {
        echo "Erro ao atualizar o produto: " . mysqli_error($conexao);
    }
}

// Consulta os detalhes do produto
$sql_detalhes_produto = "SELECT * FROM produtos WHERE id = '$id_produto'";
$result_detalhes_produto = mysqli_query($conexao, $sql_detalhes_produto);
$row_detalhes_produto = mysqli_fetch_assoc($result_detalhes_produto);
?>

<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="estilos_editar_produto.css"> <!-- CSS personalizado para a página de editar produto -->
    <link rel="stylesheet" href="../styleHeader.css">
    <title>Editar Produto</title>
    <style>
        .container {
            padding-bottom: 3%;
        }

        h1 {
            color: #58befa;
            padding: 3%;
        }

        .container img {
            border: 2px solid #58befa;
            /* Adiciona uma borda sólida cinza à imagem */
            padding: 5px;
            /* Adiciona um espaçamento interno à borda */
            border-radius: 10px;
        }
    </style>
</head>

<body>
    <header>
        <img src="../img/logo.png" alt="logo">
        <nav>
            <div class="dropdown">
                <button class="dropbtn">Cadastros</button>
                <div class="dropdown-content">
                    <a class="dropdown-start" href="../Cadastro_Cliente/clientes.html">Cliente e Fornecedor</a>
                </div>
            </div>
            <div class="dropdown">
                <button class="dropbtn">Suprimentos</button>
                <div class="dropdown-content">
                    <a class="dropdown-start" href="../Tela_compra/compra.html">Pedidos de Compra</a>
                    <a class="dropdown-meio" href="../Tela_estoque/estoque.php">Estoque</a>
                    <a class="dropdown-end" href="#">Relatorio</a>
                </div>
            </div>
            <div class="dropdown">
                <button class="dropbtn">Vendas</button>
                <div class="dropdown-content">
                    <a class="dropdown-start" href="../Tela_Venda/Venda.html">Pedidos de Venda</a>
                    <a class="dropdown-meio" href="#">Frente de Caixa</a>
                    <a class="dropdown-end" href="#">Relatorio</a>
                </div>
            </div>
        </nav>
        <div>
            <button><img class="perfil" src="../img/perfil.png" alt="Descrição da Imagem 1"></button>
            <button><img class="perfil" src="../img/sair.png" alt="Descrição da Imagem 2"></button>
        </div>
    </header>
    <h1><strong>Editar Produto</strong></h1>
    <div class="container">
        <form method="post">
            <div class="mb-3">
                <label for="nome" class="form-label"><strong>Nome do Produto</strong></label>
                <input type="text" class="form-control" id="nome" name="nome"
                    value="<?php echo $row_detalhes_produto['nome']; ?>">
            </div>
            <div class="mb-3">
                <label for="sku" class="form-label"><strong>SKU</strong></label>
                <input type="text" class="form-control" id="sku" name="sku"
                    value="<?php echo $row_detalhes_produto['sku']; ?>">
            </div>
            <div class="mb-3">
                <label for="unidade" class="form-label"><strong>Unidade</strong></label>
                <input type="text" class="form-control" id="unidade" name="unidade"
                    value="<?php echo $row_detalhes_produto['unidade']; ?>">
            </div>
            <div class="mb-3">
                <label for="quantidade" class="form-label"><strong>Quantidade em Estoque</strong></label>
                <input type="number" class="form-control" id="quantidade" name="quantidade"
                    value="<?php echo $row_detalhes_produto['quantidade_estoque']; ?>">
            </div>
            <div class="mb-3">
                <label for="preco" class="form-label"><strong>Preço de Venda</strong></label>
                <input type="text" class="form-control" id="preco" name="preco"
                    value="<?php echo $row_detalhes_produto['preco']; ?>">
            </div>
            <div class="mb-3">
                <label for="preco_compra" class="form-label"><strong>Preço de Compra</strong></label>
                <input type="text" class="form-control" id="preco_compra" name="preco_compra"
                    value="<?php echo $row_detalhes_produto['preco_compra']; ?>">
            </div>
            <div class="row">
                <div class="mb-3">
                    <label for="imagem" class="form-label"><strong>Imagem do Produto</strong></label>
                </div>
            </div>
            <div class="row">
                <div class="mb-3">
                    <img src="<?php echo $row_detalhes_produto['imagem']; ?>" alt="Imagem do Produto" class="img-fluid">
                </div>
            </div>
            <button type="submit" class="btn btn-primary">Salvar</button>
        </form>

        <form method="post" action="apagar_produto.php" class="mt-3">
            <input type="hidden" name="id" value="<?php echo $id_produto; ?>">
            <button type="submit" class="btn btn-danger">Apagar</button>
        </form>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
        crossorigin="anonymous"></script>
</body>

</html>
