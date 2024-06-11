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
$sql = "UPDATE compras SET lancado_estoque = 1 WHERE id = $id_compra";
if (mysqli_query($conexao, $sql)) {
    // Atualizar o estoque dos itens
    $sql_itens = "SELECT * FROM itens_compra WHERE compra_id = $id_compra";
    $resultado_itens = mysqli_query($conexao, $sql_itens);

    while ($item = mysqli_fetch_assoc($resultado_itens)) {
        $codigo = $item['codigo']; // Certifique-se de que 'codigo' exista na tabela itens_compra e seja o identificador correto
        $quantidade = $item['quantidade'];

        // Verificar se o produto existe na tabela produtos
        $sql_produto = "SELECT id FROM produtos WHERE sku = '$codigo'";
        $resultado_produto = mysqli_query($conexao, $sql_produto);
        $produto = mysqli_fetch_assoc($resultado_produto);

        if ($produto) {
            // Atualizar a quantidade do produto no estoque
            $produto_id = $produto['id'];
            $sql_estoque = "UPDATE produtos SET quantidade_estoque = quantidade_estoque + $quantidade WHERE id = $produto_id";
            mysqli_query($conexao, $sql_estoque);
        } else {
            echo "Produto com código $codigo não encontrado.";
        }
    }

    header("Location: Tela_compra.php");
    exit();
} else {
    echo "Erro ao lançar no estoque: " . mysqli_error($conexao);
}
?>
