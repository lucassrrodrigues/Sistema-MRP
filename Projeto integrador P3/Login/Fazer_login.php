<?php
require_once "../conexao.php";

// Recupera os valores do formulário
$email = $_POST['email'];
$senha = $_POST['senha'];

// Consulta SQL para verificar as credenciais
$sql = "SELECT id FROM clientes WHERE email='$email' AND senha='$senha'";
$resultado = mysqli_query($conexao, $sql);

// Verifica se o usuário foi encontrado
if (mysqli_num_rows($resultado) == 1) {
    // Usuário autenticado com sucesso
    $row = mysqli_fetch_assoc($resultado);
    $user_id = $row['id']; // Obtém o ID do usuário

    // Inicia a sessão e armazena o ID do usuário
    session_start();
    $_SESSION['id'] = $user_id;

    // Redireciona para a página de estoque
    header("Location: ../Tela_estoque/estoque.php");
    exit();
} else {
    // Credenciais inválidas
    header("Location: login.php?erro=1"); // Redirecionando de volta para a página de login com um erro
    exit();
}
?>
