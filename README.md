# Portal de Noticias - IPIL Makarenko

Portal oficial de noticias do IPIL Makarenko, desenvolvido como projecto escolar.

Site: http://noticias-ipil-01.great-site.net

---

## Grupo

| No | Nome |
|----|------|
| 9  | Joao Lufua Afonso |
| 24 | Pedro Simanga Mbuyi |
| 25 | Ricardo Manzala |
| 26 | Rodrigo Elias Caculo |

Assistencia tecnica: Claude (Anthropic) — Tia oficial do grupo

---

## Descricao

Portal de noticias escolar desenvolvido para manter a comunidade do IPIL Makarenko informada sobre os acontecimentos da escola. O portal permite a publicacao de noticias por administradores, registo e login de utilizadores, e comentarios nos artigos.

---

## Tecnologias Utilizadas

| Tecnologia | Utilizacao |
|------------|------------|
| HTML5 | Estrutura das paginas |
| CSS3 | Estilizacao e design responsivo |
| JavaScript | Interactividade (slideshow, drawer, validacoes) |
| PHP | Backend e logica do servidor |
| MySQL | Base de dados |
| Laragon | Ambiente de desenvolvimento local |
| InfinityFree | Hospedagem gratuita |
| phpMyAdmin | Gestao da base de dados |

---

## Estrutura do Projecto

```
Portal_IPIL/
|
|-- index.php              # Pagina principal com slideshow e noticias
|-- cadastro.php           # Registo de novos utilizadores
|-- login.php              # Login de utilizadores
|-- logout.php             # Terminar sessao
|-- admin.php              # Painel de administracao
|-- editar_noticia.php     # Editar noticias existentes
|-- apagar_noticia.php     # Apagar noticias
|-- conexao.php            # Conexao com a base de dados
|
|-- css/
|   |-- style.css          # Estilos globais e header/footer
|   |-- slides.css         # Estilos do slideshow
|   |-- cards.css          # Estilos dos cards de noticias
|   |-- drawes.css         # Estilos do drawer lateral
|   |-- login.css          # Estilos da pagina de login
|   |-- cadastro.css       # Estilos da pagina de cadastro
|   |-- admin.css          # Estilos do painel de admin
|
|-- js/
|   |-- slide.js           # Logica do slideshow automatico
|   |-- drawer.js          # Logica do drawer lateral
|   |-- cadastro.js        # Validacao do formulario de cadastro
|
|-- uploads/               # Imagens das noticias
```

---

## Base de Dados

Nome: if0_41923782_db_banco_de_dados

### Tabelas:

**utilizadores**
- id - INT, PRIMARY KEY, AUTO INCREMENT
- nome - VARCHAR(100)
- email - VARCHAR(150)
- senha - VARCHAR(255)
- tipo - VARCHAR(20) - utilizador ou administrador

**noticias**
- id - INT, PRIMARY KEY, AUTO INCREMENT
- titulo - VARCHAR(255)
- resumo - TEXT
- conteudo - TEXT
- imagem - VARCHAR(255)
- categoria - VARCHAR(50)
- data - DATE
- utilizador_id - INT (quem publicou)

**comentarios**
- id - INT, PRIMARY KEY, AUTO INCREMENT
- noticia_id - INT
- utilizador_id - INT
- texto - TEXT
- data - DATETIME

---

## Funcionalidades

- Slideshow automatico com transicao suave
- Drawer lateral para leitura de noticias
- Registo de utilizadores
- Login e logout
- Painel de administracao
- Publicacao, edicao e remocao de noticias
- Sistema de categorias (Destaques, Declaracoes, Eventos, Desporto)
- Design responsivo (mobile e desktop)
- Diferenciacaoo entre admin e utilizador normal

---

## Sistema de Administrador

O sistema distingue administradores de utilizadores normais atraves da senha:
- Senhas que comecam com ADM sao registadas como administradores
- Todas as outras senhas sao registadas como utilizadores normais

---

## Escola

IPIL Makarenko - Luanda, Angola
ipilmakarenko@escola.ao

---

Projecto desenvolvido em 2026
