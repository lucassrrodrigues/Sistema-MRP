<?php
session_start();
if (!isset($_SESSION['id'])) {
  header("Location: login.php");
  exit();
}

require_once "../conexao.php";

if (isset($_GET['id_venda']) && isset($_GET['status'])) {
  $id_venda = $_GET['id_venda'];
  $status = $_GET['status'];

  $sql = "UPDATE vendas SET status_aprovacao = ? WHERE id = ?";
  $stmt = $conexao->prepare($sql);
  $stmt->bind_param('si', $status, $id_venda);

  if ($stmt->execute()) {
    header("Location: Tela_venda.php");
  } else {
    echo "Erro ao atualizar status: " . $conexao->error;
  }
} else {
  header("Location: Tela_venda.php");
}
?>
