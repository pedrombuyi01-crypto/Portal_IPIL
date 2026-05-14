<?php
session_start();
require_once "conecxao.php";

// Proteção - só administradores
if (!isset($_SESSION["tipo"]) || $_SESSION["tipo"] != "administrador") {
    header("Location: login.php");
    exit();
}

// ADICIONAR NOTÍCIA
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $titulo    = mysqli_real_escape_string($conn, $_POST["titulo"]);
    $resumo    = mysqli_real_escape_string($conn, $_POST["resumo"]);
    $conteudo  = mysqli_real_escape_string($conn, $_POST["conteudo"]);
    $categoria = mysqli_real_escape_string($conn, $_POST["categoria"]);
    $data = mysqli_real_escape_string($conn, $_POST["data"]);

    $imagem = "";
    if (!empty($_FILES["imagem"]["name"])) {
        $imagem = $_FILES["imagem"]["name"];
        $tmp    = $_FILES["imagem"]["tmp_name"];
        $pasta  = "uploads/";
        if (!file_exists($pasta)) mkdir($pasta, 0777, true);
        move_uploaded_file($tmp, $pasta . $imagem);
    }

        $sql = "INSERT INTO noticias (titulo, resumo, conteudo, categoria, data, imagem)
        VALUES ('$titulo', '$resumo', '$conteudo', '$categoria', '$data', '$imagem')";

    if (mysqli_query($conn, $sql)) {
        $sucesso = "Notícia publicada com sucesso!";
    } else {
        $erro_form = "Erro: " . mysqli_error($conn);
    }
}

// CONTAR ESTATÍSTICAS REAIS
$total_noticias = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) as total FROM noticias"))['total'];
$total_eventos  = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) as total FROM noticias WHERE categoria='eventos'"))['total'];
$total_cats     = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(DISTINCT categoria) as total FROM noticias"))['total'];
?>

<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin - IPIL Makarenko</title>
    <link rel="stylesheet" href="css/admin.css">
</head>
<body>

<!-- SIDEBAR -->
<aside class="sidebar">
    <div class="sidebar-topo">
        <h2><span>IPIL</span> Admin</h2>
    </div>
    <nav class="sidebar-nav">
        <a href="#" class="nav-item ativo" onclick="mostrarSecao('dashboard', this)">Dashboard</a>
        <a href="#" class="nav-item" onclick="mostrarSecao('adicionar', this)">Adicionar Notícia</a>
        <a href="#" class="nav-item" onclick="mostrarSecao('noticias', this)">Gerir Notícias</a>
    </nav>
    <div class="sidebar-rodape">
        <a href="index.php" class="btn-voltar">Ver Site</a>
        <a href="logout.php" class="btn-sair">Sair</a>
    </div>
</aside>

