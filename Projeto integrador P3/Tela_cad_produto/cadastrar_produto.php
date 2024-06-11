<?php
session_start(); // Inicia a sessão

// Verifica se o ID do usuário está presente na sessão
if (!isset($_SESSION['id'])) {
    header("Location: login.php"); // Redireciona para a página de login se o ID do usuário não estiver presente na sessão
    exit();
}

require_once "../conexao.php";

// Verifica se o formulário foi submetido
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Recupera o ID do cliente da sessão
    $id_cliente = $_SESSION['id'];

    // Recupera os dados do formulário
    $nome = $_POST['nome'];
    $sku = $_POST['sku'];
    $preco = $_POST['preco'];
    $preco_compra = $_POST['preco_compra']; // Novo campo
    $unidade = $_POST['unidade'];
    $condicao = $_POST['condicao'];
    $quantidade_estoque = $_POST['quantidade_estoque']; // Recupera a quantidade em estoque

    // Processa o upload da imagem
    $uploadDir = '../produto_img/';
    $uploadFile = $uploadDir . 'produto_' . uniqid() . '_' . basename($_FILES['upload-file']['name']);

    if (move_uploaded_file($_FILES['upload-file']['tmp_name'], $uploadFile)) {
        // Insere os dados do produto no banco de dados, incluindo o ID do cliente, a quantidade em estoque e o caminho da imagem
        $sql = "INSERT INTO produtos (nome, sku, preco, preco_compra, unidade, condicao, quantidade_estoque, imagem, id_cliente) 
                VALUES ('$nome', '$sku', '$preco', '$preco_compra', '$unidade', '$condicao', '$quantidade_estoque', '$uploadFile', '$id_cliente')";
        if (mysqli_query($conexao, $sql)) {
            header("Location: ../Tela_estoque/estoque.php");
        } else {
            echo "Erro ao cadastrar o produto: " . mysqli_error($conexao);
        }
    } else {
        echo "Erro ao fazer upload da imagem.";
    }
}
?>
