## Sistema de gerencimento de biblioteca

### Introdução

Olá!

Aqui está o projeto desenvolvido para a fase de testes do processo seletivo. O sistema foi construído com PHP e PostgreSql, utilizando o framework Laravel, conforme as instruções fornecidas.

Este desafio tem como objetivo a criação de uma interface funcional de carteira financeira onde os usuários possam realizar operações de transferência de saldo e depósito. A aplicação deve garantir a segurança das transações, o tratamento de erros, e permitir reverter operações em casos de inconsistências ou por solicitação do usuário.

Para garantir a segurança algumas regras foram aplicadas: 

- O usuário não pode fazer transações para si;
- O usuário não pode solicitar estorno para transações canceladas;
- O usuário não pode solicitar estorno para transações com estorno em aberto;
- O usuário não pode solicitar estorno para transações as quais não tenham sido feitas por ele;
- O usuário só pode fazer no máximo 1 solicitação de estorno no dia antes que seja necessário um operador analisar;

### Ferramentas utilizadas

O Front-End foi feito com as laravel blades.
Para conseguir desenvolver o projeto eu utilizei diversar ferramentas para me auxiliar, dentre elas as principais foram:

- PHP 8.2
- Laravel 11
- PostgreSql 16
- Node 18
- laravel vite para compilação dos arquivos
- Tailwind 3 (para estilização do front-end)

## Como começar

Para inciar o sistema é necessário configurar na máquina as tecnologias listadas anteriormente, após a instalção é necessário criar um novo banco de dados com o nome 'library-rent' e senha 'password'. Após isso basta fazer o download do repositório e rodar os seguintes comandos após o download:

- composer install (instala as dependências do php)
- npm install (instala os pacotes do npm)
- php artisan migrate:fresh --seed (cria as tabelas no banco de dados e popula elas com o Seeder)
- npm run build (Compila os arquivos css e js)
- php artisan serve (Roda o projeto, por padrão na porta 8000)

Obs: É recomendável usar em formato mobile, embora esteja responsivo para desktop
