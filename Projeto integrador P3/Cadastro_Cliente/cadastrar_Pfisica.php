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
    $rg = $_POST['rg'];
    $orgaoEmissor = $_POST['orgaoEmissor'];
    $tipo = $_POST['tipo'];
    $rua = $_POST['rua'];
    $bairro = $_POST['bairro'];
    $numero = $_POST['numero'];
    $cidade = $_POST['cidade'];
    $uf = $_POST['uf'];
    $cep = $_POST['cep'];
    $complemento = $_POST['complemento'];
    $fone = $_POST['fone'];
    $celular = $_POST['celular'];
    $email = $_POST['email'];
    $banco = $_POST['banco'];
    $agencia = $_POST['agencia'];
    $conta = $_POST['conta'];
    $observacoes = $_POST['observacoes'];

    // Verifica se o campo celular está vazio
    if (!empty($celular)) {
        // Se o celular não estiver vazio, define-o como telefone
        $telefone = $celular;
    } else {
        // Se o celular estiver vazio, define o telefone como o valor de fone
        $telefone = $fone;
    }

    // Insere os dados na tabela pessoa_fisica
    $sql_pessoa_fisica = "INSERT INTO pessoa_fisica (nome, cpf, rg, orgao_emissor, tipo, rua, bairro, numero, cidade, uf, cep, complemento, fone, celular, email, banco, agencia, conta, observacoes, id_cliente) 
                          VALUES ('$nome', '$cpf', '$rg', '$orgaoEmissor', '$tipo', '$rua', '$bairro', '$numero', '$cidade', '$uf', '$cep', '$complemento', '$fone', '$celular', '$email', '$banco', '$agencia', '$conta', '$observacoes', '{$_SESSION['id']}')";
    
    // Insere os dados na tabela tabela_unica
    $sql_tabela_unica = "INSERT INTO tabela_cliente_fornecedor (Nome, `CPF/CNPJ`, Cidade, Telefone, Tipo)
                         VALUES ('$nome', '$cpf', '$cidade', '$telefone', '$tipo')";

    // Executa as consultas
    if (mysqli_query($conexao, $sql_pessoa_fisica) && mysqli_query($conexao, $sql_tabela_unica)) {
        header("Location: ../Cadastro_Cliente/cliente_fornecedor.php");
        exit();
    } else {
        echo "Erro ao cadastrar: " . mysqli_error($conexao);
    }

    mysqli_close($conexao);
}
?>
