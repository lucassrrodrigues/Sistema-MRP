<?php
session_start();
if (!isset($_SESSION['id'])) {
    header("Location: login.php");
    exit();
}

require_once "../conexao.php";

$id_usuario = $_SESSION['id'];
$data_inicial = isset($_POST['data_inicial']) ? $_POST['data_inicial'] : "";
$data_final = isset($_POST['data_final']) ? $_POST['data_final'] : "";
$cliente = isset($_POST['cliente']) ? $_POST['cliente'] : "";
$vendedor = isset($_POST['vendedor']) ? $_POST['vendedor'] : "";
$lancado_estoque = isset($_POST['lancado_estoque']) ? $_POST['lancado_estoque'] : "";

$filtros = [];
if (!empty($data_inicial)) {
    $filtros[] = "data_venda >= '$data_inicial'";
}
if (!empty($data_final)) {
    $filtros[] = "data_venda <= '$data_final'";
}
if (!empty($cliente)) {
    $filtros[] = "cliente LIKE '%$cliente%'";
}
if (!empty($vendedor)) {
    $filtros[] = "vendedor LIKE '%$vendedor%'";
}
if ($lancado_estoque !== "") {
    $filtros[] = "lancado_estoque = $lancado_estoque";
}

$filtros_sql = count($filtros) > 0 ? 'AND ' . implode(' AND ', $filtros) : '';

$sql = "SELECT * FROM vendas WHERE id_usuario = $id_usuario $filtros_sql";
$resultado = mysqli_query($conexao, $sql);

$totais_sql = "SELECT COUNT(id) as total_pedidos, SUM(total_venda) as total_vendido FROM vendas WHERE id_usuario = $id_usuario $filtros_sql";
$totais_resultado = mysqli_query($conexao, $totais_sql);
$totais = mysqli_fetch_assoc($totais_resultado);

$item_mais_vendido_sql = "
    SELECT nome_item, SUM(quantidade) as quantidade_total, SUM(preco_total) as valor_total 
    FROM itens_venda 
    JOIN vendas ON vendas.id = itens_venda.venda_id 
    WHERE vendas.id_usuario = $id_usuario $filtros_sql 
    GROUP BY nome_item 
    ORDER BY quantidade_total DESC 
    LIMIT 1";
$item_mais_vendido_resultado = mysqli_query($conexao, $item_mais_vendido_sql);
$item_mais_vendido = mysqli_fetch_assoc($item_mais_vendido_resultado);

$maior_cliente_sql = "
    SELECT cliente, SUM(total_venda) as total_gasto 
    FROM vendas 
    WHERE id_usuario = $id_usuario $filtros_sql 
    GROUP BY cliente 
    ORDER BY total_gasto DESC 
    LIMIT 1";
$maior_cliente_resultado = mysqli_query($conexao, $maior_cliente_sql);
$maior_cliente = mysqli_fetch_assoc($maior_cliente_resultado);

$histograma_params = http_build_query([
    'data_inicial' => $data_inicial,
    'data_final' => $data_final,
    'cliente' => $cliente,
    'vendedor' => $vendedor,
    'lancado_estoque' => $lancado_estoque
]);

// Buscar clientes e vendedores
$clientes_sql = "SELECT DISTINCT cliente FROM vendas WHERE id_usuario = $id_usuario";
$clientes_result = mysqli_query($conexao, $clientes_sql);

