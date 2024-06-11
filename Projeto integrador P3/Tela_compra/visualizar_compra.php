<?php
session_start();
if (!isset($_SESSION['id'])) {
    header("Location: login.php");
    exit();
}

require_once "../conexao.php";

if (!isset($_GET['id_compra'])) {
    header("Location: Tela_compra.php");
    exit();
}

$id_compra = $_GET['id_compra'];
$sql = "SELECT * FROM compras WHERE id = $id_compra";
$resultado = mysqli_query($conexao, $sql);
$compra = mysqli_fetch_assoc($resultado);

if (!$compra) {
    header("Location: Tela_compra.php");
    exit();
}

$id_usuario = $_SESSION['id'];
$sql_cliente = "SELECT caminho_imagem FROM clientes WHERE id = $id_usuario";
$resultado_cliente = mysqli_query($conexao, $sql_cliente);
$cliente = mysqli_fetch_assoc($resultado_cliente);
$logo_caminho = $cliente['caminho_imagem'];

$fornecedor_nome = $compra['fornecedor'];

// Verificar se o fornecedor está na tabela pessoa_fisica
$sql_pf = "SELECT nome AS razao_social, cpf AS cnpj, rua, numero, bairro, cidade, uf, cep, fone AS telefone FROM pessoa_fisica WHERE nome = ?";
$stmt_pf = mysqli_prepare($conexao, $sql_pf);
mysqli_stmt_bind_param($stmt_pf, 's', $fornecedor_nome);
mysqli_stmt_execute($stmt_pf);
$resultado_pf = mysqli_stmt_get_result($stmt_pf);
$fornecedor = mysqli_fetch_assoc($resultado_pf);

// Se não encontrar na tabela pessoa_fisica, verificar na tabela pessoa_juridica
if (!$fornecedor) {
    $sql_pj = "SELECT razao_social, cnpj, rua, numero, bairro, cidade, uf, cep, telefone FROM pessoa_juridica WHERE razao_social = ?";
    $stmt_pj = mysqli_prepare($conexao, $sql_pj);
    mysqli_stmt_bind_param($stmt_pj, 's', $fornecedor_nome);
    mysqli_stmt_execute($stmt_pj);
    $resultado_pj = mysqli_stmt_get_result($stmt_pj);
    $fornecedor = mysqli_fetch_assoc($resultado_pj);
}

$sql_itens = "SELECT nome_item, codigo, quantidade, preco_total AS valor_total FROM itens_compra WHERE compra_id = $id_compra";
$resultado_itens = mysqli_query($conexao, $sql_itens);
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>UpperPro - Visualizar Compra</title>
    <link rel="icon" href="../img/logo.png" type="image/png">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
    <style>
        @media print {
            .print-button, .back-button {
                display: none;
            }
        }
        .logo {
            width: 150px;
            height: auto;
            margin-bottom: 20px;
        }
        .header, .footer {
            text-align: center;
        }
        .details-table, .items-table, .summary-table {
            width: 100%;
            margin-bottom: 20px;
        }
        .details-table th, .details-table td, .items-table th, .items-table td, .summary-table th, .summary-table td {
            border: 1px solid #ddd;
            padding: 8px;
        }
        .details-table th, .items-table th, .summary-table th {
            background-color: #f2f2f2;
            text-align: left;
        }
        .details-table td {
            vertical-align: top;
        }
    </style>
</head>

<body>
    <div class="container mt-4">
        <div class="header">
            <?php if ($logo_caminho) { ?>
                <img src="<?php echo $logo_caminho; ?>" alt="Logo da Empresa" class="logo">
            <?php } ?>
            <h1>Pedido de Compra N° <?php echo $compra['num_ped']; ?></h1>
        </div>

        <div class="details-table">
            <table class="table">
                <tr>
                    <th>Fornecedor</th>
                    <td>
                        <?php if ($fornecedor) { ?>
                            <?php echo $fornecedor['razao_social']; ?><br>
                            CNPJ: <?php echo $fornecedor['cnpj']; ?><br>
                            Endereço: <?php echo $fornecedor['rua'] . ', ' . $fornecedor['numero'] . ' - ' . $fornecedor['bairro'] . ', ' . $fornecedor['cidade'] . ' - ' . $fornecedor['uf'] . ' - CEP: ' . $fornecedor['cep']; ?><br>
                            Telefone: <?php echo $fornecedor['telefone']; ?>
                        <?php } else { ?>
                            Dados do fornecedor não encontrados.
                        <?php } ?>
                    </td>
                    <th>Número do pedido</th>
                    <td><?php echo $compra['num_ped']; ?></td>
                </tr>
                <tr>
                    <th>Data</th>
                    <td><?php echo $compra['data_compra']; ?></td>
                    <th>Data prevista</th>
                    <td><?php echo $compra['data_prevista']; ?></td>
                </tr>
            </table>
        </div>

        <h3>Itens do pedido de compra</h3>
        <div class="items-table">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>Descrição do produto/serviço</th>
                        <th>Código</th>
                        <th>Qtde</th>
                        <th>Valor unitário</th>
                        <th>Valor total</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($item = mysqli_fetch_assoc($resultado_itens)) {
                        // Buscar o valor unitário do produto na tabela produtos
                        $nome_item = $item['nome_item'];
                        $sql_produto = "SELECT preco FROM produtos WHERE nome = '$nome_item'";
                        $resultado_produto = mysqli_query($conexao, $sql_produto);
                        $produto = mysqli_fetch_assoc($resultado_produto);
                        $valor_unitario = $produto['preco'];
                    ?>
                        <tr>
                            <td><?php echo $item['nome_item']; ?></td>
                            <td><?php echo $item['codigo']; ?></td>
                            <td><?php echo $item['quantidade']; ?></td>
                            <td><?php echo $valor_unitario; ?></td>
                            <td><?php echo $item['valor_total']; ?></td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>

        <div class="summary-table">
            <table class="table">
                <tr>
                    <th>N° de itens</th>
                    <td><?php echo $compra['num_itens']; ?></td>
                    <th>Soma das Qtde</th>
                    <td><?php echo $compra['soma_quantidades']; ?></td>
                </tr>
                <tr>
                    <th>Total de produtos</th>
                    <td><?php echo $compra['total_itens']; ?></td>
                    <th>Total do pedido</th>
                    <td colspan="3"><?php echo $compra['total_compra']; ?></td>
                </tr>
            </table>
        </div>

        <h3>Pagamento</h3>
        <div class="summary-table">
            <table class="table">
                <tr>
                    <th>Condições de pagamento</th>
                    <td><?php echo $compra['cond_pagamento']; ?></td>
                    <th>Categoria</th>
                    <td><?php echo $compra['categoria']; ?></td>
                </tr>
            </table>
        </div>

        <h3>Observações</h3>
        <p><?php echo $compra['observacoes']; ?></p>

        <button class="btn btn-primary print-button" onclick="window.print()">Imprimir</button>
        <a href="Tela_compra.php" class="btn btn-secondary back-button">Voltar</a>
    </div>
</body>

</html>
