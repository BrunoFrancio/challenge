# Let's create a `README.md` file with the provided content.

readme_content = """
# Desafio Fitness Foods LC

Este projeto é um desafio técnico proposto pela Coodesh. Ele consiste na implementação de uma API RESTful para gerenciamento de produtos alimentícios, utilizando Laravel e Docker para orquestração do ambiente de desenvolvimento.

## Tecnologias e Ferramentas Utilizadas

- **Linguagem:** PHP 8.1
- **Framework:** Laravel
- **Banco de Dados:** MySQL
- **Gerenciamento de Dependências:** Composer
- **Orquestração de Contêineres:** Docker e Docker Compose
- **Ambiente de Desenvolvimento:** VS Code

## Funcionalidades do Projeto

A API oferece um conjunto de endpoints para CRUD (Create, Read, Update e Delete) de produtos alimentícios, com os seguintes recursos:

1. **GET** `/api/status`: Verifica o status da API, conexão com o banco de dados e tempo de execução.
2. **GET** `/api/products`: Lista todos os produtos com paginação.
3. **GET** `/api/products/{codigo}`: Exibe as informações detalhadas de um produto específico.
4. **PUT** `/api/products/{codigo}`: Atualiza os detalhes de um produto existente.
5. **DELETE** `/api/products/{codigo}`: Move o produto para o status de lixeira.

Além disso, um sistema de notificação por e-mail alerta o administrador sobre falhas durante a sincronização dos dados.

## Como Instalar e Usar

### Pré-requisitos

Certifique-se de ter o **Docker** e o **Docker Compose** instalados em sua máquina.

### Passos para Instalação

1. **Clone o Repositório:**
   `git clone https://github.com/BrunoFrancio/challenge.git`
   `cd challenge`
   
2. **Configuração do Ambiente:**
    `cp .env.example .env`    

3. **Inicialização dos Contêineres:**
    `docker-compose up --build -d`

4. **Instalação das Dependências do Laravel:**
    `docker-compose exec app composer install`

5. **Configuração do Banco de Dados e Migrações:**
   `docker-compose exec app php artisan migrate`

5. **População de Dados:**
    `docker-compose exec app php artisan products:import`


## Nota: Este é um desafio técnico promovido pela [Coodesh](https://coodesh.com/).