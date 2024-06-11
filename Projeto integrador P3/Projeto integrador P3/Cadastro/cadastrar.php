<?php
require_once "conexao.php"; // Inclui o arquivo de conexão

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Recupera os dados do formulário
    $email = $_POST['email'];
    $senha = $_POST['senha'];
    $cnpj = $_POST['cnpj'];
    $razao_social = $_POST['razao_social'];
    $tamanho_empresa = $_POST['tamanho_empresa'];
    $segmento_empresa = $_POST['segmento_empresa'];
    $atividade_principal = $_POST['atividade_principal'];

    $senha_hash = password_hash($senha, PASSWORD_DEFAULT);

    // Prepara a consulta SQL para inserir os dados
    $sql = "INSERT INTO cadastro (email, senha, cnpj, razao_social, tamanho_empresa, segmento_empresa, atividade_principal)
            VALUES ('$email', '$senha', '$cnpj', '$razao_social', '$tamanho_empresa', '$segmento_empresa', '$atividade_principal')";

    // Executa a consulta
    if (mysqli_query($conexao, $sql)) {
        header("Location: ../Login/login.php");
        echo "<script>alert('Cadastro realizado com sucesso!');</script>";

    } else {
        echo "Erro ao cadastrar: " . mysqli_error($conexao);
    }

    // Fecha a conexão
    mysqli_close($conexao);
} else {
    echo "Método de requisição inválido!";
}
?>
