<?php
require_once "../conexao.php";

if (isset($_GET['nome_item'])) {
    $nomeItem = mysqli_real_escape_string($conexao, $_GET['nome_item']);
    session_start();
    $idCliente = $_SESSION['id'];

    $sql = "SELECT sku, preco_compra FROM produtos WHERE nome = ? AND id_cliente = ?";
    
    $stmt = mysqli_prepare($conexao, $sql);
    
    if ($stmt) {
        mysqli_stmt_bind_param($stmt, "si", $nomeItem, $idCliente);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_store_result($stmt);

        if (mysqli_stmt_num_rows($stmt) > 0) {
            mysqli_stmt_bind_result($stmt, $sku, $preco);
            mysqli_stmt_fetch($stmt);

            $response = array(
                'success' => true,
                'data' => array(
                    'codigo' => $sku,
                    'preco' => $preco
                )
            );
            echo json_encode($response);
        } else {
            $response = array(
                'success' => false,
                'message' => 'Produto não encontrado.'
            );
            echo json_encode($response);
        }
        mysqli_stmt_close($stmt);
    } else {
        $response = array(
            'success' => false,
            'message' => 'Erro na preparação da declaração SQL: ' . mysqli_error($conexao)
        );
        echo json_encode($response);
    }
    mysqli_close($conexao);
} else {
    $response = array(
        'success' => false,
        'message' => 'Nome do item não fornecido.'
    );
    echo json_encode($response);
}
?>
