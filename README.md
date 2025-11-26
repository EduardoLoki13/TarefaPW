 FakeCheck – Verificador de Notícias com Sistema de Votos & Login

Este projeto foi desenvolvido com o objetivo de auxiliar pessoas na verificação de credibilidade de notícias, permitindo que o usuário pesquise, avalie e compare informações registradas no banco. O sistema conta com login, cadastro, painel administrador e votação exclusiva por usuário autenticado.

 O que o site faz?

✔ Busca e identifica notícias cadastradas
✔ Classifica como Confiável, Suspeita ou Falsa
✔ Permite voto do usuário (Somente logado)
✔ Apenas um voto por usuário por notícia
✔ Gráfico em tempo real mostrando votos de "Útil" e "Não útil"
✔ Painel Admin para cadastro de novas notícias
✔ Bloqueio de acesso para quem tenta acessar admin sem login
✔ Design com animações em CSS

 Tecnologias utilizadas
Tecnologia	Função
HTML5	estrutura do site
CSS3	estilização + animações
JavaScript (Fetch/AJAX)	votação dinâmica sem recarregar página
PHP	backend e autenticação
MySQL	armazenamento das notícias e votos
Chart.js	gráfico de votos em pizza
 Estrutura do Projeto
/FakeCheck
│ index.php
│ login.php
│ cadastro.php
│ resultado.php
│ admin.php          ← Cadastro de notícias (só logado)
│ vote.php           ← Registro de votos por AJAX
│ conexao.php        ← Conexão MySQL
│ style.css          ← Tema + animações
└── /database (opcional)
     └── fakecheck.sql

 Banco de dados usado

Tabelas essenciais:

usuarios (id, nome, email, senha)
noticias (id_noticia, titulo, link, fonte, confiavel, criado_em)
votes (id_vote, id_noticia, id_user, util)
