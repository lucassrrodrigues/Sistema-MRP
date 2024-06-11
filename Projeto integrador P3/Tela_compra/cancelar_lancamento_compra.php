<?php
session_start();
require_once "../conexao.php";

if (!isset($_SESSION['id'])) {
    header("Location: login.php");
    exit();
}

if (!isset($_GET['id_compra'])) {
    header("Location: Tela_compra.php");
    exit();
}

$id_compra = $_GET['id_compra'];

// Atualizar o status de lançamento no estoque
$sql = "UPDATE compras SET lancado_estoque = 0 WHERE id = $id_compra";
if (mysqli_query($conexao, $sql)) {
    // Atualizar o estoque dos itens
    $sql_itens = "SELECT * FROM itens_compra WHERE compra_id = $id_compra";
    $resultado_itens = mysqli_query($conexao, $sql_itens);

    while ($item = mysqli_fetch_assoc($resultado_itens)) {
        $codigo = $item['codigo'];
        $quantidade = $item['quantidade'];

        // Atualizar a quantidade do produto no estoque
        $sql_estoque = "UPDATE produtos SET quantidade_estoque = quantidade_estoque - $quantidade WHERE sku = '$codigo'";
        mysqli_query($conexao, $sql_estoque);
    }

    header("Location: Tela_compra.php");
    exit();
} else {
    echo "Erro ao cancelar lançamento no estoque: " . mysqli_error($conexao);
}
?>
