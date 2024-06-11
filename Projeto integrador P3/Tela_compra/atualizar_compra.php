<?php
session_start();
require_once "../conexao.php";

if (!isset($_SESSION['id'])) {
    header("Location: login.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id_compra = $_POST['id_compra'];
    $fornecedor = $_POST['fornecedor'];
    $comprador = $_POST['comprador'];
    $cond_pagamento = $_POST['cond_pagamento'];
    $categoria = $_POST['categoria'];
    $data_compra = $_POST['data_compra'];
    $data_recebimento = $_POST['data_recebimento'];
    $data_prevista = $_POST['data_prevista'];
    $num_itens = $_POST['num_itens'];
    $soma_quantidades = $_POST['soma_quantidades'];
    $desconto_total_itens = $_POST['desconto_total_itens'];
    $total_itens = $_POST['total_itens'];
    $desconto_total_compra = $_POST['desc_total_compra'];
    $total_compra = $_POST['total_compra'];

    $sql = "UPDATE compras 
            SET fornecedor = '$fornecedor', comprador = '$comprador', cond_pagamento = '$cond_pagamento', categoria = '$categoria', data_compra = '$data_compra', data_recebimento = '$data_recebimento', data_prevista = '$data_prevista', num_itens = '$num_itens', soma_quantidades = '$soma_quantidades', desconto_total_itens = '$desconto_total_itens', total_itens = '$total_itens', desconto_total_compra = '$desconto_total_compra', total_compra = '$total_compra' 
            WHERE id = $id_compra";

    if (mysqli_query($conexao, $sql)) {
        // Atualizar os itens
        $sql_delete_itens = "DELETE FROM itens_compra WHERE compra_id = $id_compra";
        mysqli_query($conexao, $sql_delete_itens);

        foreach ($_POST['nome_item'] as $index => $nome_item) {
            $codigo = $_POST['codigo'][$index];
            $quantidade = $_POST['quantidade'][$index];
            $preco = $_POST['preco'][$index];
            $desconto = $_POST['desconto'][$index];
            $preco_total = $_POST['preco_total'][$index];

            $sql_item = "INSERT INTO itens_compra (compra_id, nome_item, codigo, quantidade, preco, desconto, preco_total) 
                         VALUES ('$id_compra', '$nome_item', '$codigo', '$quantidade', '$preco', '$desconto', '$preco_total')";

            if (!mysqli_query($conexao, $sql_item)) {
                echo "Erro ao atualizar item: " . mysqli_error($conexao);
                exit();
            }
        }

        header("Location: Tela_compra.php");
        exit();
    } else {
        echo "Erro ao atualizar a compra: " . mysqli_error($conexao);
    }
}
?>
