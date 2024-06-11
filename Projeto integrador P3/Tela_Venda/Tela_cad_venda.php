<?php
session_start();
if (!isset($_SESSION['id'])) {
    header("Location: login.php");
    exit();
}

require_once "../conexao.php";

$sql = "SELECT MAX(num_ped) AS ultimo_pedido FROM vendas";
$resultado = mysqli_query($conexao, $sql);
$row = mysqli_fetch_assoc($resultado);
$ultimo_pedido = $row['ultimo_pedido'];

$prox_num_ped = ($ultimo_pedido === null) ? 1 : $ultimo_pedido + 1;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (empty($_POST['cliente']) || empty($_POST['vendedor']) || empty($_POST['nome_item'][0])) {
        echo "Preencha todos os campos obrigatórios.";
        exit();
    }

    $id_usuario = $_SESSION['id'];
    $cliente = $_POST['cliente'];
    $vendedor = $_POST['vendedor'];
    $cond_pagamento = $_POST['cond_pagamento'];
    $categoria = $_POST['categoria'];
    $data_venda = $_POST['data_venda'];
    $data_saida = isset($_POST['data_saida']) ? $_POST['data_saida'] : null;
    $data_prevista = isset($_POST['data_prevista']) ? $_POST['data_prevista'] : null;
    $num_itens = $_POST['num_itens'];
    $soma_quantidades = $_POST['soma_quantidades'];
    $desconto_total_itens = $_POST['desconto_total_itens'];
    $total_itens = $_POST['total_itens'];
    $desconto_total_venda = $_POST['desc_total_venda'];
    $total_venda = $_POST['total_venda'];
    $frete_por_conta = isset($_POST['frete_por_conta']) ? $_POST['frete_por_conta'] : null;
    $largura = isset($_POST['largura']) ? $_POST['largura'] : null;
    $comprimento = isset($_POST['comprimento']) ? $_POST['comprimento'] : null;
    $altura = isset($_POST['altura']) ? $_POST['altura'] : null;
    $peso = isset($_POST['peso']) ? $_POST['peso'] : null;
    $prazo_entrega = isset($_POST['prazo_entrega']) ? $_POST['prazo_entrega'] : null;
    $valor_frete = isset($_POST['valor_frete']) ? $_POST['valor_frete'] : null;

    $sql = "INSERT INTO vendas (num_ped, cliente, vendedor, cond_pagamento, categoria, data_venda, data_saida, data_prevista, id_usuario, num_itens, soma_quantidades, desconto_total_itens, total_itens, desconto_total_venda, total_venda, frete_por_conta, largura, comprimento, altura, peso, prazo_entrega, valor_frete) 
            VALUES ('$prox_num_ped', '$cliente', '$vendedor', '$cond_pagamento', '$categoria', '$data_venda', '$data_saida', '$data_prevista', '$id_usuario', '$num_itens', '$soma_quantidades', '$desconto_total_itens', '$total_itens', '$desconto_total_venda', '$total_venda', '$frete_por_conta', '$largura', '$comprimento', '$altura', '$peso', '$prazo_entrega', '$valor_frete')";

    if (mysqli_query($conexao, $sql)) {
        $venda_id = mysqli_insert_id($conexao);

        foreach ($_POST['nome_item'] as $index => $nome_item) {
            $codigo = $_POST['codigo'][$index];
            $quantidade = $_POST['quantidade'][$index];
            $preco = $_POST['preco'][$index];
            $desconto = $_POST['desconto'][$index];
            $preco_total = $_POST['preco_total'][$index];

            $sql_item = "INSERT INTO itens_venda (venda_id, nome_item, codigo, quantidade, preco, desconto, preco_total) 
                         VALUES ('$venda_id', '$nome_item', '$codigo', '$quantidade', '$preco', '$desconto', '$preco_total')";

            if (!mysqli_query($conexao, $sql_item)) {
                echo "Erro ao cadastrar item: " . mysqli_error($conexao);
                exit();
            }
        }

        header("Location: Tela_venda.php");
        exit();
    } else {
        echo "Erro ao cadastrar a venda: " . mysqli_error($conexao);
    }
}

