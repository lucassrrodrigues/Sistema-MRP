<?php
session_start();
if (!isset($_SESSION['id'])) {
    header("Location: login.php");
    exit();
}

require_once "../conexao.php";

if (!isset($_GET['id_venda'])) {
    header("Location: Tela_Venda.php");
    exit();
}

$id_venda = $_GET['id_venda'];

// Inicia uma transação
mysqli_begin_transaction($conexao);

try {
    // Move a venda para o histórico
    $sql_move_venda = "
        INSERT INTO historico_Del_venda (num_ped, cliente, vendedor, cond_pagamento, categoria, data_venda, data_saida, data_prevista, id_usuario, num_itens, soma_quantidades, desconto_total_itens, total_itens, desconto_total_venda, total_venda, lancado_estoque)
        SELECT num_ped, cliente, vendedor, cond_pagamento, categoria, data_venda, data_saida, data_prevista, id_usuario, num_itens, soma_quantidades, desconto_total_itens, total_itens, desconto_total_venda, total_venda, lancado_estoque
        FROM vendas
        WHERE id = $id_venda";
    mysqli_query($conexao, $sql_move_venda);

    // Move os itens da venda para o histórico
    $sql_move_itens = "
        INSERT INTO historico_Del_itens_venda (venda_id, nome_item, codigo, quantidade, preco, desconto, preco_total)
        SELECT venda_id, nome_item, codigo, quantidade, preco, desconto, preco_total
        FROM itens_venda
        WHERE venda_id = $id_venda";
    mysqli_query($conexao, $sql_move_itens);

    // Deleta os itens da venda
    $sql_delete_itens = "DELETE FROM itens_venda WHERE venda_id = $id_venda";
    mysqli_query($conexao, $sql_delete_itens);

    // Deleta a venda
    $sql_delete_venda = "DELETE FROM vendas WHERE id = $id_venda";
    mysqli_query($conexao, $sql_delete_venda);

    // Comita a transação
    mysqli_commit($conexao);

    header("Location: Tela_Venda.php?msg=Venda movida para o histórico com sucesso");
} catch (Exception $e) {
    // Se der algum erro, desfaz a transação
    mysqli_rollback($conexao);
    header("Location: Tela_Venda.php?msg=Erro ao mover a venda para o histórico");
}
?>
