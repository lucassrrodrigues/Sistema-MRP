<?php
session_start();
if (!isset($_SESSION['id'])) {
  header("Location: login.php");
  exit();
}

require_once "../conexao.php";

$id_usuario = $_SESSION['id'];
$sql = "SELECT * FROM vendas WHERE id_usuario = $id_usuario";
$resultado = mysqli_query($conexao, $sql);
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
  <link rel="stylesheet" href="estilos_venda.css">
  <link rel="stylesheet" href="../styleHeader.css">
  <title>UpperPro - Vendas</title>
  <link rel="icon" href="../img/logo.png" type="image/png">
</head>

<body>
  <header>
    <img src="../img/logo.png" alt="logo">
    <nav>
      <div class="dropdown">
        <button class="dropbtn">Cadastros</button>
        <div class="dropdown-content">
          <a class="dropdown-start" href="../Cadastro_Cliente/cliente_fornecedor.php">Cliente e Fornecedor</a>
          <a class="dropdown-end" href="../Cad_funcionario/cadastro_funcionario.php">Funcionarios</a>
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
          <a class="dropdown-meio" href="../Frente de caixa/frente_caixa.php">Frente de Caixa</a>
          <a class="dropdown-end" href="#">Relatorio</a>
        </div>
      </div>
    </nav>
    <div>
      <button id="perfilBtn"><img class="perfil" src="../img/perfil.png" alt="Descrição da Imagem 1"></button>
      <button id="logoutBtn"><img class="perfil" src="../img/sair.png" alt="Descrição da Imagem 2"></button>
    </div>
  </header>
  <div class="title">
    <h1><strong>Pedidos de Venda</strong></h1>
  </div>
  <button id="sidebarToggle"></button>
  <aside id="sidebar">
    <button id="sidebarClose">Fechar</button>
  </aside>
  <main>
    <a class="btn-cadastrar-produto" href="Tela_cad_venda.php"><strong>+ Incluir novo Pedido</strong></a>
    <div class="table-responsive">
      <table class="table table-striped">
        <thead>
          <tr>
            <th>Número do Pedido</th>
            <th>Cliente</th>
            <th>Vendedor</th>
            <th>Data da Venda</th>
            <th>Total da Venda</th>
            <th>Status</th>
            <th>Ações</th>
          </tr>
        </thead>
        <tbody>
          <?php if (mysqli_num_rows($resultado) > 0) {
            while ($row = mysqli_fetch_assoc($resultado)) { ?>
              <tr>
                <td><?php echo $row['num_ped']; ?></td>
                <td><?php echo $row['cliente']; ?></td>
                <td><?php echo $row['vendedor']; ?></td>
                <td><?php echo $row['data_venda']; ?></td>
                <td><?php echo $row['total_venda']; ?></td>
                <td>
                  <div class="btn-group">
                    <button class="btn btn-<?php echo $row['status_aprovacao'] == 'Pendente' ? 'warning' : ($row['status_aprovacao'] == 'Aprovado' ? 'success' : 'danger'); ?> btn-sm dropdown-toggle" type="button" id="dropdownMenuButton<?php echo $row['id']; ?>" data-bs-toggle="dropdown" aria-expanded="false">
                      <?php echo $row['status_aprovacao']; ?>
                    </button>
                    <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton<?php echo $row['id']; ?>">
                      <?php if ($row['status_aprovacao'] != 'Pendente') { ?>
                        <li><a class="dropdown-item" href="alterar_status_venda.php?id_venda=<?php echo $row['id']; ?>&status=Pendente">Pendente</a></li>
                      <?php } ?>
                      <?php if ($row['status_aprovacao'] != 'Aprovado') { ?>
                        <li><a class="dropdown-item" href="alterar_status_venda.php?id_venda=<?php echo $row['id']; ?>&status=Aprovado">Aprovar</a></li>
                      <?php } ?>
                      <?php if ($row['status_aprovacao'] != 'Reprovado') { ?>
                        <li><a class="dropdown-item" href="alterar_status_venda.php?id_venda=<?php echo $row['id']; ?>&status=Reprovado">Reprovar</a></li>
                      <?php } ?>
                    </ul>
                  </div>
                </td>
                <td>
                  <a href="editar_venda.php?id_venda=<?php echo $row['id']; ?>" class="btn btn-primary btn-sm">Editar</a>
                  <a href="visualizar_venda.php?id_venda=<?php echo $row['id']; ?>" target="_blank"
                    class="btn btn-secondary btn-sm">Imprimir</a>
                  <?php if ($row['lancado_estoque']) { ?>
                    <a href="cancelar_lancamento.php?id_venda=<?php echo $row['id']; ?>"
                      class="btn btn-warning btn-sm">Cancelar Lançamento</a>
                  <?php } else { ?>
                    <a href="lancar_estoque.php?id_venda=<?php echo $row['id']; ?>" class="btn btn-success btn-sm">Lançar no
                      Estoque</a>
                  <?php } ?>
                  <a href="deletar_venda.php?id_venda=<?php echo $row['id']; ?>" class="btn btn-danger btn-sm">Deletar</a>
                </td>
              </tr>
            <?php }
          } else { ?>
            <tr>
              <td colspan="7">Nenhum pedido de venda encontrado.</td>
            </tr>
          <?php } ?>
        </tbody>
      </table>
    </div>
  </main>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
    crossorigin="anonymous"></script>
  <script src="script.js"></script>
</body>

</html>
