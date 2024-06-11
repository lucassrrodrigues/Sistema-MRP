<?php
require_once "../conexao.php";

if (isset($_GET['cliente'])) {
    $cliente = $_GET['cliente'];
    $query = "SELECT Nome, `CPF/CNPJ` FROM tabela_cliente_fornecedor WHERE `CPF/CNPJ` = ? OR Nome = ?";
    $stmt = $conexao->prepare($query);
    $stmt->bind_param("ss", $cliente, $cliente);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        echo json_encode(['success' => true, 'nome' => $row['Nome']]);
    } else {
        echo json_encode(['success' => false, 'message' => 'Cliente não encontrado.']);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Parâmetro cliente não fornecido.']);
}
?>
