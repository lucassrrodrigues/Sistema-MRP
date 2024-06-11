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
$sql_clientes_fornecedores = "SELECT * FROM tabela_cliente_fornecedor WHERE 1";

// Aplica os filtros, se existirem
if (isset($_GET['filtro_nome']) && !empty($_GET['filtro_nome'])) {
    $filtro_nome = $_GET['filtro_nome'];
    $sql_clientes_fornecedores .= " AND Nome LIKE '%$filtro_nome%'";
}

if (isset($_GET['filtro_cpf_cnpj']) && !empty($_GET['filtro_cpf_cnpj'])) {
    $filtro_cpf_cnpj = $_GET['filtro_cpf_cnpj'];
    $sql_clientes_fornecedores .= " AND `CPF/CNPJ` LIKE '%$filtro_cpf_cnpj%'";
}

if (isset($_GET['filtro_tipo']) && !empty($_GET['filtro_tipo'])) {
    $filtro_tipo = $_GET['filtro_tipo'];
    $sql_clientes_fornecedores .= " AND Tipo = '$filtro_tipo'";
}

// Executa a consulta SQL
$result_clientes_fornecedores = mysqli_query($conexao, $sql_clientes_fornecedores);
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
    <title>UpperPro - Clientes e Fornecedores</title>
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
            transition: left 0.0s ease;
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

        .title-container {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin: 20px;
            padding: 0 20px;
        }

        .title-container h1 {
            margin: 0;
            padding: 15px;
            color: #3FB5FA;
            flex-grow: 1;
            text-align: center;
        }

        .button-group {
            display: flex;
            flex-direction: column;
            align-items: flex-end;
        }

        .btn-cadastro {
            margin: 10px 0;
            padding: 10px 20px;
            background-color: #58befa;
            border: none;
            border-radius: 5px;
            color: white;
            cursor: pointer;
            width: 200px;
            text-align: center;
        }

        .btn-cadastro:hover {
            background-color: #4A9ECB;
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
    <div class="title-container">
        <h1><strong>Clientes e Fornecedores</strong></h1>
        <div class="button-group">
            <button class="btn-cadastro" onclick="location.href='juridica.html'">Cadastrar Pessoa Jurídica</button>
            <button class="btn-cadastro" onclick="location.href='fisica.html'">Cadastrar Pessoa Física</button>
        </div>
    </div>
    <button id="sidebarToggle"></button>
    <aside id="sidebar" class="closed">
        <button id="sidebarClose">Fechar</button>
        <form class="filtro" action="cliente_fornecedor.php" method="GET">
            <label for="filtro_nome">Filtrar por Nome:</label>
            <input type="text" name="filtro_nome" id="filtro_nome">
            <label for="filtro_cpf_cnpj">Filtrar por CPF/CNPJ:</label>
            <input type="text" name="filtro_cpf_cnpj" id="filtro_cpf_cnpj">
            <label for="filtro_tipo">Filtrar por Cliente/Fornecedor:</label>
            <select name="filtro_tipo" id="filtro_tipo">
                <option value="">Todos</option>
                <option value="cliente">Cliente</option>
                <option value="fornecedor">Fornecedor</option>
            </select>
            <button type="submit" style="margin-top: 20px;">Filtrar</button>
        </form>
    </aside>
    <main>
        <div class="container">
            <table class="table">
                <thead>
                    <tr>
                        <th>Nome</th>
                        <th>CPF/CNPJ</th>
                        <th>Cidade</th>
                        <th>Telefone</th>
                        <th>Tipo</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($row = mysqli_fetch_assoc($result_clientes_fornecedores)) { ?>
                        <tr>
                            <td><?php echo $row['Nome']; ?></td>
                            <td><?php echo $row['CPF/CNPJ']; ?></td>
                            <td><?php echo $row['Cidade']; ?></td>
                            <td><?php echo $row['Telefone']; ?></td>
                            <td><?php echo $row['Tipo']; ?></td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    </main>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <script type="text/javascript" src="script_cliente.js"></script>
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