// Buscar clientes e fornecedores que são clientes
$clientes_sql = "SELECT `Nome`, `CPF/CNPJ` FROM tabela_cliente_fornecedor WHERE `Tipo` = 'cliente'";
$clientes_result = mysqli_query($conexao, $clientes_sql);
$clientes_options = '';
while ($cliente = mysqli_fetch_assoc($clientes_result)) {
    $clientes_options .= '<option value="' . $cliente['Nome'] . '">' . $cliente['Nome'] . '</option>';
}
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
    <link rel="stylesheet" href="../styleHeader.css">
    <title>UpperPro - Cadastro de Venda</title>
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
        <h1>Cadastro de Pedido de Venda</h1>
        <form id="forml" action="Tela_cad_venda.php" method="POST" onsubmit="return validarFormulario();">
            <div class="error-message" id="erro-cliente">O campo cliente é obrigatório.</div>
            <div class="error-message" id="erro-vendedor">O campo vendedor é obrigatório.</div>
            <div class="error-message" id="erro-itens">Adicione ao menos um item.</div>
            <div class="form-group">
                <label for="num_ped">N° do Pedido</label>
                <input class="form-control" name="num_ped" type="text" id="num_ped" readonly value="<?php echo $prox_num_ped; ?>" readonly>
            </div>
            <h3>Dados do Cliente</h3>
            <div class="row">
                <div class="col-md-3">
                    <label for="cliente">Cliente</label>
                    <select class="form-control" name="cliente" id="cliente" required>
                        <option value="">Selecione um Cliente</option>
                        <?php echo $clientes_options; ?>
                    </select>
                </div>
                <div class="col-md-3">
                    <label for="vendedor">Vendedor</label>
                    <input class="form-control" name="vendedor" type="text" id="vendedor" size="20" required>
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

            <h3>Transportador</h3>
            <div class="row">
                <div class="col-md-3">
                    <label for="frete_por_conta">Frete por conta</label>
                    <input class="form-control" name="frete_por_conta" type="text" id="frete_por_conta" size="40">
                </div>
                <div class="col-md-3">
                    <label for="largura">Largura</label>
                    <input class="form-control" name="largura" type="text" id="largura" size="40">
                </div>
                <div class="col-md-3">
                    <label for="comprimento">Comprimento</label>
                    <input class="form-control" name="comprimento" type="text" id="comprimento" size="20">
                </div>
                <div class="col-md-3">
                    <label for="altura">Altura</label>
                    <input class="form-control" name="altura" type="text" id="altura" size="20">
                </div>
            </div>
            <div class="row">
                <div class="col-md-3">
                    <label for="peso">Peso</label>
                    <input class="form-control" name="peso" type="text" id="peso" size="20">
                </div>
                <div class="col-md-3">
                    <label for="prazo_entrega">Prazo de entrega</label>
                    <input class="form-control" name="prazo_entrega" type="date" id="prazo_entrega" size="20">
                </div>
                <div class="col-md-3">
                    <label for="valor_frete">Valor do Frete</label>
                    <input class="form-control" name="valor_frete" type="text" id="valor_frete" size="20">
                </div>
            </div>

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
                    <label for="desc_total_venda">Desconto total da Venda</label>
                    <input class="form-control" name="desc_total_venda" type="text" id="desc_total_venda" size="20" readonly>
                </div>
                <div class="col-md-4">
                    <label for="total_venda">Total da venda</label>
                    <input class="form-control" name="total_venda" type="text" id="total_venda" size="20" readonly>
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

            <h3>Detalhes da venda</h3>
            <div class="row">
                <div class="col-md-3">
                    <label for="data_venda">Data da venda</label>
                    <input class="form-control" name="data_venda" type="date" id="data_venda" size="20" >
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
            let erroCliente = document.getElementById("erro-cliente");
            let erroVendedor = document.getElementById("erro-vendedor");
            let erroItens = document.getElementById("erro-itens");

            erroCliente.style.display = "none";
            erroVendedor.style.display = "none";
            erroItens.style.display = "none";

            let cliente = document.getElementById("cliente").value;
            let vendedor = document.getElementById("vendedor").value;
            let nomeItem = document.querySelector(".nome-item").value;

            let valid = true;

            if (cliente.trim() === "") {
                erroCliente.style.display = "block";
                valid = false;
            }

            if (vendedor.trim() === "") {
                erroVendedor.style.display = "block";
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

                const valorFrete = parseFloat($('#valor_frete').inputmask('unmaskedvalue')) || 0;

                $('#num_itens').val(totalItens);
                $('#soma_quantidades').val(somaQuantidades);
                $('#desconto_total_itens').val(descontoTotalItens.toFixed(2));
                $('#total_itens').val(totalItensDescontados.toFixed(2));
                $('#total_venda').val((totalItensDescontados + valorFrete).toFixed(2));
                $('#desc_total_venda').val(descontoTotalItens.toFixed(2));
            }

            $('#valor_frete').on('input', function () {
                atualizarTotais();
            });

            $('#cliente').on('blur', function () {
                var cliente = $(this).val();
                if(cliente.trim() !== ""){
                    $.ajax({
                        url: 'buscar_cliente.php',
                        method: 'GET',
                        data: { cliente: cliente },
                        success: function (response) {
                            var data = JSON.parse(response);
                            if (data.success) {
                                $('#cliente').val(data.nome);
                            } else {
                                alert('Cadastro não encontrado');
                                $('#cliente').val('');
                            }
                        }
                    });
                }
            });

            function definirDataAtual() {
                const hoje = new Date().toISOString().split('T')[0];
                $('#data_venda').val(hoje);
            }

            definirDataAtual();
            adicionarLinha();
        });
    </script>
</body>
</html>
