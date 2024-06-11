<?php
session_start(); // Inicia a sessão

// Verifica se o ID do usuário está presente na sessão
if (!isset($_SESSION['id'])) {
    header("Location: login.php"); // Redireciona para a página de login se o ID do usuário não estiver presente na sessão
    exit();
}

require_once "../conexao.php"; // Inclua o arquivo de conexão com o banco de dados

$id_usuario = $_SESSION['id']; // Obtém o ID do usuário da sessão

// Consulta as informações do usuário no banco de dados
$sql_usuario = "SELECT * FROM clientes WHERE id = '$id_usuario'";
$result_usuario = mysqli_query($conexao, $sql_usuario);
$row_usuario = mysqli_fetch_assoc($result_usuario);

// Verifica se o formulário foi submetido
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_FILES["imagem"]) && !empty($_FILES["imagem"]["name"])) {
    $imagem_nome = $_FILES["imagem"]["name"];
    $imagem_temp = $_FILES["imagem"]["tmp_name"];
    $imagem_nova_nome = "perfil_" . uniqid() . "_" . $imagem_nome; // Gera um nome único para a imagem
    $imagem_destino = "../perfil_img/" . $imagem_nova_nome;

    // Move o arquivo para a pasta de perfil_img
    if (move_uploaded_file($imagem_temp, $imagem_destino)) {
        // Atualiza o caminho da imagem no banco de dados
        $sql_atualiza_imagem = "UPDATE clientes SET caminho_imagem = '$imagem_destino' WHERE id = '$id_usuario'";
        mysqli_query($conexao, $sql_atualiza_imagem);
        // Recarrega a página para exibir a nova imagem
        header("Location: perfil.php");
        exit();
    } else {
        $erro = "Erro ao fazer upload da imagem.";
    }
}
?>

<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="../styleHeader.css">
    <title>UpperPro - Perfil</title>
    <link rel="icon" href="../img/logo.png" type="image/png">
    <style>
        body {
            font-family: Arial, sans-serif;
        }

        .container {
            max-width: 600px;
            margin: auto;
            padding: 20px;
        }

        h1 {
            color: #58befa;
            padding: 3%;
        }

        .card {
            margin-top: 20px;
        }

        .card-header {
            background-color: #58befa;
            color: #fff;
        }

        .btn-upload {
            margin-top: 20px;
        }
    </style>
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
            <button id="perfilBtn"><img class="perfil" src="../img/perfil.png" alt="Descrição da Imagem 1"></button>
            <button id="logoutBtn"><img class="perfil" src="../img/sair.png" alt="Descrição da Imagem 2"></button>
        </div>
    </header>
    <h1><strong>Perfil do Usuário</strong></h1>
    <div class="container">
        <div class="">
            <div class="body">
                <p><strong>Nome:</strong> <?php echo $row_usuario['razao_social']; ?></p>
                <p><strong>Email:</strong> <?php echo $row_usuario['email']; ?></p>
                <p><strong>CNPJ:</strong> <?php echo $row_usuario['cnpj']; ?></p>
                <p><strong>Tamanho da Empresa:</strong> <?php echo $row_usuario['tamanho_empresa']; ?></p>
                <p><strong>Segmento da Empresa:</strong> <?php echo $row_usuario['segmento_empresa']; ?></p>
                <p><strong>Atividade Principal:</strong> <?php echo $row_usuario['atividade_principal']; ?></p>
                <?php if (!empty($row_usuario['caminho_imagem'])): ?>
                <img src="<?php echo $row_usuario['caminho_imagem']; ?>" alt="Imagem do Perfil">
                <?php else: ?>
                <p>Nenhuma imagem de perfil encontrada.</p>
                <?php endif; ?>
                <!-- Formulário para upload de imagem -->
                <form method="post" enctype="multipart/form-data">
                    <div class="form-group">
                        <label for="imagem">Adicionar Imagem de Perfil:</label>
                        <input type="file" class="form-control" id="imagem" name="imagem" accept="image/*">
                    </div>
                    <button type="submit" class="btn btn-primary btn-upload">Enviar</button>
                </form>
                <?php if (isset($erro)): ?>
                <p class="text-danger"><?php echo $erro; ?></p>
                <?php endif; ?>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
        crossorigin="anonymous"></script>
    <script>        // Event listener para o botão "Sair"
        document.getElementById("logoutBtn").addEventListener("click", function () {
            // Aqui você pode adicionar a lógica para executar o logout, como redirecionar para uma página de login
            window.location.href = "../Login/logout.php"; // Exemplo: redireciona para a página de logout
        });

        // Event listener para o botão "Perfil"
        document.getElementById("perfilBtn").addEventListener("click", function () {
            // Aqui você pode adicionar a lógica para ir para a página de perfil do usuário
            window.location.href = "../perfil/perfil.php"; // Exemplo: redireciona para a página de perfil
        });
    </script>
</body>

</html>
