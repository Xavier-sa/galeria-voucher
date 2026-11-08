<div align="center">

# 🎓 GALERIA VOUCHER
</div>

<div align="center">
  <picture>
    <source media="(prefers-color-scheme: dark)" srcset="App/View/assets/img/utilitarios/voucher-logo-green.jpg">
    <source media="(prefers-color-scheme: light)" srcset="App/View/assets/img/utilitarios/voucher-logo-green.jpg">
    <img alt="Logo Galeria Voucher" src="App/View/assets/img/utilitarios/voucher-logo-green.jpg" width="200">
  </picture>
</div>

A **Galeria Voucher** é um projeto desenvolvido para exibir as turmas participantes do programa governamental de formação técnica em **Desenvolvimento de Sistemas**, com destaque para os **Projetos Integradores (PI)** criados durante o curso.

## 🖼️ Visão Geral do Sistema

| Tela | Miniatura | Descrição |
|------|------------|-----------|
| 🏠 **Home** | ![Tela Home](Docs/tela_home_deploy.PNG) | Página inicial da Galeria, com destaque para turmas e projetos. |
| 🔐 **Login** | ![Tela Login](Docs/tela_login.PNG) | Acesso administrativo para manutenção de dados e cadastro de novas turmas. |
| 👩‍🏫 **Turmas** | ![Tela Turma](Docs/tela_turmas.PNG) | Listagem e detalhes das turmas participantes do programa. |
| 👨‍💻 **Desenvolvedores** | ![Tela Desenvolvedores](Docs/tela_desenvolvedores.PNG) | Página que apresenta os criadores e mantenedores do projeto. |
| 🛠️ **Administrador** | ![Tela Admin](Docs/tela_login_admin.png) | Painel de gerenciamento utilizado  manter os dados atualizados. |

## 📌 Objetivo

O objetivo da **Galeria Voucher** é **centralizar e divulgar** os trabalhos desenvolvidos pelas turmas, promovendo visibilidade às soluções criativas e técnicas que os alunos criaram ao longo do curso.

📄 **Para informações técnicas e orientações para desenvolvedores**, acesse o documento de apoio:  
🔗 [Orientações para Devs](./Docs/orientacoes-dev.md)


## 🧩 Funcionalidades

- 📚 Exibição das turmas participantes  
- 🧑‍💻 Listagem dos **Projetos Integradores** de cada turma  
- 🔍 Visualização detalhada de cada projeto (descrição, tecnologias usadas, equipe, etc.)  
- 🌐 Interface **amigável e responsiva** para o público  
- ⚙️ Painel administrativo para controle interno (em desenvolvimento)

## 🏛️ Sobre o Programa

O projeto está inserido no **programa governamental de capacitação técnica** que visa preparar estudantes para o mercado de trabalho na área de **Desenvolvimento de Sistemas**.  

Cada turma participante desenvolve, ao longo do curso, um **Projeto Integrador (PI)**, aplicando de forma prática os conhecimentos adquiridos.

<div align="center">

## 🛠️ Tecnologias Utilizadas

| Camada | Tecnologias |
|--------|--------------|
| 🎨 **Frontend** | HTML, CSS, JavaScript |
| ⚙️ **Backend** | PHP |
| 🗄️ **Banco de Dados** | MySQL |

</div>

## 🚀 Como executar o projeto
```bash
# Clone o repositório
git clone https://github.com/VoucherDesenvSenacHub/galeria-voucher.git

# Acesse o diretório do projeto
cd galeria-voucher

# Crie a configuração local (não versionada)
cp .env.example .env.local

# Inicie o servidor embutido do PHP
php -S localhost:8000
```

Acesse `http://localhost:8000`. O PHP precisa da extensão `pdo_pgsql` habilitada.
Preencha `DATABASE_URL` em `.env.local` com a connection string do Neon. Como
alternativa, use as variáveis `DB_*`; `DB_SSLMODE=require` é obrigatório. Para Apache/XAMPP, `APP_URL=auto`
detecta automaticamente o subdiretório do projeto.
## 👥 Colaboradores
[![Anuar El](https://github.com/AnuarRezz.png?size=50)](https://github.com/AnuarRezz)
[![Bruno Ribeiro](https://github.com/brunoDevfull.png?size=50)](https://github.com/brunoDevfull)
[![Carlos Eduardo](https://github.com/yonnnxr.png?size=50)](https://github.com/yonnnxr)
[![Frederico Soares](https://github.com/Fred-Curso-Do-Senac-2024-Tc-ADS.png?size=50)](https://github.com/Fred-Curso-Do-Senac-2024-Tc-ADS)
[![Henrique Guisa](https://github.com/henriguisatec.png?size=50)](https://github.com/henriguisatec)
[![Gustavo Santos](https://github.com/sntosz.png?size=50)](https://github.com/sntosz)
[![joao heitor](https://github.com/joaoheitoror.png?size=50)](https://github.com/joaoheitoror)
[![João Pedro](https://github.com/jeipe.png?size=50)](https://github.com/jeipe)
[![Jonatan Samuel](https://github.com/samuelserri.png?size=50)](https://github.com/samuelserri)
[![José Otávio](https://github.com/OtavioDayrots.png?size=50)](https://github.com/OtavioDayrots)
[![Lourran](https://github.com/ribinha-code.png?size=50)](https://github.com/ribinha-code)
[![Lucas Ajpert](https://github.com/LucasAjpert.png?size=50)](https://github.com/LucasAjpert)
[![Luis Cunha](https://github.com/LuisCunha05.png?size=50)](https://github.com/LuisCunha05)
[![Luiz Oliveira](https://github.com/LuizzOliveira.png?size=50)](https://github.com/LuizzOliveira)
[![Manoel Oliveira](https://github.com/Tewdric.png?size=50)](https://github.com/Tewdric)
[![Matheus Corsine](https://github.com/matheuscorsine.png?size=50)](https://github.com/matheuscorsine)
[![Riquelme Gomes](https://github.com/RiquelmeG22.png?size=50)](https://github.com/RiquelmeG22)
[![Rodrigo Santos](https://github.com/rodrigo570282.png?size=50)](https://github.com/rodrigo570282)
[![Sambegara Cristaldo](https://github.com/Saambrc.png?size=50)](https://github.com/Saambrc)
[![Wellington Xavier](https://github.com/Xavier-sa.png?size=50)](https://github.com/Xavier-sa)
[![Wendril Ferreira](https://github.com/WendrilSFS.png?size=50)](https://github.com/WendrilSFS)
[![S4GAZI](https://github.com/S4GAZI.png?size=50)](https://github.com/S4GAZI)
[![Andromeda067](https://github.com/Andromeda067.png?size=50)](https://github.com/Andromeda067)
[![Erika Santos](https://github.com/Erikasantos31.png?size=50)](https://github.com/Erikasantos31)
[![Celestino](https://github.com/Celestiinoo.png?size=50)](https://github.com/Celestiinoo)

<!-- atencao confirma quem deve permanecer no documento e no github com os professores obs os tres abaixo a foto padrao do github quebra la no readem atualizar para images -->
<!-- [![Desenvolvedor(a) Devs146](https://github.com/Devs146.png?size=50)](https://github.com/Devs146) -->
<!-- [![Jéssica Santos](https://github.com/jessica249.png?size=50)](https://github.com/jessica249) -->
### Orientadores (Professores)
[![Mauricio de Souza](https://github.com/Mauriiicio.png?size=50)](https://github.com/Mauriiicio)
[![Thiago Suzuqui](https://github.com/thszk.png?size=50)](https://github.com/thszk)
