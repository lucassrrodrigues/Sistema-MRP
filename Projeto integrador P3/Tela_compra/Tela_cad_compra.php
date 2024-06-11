<?php
session_start();
if (!isset($_SESSION['id'])) {
    header("Location: login.php");
    exit();
}

require_once "../conexao.php";

$sql = "SELECT MAX(num_ped) AS ultimo_pedido FROM compras";
$resultado = mysqli_query($conexao, $sql);
$row = mysqli_fetch_assoc($resultado);
$ultimo_pedido = $row['ultimo_pedido'];

$prox_num_ped = ($ultimo_pedido === null) ? 1 : $ultimo_pedido + 1;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (empty($_POST['fornecedor']) || empty($_POST['comprador']) || empty($_POST['nome_item'][0])) {
        echo "Preencha todos os campos obrigatórios.";
        exit();
    }

    $id_usuario = $_SESSION['id'];
    $fornecedor = $_POST['fornecedor'];
    $comprador = $_POST['comprador'];
    $cond_pagamento = $_POST['cond_pagamento'];
    $categoria = $_POST['categoria'];
    $data_compra = $_POST['data_compra'];
    $data_recebimento = $_POST['data_recebimento'];
    $data_prevista = $_POST['data_prevista'];
    $num_itens = $_POST['num_itens'];
    $soma_quantidades = $_POST['soma_quantidades'];
    $desconto_total_itens = $_POST['desconto_total_itens'];
    $total_itens = $_POST['total_itens'];
    $desconto_total_compra = $_POST['desc_total_compra'];
    $total_compra = $_POST['total_compra'];

    $sql = "INSERT INTO compras (num_ped, fornecedor, comprador, cond_pagamento, categoria, data_compra, data_recebimento, data_prevista, id_usuario, num_itens, soma_quantidades, desconto_total_itens, total_itens, desconto_total_compra, total_compra) 
            VALUES ('$prox_num_ped', '$fornecedor', '$comprador', '$cond_pagamento', '$categoria', '$data_compra', '$data_recebimento', '$data_prevista', '$id_usuario', '$num_itens', '$soma_quantidades', '$desconto_total_itens', '$total_itens', '$desconto_total_compra', '$total_compra')";

    if (mysqli_query($conexao, $sql)) {
        $compra_id = mysqli_insert_id($conexao);

        foreach ($_POST['nome_item'] as $index => $nome_item) {
            $codigo = $_POST['codigo'][$index];
            $quantidade = $_POST['quantidade'][$index];
            $preco = $_POST['preco'][$index];
            $desconto = $_POST['desconto'][$index];
            $preco_total = $_POST['preco_total'][$index];

            $sql_item = "INSERT INTO itens_compra (compra_id, nome_item, codigo, quantidade, preco, desconto, preco_total) 
                         VALUES ('$compra_id', '$nome_item', '$codigo', '$quantidade', '$preco', '$desconto', '$preco_total')";

            if (!mysqli_query($conexao, $sql_item)) {
                echo "Erro ao cadastrar item: " . mysqli_error($conexao);
                exit();
            }
        }

        header("Location: Tela_compra.php");
        exit();
    } else {
        echo "Erro ao cadastrar a compra: " . mysqli_error($conexao);
    }
}

// Buscar fornecedores
$fornecedores_sql = "SELECT `Nome`, `CPF/CNPJ` FROM tabela_cliente_fornecedor WHERE `Tipo` = 'fornecedor'";
$fornecedores_result = mysqli_query($conexao, $fornecedores_sql);
$fornecedores_options = '';
while ($fornecedor = mysqli_fetch_assoc($fornecedores_result)) {
    $fornecedores_options .= '<option value="' . $fornecedor['Nome'] . '">' . $fornecedor['Nome'] . '</option>';
}
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
    <link rel="stylesheet" href="../styleHeader.css">
    <title>UpperPro - Cadastro de Compra</title>
    <link rel="icon" href="../img/logo.png" type="image/png">
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
        .error-message {
            color: red;
            display: none;
            margin-bottom: 15px;
        }
        .btn-primary{
            margin-top: 5%;
            margin-bottom: 5%;
        }
    </style>
    <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
