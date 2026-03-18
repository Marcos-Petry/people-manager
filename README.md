# People Manager

Este projeto foi desenvolvido como resposta à etapa final do processo seletivo da **Apresenta.me**!

## Desafio proposto

Criar um projeto com Laravel e Vue.js, para cadastro, alteração, exclusão e visualização de pessoas. Onde é realizado o login com um user e depois esse user pode realizar a manutenção de pessoas.
- Listagem
- Cadastro
- Alteração
- Exclusão

Migration para criar a tabela de pessoas e seus atributos, sendo eles:
- id 
- nome
- cpf
- tipo (fisica/juridica)
- telefone
- email

Trabalhar com Laravel, Vue.js e Tailwind

## Decisões adotadas para a implementação da solução

Com base nos requisitos propostos, foi definido a seguinte abordagem para o projeto

### Arquitetura

Foi adotada uma estrutura com Laravel e Vue no mesmo projeto, mantendo o backend e o frontend organizados de forma separada dentro da mesma aplicação.

- O Laravel é responsável pela autenticação, regras de negócio, rotas e acesso ao banco de dados.

- O Vue.js é responsável pela interface da aplicação.

### Autenticação

Para realizar o login antes de acessar a manutenção de pessoas, foi utilizada autenticação baseada em sessão com Laravel Breeze. 

- Essa escolha permite utilizar uma solução oficial do ecossistema Laravel para login, logout e proteção de rotas.

###  Banco de dados 

MariaDB no ambiente local de desenvolvimento.

### Ambiente de desenvolvimento

O projeto está sendo executado localmente com Laragon, por ser um ambiente prático para desenvolvimento com Laravel, PHP e MariaDB no Windows.