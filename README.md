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

Foi adotada uma arquitetura monolítica moderna utilizando Laravel no backend e Vue.js no frontend, integrados através do Inertia.js.

- O Laravel é responsável pela autenticação, regras de negócio, rotas e acesso ao banco de dados.

- O Vue.js é responsável pela interface da aplicação.

### Autenticação

Para realizar o login antes de acessar a manutenção de pessoas, foi utilizada autenticação baseada em sessão com Laravel Breeze. 

- Essa escolha permite utilizar uma solução oficial do ecossistema Laravel para login, logout e proteção de rotas.

###  Banco de dados 

MySQL no ambiente local de desenvolvimento.

### Ambiente de desenvolvimento

O projeto está sendo executado localmente com Laragon, por ser um ambiente prático para desenvolvimento com Laravel, PHP e MySQL no Windows.

## Como executar o projeto localmente

### Pré-requisitos

Antes de iniciar, é necessário ter instalado na máquina:

- PHP 8.2 ou superior
- Composer
- Node.js e npm
- MySQL
- Laragon (opcional, mas foi o ambiente utilizado no desenvolvimento)

### Passo a passo

1. Clonar o repositório
```bash
git clone https://github.com/Marcos-Petry/people-manager.git
cd people-manager
```

2. Instalar as dependências do backend
```bash
composer install
```

3. Instalar as dependências do frontend
```bash
npm install
```

4. Criar o arquivo de ambiente
```bash
cp .env.example .env
```

5. Gerar a chave da aplicação
```bash
php artisan key:generate
```

6. Configurar o banco de dados exemplo
```bash
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=people_manager
DB_USERNAME=root
DB_PASSWORD=
```

7. Criar o banco de dados
```bash
CREATE DATABASE people_manager;
```

8. Executar as migrations
```bash
php artisan migrate
```

9. Iniciar o servidor backend
```bash
php artisan serve
```

10. Iniciar o servidor frontend com Vite
```bash
npm run dev
```

11. Acessar o sistema
```bash
http://127.0.0.1:8000
```