</head>

<body>
    <header>
        <img src="../img/logo.png" alt="logo">
        <nav>
            <div class="dropdown">
                <button class="dropbtn">Cadastros</button>
                <div class="dropdown-content">
                    <a class="dropdown-start" href="../Cadastro_Cliente/cliente_fornecedor.php">Cliente e Fornecedor Pessoa Fisica</a>
                </div>
            </div>
            <div class="dropdown">
                <button class="dropbtn">Suprimentos</button>
                <div class="dropdown-content">
                    <a class="dropdown-start" href="../Tela_compra/Tela_compra.php">Pedidos de Compra</a>
                    <a class="dropdown-meio" href="../Tela_estoque/estoque.php">Estoque</a>
                    <a class="dropdown-end" href="#">Relatorio</a>
                </div>
            </div>
            <div class="dropdown">
                <button class="dropbtn">Vendas</button>
                <div class="dropdown-content">
                    <a class="dropdown-start" href="../Tela_Venda/Tela_Venda.php">Pedidos de Venda</a>
                    <a class="dropdown-meio" href="#">Frente de Caixa</a>
                    <a class="dropdown-end" href="#">Relatorio</a>
                </div>
            </div>
        </nav>
        <div>
            <button id="perfilBtn"><img class="perfil" src="../img/perfil.png" alt="Perfil"></button>
            <button id="logoutBtn"><img class="perfil" src="../img/sair.png" alt="Sair"></button>
        </div>
    </header>
    <div class="container">
        <h1>Cadastro de Pedido de Compra</h1>
        <form id="forml" action="Tela_cad_compra.php" method="POST" onsubmit="return validarFormulario();">
            <div class="error-message" id="erro-fornecedor">O campo fornecedor é obrigatório.</div>
            <div class="error-message" id="erro-comprador">O campo comprador é obrigatório.</div>
            <div class="error-message" id="erro-itens">Adicione ao menos um item.</div>
            <div class="form-group">
                <label for="num_ped">N° do Pedido</label>
                <input class="form-control" name="num_ped" type="text" id="num_ped" readonly value="<?php echo $prox_num_ped; ?>">
            </div>
            <h3>Dados do fornecedor</h3>
            <div class="row">
                <div class="col-md-3">
                    <label for="fornecedor">Fornecedor</label>
                    <select class="form-control" name="fornecedor" id="fornecedor" required>
                        <option value="">Selecione um Fornecedor</option>
                        <?php echo $fornecedores_options; ?>
                    </select>
                </div>
                <div class="col-md-3">
                    <label for="comprador">Comprador</label>
                    <input class="form-control" name="comprador" type="text" id="comprador" size="20" required>
                </div>
            </div>
            <h3>Itens</h3>
            <div id="items-container">
                <div class="row no-gutters item-row">
                    <div class="col-md-3">
                        <label>Nome do item</label>
                        <input class="form-control nome-item" name="nome_item[]" type="text" required>
                    </div>
                    <div class="col-md-2">
                        <label>Código</label>
                        <input class="form-control codigo" name="codigo[]" type="text" readonly>
                    </div>
                    <div class="col-md-2">
                        <label>Quantidade</label>
                        <input class="form-control quantidade" name="quantidade[]" type="number">
                    </div>
                    <div class="col-md-2">
                        <label>Preço</label>
                        <input class="form-control preco" name="preco[]" type="text" readonly>
                    </div>
                    <div class="col-md-1">
                        <label>Desconto(%)</label>
                        <input class="form-control desconto" name="desconto[]" type="number">
                    </div>
                    <div class="col-md-1">
                        <label>Preço Total</label>
                        <input class="form-control preco-total" name="preco_total[]" type="text" readonly>
                    </div>
                    <div class="col-md-1 delete-button-container"></div>
                </div>
            </div>
            <button type="button" class="btn btn-adicionar">Adicionar Item</button>

            <h3>Totais</h3>
            <div class="row">
                <div class="col-md-4">
                    <label for="num_itens">N° de Itens</label>
                    <input class="form-control" name="num_itens" type="text" id="num_itens" size="20" readonly>
                </div>
                <div class="col-md-4">
                    <label for="soma_quantidades">Soma das quantidades</label>
                    <input class="form-control" name="soma_quantidades" type="text" id="soma_quantidades" size="20" readonly>
                </div>
                <div class="col-md-4">
                    <label for="desconto_total_itens">Desconto total dos itens</label>
                    <input class="form-control" name="desconto_total_itens" type="text" id="desconto_total_itens" size="20" readonly>
                </div>
            </div>
            <div class="row">
                <div class="col-md-4">
                    <label for="total_itens">Total dos itens</label>
                    <input class="form-control" name="total_itens" type="text" id="total_itens" size="20" readonly>
                </div>
                <div class="col-md-4">
                    <label for="desc_total_compra">Desconto total da compra</label>
                    <input class="form-control" name="desc_total_compra" type="text" id="desc_total_compra" size="20" readonly>
                </div>
                <div class="col-md-4">
                    <label for="total_compra">Total da compra</label>
                    <input class="form-control" name="total_compra" type="text" id="total_compra" size="20" readonly>
                </div>
            </div>

            <h3>Pagamento</h3>
            <div class="row">
                <div class="col-md-3">
                    <label for="cond_pagamento">Condições de pagamento</label>
                    <input class="form-control" name="cond_pagamento" type="text" id="cond_pagamento" size="65">
                </div>
                <div class="col-md-3">
                    <label for="categoria">Categoria</label>
                    <input class="form-control" name="categoria" type="text" id="categoria" size="50">
                </div>
            </div>

            <h3>Detalhes da compra</h3>
            <div class="row">
                <div class="col-md-3">
                    <label for="data_compra">Data da compra</label>
                    <input class="form-control" name="data_compra" type="date" id="data_compra" size="20">
                </div>
                <div class="col-md-3">
                    <label for="data_recebimento">Data de Recebimento</label>
                    <input class="form-control" name="data_recebimento" type="date" id="data_recebimento" size="20">
                </div>
                <div class="col-md-3">
                    <label for="data_prevista">Data prevista</label>
                    <input class="form-control" name="data_prevista" type="date" id="data_prevista" size="20">
                </div>
            </div>

            <button type="submit" class="btn btn-primary">Salvar</button>
        </form>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/inputmask@5.0.7-beta.19/dist/jquery.inputmask.min.js"></script>
    <script>
        function validarFormulario() {
            let erroFornecedor = document.getElementById("erro-fornecedor");
            let erroComprador = document.getElementById("erro-comprador");
            let erroItens = document.getElementById("erro-itens");

            erroFornecedor.style.display = "none";
            erroComprador.style.display = "none";
            erroItens.style.display = "none";

            let fornecedor = document.getElementById("fornecedor").value;
            let comprador = document.getElementById("comprador").value;
            let nomeItem = document.querySelector(".nome-item").value;

            let valid = true;

            if (fornecedor.trim() === "") {
                erroFornecedor.style.display = "block";
                valid = false;
            }

            if (comprador.trim() === "") {
                erroComprador.style.display = "block";
                valid = false;
            }

            if (nomeItem.trim() === "") {
                erroItens.style.display = "block";
                valid = false;
            }

            return valid;
        }

        $(document).ready(function () {
            function aplicarMascara() {
                $('.preco, #valor_frete').inputmask('currency', { prefix: 'R$ ', rightAlign: false });
            }

            aplicarMascara();

            function adicionarLinha() {
                const itemCount = $('#items-container .item-row').length;
                const deleteButton = itemCount > 0 ? '<button type="button" class="btn btn-danger delete-item">Deletar</button>' : '';
                const novaLinha = `
                <div class="row no-gutters item-row">
                    <div class="col-md-3">
                        <input class="form-control nome-item" name="nome_item[]" type="text" required>
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
                    <div class="col-md-1 delete-button-container">
                        ${deleteButton}
                    </div>
                </div>
                `;
                $('#items-container').append(novaLinha);
                aplicarMascara();
            }

            $('.btn-adicionar').click(function () {
                adicionarLinha();
                atualizarTotais();
            });

            $('#items-container').on('click', '.delete-item', function () {
                $(this).closest('.item-row').remove();
                atualizarTotais();
            });

            function calcularPrecoTotal(row) {
                const preco = parseFloat(row.find('.preco').inputmask('unmaskedvalue')) || 0;
                const quantidade = parseFloat(row.find('.quantidade').val()) || 0;
                const desconto = parseFloat(row.find('.desconto').val()) || 0;

                let precoTotal = preco * quantidade;
                if (desconto > 0) {
                    precoTotal -= precoTotal * (desconto / 100);
                }

                row.find('.preco-total').val(precoTotal.toFixed(2));
                atualizarTotais();
            }

            $('#items-container').on('input', '.preco, .quantidade, .desconto', function () {
                const row = $(this).closest('.item-row');
                calcularPrecoTotal(row);
            });

            $('#items-container').on('blur', '.preco', function () {
                const row = $(this).closest('.item-row');
                calcularPrecoTotal(row);
            });

            $('#items-container').on('blur', '.nome-item', function () {
                const row = $(this).closest('.item-row');
                const nomeItem = $(this).val();
                $.ajax({
                    url: 'buscar_detalhes_produto.php',
                    method: 'GET',
                    data: { nome_item: nomeItem },
                    success: function (response) {
                        var data = JSON.parse(response);
                        if (data.success) {
                            row.find('.codigo').val(data.data.codigo);
                            row.find('.preco').val(data.data.preco);
                            calcularPrecoTotal(row);
                        } else {
                            alert(data.message);
                            row.find('.codigo').val('');
                            row.find('.preco').val('');
                        }
                    }
                });
            });

            function atualizarTotais() {
                let totalItens = 0;
                let somaQuantidades = 0;
                let descontoTotalItens = 0;
                let totalItensDescontados = 0;

                $('.item-row').each(function () {
                    const quantidade = parseFloat($(this).find('.quantidade').val()) || 0;
                    const precoTotal = parseFloat($(this).find('.preco-total').val()) || 0;
                    const desconto = parseFloat($(this).find('.desconto').val()) || 0;
                    const preco = parseFloat($(this).find('.preco').inputmask('unmaskedvalue')) || 0;

                    totalItens += 1;
                    somaQuantidades += quantidade;
                    descontoTotalItens += (preco * quantidade * (desconto / 100));
                    totalItensDescontados += precoTotal;
                });

                $('#num_itens').val(totalItens);
                $('#soma_quantidades').val(somaQuantidades);
                $('#desconto_total_itens').val(descontoTotalItens.toFixed(2));
                $('#total_itens').val(totalItensDescontados.toFixed(2));
                $('#total_compra').val(totalItensDescontados.toFixed(2));
                $('#desc_total_compra').val(descontoTotalItens.toFixed(2));
            }

            $('#valor_frete').on('input', function () {
                atualizarTotais();
            });

            $('#fornecedor').on('blur', function () {
                var fornecedor = $(this).val();
                $.ajax({
                    url: 'buscar_fornecedor.php',
                    method: 'GET',
                    data: { fornecedor: fornecedor },
                    success: function (response) {
                        var data = JSON.parse(response);
                        if (data.success) {
                            $('#fornecedor').val(data.nome);
                        } else {
                            alert('Cadastro não encontrado');
                            $('#fornecedor').val('');
                        }
                    }
                });
            });

            function definirDataAtual() {
                const hoje = new Date().toISOString().split('T')[0];
                $('#data_compra').val(hoje);
            }

            definirDataAtual();
            adicionarLinha();
        });
    </script>
</body>

</html>
