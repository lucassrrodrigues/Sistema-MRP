<?php
session_start();

if (!isset($_SESSION['id'])) {
    header("Location: login.php");
    exit();
}

require_once "../conexao.php";

if (!isset($_POST['id']) || !is_numeric($_POST['id'])) {
    header("Location: estoque.php");
    exit();
}

$id_produto = $_POST['id'];

$id_cliente = $_SESSION['id'];
$sql_verifica_produto = "SELECT * FROM produtos WHERE id = '$id_produto' AND id_cliente = '$id_cliente'";
$result_verifica_produto = mysqli_query($conexao, $sql_verifica_produto);

if (mysqli_num_rows($result_verifica_produto) != 1) {
    header("Location: estoque.php"); 
    exit();
}

$sql_move = "INSERT INTO historico_produtos (nome, sku, preco, preco_compra, unidade, condicao, quantidade_estoque, imagem, id_cliente)
             SELECT nome, sku, preco, preco_compra, unidade, condicao, quantidade_estoque, imagem, id_cliente
             FROM produtos
             WHERE id = '$id_produto'";
mysqli_query($conexao, $sql_move);

$sql_delete = "DELETE FROM produtos WHERE id = '$id_produto'";
mysqli_query($conexao, $sql_delete);

header("Location: estoque.php");
exit();
?>
