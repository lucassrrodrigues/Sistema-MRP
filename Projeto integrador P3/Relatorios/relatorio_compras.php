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
$fornecedor = isset($_POST['fornecedor']) ? $_POST['fornecedor'] : "";
$lancado_estoque = isset($_POST['lancado_estoque']) ? $_POST['lancado_estoque'] : "";

$filtros = [];
if (!empty($data_inicial)) {
    $filtros[] = "data_compra >= '$data_inicial'";
}
if (!empty($data_final)) {
    $filtros[] = "data_compra <= '$data_final'";
}
if (!empty($fornecedor)) {
    $filtros[] = "fornecedor LIKE '%$fornecedor%'";
}
if ($lancado_estoque !== "") {
    $filtros[] = "lancado_estoque = $lancado_estoque";
}

$filtros_sql = count($filtros) > 0 ? 'AND ' . implode(' AND ', $filtros) : '';

$sql = "SELECT * FROM compras WHERE id_usuario = $id_usuario $filtros_sql";
$resultado = mysqli_query($conexao, $sql);

$totais_sql = "SELECT COUNT(id) as total_pedidos, SUM(total_compra) as total_gasto FROM compras WHERE id_usuario = $id_usuario $filtros_sql";
$totais_resultado = mysqli_query($conexao, $totais_sql);
$totais = mysqli_fetch_assoc($totais_resultado);

$item_mais_comprado_sql = "
    SELECT nome_item, SUM(quantidade) as quantidade_total, SUM(preco_total) as valor_total 
    FROM itens_compra 
    JOIN compras ON compras.id = itens_compra.compra_id 
    WHERE compras.id_usuario = $id_usuario $filtros_sql 
    GROUP BY nome_item 
    ORDER BY quantidade_total DESC 
    LIMIT 1";
$item_mais_comprado_resultado = mysqli_query($conexao, $item_mais_comprado_sql);
$item_mais_comprado = mysqli_fetch_assoc($item_mais_comprado_resultado);

$maior_fornecedor_sql = "
    SELECT fornecedor, SUM(total_compra) as total_gasto 
    FROM compras 
    WHERE id_usuario = $id_usuario $filtros_sql 
    GROUP BY fornecedor 
    ORDER BY total_gasto DESC 
    LIMIT 1";
$maior_fornecedor_resultado = mysqli_query($conexao, $maior_fornecedor_sql);
$maior_fornecedor = mysqli_fetch_assoc($maior_fornecedor_resultado);

$histograma_params = http_build_query([
    'data_inicial' => $data_inicial,
    'data_final' => $data_final,
    'fornecedor' => $fornecedor,
    'lancado_estoque' => $lancado_estoque
]);

// Buscar fornecedores
$fornecedores_sql = "SELECT DISTINCT fornecedor FROM compras WHERE id_usuario = $id_usuario";
$fornecedores_result = mysqli_query($conexao, $fornecedores_sql);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="../styleHeader.css">
    <title>UpperPro - Relatório de Compras</title>
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
        <h1>Relatório de Compras</h1>
        <form action="relatorio_compras.php" method="POST" class="row g-3">
            <div class="col-md-3">
                <label for="data_inicial" class="form-label">Data Inicial</label>
                <input type="date" class="form-control" id="data_inicial" name="data_inicial" value="<?php echo $data_inicial; ?>">
            </div>
            <div class="col-md-3">
                <label for="data_final" class="form-label">Data Final</label>
                <input type="date" class="form-control" id="data_final" name="data_final" value="<?php echo $data_final; ?>">
            </div>
            <div class="col-md-3">
                <label for="fornecedor" class="form-label">Fornecedor</label>
                <select class="form-control" id="fornecedor" name="fornecedor">
                    <option value="">Todos</option>
                    <?php while ($row = mysqli_fetch_assoc($fornecedores_result)) { ?>
                        <option value="<?php echo $row['fornecedor']; ?>" <?php echo $fornecedor == $row['fornecedor'] ? 'selected' : ''; ?>><?php echo $row['fornecedor']; ?></option>
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
                <a href="gerar_histograma.php?<?php echo $histograma_params; ?>" class="btn btn-secondary">Gerar Histograma</a>
            </div>
        </form>
        <hr>
        <h2>Resumo</h2>
        <p>Total de Pedidos: <?php echo $totais['total_pedidos'] ?? 0; ?></p>
        <p>Total Gasto: R$ <?php echo number_format($totais['total_gasto'] ?? 0, 2, ',', '.'); ?></p>
        <p>Item Mais Comprado: 
            <?php echo $item_mais_comprado['nome_item'] ?? 'N/A'; ?> 
            (<?php echo $item_mais_comprado['quantidade_total'] ?? 0; ?> unidades, R$ 
            <?php echo number_format($item_mais_comprado['valor_total'] ?? 0, 2, ',', '.'); ?>)
        </p>
        <p>Maior Fornecedor: 
            <?php echo $maior_fornecedor['fornecedor'] ?? 'N/A'; ?> 
            (R$ <?php echo number_format($maior_fornecedor['total_gasto'] ?? 0, 2, ',', '.'); ?>)
        </p>
        <hr>
        <h2>Pedidos de Compra</h2>
        <div class="table-responsive">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>Número do Pedido</th>
                        <th>Fornecedor</th>
                        <th>Comprador</th>
                        <th>Data da Compra</th>
                        <th>Total da Compra</th>
                        <th>Lançado no Estoque</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (mysqli_num_rows($resultado) > 0) {
                        while ($row = mysqli_fetch_assoc($resultado)) { ?>
                            <tr>
                                <td><?php echo $row['num_ped']; ?></td>
                                <td><?php echo $row['fornecedor']; ?></td>
                                <td><?php echo $row['comprador']; ?></td>
                                <td><?php echo $row['data_compra']; ?></td>
                                <td><?php echo $row['total_compra']; ?></td>
                                <td><?php echo $row['lancado_estoque'] ? 'Sim' : 'Não'; ?></td>
                            </tr>
                        <?php }
                    } else { ?>
                        <tr>
                            <td colspan="6">Nenhum pedido de compra encontrado.</td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH"
        crossorigin="anonymous"></script>
</body>

</html>
