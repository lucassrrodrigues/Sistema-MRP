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

$sql_itens = "SELECT * FROM itens_compra WHERE compra_id = $id_compra";
$resultado_itens = mysqli_query($conexao, $sql_itens);
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../styleHeader.css">
    <title>UpperPro - Editar Compra</title>
    <link rel="icon" href="../img/logo.png" type="image/png">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
    <style>
        .no-gutters {
            display: flex;
            align-items: center;
            margin-top: 10px;
            gap: 0px;
        }

        .no-gutters>.col,
        .no-gutters>[class*="col-"] {
            padding-right: 0;
            padding-left: 0;
        }

        .btn-adicionar {
            background-color: #58bffa00;
            border: 0;
            padding: 5px;
            border-radius: 6%;
            color: #58befa;
            margin-top: 1%;
            margin-left: 89%;
        }

        h1 {
            color: #58befa;
            padding: 3%;
        }

        .custom-container {
            width: 100000px;
            margin: 0 auto;
            margin-bottom: 3%;
        }

        .form-control:focus {
            border-color: #58befa;
            -webkit-box-shadow: none;
            box-shadow: none;
        }

        .form-select:focus {
            border-color: #58befa;
            -webkit-box-shadow: none;
            box-shadow: none;
        }

        .delete-item:hover {
            background-color: #c82333;
        }

        .delete-button-container {
            display: flex;
            align-items: center;
            justify-content: center;
            height: 100%;
        }

        .error-message {
            color: red;
            display: none;
            margin-bottom: 15px;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Editar Pedido de Compra</h1>
        <form id="forml" action="atualizar_compra.php" method="POST">
            <input type="hidden" name="id_compra" value="<?php echo $id_compra; ?>">
            <div class="form-group">
                <label for="num_ped">N° do Pedido</label>
                <input class="form-control" name="num_ped" type="text" id="num_ped" readonly value="<?php echo $compra['num_ped']; ?>">
            </div>
            <h3>Dados do fornecedor</h3>
            <div class="row">
                <div class="col-md-3">
                    <label for="fornecedor">Fornecedor</label>
                    <input class="form-control" name="fornecedor" type="text" id="fornecedor" size="20" value="<?php echo $compra['fornecedor']; ?>">
                </div>
                <div class="col-md-3">
                    <label for="comprador">Comprador</label>
                    <input class="form-control" name="comprador" type="text" id="comprador" size="20" value="<?php echo $compra['comprador']; ?>">
                </div>
            </div>
            <h3>Itens</h3>
            <div id="items-container">
                <?php while ($item = mysqli_fetch_assoc($resultado_itens)) { ?>
                <div class="row no-gutters item-row">
                    <div class="col-md-3">
                        <label>Nome do item</label>
                        <input class="form-control nome-item" name="nome_item[]" type="text" value="<?php echo $item['nome_item']; ?>">
                    </div>
                    <div class="col-md-2">
                        <label>Código</label>
                        <input class="form-control codigo" name="codigo[]" type="text" value="<?php echo $item['codigo']; ?>" readonly>
                    </div>
                    <div class="col-md-2">
                        <label>Quantidade</label>
                        <input class="form-control quantidade" name="quantidade[]" type="number" value="<?php echo $item['quantidade']; ?>">
                    </div>
                    <div class="col-md-2">
                        <label>Preço</label>
                        <input class="form-control preco" name="preco[]" type="text" value="<?php echo $item['preco']; ?>" readonly>
                    </div>
                    <div class="col-md-1">
                        <label>Desconto(%)</label>
                        <input class="form-control desconto" name="desconto[]" type="number" value="<?php echo $item['desconto']; ?>">
                    </div>
                    <div class="col-md-1">
                        <label>Preço Total</label>
                        <input class="form-control preco-total" name="preco_total[]" type="text" readonly value="<?php echo $item['preco_total']; ?>">
                    </div>
                    <div class="col-md-1">
                        <button type="button" class="btn btn-danger delete-item">Deletar</button>
                    </div>
                </div>
                <?php } ?>
            </div>
            <button type="button" class="btn btn-adicionar">Adicionar Item</button>

            <h3>Totais</h3>
            <div class="row">
                <div class="col-md-4">
                    <label for="num_itens">N° de Itens</label>
                    <input class="form-control" name="num_itens" type="text" id="num_itens" size="20" readonly value="<?php echo $compra['num_itens']; ?>">
                </div>
                <div class="col-md-4">
                    <label for="soma_quantidades">Soma das quantidades</label>
                    <input class="form-control" name="soma_quantidades" type="text" id="soma_quantidades" size="20" readonly value="<?php echo $compra['soma_quantidades']; ?>">
                </div>
                <div class="col-md-4">
                    <label for="desconto_total_itens">Desconto total dos itens</label>
                    <input class="form-control" name="desconto_total_itens" type="text" id="desconto_total_itens" size="20" readonly value="<?php echo $compra['desconto_total_itens']; ?>">
                </div>
            </div>
            <div class="row">
                <div class="col-md-4">
                    <label for="total_itens">Total dos itens</label>
                    <input class="form-control" name="total_itens" type="text" id="total_itens" size="20" readonly value="<?php echo $compra['total_itens']; ?>">
                </div>
                <div class="col-md-4">
                    <label for="desc_total_compra">Desconto total da compra</label>
                    <input class="form-control" name="desc_total_compra" type="text" id="desc_total_compra" size="20" readonly value="<?php echo $compra['desconto_total_compra']; ?>">
                </div>
                <div class="col-md-4">
                    <label for="total_compra">Total da compra</label>
                    <input class="form-control" name="total_compra" type="text" id="total_compra" size="20" readonly value="<?php echo $compra['total_compra']; ?>">
                </div>
            </div>

            <h3>Pagamento</h3>
            <div class="row">
                <div class="col-md-3">
                    <label for="cond_pagamento">Condições de pagamento</label>
                    <input class="form-control" name="cond_pagamento" type="text" id="cond_pagamento" size="65" value="<?php echo $compra['cond_pagamento']; ?>">
                </div>
                <div class="col-md-3">
                    <label for="categoria">Categoria</label>
                    <input class="form-control" name="categoria" type="text" id="categoria" size="50" value="<?php echo $compra['categoria']; ?>">
                </div>
            </div>

            <h3>Detalhes da compra</h3>
            <div class="row">
                <div class="col-md-3">
                    <label for="data_compra">Data da compra</label>
                    <input class="form-control" name="data_compra" type="date" id="data_compra" size="20" value="<?php echo $compra['data_compra']; ?>">
                </div>
                <div class="col-md-3">
                    <label for="data_recebimento">Data de Recebimento</label>
                    <input class="form-control" name="data_recebimento" type="date" id="data_recebimento" size="20" value="<?php echo $compra['data_recebimento']; ?>">
                </div>
                <div class="col-md-3">
                    <label for="data_prevista">Data prevista</label>
                    <input class="form-control" name="data_prevista" type="date" id="data_prevista" size="20" value="<?php echo $compra['data_prevista']; ?>">
                </div>
            </div>

            <button type="submit" class="btn btn-primary">Salvar</button>
        </form>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/inputmask@5.0.7-beta.19/dist/jquery.inputmask.min.js"></script>
    <script>
        $(document).ready(function () {
            // Função para aplicar a máscara de moeda
            function aplicarMascara() {
                $('.preco, #valor_frete').inputmask('currency', { prefix: 'R$ ', rightAlign: false });
            }

            // Aplicar máscara aos campos de preço já existentes
            aplicarMascara();

            // Adicionar nova linha de item
            $('.btn-adicionar').click(function () {
                const novaLinha = `
                <div class="row no-gutters item-row">
                    <div class="col-md-3">
                        <input class="form-control nome-item" name="nome_item[]" type="text">
                    </div>
                    <div class="col-md-2">
                        <input class="form-control codigo" name="codigo[]" type="text" readonly>
                    </div>
                    <div class="col-md-2">
                        <input class="form-control quantidade" name="quantidade[]" type="number">
                    </div>
                    <div class="col-md-2">
                        <input class="form-control preco" name="preco[]" type="text" readonly>
                    </div>
                    <div class="col-md-1">
                        <input class="form-control desconto" name="desconto[]" type="number">
                    </div>
                    <div class="col-md-1">
                        <input class="form-control preco-total" name="preco_total[]" type="text" readonly>
                    </div>
                    <div class="col-md-1">
                        <button type="button" class="btn btn-danger delete-item">Deletar</button>
                    </div>
                </div>
                `;
                $('#items-container').append(novaLinha);
                aplicarMascara(); // Reaplicar a máscara aos novos campos
                atualizarTotais(); // Atualizar totais quando um novo item é adicionado
            });

            // Deletar linha de item
            $('#items-container').on('click', '.delete-item', function () {
                $(this).closest('.item-row').remove();
                atualizarTotais(); // Atualizar totais quando um item é deletado
            });

            // Função para calcular o preço total com base no preço, quantidade e desconto
            function calcularPrecoTotal(row) {
                const preco = parseFloat(row.find('.preco').inputmask('unmaskedvalue')) || 0;
                const quantidade = parseFloat(row.find('.quantidade').val()) || 0;
                const desconto = parseFloat(row.find('.desconto').val()) || 0;

                let precoTotal = preco * quantidade;
                if (desconto > 0) {
                    precoTotal -= precoTotal * (desconto / 100);
                }

                row.find('.preco-total').val(`R$ ${precoTotal.toFixed(2)}`);
                atualizarTotais(); // Atualizar totais sempre que o preço total for recalculado
            }

            // Atualizar o preço total ao alterar os campos
            $('#items-container').on('input', '.preco, .quantidade, .desconto', function () {
                const row = $(this).closest('.item-row');
                calcularPrecoTotal(row);
            });

            // Atualizar o preço total ao sair do campo de preço
            $('#items-container').on('blur', '.preco', function () {
                const row = $(this).closest('.item-row');
                calcularPrecoTotal(row);
            });

            // Função para atualizar os totais
            function atualizarTotais() {
                let totalItens = 0;
                let somaQuantidades = 0;
                let descontoTotalItens = 0;
                let totalItensDescontados = 0;

                $('.item-row').each(function () {
                    const quantidade = parseFloat($(this).find('.quantidade').val()) || 0;
                    const precoTotal = parseFloat($(this).find('.preco-total').inputmask('unmaskedvalue')) || 0;
                    const desconto = parseFloat($(this).find('.desconto').val()) || 0;
                    const preco = parseFloat($(this).find('.preco').inputmask('unmaskedvalue')) || 0;

                    totalItens += 1;
                    somaQuantidades += quantidade;
                    descontoTotalItens += (preco * quantidade * (desconto / 100));
                    totalItensDescontados += precoTotal;
                });

                const valorFrete = parseFloat($('#valor_frete').inputmask('unmaskedvalue')) || 0;

                $('#num_itens').val(totalItens);
                $('#soma_quantidades').val(somaQuantidades);
                $('#desconto_total_itens').val(`R$ ${descontoTotalItens.toFixed(2)}`);
                $('#total_itens').val(`R$ ${totalItensDescontados.toFixed(2)}`);
                $('#total_compra').val(`R$ ${(totalItensDescontados + valorFrete).toFixed(2)}`);
                $('#desc_total_compra').val(`R$ ${descontoTotalItens.toFixed(2)}`);
            }

            // Atualizar totais quando o valor do frete é alterado
            $('#valor_frete').on('input', function () {
                atualizarTotais();
            });

            // Autocomplete de nome do item
            $('#items-container').on('input', '.nome-item', function () {
                const nomeItem = $(this).val();
                const row = $(this).closest('.item-row');
                if (nomeItem.length > 2) {
                    $.ajax({
                        url: 'buscar_produto.php',
                        method: 'GET',
                        data: { nome: nomeItem },
                        success: function (response) {
                            const produto = JSON.parse(response);
                            if (produto) {
                                row.find('.codigo').val(produto.codigo);
                                row.find('.preco').val(produto.preco);
                                calcularPrecoTotal(row); // Recalcular o preço total ao atualizar os campos
                            }
                        }
                    });
                }
            });
        });
    </script>
</body>
</html>
