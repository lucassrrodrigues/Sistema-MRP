<?php
session_start();
if (!isset($_SESSION['id'])) {
    header("Location: login.php");
    exit();
}

require_once "../conexao.php";
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="estilos_cadastro_funcionario.css">
    <link rel="stylesheet" href="../styleHeader.css">
    <title>UpperPro - Cadastro de Funcionário</title>
    <link rel="icon" href="../img/logo.png" type="image/png">
</head>

<body>
    <header>
        <img src="../img/logo.png" alt="logo">
        <nav>
            <div class="dropdown">
                <button class="dropbtn">Cadastros</button>
                <div class="dropdown-content">
                    <a class="dropdown-start" href="../Cadastro_Cliente/cliente_fornecedor.php">Cliente e Fornecedor Pessoa
                        Fisica</a>
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
                    <a class="dropdown-meio" href="../frente_caixa.php">Frente de Caixa</a>
                    <a class="dropdown-end" href="#">Relatorio</a>
                </div>
            </div>
        </nav>
        <div>
            <button id="perfilBtn"><img class="perfil" src="../img/perfil.png" alt="Perfil"></button>
            <button id="logoutBtn"><img class="perfil" src="../img/sair.png" alt="Sair"></button>
        </div>
    </header>
    <div class="container">
        <h1>Cadastro de Funcionário</h1>
        <form action="processar_funcionario.php" method="POST">
            <div class="form-group mb-3">
                <label for="nome">Nome</label>
                <input type="text" class="form-control" id="nome" name="nome" required>
            </div>
            <div class="form-group mb-3">
                <label for="cpf">CPF</label>
                <input type="text" class="form-control" id="cpf" name="cpf" required>
            </div>
            <div class="form-group mb-3">
                <label for="cargo">Cargo</label>
                <select class="form-control" id="cargo" name="cargo" required>
                    <option value="">Selecione um Cargo</option>
                    <option value="Gerente">Gerente</option>
                    <option value="Vendedor">Vendedor</option>
                    <option value="Caixa">Caixa</option>
                    <option value="Estoque">Estoque</option>
                    <option value="Auxiliar Administrativo">Auxiliar Administrativo</option>
                    <!-- Adicione mais opções conforme necessário -->
                </select>
            </div>
            <div class="form-group mb-3">
                <label for="email">Email</label>
                <input type="email" class="form-control" id="email" name="email" required>
            </div>
            <div class="form-group mb-3">
                <label for="telefone">Telefone</label>
                <input type="text" class="form-control" id="telefone" name="telefone">
            </div>
            <div class="form-group mb-3">
                <label for="data_contratacao">Data de Contratação</label>
                <input type="date" class="form-control" id="data_contratacao" name="data_contratacao" required>
            </div>
            <div class="form-group mb-3">
                <label for="salario">Salário</label>
                <input type="number" step="0.01" class="form-control" id="salario" name="salario" required>
            </div>
            <button type="submit" class="btn btn-primary">Salvar</button>
        </form>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
        crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/inputmask@5.0.7-beta.19/dist/jquery.inputmask.min.js"></script>
    <script>
        $(document).ready(function () {
            $('#cpf').inputmask('999.999.999-99');
            $('#telefone').inputmask('(99) 99999-9999');
        });
    </script>
</body>

</html>
