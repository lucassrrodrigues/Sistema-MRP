<?php
session_start(); // Iniciar a sessão
require_once "../conexao.php";

// Verificar se o ID do usuário está presente na sessão
if (!isset($_SESSION['id'])) {
    header("Location: login.php"); // Redirecionar para login se o ID do usuário não estiver na sessão
    exit();
}

$id_usuario = $_SESSION['id'];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
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

    // Obter o próximo número de pedido
    $sql = "SELECT MAX(num_ped) AS ultimo_pedido FROM vendas";
    $resultado = mysqli_query($conexao, $sql);
    $row = mysqli_fetch_assoc($resultado);
    $ultimo_pedido = $row['ultimo_pedido'];
    $prox_num_ped = ($ultimo_pedido === null) ? 1 : $ultimo_pedido + 1;

    // Inserir a venda na tabela `vendas`
    $sql = "INSERT INTO vendas (num_ped, cliente, vendedor, cond_pagamento, categoria, data_venda, data_saida, data_prevista, id_usuario, num_itens, soma_quantidades, desconto_total_itens, total_itens, desconto_total_venda, total_venda, frete_por_conta, largura, comprimento, altura, peso, prazo_entrega, valor_frete) 
            VALUES ('$prox_num_ped', '$cliente', '$vendedor', '$cond_pagamento', '$categoria', '$data_venda', '$data_saida', '$data_prevista', '$id_usuario', '$num_itens', '$soma_quantidades', '$desconto_total_itens', '$total_itens', '$desconto_total_venda', '$total_venda', '$frete_por_conta', '$largura', '$comprimento', '$altura', '$peso', '$prazo_entrega', '$valor_frete')";

    if (mysqli_query($conexao, $sql)) {
        $venda_id = mysqli_insert_id($conexao); // Obter o último ID inserido

        // Inserir cada item na tabela `itens_venda`
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

        header("Location: Tela_Venda.php");
        exit();
    } else {
        echo "Erro ao cadastrar a venda: " . mysqli_error($conexao);
    }
}
?>
