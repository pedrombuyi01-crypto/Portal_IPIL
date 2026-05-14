<?php

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    require_once "conecxao.php";

    $nome          = mysqli_real_escape_string($conn, $_POST["nome"]);
    $email         = mysqli_real_escape_string($conn, $_POST["email"]);
    $senha         = $_POST["senha"];
    $confirm_senha = $_POST["confirmacao_senha"];

    if ($senha != $confirm_senha) {
        $erro = "As senhas não coincidem!";
    } else {

        $senha_hash = password_hash($senha, PASSWORD_DEFAULT);

        // Se a senha começa com ADM, é administrador
        if (strpos($senha, "ADM") === 0) {
            $tipo = "administrador";
        } else {
            $tipo = "utilizador";
        }

        // Verificar se email já existe
        $check = mysqli_query($conn, "SELECT id FROM utilizadores WHERE email='$email'");
        if (mysqli_num_rows($check) > 0) {
            $erro = "Este e-mail já está registado!";
        } else {
            $sql = "INSERT INTO utilizadores (nome, email, senha, tipo)
                    VALUES ('$nome', '$email', '$senha_hash', '$tipo')";
            mysqli_query($conn, $sql);
            header("Location: login.php");
            exit();
        }
    }
}
?>

<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro - IPIL Makarenko</title>
    <link rel="stylesheet" href="css/cadastro.css">
</head>
<body>

<div class="pagina">

    <div class="lado-esquerdo">
        <a href="index.php" class="logo">
            <span class="logo-ipil">IPIL</span>
            <span class="logo-nome">Makarenko</span>
        </a>
        <div class="texto-esquerdo">
            <h2>Bem-vindo ao portal de notícias oficial.</h2>
            <p>Cria a tua conta e fica informado sobre todas as novidades e acontecimentos da escola.</p>
        </div>
        <div class="rodape-esquerdo">
            <p>Luanda, Angola</p>
            <p>ipilmakarenko@escola.ao</p>
        </div>
    </div>

    <div class="lado-direito">
        <div class="formulario">

            <h3>Criar conta</h3>
            <p class="form-sub">Preenche os campos abaixo para te registares</p>

            <?php if (isset($erro)) { echo "<p style='color:red;'>$erro</p>"; } ?>

            <form action="cadastro.php" method="POST">

                <div class="campo">
                    <label>Nome</label>
                    <input type="text" name="nome" placeholder="Digite o seu nome" required>
                </div>

                <div class="campo">
                    <label>E-mail</label>
                    <input type="email" name="email" placeholder="Digite o seu e-mail" required>
                </div>

                <div class="campo">
                    <label>Senha</label>
                    <input type="password" name="senha" placeholder="Digite a sua senha" required>
                </div>

                <div class="campo">
                    <label>Confirme a sua senha</label>
                    <input type="password" name="confirmacao_senha" placeholder="Confirme a sua senha" required>
                </div>

                <button type="submit" class="btn-submit">Criar conta</button>

                <p class="form-login">
                    Já tens conta? <a href="login.php">Entrar aqui</a>
                </p>

            </form>
        </div>
    </div>

</div>

</body>
</html>