<?php
session_start();
if (!isset($_SESSION['id'])) {
    header("Location: login.php");
    exit();
}

require_once "../conexao.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nome = $_POST['nome'];
    $cpf = $_POST['cpf'];
    $cargo = $_POST['cargo'];
    $email = $_POST['email'];
    $telefone = $_POST['telefone'];
    $data_contratacao = $_POST['data_contratacao'];
    $salario = $_POST['salario'];

    $sql = "INSERT INTO funcionarios (nome, cpf, cargo, email, telefone, data_contratacao, salario) 
            VALUES ('$nome', '$cpf', '$cargo', '$email', '$telefone', '$data_contratacao', '$salario')";

    if (mysqli_query($conexao, $sql)) {
        header("Location: cadastro_funcionario.php?success=1");
        exit();
    } else {
        echo "Erro ao cadastrar o funcionário: " . mysqli_error($conexao);
    }
} else {
    echo "Método de requisição inválido.";
}
?>
