# 🔎 FakeCheck — Sistema de Verificação de Notícias  
Sistema web que permite pesquisar notícias cadastradas, verificar se são confiáveis, suspeitas ou falsas e ainda votar se o resultado foi útil ou não. Possui login, banco de dados, painel admin e gráfico dinâmico.



 ✨ Funcionalidades principais

| Função | Status |
|---|---|
| Cadastro e login de usuários | ✅ |
| Busca de notícias no banco de dados | ✅ |
| Classificação: **confiável / suspeita / falsa** | ✅ |
| Sistema de voto exclusivo por usuário | ✅ |
| Voto com **AJAX** (sem recarregar página) | ✅ |
| Gráfico de porcentagem com **Chart.js** | ✅ |
| Painel admin protegido por login | ✅ |
| CSS com animações e transições modernas | ⚡ |



 🛠 Tecnologias utilizadas

| Tecnologia | Uso |
|---|---|
| HTML5 | Estrutura das páginas |
| CSS3 | Estilização + Animações |
| JavaScript (Fetch/AJAX) | Votação dinâmica |
| PHP | Backend e autenticação |
| MySQL | Armazenamento de dados |
| Chart.js | Gráfico de votos |
<img width="1600" height="900" alt="image" src="https://github.com/user-attachments/assets/d7f6fa25-dc36-4a8a-9afa-5330549cc600" />



## 📁 Estrutura do projeto
''' texto
/FakeCheck
│ index.php → Página inicial |

│ login.php → Login do usuário |
│ cadastro.php → Cadastro de conta |
│ resultado.php → Resultado da pesquisa + gráfico |
│ admin.php → Cadastro de notícias (somente logado) |
│ vote.php → Processa votos via AJAX |
│ conexao.php → Conexão com banco MySQL |
│ style.css → Tema e animações do site |
└── /database |
└── fakecheck.sql (opcional) |

---

## 🔐 Banco de dados (MySQL)

**Tabelas usadas no sistema**

```sql
usuarios (id, nome, email, senha)
noticias (id_noticia, titulo, link, fonte, confiavel, criado_em)
votes (id_vote, id_noticia, id_user, util)