$vendedores_sql = "SELECT DISTINCT vendedor FROM vendas WHERE id_usuario = $id_usuario";
$vendedores_result = mysqli_query($conexao, $vendedores_sql);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="../styleHeader.css">
    <title>UpperPro - Relatório de Vendas</title>
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
                    <a class="dropdown-meio" href="#">Frente de Caixa</a>
                    <a class="dropdown-end" href="#">Relatorio</a>
                </div>
            </div>
        </nav>
        <div>
            <button id="perfilBtn"><img class="perfil" src="../img/perfil.png" alt="Perfil"></button>
            <button id="logoutBtn"><img class="perfil" src="../img/sair.png" alt="Sair"></button>
        </div>
    </header>
    <div class="container mt-4">
        <h1>Relatório de Vendas</h1>
        <form action="relatorio_vendas.php" method="POST" class="row g-3">
            <div class="col-md-3">
                <label for="data_inicial" class="form-label">Data Inicial</label>
                <input type="date" class="form-control" id="data_inicial" name="data_inicial" value="<?php echo $data_inicial; ?>">
            </div>
            <div class="col-md-3">
                <label for="data_final" class="form-label">Data Final</label>
                <input type="date" class="form-control" id="data_final" name="data_final" value="<?php echo $data_final; ?>">
            </div>
            <div class="col-md-3">
                <label for="cliente" class="form-label">Cliente</label>
                <select class="form-control" id="cliente" name="cliente">
                    <option value="">Todos</option>
                    <?php while ($row = mysqli_fetch_assoc($clientes_result)) { ?>
                        <option value="<?php echo $row['cliente']; ?>" <?php echo $cliente == $row['cliente'] ? 'selected' : ''; ?>><?php echo $row['cliente']; ?></option>
                    <?php } ?>
                </select>
            </div>
            <div class="col-md-3">
                <label for="vendedor" class="form-label">Vendedor</label>
                <select class="form-control" id="vendedor" name="vendedor">
                    <option value="">Todos</option>
                    <?php while ($row = mysqli_fetch_assoc($vendedores_result)) { ?>
                        <option value="<?php echo $row['vendedor']; ?>" <?php echo $vendedor == $row['vendedor'] ? 'selected' : ''; ?>><?php echo $row['vendedor']; ?></option>
                    <?php } ?>
                </select>
            </div>
            <div class="col-md-3">
                <label for="lancado_estoque" class="form-label">Lançado no Estoque</label>
                <select class="form-control" id="lancado_estoque" name="lancado_estoque">
                    <option value="">Todos</option>
                    <option value="1" <?php echo $lancado_estoque === '1' ? 'selected' : ''; ?>>Sim</option>
                    <option value="0" <?php echo $lancado_estoque === '0' ? 'selected' : ''; ?>>Não</option>
                </select>
            </div>
            <div class="col-12">
                <button type="submit" class="btn btn-primary">Filtrar</button>
                <a href="gerar_histograma_vendas.php?<?php echo $histograma_params; ?>" class="btn btn-secondary">Gerar Histograma</a>
            </div>
        </form>
        <hr>
        <h2>Resumo</h2>
        <p>Total de Pedidos: <?php echo $totais['total_pedidos']; ?></p>
        <p>Total Vendido: R$ <?php echo number_format($totais['total_vendido'], 2, ',', '.'); ?></p>
        <p>Item Mais Vendido: 
            <?php 
            if ($item_mais_vendido) {
                echo $item_mais_vendido['nome_item'] . ' (' . $item_mais_vendido['quantidade_total'] . ' unidades, R$ ' . number_format($item_mais_vendido['valor_total'], 2, ',', '.') . ')';
            } else {
                echo 'N/A';
            }
            ?>
        </p>
        <p>Maior Cliente: 
            <?php 
            if ($maior_cliente) {
                echo $maior_cliente['cliente'] . ' (R$ ' . number_format($maior_cliente['total_gasto'], 2, ',', '.') . ')';
            } else {
                echo 'N/A';
            }
            ?>
        </p>
        <hr>
        <h2>Pedidos de Venda</h2>
        <div class="table-responsive">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>Número do Pedido</th>
                        <th>Cliente</th>
                        <th>Vendedor</th>
                        <th>Data da Venda</th>
                        <th>Total da Venda</th>
                        <th>Lançado no Estoque</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (mysqli_num_rows($resultado) > 0) {
                        while ($row = mysqli_fetch_assoc($resultado)) { ?>
                            <tr>
                                <td><?php echo $row['num_ped']; ?></td>
                                <td><?php echo $row['cliente']; ?></td>
                                <td><?php echo $row['vendedor']; ?></td>
                                <td><?php echo $row['data_venda']; ?></td>
                                <td>R$ <?php echo number_format($row['total_venda'], 2, ',', '.'); ?></td>
                                <td><?php echo $row['lancado_estoque'] ? 'Sim' : 'Não'; ?></td>
                            </tr>
                        <?php }
                    } else { ?>
                        <tr>
                            <td colspan="6">Nenhum pedido de venda encontrado.</td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
        crossorigin="anonymous"></script>
</body>

</html>
