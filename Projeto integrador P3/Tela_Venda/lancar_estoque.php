<?php
session_start();
if (!isset($_SESSION['id'])) {
    header("Location: login.php");
    exit();
}

require_once "../conexao.php";

$id_compra = $_GET['id_compra'];

// Obter itens da compra
$sql_itens = "SELECT * FROM itens_compra WHERE compra_id = $id_compra";
$resultado_itens = mysqli_query($conexao, $sql_itens);

if (mysqli_num_rows($resultado_itens) > 0) {
    while ($item = mysqli_fetch_assoc($resultado_itens)) {
        $codigo = $item['codigo'];
        $quantidade = $item['quantidade'];

        // Atualizar estoque do produto
        $sql_estoque = "UPDATE produtos SET quantidade = quantidade + $quantidade WHERE codigo = '$codigo'";
        if (!mysqli_query($conexao, $sql_estoque)) {
            echo "Erro ao atualizar o estoque: " . mysqli_error($conexao);
            exit();
        }
    }

    // Marcar a compra como lançada no estoque
    $sql_lancado = "UPDATE compras SET lancado_estoque = 1 WHERE id = $id_compra";
    if (!mysqli_query($conexao, $sql_lancado)) {
        echo "Erro ao marcar a compra como lançada: " . mysqli_error($conexao);
        exit();
    }

    header("Location: Tela_compra.php");
    exit();
} else {
    echo "Nenhum item encontrado para esta compra.";
}
?>
