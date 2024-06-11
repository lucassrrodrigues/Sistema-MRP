<?php
session_start(); // Inicia a sessão

// Verifica se o ID do usuário está presente na sessão
if (!isset($_SESSION['id'])) {
    header("Location: login.php"); // Redireciona para a página de login se o ID do usuário não estiver presente na sessão
    exit();
}

require_once "../conexao.php";

// Recupera o ID do cliente da sessão
$id_cliente = $_SESSION['id'];

// Constrói a consulta SQL base
$sql_produtos = "SELECT * FROM produtos WHERE id_cliente = '$id_cliente'";

// Verifica se foi enviado um filtro
if (isset($_GET['filtro'])) {
    $filtro = $_GET['filtro'];

    // Ajusta a consulta com base no filtro selecionado
    switch ($filtro) {
        case 'maior':
            $sql_produtos .= " AND quantidade_estoque > 0";
            break;
        case 'igual':
            $sql_produtos .= " AND quantidade_estoque = 0";
            break;
        case 'menor':
            $sql_produtos .= " AND quantidade_estoque < 0";
            break;
        // Adicionando a opção "Todos"
        case 'todos':
            // Nenhuma restrição adicional é necessária para mostrar todos os produtos
            break;
        default:
            // Se a opção de filtro for inválida, exibir todos os produtos
            break;
    }
}

// Verifica se foi enviada uma consulta de pesquisa
if (isset($_GET['pesquisa'])) {
    $pesquisa = $_GET['pesquisa'];
    // Adiciona a condição de pesquisa à consulta SQL
    $sql_produtos .= " AND nome LIKE '%$pesquisa%'";
}

// Executa a consulta SQL
$result_produtos = mysqli_query($conexao, $sql_produtos);
?>

