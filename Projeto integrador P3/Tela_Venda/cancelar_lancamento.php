<?php
session_start();
if (!isset($_SESSION['id'])) {
    header("Location: login.php");
    exit();
}

require_once "../conexao.php";

$id_venda = $_GET['id_venda'];

// Obter itens da venda
$sql_itens = "SELECT * FROM itens_venda WHERE venda_id = $id_venda";
$resultado_itens = mysqli_query($conexao, $sql_itens);

if (mysqli_num_rows($resultado_itens) > 0) {
    while ($item = mysqli_fetch_assoc($resultado_itens)) {
        $codigo = $item['codigo'];
        $quantidade = $item['quantidade'];

        // Atualizar estoque do produto
        $sql_estoque = "UPDATE produtos SET quantidade_estoque = quantidade_estoque + $quantidade WHERE sku = '$codigo'";
        if (!mysqli_query($conexao, $sql_estoque)) {
            echo "Erro ao atualizar o estoque: " . mysqli_error($conexao);
            exit();
        }
    }

    // Marcar a venda como não lançada no estoque
    $sql_lancado = "UPDATE vendas SET lancado_estoque = 0 WHERE id = $id_venda";
    if (!mysqli_query($conexao, $sql_lancado)) {
        echo "Erro ao marcar a venda como não lançada: " . mysqli_error($conexao);
        exit();
    }

    header("Location: Tela_Venda.php");
    exit();
} else {
    echo "Nenhum item encontrado para esta venda.";
}
?>
