<?php
require_once "../conexao.php";

if (isset($_GET['termo'])) {
    $termo = mysqli_real_escape_string($conexao, $_GET['termo']);
    session_start();
    $idCliente = $_SESSION['id'];

    $sql = "SELECT nome, sku, preco FROM produtos WHERE nome LIKE ? AND id_cliente = ?";
    
    $stmt = mysqli_prepare($conexao, $sql);
    
    if ($stmt) {
        $termo_like = '%' . $termo . '%';
        mysqli_stmt_bind_param($stmt, "si", $termo_like, $idCliente);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_store_result($stmt);

        $result = [];
        if (mysqli_stmt_num_rows($stmt) > 0) {
            mysqli_stmt_bind_result($stmt, $nome, $sku, $preco);
            while (mysqli_stmt_fetch($stmt)) {
                $result[] = [
                    'label' => $nome,
                    'value' => $nome,
                    'codigo' => $sku,
                    'preco' => $preco
                ];
            }
        }
        echo json_encode($result);
        mysqli_stmt_close($stmt);
    } else {
        echo json_encode([]);
    }
    mysqli_close($conexao);
} else {
    echo json_encode([]);
}
?>
