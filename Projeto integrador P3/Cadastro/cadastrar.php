<?php
require_once "../conexao.php"; // Inclui o arquivo de conexão

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Recupera os dados do formulário
    $email = $_POST['email'];
    $senha = $_POST['senha'];
    $cnpj = $_POST['cnpj'];
    $razao_social = $_POST['razao_social'];
    $rua = $_POST['rua'];
    $bairro = $_POST['bairro'];
    $cidade = $_POST['cidade'];
    $uf = $_POST['uf'];
    $cep = $_POST['cep'];
    $tamanho_empresa = $_POST['tamanho_empresa'];
    $segmento_empresa = $_POST['segmento_empresa'];
    $atividade_principal = $_POST['atividade_principal'];

    $senha_hash = password_hash($senha, PASSWORD_DEFAULT);

    // Prepara a consulta SQL para inserir os dados (usando declaração preparada)
    $stmt = $conexao->prepare("INSERT INTO clientes (email, senha, cnpj, razao_social, rua, bairro, cidade, uf, cep, tamanho_empresa, segmento_empresa, atividade_principal) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("ssssssssssss", $email, $senha_hash, $cnpj, $razao_social, $rua, $bairro, $cidade, $uf, $cep, $tamanho_empresa, $segmento_empresa, $atividade_principal);

    // Executa a consulta
    if ($stmt->execute()) {
        header("Location: ../Login/login.php");
        exit; // Termina o script após redirecionar
    } else {
        echo "Erro ao cadastrar: " . $conexao->error;
    }

    // Fecha a consulta preparada
    $stmt->close();
    // Fecha a conexão
    $conexao->close();
} else {
    echo "Método de requisição inválido!";
}
?>
