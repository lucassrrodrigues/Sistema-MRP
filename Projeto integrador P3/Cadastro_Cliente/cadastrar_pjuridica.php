<?php
session_start();

if (!isset($_SESSION['id'])) {
    header("Location: login.php");
    exit();
}

require_once "../conexao.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $razaoSocial = $_POST['razaoSocial'];
    $nomeFantasia = $_POST['nomeFantasia'];
    $cpfCnpj = $_POST['Cnpj'];
    $tipoPessoa = $_POST['tipoPessoa'];
    $inscricaoEstadual = $_POST['inscricaoEstadual'];
    $ieIsento = isset($_POST['ieIsento']) ? 1 : 0;
    $tipo = $_POST['tipo'];
    $rua = $_POST['rua'];
    $bairro = $_POST['bairro'];
    $numero = $_POST['numero'];
    $cidade = $_POST['cidade'];
    $uf = $_POST['uf'];
    $cep = $_POST['cep'];
    $complemento = $_POST['complemento'];
    $contato = $_POST['contato'];
    $fone = $_POST['fone'];
    $celular = $_POST['celular'];
    $email = $_POST['email'];
    $emailNfe = $_POST['emailNfe'];
    $website = $_POST['website'];

    // Verifica se o campo celular está vazio
    if (!empty($celular)) {
        // Se o celular não estiver vazio, define-o como telefone
        $telefone = $celular;
    } else {
        // Se o celular estiver vazio, define o telefone como o valor de fone
        $telefone = $fone;
    }

    // Insere os dados na tabela pessoa_juridica
    $sql_pessoa_juridica = "INSERT INTO pessoa_juridica (razao_social, nome_fantasia, cnpj, tipo_pessoa, inscricao_estadual, ie_isento, tipo, rua, bairro, numero, cidade, uf, cep, complemento, contato, fone, celular, email, email_nfe, website, id_cliente) 
                            VALUES ('$razaoSocial', '$nomeFantasia', '$cnpj', '$tipoPessoa', '$inscricaoEstadual', '$ieIsento', '$tipo', '$rua', '$bairro', '$numero', '$cidade', '$uf', '$cep', '$complemento', '$contato', '$fone', '$celular', '$email', '$emailNfe', '$website', '{$_SESSION['id']}')";

    // Insere os dados na tabela tabela_unica
    $sql_tabela_unica = "INSERT INTO tabela_cliente_fornecedor (Nome, `CPF/CNPJ`, Cidade, Telefone, Tipo)
                         VALUES ('$razaoSocial', '$cpfCnpj', '$cidade', '$telefone', '$tipo')";

    // Executa as consultas
    if (mysqli_query($conexao, $sql_pessoa_juridica) && mysqli_query($conexao, $sql_tabela_unica)) {
        header("Location: ../Cadastro_Cliente/cliente_fornecedor.php");
        exit();
    } else {
        echo "Erro ao cadastrar: " . mysqli_error($conexao);
    }

    mysqli_close($conexao);
}
?>
