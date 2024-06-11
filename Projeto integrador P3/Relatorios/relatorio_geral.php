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

// Filtros para as consultas
$filtros = [];
$filtros_compras = [];
if (!empty($data_inicial)) {
    $filtros[] = "data_venda >= '$data_inicial'";
    $filtros_compras[] = "data_compra >= '$data_inicial'";
}
if (!empty($data_final)) {
    $filtros[] = "data_venda <= '$data_final'";
    $filtros_compras[] = "data_compra <= '$data_final'";
}
$filtros_sql = count($filtros) > 0 ? 'AND ' . implode(' AND ', $filtros) : '';
$filtros_sql_compras = count($filtros_compras) > 0 ? 'AND ' . implode(' AND ', $filtros_compras) : '';

// Total de Vendas
$total_vendas_sql = "SELECT SUM(total_venda) AS total_vendas FROM vendas WHERE id_usuario = $id_usuario $filtros_sql";
$total_vendas_resultado = mysqli_query($conexao, $total_vendas_sql);
$total_vendas = mysqli_fetch_assoc($total_vendas_resultado)['total_vendas'] ?? 0;

// Total de Compras
$total_compras_sql = "SELECT SUM(total_compra) AS total_compras FROM compras WHERE id_usuario = $id_usuario $filtros_sql_compras";
$total_compras_resultado = mysqli_query($conexao, $total_compras_sql);
$total_compras = mysqli_fetch_assoc($total_compras_resultado)['total_compras'] ?? 0;

// Lucro Bruto e Lucro Líquido
$lucro_bruto = $total_vendas - $total_compras;
$lucro_liquido = $lucro_bruto; // Considerando que despesas são apenas as compras

// Consultas para obter os dados detalhados de vendas e compras
$vendas_sql = "SELECT * FROM vendas WHERE id_usuario = $id_usuario $filtros_sql";
$vendas_resultado = mysqli_query($conexao, $vendas_sql);

$compras_sql = "SELECT * FROM compras WHERE id_usuario = $id_usuario $filtros_sql_compras";
$compras_resultado = mysqli_query($conexao, $compras_sql);

$histograma_params = http_build_query([
    'data_inicial' => $data_inicial,
    'data_final' => $data_final,
    'id_usuario' => $id_usuario
]);

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="../styleHeader.css">
    <title>UpperPro - Relatório Geral</title>
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
        <h1>Relatório Geral</h1>
        <hr>
        <form action="relatorio_geral.php" method="POST" class="row g-3">
            <div class="col-md-3">
                <label for="data_inicial" class="form-label">Data Inicial</label>
                <input type="date" class="form-control" id="data_inicial" name="data_inicial" value="<?php echo $data_inicial; ?>">
            </div>
            <div class="col-md-3">
                <label for="data_final" class="form-label">Data Final</label>
                <input type="date" class="form-control" id="data_final" name="data_final" value="<?php echo $data_final; ?>">
            </div>
            <div class="col-12">
                <button type="submit" class="btn btn-primary">Filtrar</button>
                <a href="gerar_histograma_geral.php?<?php echo $histograma_params; ?>" class="btn btn-secondary">Gerar Histograma</a>
            </div>
        </form>
        <hr>
        <h2>Resumo Financeiro</h2>
        <p>Total de Vendas: R$ <?php echo number_format($total_vendas, 2, ',', '.'); ?></p>
        <p>Total de Compras: R$ <?php echo number_format($total_compras, 2, ',', '.'); ?></p>
        <p>Lucro Bruto: R$ <?php echo number_format($lucro_bruto, 2, ',', '.'); ?></p>
        <p>Lucro Líquido: R$ <?php echo number_format($lucro_liquido, 2, ',', '.'); ?></p>
        <hr>
        <h2>Detalhamento de Vendas</h2>
        <div class="table-responsive">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>Número do Pedido</th>
                        <th>Cliente</th>
                        <th>Vendedor</th>
                        <th>Data da Venda</th>
                        <th>Total da Venda</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (mysqli_num_rows($vendas_resultado) > 0) {
                        while ($row = mysqli_fetch_assoc($vendas_resultado)) { ?>
                            <tr>
                                <td><?php echo $row['num_ped']; ?></td>
                                <td><?php echo $row['cliente']; ?></td>
                                <td><?php echo $row['vendedor']; ?></td>
                                <td><?php echo $row['data_venda']; ?></td>
                                <td>R$ <?php echo number_format($row['total_venda'], 2, ',', '.'); ?></td>
                            </tr>
                        <?php }
                    } else { ?>
                        <tr>
                            <td colspan="5">Nenhum pedido de venda encontrado.</td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
        <hr>
        <h2>Detalhamento de Compras</h2>
        <div class="table-responsive">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>Número do Pedido</th>
                        <th>Fornecedor</th>
                        <th>Comprador</th>
                        <th>Data da Compra</th>
                        <th>Total da Compra</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (mysqli_num_rows($compras_resultado) > 0) {
                        while ($row = mysqli_fetch_assoc($compras_resultado)) { ?>
                            <tr>
                                <td><?php echo $row['num_ped']; ?></td>
                                <td><?php echo $row['fornecedor']; ?></td>
                                <td><?php echo $row['comprador']; ?></td>
                                <td><?php echo $row['data_compra']; ?></td>
                                <td>R$ <?php echo number_format($row['total_compra'], 2, ',', '.'); ?></td>
                            </tr>
                        <?php }
                    } else { ?>
                        <tr>
                            <td colspan="5">Nenhum pedido de compra encontrado.</td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    </div>
</body>

</html>
