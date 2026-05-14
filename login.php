<?php

session_start();
require_once "conecxao.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $email = mysqli_real_escape_string($conn, $_POST["email"]);
    $senha = $_POST["senha"];

    $sql = "SELECT * FROM utilizadores WHERE email = '$email'";
    $resultado = mysqli_query($conn, $sql);

    if (mysqli_num_rows($resultado) > 0) {

        $utilizador = mysqli_fetch_assoc($resultado);

        if (password_verify($senha, $utilizador["senha"])) {

            $_SESSION["id"]   = $utilizador["id"];
            $_SESSION["nome"] = $utilizador["nome"];
            $_SESSION["tipo"] = $utilizador["tipo"];

            // BUG CORRIGIDO: era = agora é ==
            if ($utilizador["tipo"] == "administrador") {
                header("Location: admin.php");
            } else {
                header("Location: index.php");
            }
            exit();

        } else {
            $erro = "Senha incorreta!";
        }

    } else {
        $erro = "E-mail não encontrado!";
    }
}
?>

<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - IPIL Makarenko</title>
    <link rel="stylesheet" href="css/login.css">
</head>
<body>

    <div class="conteiner">

        <div class="texto">
            <h2>Entrar</h2>
            <p>Preencha os campos para acessar a sua conta</p>
            <div class="divider"></div>
        </div>

        <?php if (isset($erro)) { echo "<p style='color:red;'>$erro</p>"; } ?>

        <form action="" method="post">

            <div class="campo">
                <label for="email">E-mail</label>
                <input type="email" id="email" name="email" placeholder="o.seu@email.com" required>
            </div>

            <div class="campo">
                <label for="senha">Senha</label>
                <input type="password" id="senha" name="senha" placeholder="••••••••" required>
            </div>

            <a href="#" class="forgot">Esqueceu a senha?</a>

            <button type="submit" class="btn-login">Entrar</button>

        </form>

        <p class="register-link">
            Não tem conta? <a href="cadastro.php">Criar conta</a>
        </p>

    </div>

</body>
</html>