<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="estilos_produto.css">
    <link rel="stylesheet" href="../styleHeader.css">
    <title>UpperPro - Estoque</title>
    <link rel="icon" href="../img/logo.png" type="image/png">
    <style>
        #sidebar {
            margin-top: 95px;
            position: fixed;
            top: 0;
            left: -250px;
            width: 250px;
            height: 100vh;
            background-color: #3FB5FA;
            border-radius: 0px 7px;
            transition: left 0.0s ease
        }

        #sidebar.open {
            left: 0;
        }

        #sidebarClose {
            margin-top: 5%;
            margin-left: 55%;
            background-color: #58befa;
            border-radius: 7px;
            border: 0;
            color: #fff;
            height: 40px;
            width: 40%;
            font-size: 16px;

        }

        #sidebarToggle {
            background-image: url('../img/InconFiltro.png');
            background-size: cover;
            width: 40px;
            height: 40px;
            padding: 20px;
            background-color: #3FB5FA;
            border-radius: 7px;
            position: fixed;
            top: 100px;
            z-index: 9999;
            border: 0;
            border-radius: 5px;
            text-decoration: none;
        }

        .btn-cadastrar-produto {
            position: fixed;
            padding: 8px;
            top: 110px;
            right: 10px;
            z-index: 9999;
            background-color: #58befa;
            border: 0;
            border-radius: 5px;
            color: #fff;
            text-decoration: none;
        }

        .title h1 {
            padding: 15px;
            color: #3FB5FA;
        }

        .title {
            text-align: center;
            margin-top: 20px;
            margin-bottom: 20px;
        }

        .table {
            background-color: transparent;
            width: 100%;
            border-collapse: collapse;
        }

        .table tbody tr td {
            padding: 8px;
            text-align: left;
            border-bottom: 2px solid #ccc;
        }

        .table th {
            background-color: transparent;
        }

        .table tbody tr td {
            background-color: #aed3e9;
        }

        .table tbody tr:last-child td {
            border-bottom: none;
        }


        .table tbody tr td:first-child {
            border-top-left-radius: 5px;
            border-bottom-left-radius: 5px;
        }

        .table tbody tr td:last-child {
            border-top-right-radius: 5px;
            border-bottom-right-radius: 5px;
        }


        /* Estilizando o formulário de filtro dentro da barra lateral */
        #sidebar form.filtro {
            padding: 10px;
            margin-right: 10px;
            /* Adicionando margem à direita */
        }

        /* Estilizando o formulário de pesquisa dentro da barra lateral */
        #sidebar form.pesquisa {
            padding: 10px;
        }

        /* Estilizando os botões de filtro e pesquisa dentro da barra lateral */
        #sidebar form button {
            background-color: #4CAF50;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            margin-right: 10px;
        }

        #sidebar form button:hover {
            background-color: #45a049;
        }

        /* Estilizando a entrada de texto de pesquisa dentro da barra lateral */
        #sidebar form input[type="text"] {
            width: 100%;
            padding: 8px;
            border: 1px solid #ccc;
            border-radius: 4px;
            margin-bottom: 10px;
            font-size: 16px;
        }

        #sidebar form select {
            width: 100%;
            padding: 8px;
            border: 1px solid #ccc;
            border-radius: 4px;
            margin-bottom: 10px;
            font-size: 16px;
        }

        .btn-editar {
            color: black;
            padding: 8px 16px;
            border: none;
            border-radius: 4px;
            text-decoration: none;
        }

        .btn-editar:hover {
            background-color: #aed3e9;
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
                    <a class="dropdown-start" href="../Cadastro_Cliente/cliente_fornecedor.php">Cliente e Fornecedor Pessoa Fisica</a>
                </div>
            </div>
            <div class="dropdown">
                <button class="dropbtn">Suprimentos</button>
                <div class="dropdown-content">
                    <a class="dropdown-start" href="../Tela_compra/Tela_compra.php">Pedidos de Compra</a>
                    <a class="dropdown-meio" href="../Tela_estoque/estoque.php">Estoque</a>
                    <a class="dropdown-end" href="#">Relatorio</a>
                </div>
            </div>
            <div class="dropdown">
                <button class="dropbtn">Vendas</button>
                <div class="dropdown-content">
                    <a class="dropdown-start" href="../Tela_Venda/Tela_Venda.php">Pedidos de Venda</a>
                    <a class="dropdown-meio" href="#">Frente de Caixa</a>
                    <a class="dropdown-end" href="#">Relatorio</a>
                </div>
            </div>
        </nav>
        <div>
            <button id="perfilBtn"><img class="perfil" src="../img/perfil.png" alt="Descrição da Imagem 1"></button>
            <button id="logoutBtn"><img class="perfil" src="../img/sair.png" alt="Descrição da Imagem 2"></button>
        </div>
    </header>
    <div class="title">
        <h1><strong>Estoque</strong></h1>
    </div>
    <button id="sidebarToggle"></button>
    <aside id="sidebar">
        <button id="sidebarClose">Fechar</button>
        <form class="filtro" action="estoque.php" method="GET">
            <label for="filtro">Filtrar por quantidade:</label>
            <select name="filtro" id="filtro">
                <option value="todos">Todos</option>
                <option value="maior">Maior que 0</option>
                <option value="igual">Igual a 0</option>
                <option value="menor">Menor que 0</option>
            </select>
            <button type="submit">Filtrar</button>
        </form>
        <form class="filtro" action="estoque.php" method="GET">
            <label for="pesquisa">Pesquisar produto:</label>
            <input type="text" name="pesquisa" id="pesquisa">
            <button type="submit">Pesquisar</button>
        </form>
    </aside>
    <main>
        <a class="btn-cadastrar-produto" href="../Tela_cad_produto/Cadastro_prod.html"><strong>+ Cadastrar
                Produto</strong></a>
        <div class="container">
            <table class="table">
                <thead>
                    <tr>
                        <th>Nome do Produto</th>
                        <th>SKU</th>
                        <th>Unidade</th>
                        <th>Estoque</th>
                        <th>Preço de Venda</th>
                        <th>Preço de Compra</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($row = mysqli_fetch_assoc($result_produtos)): ?>
                        <tr>
                            <td><?php echo $row['nome']; ?></td>
                            <td><?php echo $row['sku']; ?></td>
                            <td><?php echo $row['unidade']; ?></td>
                            <td><?php echo $row['quantidade_estoque']; ?></td>
                            <td>R$ <?php echo $row['preco']; ?></td>
                            <td>R$ <?php echo $row['preco_compra']; ?></td>
                            <td>
                                <a href="editar_produto.php?id=<?php echo $row['id']; ?>"
                                    class="btn-editar"><strong>...</strong></a>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>
    </main>
    <footer>
        <!-- Seu rodapé aqui -->
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
        crossorigin="anonymous"></script>
    <script type="text/javascript" src="script_estoque.js"></script>
    <script>
        // Event listener para o botão "Sair"
        document.getElementById("logoutBtn").addEventListener("click", function () {
            // Aqui você pode adicionar a lógica para executar o logout, como redirecionar para uma página de login
            window.location.href = "../Login/logout.php"; // Exemplo: redireciona para a página de logout
        });

        // Event listener para o botão "Perfil"
        document.getElementById("perfilBtn").addEventListener("click", function () {
            // Aqui você pode adicionar a lógica para ir para a página de perfil do usuário
            window.location.href = "../perfil/perfil.php"; // Exemplo: redireciona para a página de perfil
        });
    </script>
</body>

</html>
