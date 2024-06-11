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

$sql_itens = "SELECT * FROM itens_venda WHERE venda_id = $id_venda";
$resultado_itens = mysqli_query($conexao, $sql_itens);
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>UpperPro - Editar Pedido de Venda</title>
    <link rel="icon" href="../img/logo.png" type="image/png">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
    <style>
    .no-gutters {
      display: flex;
      align-items: center;
      gap: 0px;
    }

    .no-gutters>.col,
    .no-gutters>[class*="col-"] {
      padding-right: 0;
      padding-left: 0;
    }
    .no-gutters .btn{
      margin-top: 24px;
      margin-left: 20px;
    }
    .btn-adicionar{
      background-color: #58bffa00;
      border: 0;
      padding: 5px;
      border-radius: 6%;
      color: #58befa;
      margin-left: 89%;
    }
    h1{
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
    .btn-primary{
        margin-top: 5%;
        margin-bottom: 5%;
    }
    </style>
</head>
<body>
    <div class="container">
        <h1>Editar Pedido de Venda</h1>
        <form id="forml" action="atualizar_venda.php" method="POST">
            <input type="hidden" name="id_venda" value="<?php echo $id_venda; ?>">
            <div class="form-group">
                <label for="num_ped">N° do Pedido</label>
                <input class="form-control" name="num_ped" type="text" id="num_ped" readonly value="<?php echo $venda['num_ped']; ?>">
            </div>
            <h3>Dados do cliente</h3>
            <div class="row">
                <div class="col-md-3">
                    <label for="cliente">Cliente</label>
                    <input class="form-control" name="cliente" type="text" id="cliente" size="20" value="<?php echo $venda['cliente']; ?>">
                </div>
                <div class="col-md-3">
                    <label for="vendedor">Vendedor</label>
                    <input class="form-control" name="vendedor" type="text" id="vendedor" size="20" value="<?php echo $venda['vendedor']; ?>">
                </div>
            </div>
            <h3>Itens</h3>
            <div id="items-container">
                <?php while ($item = mysqli_fetch_assoc($resultado_itens)) { ?>
                <div class="row no-gutters item-row">
                    <div class="col-md-3">
                        <label>Nome do item</label>
                        <input class="form-control" name="nome_item[]" type="text" value="<?php echo $item['nome_item']; ?>">
                    </div>
                    <div class="col-md-2">
                        <label>Código</label>
                        <input class="form-control" name="codigo[]" type="text" value="<?php echo $item['codigo']; ?>">
                    </div>
                    <div class="col-md-2">
                        <label>Quantidade</label>
                        <input class="form-control quantidade" name="quantidade[]" type="number" value="<?php echo $item['quantidade']; ?>">
                    </div>
                    <div class="col-md-2">
                        <label>Preço</label>
                        <input class="form-control preco" name="preco[]" type="text" value="<?php echo $item['preco']; ?>">
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

            <h3>Transportador</h3>
            <div class="row">
                <div class="col-md-3">
                    <label for="frete_por_conta">Frete por conta</label>
                    <input class="form-control" name="frete_por_conta" type="text" id="frete_por_conta" size="40" value="<?php echo $venda['frete_por_conta']; ?>">
                </div>
                <div class="col-md-3">
                    <label for="largura">Largura</label>
                    <input class="form-control" name="largura" type="text" id="largura" size="40" value="<?php echo $venda['largura']; ?>">
                </div>
                <div class="col-md-3">
                    <label for="comprimento">Comprimento</label>
                    <input class="form-control" name="comprimento" type="text" id="comprimento" size="20" value="<?php echo $venda['comprimento']; ?>">
                </div>
                <div class="col-md-3">
                    <label for="altura">Altura</label>
                    <input class="form-control" name="altura" type="text" id="altura" size="20" value="<?php echo $venda['altura']; ?>">
                </div>
            </div>
            <div class="row">
                <div class="col-md-3">
                    <label for="peso">Peso</label>
                    <input class="form-control" name="peso" type="text" id="peso" size="20" value="<?php echo $venda['peso']; ?>">
                </div>
                <div class="col-md-3">
                    <label for="prazo_entrega">Prazo de entrega</label>
                    <input class="form-control" name="prazo_entrega" type="date" id="prazo_entrega" size="20" value="<?php echo $venda['prazo_entrega']; ?>">
                </div>
                <div class="col-md-3">
                    <label for="valor_frete">Valor do Frete</label>
                    <input class="form-control" name="valor_frete" type="text" id="valor_frete" size="20" value="<?php echo $venda['valor_frete']; ?>">
                </div>
            </div>

            <h3>Totais</h3>
            <div class="row">
                <div class="col-md-4">
                    <label for="num_itens">N° de Itens</label>
                    <input class="form-control" name="num_itens" type="text" id="num_itens" size="20" readonly value="<?php echo $venda['num_itens']; ?>">
                </div>
                <div class="col-md-4">
                    <label for="soma_quantidades">Soma das quantidades</label>
                    <input class="form-control" name="soma_quantidades" type="text" id="soma_quantidades" size="20" readonly value="<?php echo $venda['soma_quantidades']; ?>">
                </div>
                <div class="col-md-4">
                    <label for="desconto_total_itens">Desconto total dos itens</label>
                    <input class="form-control" name="desconto_total_itens" type="text" id="desconto_total_itens" size="20" readonly value="<?php echo $venda['desconto_total_itens']; ?>">
                </div>
            </div>
            <div class="row">
                <div class="col-md-4">
                    <label for="total_itens">Total dos itens</label>
                    <input class="form-control" name="total_itens" type="text" id="total_itens" size="20" readonly value="<?php echo $venda['total_itens']; ?>">
                </div>
                <div class="col-md-4">
                    <label for="desc_total_venda">Desconto total da venda</label>
                    <input class="form-control" name="desc_total_venda" type="text" id="desc_total_venda" size="20" readonly value="<?php echo $venda['desconto_total_venda']; ?>">
                </div>
                <div class="col-md-4">
                    <label for="total_venda">Total da venda</label>
                    <input class="form-control" name="total_venda" type="text" id="total_venda" size="20" readonly value="<?php echo $venda['total_venda']; ?>">
                </div>
            </div>

            <h3>Pagamento</h3>
            <div class="row">
                <div class="col-md-3">
                    <label for="cond_pagamento">Condições de pagamento</label>
                    <input class="form-control" name="cond_pagamento" type="text" id="cond_pagamento" size="65" value="<?php echo $venda['cond_pagamento']; ?>">
                </div>
                <div class="col-md-3">
                    <label for="categoria">Categoria</label>
                    <input class="form-control" name="categoria" type="text" id="categoria" size="50" value="<?php echo $venda['categoria']; ?>">
                </div>
            </div>

            <h3>Detalhes da venda</h3>
            <div class="row">
                <div class="col-md-3">
                    <label for="data_venda">Data da venda</label>
                    <input class="form-control" name="data_venda" type="date" id="data_venda" size="20" value="<?php echo $venda['data_venda']; ?>">
                </div>
                <div class="col-md-3">
                    <label for="data_saida">Data Saída</label>
                    <input class="form-control" name="data_saida" type="date" id="data_saida" size="20" value="<?php echo $venda['data_saida']; ?>">
                </div>
                <div class="col-md-3">
                    <label for="data_prevista">Data prevista</label>
                    <input class="form-control" name="data_prevista" type="date" id="data_prevista" size="20" value="<?php echo $venda['data_prevista']; ?>">
                </div>
            </div>

            <button type="submit" class="btn btn-primary">Salvar</button>
            <a href="Tela_Venda.php" class="btn btn-secondary back-button">Voltar</a>
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
                        <input class="form-control" name="nome_item[]" type="text">
                    </div>
                    <div class="col-md-2">
                        <input class="form-control" name="codigo[]" type="text">
                    </div>
                    <div class="col-md-2">
                        <input class="form-control quantidade" name="quantidade[]" type="number">
                    </div>
                    <div class="col-md-2">
                        <input class="form-control preco" name="preco[]" type="text">
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
                $('#total_venda').val(`R$ ${(totalItensDescontados + valorFrete).toFixed(2)}`);
                $('#desc_total_venda').val(`R$ ${descontoTotalItens.toFixed(2)}`);
            }

            // Atualizar totais quando o valor do frete é alterado
            $('#valor_frete').on('input', function () {
                atualizarTotais();
            });
        });
    </script>
</body>
</html>
