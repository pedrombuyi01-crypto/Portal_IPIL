<?php require_once "conecxao.php"; ?>

<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>IPIL Makarenko - Portal de Notícias</title>
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/slides.css">
    <link rel="stylesheet" href="css/cards.css">
    <link rel="stylesheet" href="css/drawes.css">
</head>
<body>

<header>
    <h1><span>IPIL</span> Makarenko</h1>
    <nav>
        <a href="#">Início</a>
        <a href="#destaques">Destaques da semana</a>
        <a href="#declaracoes">Declarações da escola</a>
        <a href="#eventos">Eventos</a>
    </nav>
    <a href="cadastro.php" class="cadastro">Entrar</a>
</header>

<main>

    <div class="overlay"></div>
    <div class="drawer">
        <button class="btn-fechar">✕</button>
        <img src="" alt="imagem">
        <h2>titulo</h2>
        <p>texto por extenso</p>
    </div>

    <!-- SLIDESHOW - primeira notícia de destaque -->
    <section class="slideshow" id="inicio">
        <?php
            $sql_slide = "SELECT * FROM noticias ORDER BY id DESC LIMIT 4";
            $result_slide = mysqli_query($conn, $sql_slide);
            $slides = [];
            while ($row = mysqli_fetch_assoc($result_slide)) {
                $slides[] = $row;
            }
            $primeiro = $slides[0] ?? null;
          $imagem_slide = ($primeiro && !empty($primeiro['imagem'])) ? "uploads/" . $primeiro['imagem'] : "";?>
        <div class="slide-track">
            <img class="slide-img" src="<?php echo $imagem_slide; ?>" alt="destaque">
        </div>
        <div class="slide-overlay"></div>
        <div class="slide-conteudo">
            <span class="tag" id="slide-categoria">
                <?php echo $primeiro ? htmlspecialchars($primeiro['categoria']) : 'Destaques'; ?>
            </span>
            <h1 id="slide-titulo">
                <?php echo $primeiro ? htmlspecialchars($primeiro['titulo']) : 'Bem-vindo ao IPIL Makarenko'; ?>
            </h1>
            <p id="slide-resumo">
                <?php echo $primeiro ? htmlspecialchars($primeiro['resumo']) : 'Portal oficial de notícias.'; ?>
            </p>
            <?php if ($primeiro): ?>
            <button class="btn-ler" onclick="abrirDrawer(
                '<?php echo addslashes($primeiro['titulo']); ?>',
                '<?php echo $imagem_slide; ?>',
                '<?php echo addslashes($primeiro['conteudo']); ?>'
            )">Ler mais</button>
            <?php endif; ?>
        </div>
        <div class="slide-nav">
            <button class="slide-btn" onclick="slideAnterior()">&#8592;</button>
            <div class="slide-dots" id="dots"></div>
            <button class="slide-btn" onclick="slideProximo()">&#8594;</button>
        </div>
    </section>

    <!-- DESTAQUES DA SEMANA -->
    <section class="secao" id="destaques">
        <div class="secao-topo">
            <div class="secao-label">Destaques da Semana</div>
            <div class="secao-linha"></div>
        </div>
        <div class="grid-cards">
            <?php
                $sql = "SELECT * FROM noticias WHERE categoria = 'destaques' ORDER BY id DESC LIMIT 3";
                $result = mysqli_query($conn, $sql);
                $count = 0;
                while ($row = mysqli_fetch_assoc($result)) {
                    $count++;
                    $imagem   = !empty($row['imagem']) ? "uploads/" . $row['imagem'] : "imgs/PC_WALPAPPER.jpg";
                    $titulo   = htmlspecialchars($row['titulo']);
                    $resumo   = htmlspecialchars($row['resumo']);
                    $conteudo = addslashes($row['conteudo']);
                    $data     = $row['data'];
                    echo "
                    <article class='card'>
                        <div class='card-img'>
                            <img src='$imagem' alt='notícia'>
                            <span>destaques</span>
                        </div>
                        <div class='card-body'>
                            <h2>$titulo</h2>
                            <p>$resumo</p>
                            <div class='card-rodape'>
                                <button class='btn-ler' onclick=\"abrirDrawer('$titulo', '$imagem', '$conteudo')\">Ler mais</button>
                                <small>$data</small>
                            </div>
                        </div>
                    </article>";
                }
                if ($count == 0) {
                    echo "<p style='color:#888;padding:20px;'>Nenhum destaque publicado ainda.</p>";
                }
            ?>
        </div>
    </section>

    <!-- DECLARAÇÕES DA ESCOLA -->
    <section class="secao" id="declaracoes">
        <div class="secao-topo">
            <div class="secao-label">Declarações da Escola</div>
            <div class="secao-linha"></div>
        </div>
        <div class="grid-cards">
            <?php
                $sql = "SELECT * FROM noticias WHERE categoria = 'declaracoes' ORDER BY id DESC LIMIT 3";
                $result = mysqli_query($conn, $sql);
                $count = 0;
                while ($row = mysqli_fetch_assoc($result)) {
                    $count++;
                    $imagem   = !empty($row['imagem']) ? "uploads/" . $row['imagem'] : "imgs/PC_WALPAPPER.jpg";
                    $titulo   = htmlspecialchars($row['titulo']);
                    $resumo   = htmlspecialchars($row['resumo']);
                    $conteudo = addslashes($row['conteudo']);
                    $data     = $row['data'];
                    echo "
                    <article class='card'>
                        <div class='card-img'>
                            <img src='$imagem' alt='notícia'>
                            <span>declarações</span>
                        </div>
                        <div class='card-body'>
                            <h2>$titulo</h2>
                            <p>$resumo</p>
                            <div class='card-rodape'>
                                <button class='btn-ler' onclick=\"abrirDrawer('$titulo', '$imagem', '$conteudo')\">Ler mais</button>
                                <small>$data</small>
                            </div>
                        </div>
                    </article>";
                }
                if ($count == 0) {
                    echo "<p style='color:#888;padding:20px;'>Nenhuma declaração publicada ainda.</p>";
                }
            ?>
        </div>
    </section>

    <!-- EVENTOS -->
    <section class="secao" id="eventos">
        <div class="secao-topo">
            <div class="secao-label">Eventos</div>
            <div class="secao-linha"></div>
        </div>
        <div class="grid-cards">
            <?php
                $sql = "SELECT * FROM noticias WHERE categoria = 'eventos' ORDER BY id DESC LIMIT 3";
                $result = mysqli_query($conn, $sql);
                $count = 0;
                while ($row = mysqli_fetch_assoc($result)) {
                    $count++;
                    $imagem   = !empty($row['imagem']) ? "uploads/" . $row['imagem'] : "imgs/PC_WALPAPPER.jpg";
                    $titulo   = htmlspecialchars($row['titulo']);
                    $resumo   = htmlspecialchars($row['resumo']);
                    $conteudo = addslashes($row['conteudo']);
                    $data     = $row['data'];
                    echo "
                    <article class='card'>
                        <div class='card-img'>
                            <img src='$imagem' alt='notícia'>
                            <span>eventos</span>
                        </div>
                        <div class='card-body'>
                            <h2>$titulo</h2>
                            <p>$resumo</p>
                            <div class='card-rodape'>
                                <button class='btn-ler' onclick=\"abrirDrawer('$titulo', '$imagem', '$conteudo')\">Ler mais</button>
                                <small>$data</small>
                            </div>
                        </div>
                    </article>";
                }
                if ($count == 0) {
                    echo "<p style='color:#888;padding:20px;'>Nenhum evento publicado ainda.</p>";
                }
            ?>
        </div>
    </section>

