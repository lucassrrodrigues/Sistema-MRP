<?php
$server = "localhost";
$usuario = "root";
$senha = "";
$banco = "upperpro"; // Nome do seu banco de dados

// Criando a conexão
$conexao = mysqli_connect($server, $usuario, $senha, $banco);

// Verificando a conexão
if (!$conexao) {
    die("Conexão falhou: " . mysqli_connect_error());
}
?>
