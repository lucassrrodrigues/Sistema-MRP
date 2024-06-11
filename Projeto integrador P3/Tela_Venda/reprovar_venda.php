<?php
session_start();
if (!isset($_SESSION['id'])) {
    header("Location: login.php");
    exit();
}

require_once "../conexao.php";

if (isset($_GET['id_venda'])) {
    $id_venda = $_GET['id_venda'];
    $sql = "UPDATE vendas SET status_aprovacao = 'Reprovado' WHERE id = $id_venda";

    if (mysqli_query($conexao, $sql)) {
        header("Location: Tela_Venda.php");
        exit();
    } else {
        echo "Erro ao reprovar a venda: " . mysqli_error($conexao);
    }
} else {
    header("Location: Tela_Venda.php");
    exit();
}
?>
