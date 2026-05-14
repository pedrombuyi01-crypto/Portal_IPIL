<?php

session_start();
require_once "conecxao.php";

// Só administradores podem editar
if (!isset($_SESSION["tipo"]) || $_SESSION["tipo"] != "administrador") {
    header("Location: login.php");
    exit();
}

$id = (int) $_GET['id'];

// Buscar notícia actual
$sql    = "SELECT * FROM noticias WHERE id = $id";
$result = mysqli_query($conn, $sql);
$noticia = mysqli_fetch_assoc($result);

if (!$noticia) {
    header("Location: admin.php");
    exit();
}

// Processar formulário
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $titulo    = mysqli_real_escape_string($conn, $_POST["titulo"]);
    $resumo    = mysqli_real_escape_string($conn, $_POST["resumo"]);
    $conteudo  = mysqli_real_escape_string($conn, $_POST["conteudo"]);
    $categoria = mysqli_real_escape_string($conn, $_POST["categoria"]);
    $data      = mysqli_real_escape_string($conn, $_POST["data_publicacao"]);

    $sql = "UPDATE noticias SET
                titulo='$titulo',
                resumo='$resumo',
                conteudo='$conteudo',
                categoria='$categoria',
                data_publicacao='$data'
            WHERE id=$id";

    mysqli_query($conn, $sql);

    header("Location: admin.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Notícia - IPIL</title>
    <link rel="stylesheet" href="css/admin.css">
</head>
<body>

<aside class="sidebar">
    <div class="sidebar-topo">
        <h2><span>IPIL</span> Admin</h2>
    </div>
    <nav class="sidebar-nav">
        <a href="admin.php" class="nav-item">Dashboard</a>
    </nav>
    <div class="sidebar-rodape">
        <a href="index.php" class="btn-voltar">Ver Site</a>
        <a href="login.php" class="btn-sair">Sair</a>
    </div>
</aside>

<main class="conteudo">
    <div class="topo-barra">
        <h1 class="topo-titulo">Editar Notícia</h1>
        <span class="admin-nome"><?php echo $_SESSION["nome"]; ?></span>
    </div>

    <section class="secao-admin">
        <h3 class="subtitulo">Editar: <?php echo htmlspecialchars($noticia['titulo']); ?></h3>

        <form class="formulario" method="POST">

            <div class="campo">
                <label>Título</label>
                <input type="text" name="titulo" value="<?php echo htmlspecialchars($noticia['titulo']); ?>" required>
            </div>

            <div class="campo">
                <label>Resumo</label>
                <textarea name="resumo" rows="3"><?php echo htmlspecialchars($noticia['resumo']); ?></textarea>
            </div>

            <div class="campo">
                <label>Conteúdo completo</label>
                <textarea name="conteudo" rows="6"><?php echo htmlspecialchars($noticia['conteudo']); ?></textarea>
            </div>

            <div class="campo-linha">
                <div class="campo">
                    <label>Categoria</label>
                    <select name="categoria">
                        <option value="destaques"   <?php if($noticia['categoria']=='destaques')   echo 'selected'; ?>>Destaques da Semana</option>
                        <option value="declaracoes" <?php if($noticia['categoria']=='declaracoes') echo 'selected'; ?>>Declarações da Escola</option>
                        <option value="eventos"     <?php if($noticia['categoria']=='eventos')     echo 'selected'; ?>>Eventos</option>
                        <option value="desporto"    <?php if($noticia['categoria']=='desporto')    echo 'selected'; ?>>Desporto</option>
                    </select>
                </div>
                <div class="campo">
                    <label>Data</label>
                    <input type="date" name="data_publicacao" value="<?php echo $noticia['data_publicacao']; ?>">
                </div>
            </div>

            <div class="botoes-formulario">
                <button type="submit" class="btn-guardar">Guardar Alterações</button>
                <a href="admin.php" class="btn-cancelar">Cancelar</a>
            </div>

        </form>
    </section>
</main>

</body>
</html>