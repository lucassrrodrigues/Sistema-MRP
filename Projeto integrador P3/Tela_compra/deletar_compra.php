<?php
session_start();
if (!isset($_SESSION['id'])) {
    header("Location: login.php");
    exit();
}

require_once "../conexao.php";

if (!isset($_GET['id_compra'])) {
    header("Location: Tela_compra.php");
    exit();
}

$id_compra = $_GET['id_compra'];

// Inicia uma transação
mysqli_begin_transaction($conexao);

try {
    // Move a compra para o histórico
    $sql_move_compra = "
        INSERT INTO historico_Del_compra (num_ped, fornecedor, comprador, cond_pagamento, categoria, data_compra, data_recebimento, data_prevista, id_usuario, num_itens, soma_quantidades, desconto_total_itens, total_itens, desconto_total_compra, total_compra, lancado_estoque)
        SELECT num_ped, fornecedor, comprador, cond_pagamento, categoria, data_compra, data_recebimento, data_prevista, id_usuario, num_itens, soma_quantidades, desconto_total_itens, total_itens, desconto_total_compra, total_compra, lancado_estoque
        FROM compras
        WHERE id = $id_compra";
    mysqli_query($conexao, $sql_move_compra);

    // Move os itens da compra para o histórico
    $sql_move_itens = "
        INSERT INTO historico_Del_itens_compra (compra_id, nome_item, codigo, quantidade, preco, desconto, preco_total)
        SELECT compra_id, nome_item, codigo, quantidade, preco, desconto, preco_total
        FROM itens_compra
        WHERE compra_id = $id_compra";
    mysqli_query($conexao, $sql_move_itens);

    // Deleta os itens da compra
    $sql_delete_itens = "DELETE FROM itens_compra WHERE compra_id = $id_compra";
    mysqli_query($conexao, $sql_delete_itens);

    // Deleta a compra
    $sql_delete_compra = "DELETE FROM compras WHERE id = $id_compra";
    mysqli_query($conexao, $sql_delete_compra);

    // Comita a transação
    mysqli_commit($conexao);

    header("Location: Tela_compra.php?msg=Compra movida para o histórico com sucesso");
} catch (Exception $e) {
    // Se der algum erro, desfaz a transação
    mysqli_rollback($conexao);
    header("Location: Tela_compra.php?msg=Erro ao mover a compra para o histórico");
}
?>
