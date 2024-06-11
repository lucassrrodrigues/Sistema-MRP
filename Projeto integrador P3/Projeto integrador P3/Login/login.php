<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" type="text/css" href="style_login.css" />
    <title>UpperPro</title>
</head>

<body>
<header>
        <a href="../Tela Inicial/Tela_inicial.html" class="navbar-brand d-flex align-items-center">
            <img class="logo" src="../img/LogosSemFundo.png" alt="Sua Logo" height="40" width="200">
        </a>
        <nav>
            <ul>
                <li><a href="#hero">Sobre</a></li>
                <li><a href="#container">Funcionalidades</a></li>
                <li><a href="../Cadastro/cadastro.php">Cadastre-se</a></li>
                <li><a href="#contato">Contato</a></li>
            </ul>
        </nav>
    </header>
    <h1 class="titulo"><strong>Minha conta</strong></h1>
    <div class="container">
        <div class="form-container">
            <h1>Login</h1>
            <form>
                <div class="mb-3">
                    <label for="exampleInputEmail1" class="form-label">E-mail</label>
                    <input type="email" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp">
                </div>
                <div class="mb-3">
                    <label for="exampleInputPassword1" class="form-label">Password</label>
                    <input type="password" class="form-control" id="exampleInputPassword1">
                </div>
                <div class="link-cadastro">
                    <a href="../Cadastro/cadastro.html">Ainda não tem cadastro? Inscreva-se agora!</a>
                </div>
                <button type="submit" class="btn-primary"><strong>Entrar</strong></button>
            </form>
        </div>
        <div class="image-container">
            <figure>
                <img src="../img/qrcode.png" alt="Descrição da imagem">
                <figcaption>Antes de conhecer nosso ERP </figcaption>
                <figcaption>veja nossa documentação</figcaption>
            </figure>
        </div>
    </div>
</body>

</html>
