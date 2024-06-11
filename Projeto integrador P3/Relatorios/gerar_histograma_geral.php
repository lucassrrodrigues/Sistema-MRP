<?php
session_start();
if (!isset($_SESSION['id'])) {
    header("Location: login.php");
    exit();
}

require_once "../conexao.php";

$id_usuario = $_SESSION['id'];
$data_inicial = isset($_GET['data_inicial']) ? $_GET['data_inicial'] : "";
$data_final = isset($_GET['data_final']) ? $_GET['data_final'] : "";

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

// Consultas para obter os dados detalhados de vendas e compras
$vendas_sql = "SELECT DATE(data_venda) as data, SUM(total_venda) as total_venda FROM vendas WHERE id_usuario = $id_usuario $filtros_sql GROUP BY DATE(data_venda)";
$vendas_resultado = mysqli_query($conexao, $vendas_sql);

$compras_sql = "SELECT DATE(data_compra) as data, SUM(total_compra) as total_compra FROM compras WHERE id_usuario = $id_usuario $filtros_sql_compras GROUP BY DATE(data_compra)";
$compras_resultado = mysqli_query($conexao, $compras_sql);

$datas_vendas = [];
$totais_vendas = [];

while ($row = mysqli_fetch_assoc($vendas_resultado)) {
    $datas_vendas[] = $row['data'];
    $totais_vendas[] = $row['total_venda'];
}

$datas_compras = [];
$totais_compras = [];

while ($row = mysqli_fetch_assoc($compras_resultado)) {
    $datas_compras[] = $row['data'];
    $totais_compras[] = $row['total_compra'];
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <title>UpperPro - Histograma Geral</title>
    <link rel="icon" href="../img/logo.png" type="image/png">
</head>

<body>
    <div class="container mt-4">
        <h1>Histograma Geral</h1>
        <canvas id="histogramaGeral"></canvas>
        <a href="relatorio_geral.php" class="btn btn-primary mt-3">Voltar</a>
    </div>

    <script>
        var ctx = document.getElementById('histogramaGeral').getContext('2d');
        var histogramaGeral = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: <?php echo json_encode(array_unique(array_merge($datas_vendas, $datas_compras))); ?>,
                datasets: [
                    {
                        label: 'Total Vendas',
                        data: <?php echo json_encode($totais_vendas); ?>,
                        backgroundColor: 'rgba(54, 162, 235, 0.2)',
                        borderColor: 'rgba(54, 162, 235, 1)',
                        borderWidth: 1
                    },
                    {
                        label: 'Total Compras',
                        data: <?php echo json_encode($totais_compras); ?>,
                        backgroundColor: 'rgba(255, 99, 132, 0.2)',
                        borderColor: 'rgba(255, 99, 132, 1)',
                        borderWidth: 1
                    }
                ]
            },
            options: {
                scales: {
                    x: {
                        title: {
                            display: true,
                            text: 'Data'
                        }
                    },
                    y: {
                        title: {
                            display: true,
                            text: 'Valor (R$)'
                        },
                        beginAtZero: true
                    }
                }
            }
        });
    </script>
</body>

</html>
