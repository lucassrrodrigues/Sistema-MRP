<?php
session_start();
if (!isset($_SESSION['id'])) {
    header("Location: login.php");
    exit();
}

require_once "../conexao.php";

if (!isset($_GET['id_venda'])) {
    header("Location: Tela_Venda.php");
    exit();
}

$id_venda = $_GET['id_venda'];
$sql = "SELECT * FROM vendas WHERE id = $id_venda";
$resultado = mysqli_query($conexao, $sql);
$venda = mysqli_fetch_assoc($resultado);

if (!$venda) {
    header("Location: Tela_Venda.php");
    exit();
}

$id_usuario = $_SESSION['id'];
$sql_cliente = "SELECT caminho_imagem FROM clientes WHERE id = $id_usuario";
$resultado_cliente = mysqli_query($conexao, $sql_cliente);
$cliente = mysqli_fetch_assoc($resultado_cliente);
$logo_caminho = $cliente['caminho_imagem'];

$cliente_nome = $venda['cliente'];

// Verificar se o cliente está na tabela pessoa_fisica
$sql_pf = "SELECT nome AS nome_cliente, cpf AS cnpj, rua, numero, bairro, cidade, uf, cep, fone AS telefone FROM pessoa_fisica WHERE nome = ?";
$stmt_pf = mysqli_prepare($conexao, $sql_pf);
mysqli_stmt_bind_param($stmt_pf, 's', $cliente_nome);
mysqli_stmt_execute($stmt_pf);
$resultado_pf = mysqli_stmt_get_result($stmt_pf);
$cliente_detalhes = mysqli_fetch_assoc($resultado_pf);

// Se não encontrar na tabela pessoa_fisica, verificar na tabela pessoa_juridica
if (!$cliente_detalhes) {
    $sql_pj = "SELECT razao_social AS nome_cliente, cnpj, rua, numero, bairro, cidade, uf, cep, telefone FROM pessoa_juridica WHERE razao_social = ?";
    $stmt_pj = mysqli_prepare($conexao, $sql_pj);
    mysqli_stmt_bind_param($stmt_pj, 's', $cliente_nome);
    mysqli_stmt_execute($stmt_pj);
    $resultado_pj = mysqli_stmt_get_result($stmt_pj);
    $cliente_detalhes = mysqli_fetch_assoc($resultado_pj);
}

$sql_itens = "SELECT nome_item, codigo, quantidade, preco, desconto, preco_total FROM itens_venda WHERE venda_id = $id_venda";
$resultado_itens = mysqli_query($conexao, $sql_itens);
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>UpperPro - Visualizar Venda</title>
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
            <h1>Pedido de Venda N° <?php echo $venda['num_ped']; ?></h1>
        </div>

        <div class="details-table">
            <table class="table">
                <tr>
                    <th>Cliente</th>
                    <td>
                        <?php if ($cliente_detalhes) { ?>
                            <?php echo $cliente_detalhes['nome_cliente']; ?><br>
                            CNPJ: <?php echo $cliente_detalhes['cnpj']; ?><br>
                            Endereço: <?php echo $cliente_detalhes['rua'] . ', ' . $cliente_detalhes['numero'] . ' - ' . $cliente_detalhes['bairro'] . ', ' . $cliente_detalhes['cidade'] . ' - ' . $cliente_detalhes['uf'] . ' - CEP: ' . $cliente_detalhes['cep']; ?><br>
                            Telefone: <?php echo $cliente_detalhes['telefone']; ?>
                        <?php } else { ?>
                            Dados do cliente não encontrados.
                        <?php } ?>
                    </td>
                    <th>Número do pedido</th>
                    <td><?php echo $venda['num_ped']; ?></td>
                </tr>
                <tr>
                    <th>Data da Venda</th>
                    <td><?php echo $venda['data_venda']; ?></td>
                    <th>Data de Saída</th>
                    <td><?php echo $venda['data_saida']; ?></td>
                </tr>
                <tr>
                    <th>Data Prevista</th>
                    <td><?php echo $venda['data_prevista']; ?></td>
                </tr>
            </table>
        </div>

        <h3>Itens do pedido de venda</h3>
        <div class="items-table">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>Descrição do produto/serviço</th>
                        <th>Código</th>
                        <th>Qtde</th>
                        <th>Valor unitário</th>
                        <th>Desconto (%)</th>
                        <th>Valor total</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($item = mysqli_fetch_assoc($resultado_itens)) { ?>
                        <tr>
                            <td><?php echo $item['nome_item']; ?></td>
                            <td><?php echo $item['codigo']; ?></td>
                            <td><?php echo $item['quantidade']; ?></td>
                            <td><?php echo $item['preco']; ?></td>
                            <td><?php echo $item['desconto']; ?></td>
                            <td><?php echo $item['preco_total']; ?></td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>

        <div class="summary-table">
            <table class="table">
                <tr>
                    <th>N° de itens</th>
                    <td><?php echo $venda['num_itens']; ?></td>
                    <th>Soma das Qtde</th>
                    <td><?php echo $venda['soma_quantidades']; ?></td>
                </tr>
                <tr>
                    <th>Total de produtos</th>
                    <td><?php echo $venda['total_itens']; ?></td>
                    <th>Total do pedido</th>
                    <td colspan="3"><?php echo $venda['total_venda']; ?></td>
                </tr>
            </table>
        </div>

        <h3>Pagamento</h3>
        <div class="summary-table">
            <table class="table">
                <tr>
                    <th>Condições de pagamento</th>
                    <td><?php echo $venda['cond_pagamento']; ?></td>
                    <th>Categoria</th>
                    <td><?php echo $venda['categoria']; ?></td>
                </tr>
            </table>
        </div>

        <button class="btn btn-primary print-button" onclick="window.print()">Imprimir</button>
        <a href="Tela_Venda.php" class="btn btn-secondary back-button">Voltar</a>
    </div>
</body>

</html>
