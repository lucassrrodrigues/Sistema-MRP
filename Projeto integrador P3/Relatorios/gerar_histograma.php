<?php
session_start();
if (!isset($_SESSION['id'])) {
    header("Location: login.php");
    exit();
}

require_once "../conexao.php";

$id_usuario = $_SESSION['id'];
$filtros = [];
$data_inicial = isset($_GET['data_inicial']) ? $_GET['data_inicial'] : "";
$data_final = isset($_GET['data_final']) ? $_GET['data_final'] : "";
$fornecedor = isset($_GET['fornecedor']) ? $_GET['fornecedor'] : "";
$lancado_estoque = isset($_GET['lancado_estoque']) ? $_GET['lancado_estoque'] : "";

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

$sql = "SELECT data_compra, SUM(total_compra) AS total_gasto FROM compras WHERE id_usuario = $id_usuario $filtros_sql GROUP BY data_compra";
$resultado = mysqli_query($conexao, $sql);

$datas = [];
$totais = [];

while ($row = mysqli_fetch_assoc($resultado)) {
    $datas[] = $row['data_compra'];
    $totais[] = $row['total_gasto'];
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
    <title>UpperPro - Histograma de Compras</title>
    <link rel="icon" href="../img/logo.png" type="image/png">
</head>

<body>
    <div class="container mt-4">
        <h1>Histograma de Compras</h1>
        <canvas id="histogramaCompras"></canvas>
        <a href="relatorio_compras.php" class="btn btn-primary mt-3">Voltar</a>
    </div>

    <script>
        var ctx = document.getElementById('histogramaCompras').getContext('2d');
        var histogramaCompras = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: <?php echo json_encode($datas); ?>,
                datasets: [{
                    label: 'Total Gasto',
                    data: <?php echo json_encode($totais); ?>,
                    backgroundColor: 'rgba(75, 192, 192, 0.2)',
                    borderColor: 'rgba(75, 192, 192, 1)',
                    borderWidth: 1
                }]
            },
            options: {
                scales: {
                    x: {
                        title: {
                            display: true,
                            text: 'Data da Compra'
                        }
                    },
                    y: {
                        title: {
                            display: true,
                            text: 'Total Gasto (R$)'
                        },
                        beginAtZero: true
                    }
                }
            }
        });
    </script>
</body>

</html>