<!-- CONTEUDO PRINCIPAL -->
<main class="conteudo">

    <!-- TOPO -->
    <div class="topo-barra">
        <h1 class="topo-titulo" id="titulo-pagina">Dashboard</h1>
        <span class="admin-nome">
            <?php echo htmlspecialchars($_SESSION["nome"]); ?>
        </span>
    </div>

    <!-- MENSAGENS -->
    <?php if (isset($sucesso)) echo "<p class='msg-sucesso'>$sucesso</p>"; ?>
    <?php if (isset($erro_form)) echo "<p class='msg-erro'>$erro_form</p>"; ?>

    <!-- DASHBOARD -->
    <section class="secao-admin" id="dashboard">
        <div class="resumo-grid">
            <div class="resumo-card">
                <p class="resumo-numero"><?php echo $total_noticias; ?></p>
                <p class="resumo-label">Notícias publicadas</p>
            </div>
            <div class="resumo-card">
                <p class="resumo-numero"><?php echo $total_cats; ?></p>
                <p class="resumo-label">Categorias ativas</p>
            </div>
            <div class="resumo-card">
                <p class="resumo-numero"><?php echo $total_eventos; ?></p>
                <p class="resumo-label">Eventos publicados</p>
            </div>
            <div class="resumo-card">
                <p class="resumo-numero">1</p>
                <p class="resumo-label">Administrador</p>
            </div>
        </div>

        <h3 class="subtitulo">Últimas notícias adicionadas</h3>
        <table class="tabela">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Título</th>
                    <th>Categoria</th>
                    <th>Data</th>
                    <th>Ações</th>
                </tr>
            </thead>
            <tbody>
                <?php
                    $sql    = "SELECT * FROM noticias ORDER BY id DESC LIMIT 10";
                    $result = mysqli_query($conn, $sql);
                    $i = 1;
                    while ($row = mysqli_fetch_assoc($result)) {
                        echo "<tr>
                            <td>{$i}</td>
                            <td>" . htmlspecialchars($row['titulo']) . "</td>
                            <td><span class='badge'>{$row['categoria']}</span></td>
                            <td>{$row['data_publicacao']}</td>
                            <td>
                                <a href='editar_noticia.php?id={$row['id']}' class='btn-editar'>Editar</a>
                                <a href='apagar_noticia.php?id={$row['id']}' class='btn-apagar'
                                   onclick=\"return confirm('Tens a certeza que queres apagar esta notícia?')\">Apagar</a>
                            </td>
                        </tr>";
                        $i++;
                    }
                    if ($i == 1) {
                        echo "<tr><td colspan='5' style='text-align:center;color:#888;'>Nenhuma notícia publicada ainda.</td></tr>";
                    }
                ?>
            </tbody>
        </table>
    </section>

    <!-- ADICIONAR NOTÍCIA -->
    <section class="secao-admin escondido" id="adicionar">
        <h3 class="subtitulo">Nova Notícia</h3>

        <form class="formulario" method="POST" enctype="multipart/form-data">

            <div class="campo">
                <label>Título</label>
                <input type="text" name="titulo" placeholder="Escreve o título da notícia" required>
            </div>

            <div class="campo">
                <label>Resumo</label>
                <textarea name="resumo" placeholder="Breve resumo da notícia..." rows="3" required></textarea>
            </div>

            <div class="campo">
                <label>Conteúdo completo</label>
                <textarea name="conteudo" placeholder="Texto completo da notícia..." rows="6" required></textarea>
            </div>

            <div class="campo-linha">
                <div class="campo">
                    <label>Categoria</label>
                    <select name="categoria" required>
                        <option value="">Escolha uma categoria</option>
                        <option value="destaques">Destaques da Semana</option>
                        <option value="declaracoes">Declarações da Escola</option>
                        <option value="eventos">Eventos</option>
                        <option value="desporto">Desporto</option>
                    </select>
                </div>
                <div class="campo">
                    <label>Data</label>
                <input type="date" name="data" required>
                </div>
            </div>

            <div class="campo">
                <label>Imagem</label>
                <input type="file" name="imagem" accept="image/*">
            </div>

            <div class="botoes-formulario">
                <button type="submit" class="btn-guardar">Guardar Notícia</button>
                <button type="button" class="btn-cancelar" onclick="mostrarSecao('dashboard', document.querySelector('.nav-item'))">Cancelar</button>
            </div>

        </form>
    </section>

    <!-- GERIR NOTÍCIAS -->
    <section class="secao-admin escondido" id="noticias">
        <div class="topo-secao">
            <h3 class="subtitulo">Todas as Notícias</h3>
            <input type="text" class="pesquisa" id="campoPesquisa" placeholder="Pesquisar notícia..." onkeyup="pesquisar()">
        </div>

        <table class="tabela" id="tabelaNoticias">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Título</th>
                    <th>Categoria</th>
                    <th>Data</th>
                    <th>Ações</th>
                </tr>
            </thead>
            <tbody>
                <?php
                    require_once "conecxao.php";
                    $sql    = "SELECT * FROM noticias ORDER BY id DESC";
                    $result = mysqli_query($conn, $sql);
                    $i = 1;
                    while ($row = mysqli_fetch_assoc($result)) {
                        echo "<tr>
                            <td>{$i}</td>
                            <td>" . htmlspecialchars($row['titulo']) . "</td>
                            <td><span class='badge'>{$row['categoria']}</span></td>
                            <td>{$row['data_publicacao']}</td>
                            <td>
                                <a href='editar_noticia.php?id={$row['id']}' class='btn-editar'>Editar</a>
                                <a href='apagar_noticia.php?id={$row['id']}' class='btn-apagar'
                                   onclick=\"return confirm('Tens a certeza que queres apagar esta notícia?')\">Apagar</a>
                            </td>
                        </tr>";
                        $i++;
                    }
                    if ($i == 1) {
                        echo "<tr><td colspan='5' style='text-align:center;color:#888;'>Nenhuma notícia publicada ainda.</td></tr>";
                    }
                ?>
            </tbody>
        </table>
    </section>

</main>

<script>
    function mostrarSecao(id, elemento) {
        document.querySelectorAll('.secao-admin').forEach(s => s.classList.add('escondido'));
        document.getElementById(id).classList.remove('escondido');
        document.getElementById('titulo-pagina').textContent = elemento.textContent;
        document.querySelectorAll('.nav-item').forEach(n => n.classList.remove('ativo'));
        elemento.classList.add('ativo');
    }

    // Pesquisa em tempo real
    function pesquisar() {
        const filtro = document.getElementById("campoPesquisa").value.toLowerCase();
        const linhas = document.querySelectorAll("#tabelaNoticias tbody tr");
        linhas.forEach(linha => {
            const texto = linha.textContent.toLowerCase();
            linha.style.display = texto.includes(filtro) ? "" : "none";
        });
    }

    // Se veio de adicionar notícia com sucesso, mostrar dashboard
    <?php if (isset($sucesso)) echo "mostrarSecao('dashboard', document.querySelector('.nav-item'));"; ?>
</script>

</body>
</html>