</main>

<footer>
    <div class="footer-container">
        <div class="footer-secao">
            <h4>IPIL Makarenko</h4>
            <p>O portal oficial de notícias do IPIL Makarenko. Mantendo a comunidade informada.</p>
        </div>
        <div class="footer-secao">
            <h4>Navegação</h4>
            <ul>
                <li><a href="#">Início</a></li>
                <li><a href="#destaques">Destaques da semana</a></li>
                <li><a href="#declaracoes">Declarações da escola</a></li>
                <li><a href="#eventos">Eventos</a></li>
            </ul>
        </div>
        <div class="footer-secao">
            <h4>Contacto</h4>
            <p>Luanda, Angola</p>
            <p>ipilmakarenko@escola.ao</p>
            <p>+244 900 000 000</p>
        </div>
    </div>
    <div class="footer-bottom">
        <p>&copy; 2026 IPIL Makarenko - Todos os direitos reservados</p>
    </div>
</footer>
<script src="drawer.js"></script>

<!-- SLIDESHOW DINÂMICO COM DADOS DO BANCO -->
<script>
    const slides = <?php

        $arr = [];
        foreach ($slides as $s) {
            $arr[] = [
                "imagem" => !empty($s['imagem']) ? "uploads/" . $s['imagem'] : "",                
                "categoria" => $s['categoria'],
                "titulo"    => $s['titulo'],
                "resumo"    => $s['resumo'],
                "conteudo"  => $s['conteudo']
            ];
        }
        echo json_encode($arr);
    ?>;
</script>
<script src="slide.js"></script>

</body>
</html>