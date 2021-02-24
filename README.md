# API-EMPESA

API feita em Symfony 5

**Objetivo do projeto**

    1. Desenvolver CRUD para criar Empresas

    2. Desenvolver CRUD para criar Sócios com relações com Empresas


**Documentação**


- **Instalção**

    - Pré-requisitos
        - PHP 7.4+  <br>
        - composer
        - extensão PDO e dos bancos ativas no php.ini
<br>

Após a clonagem do código no gitlab para a pasta que você salvar o clone do arquivo abra seu terminal ou prompt de comando e   acesse a pasta.

escreva o código:
    `composer install`
Esse comando irá baixar todas as dependências que o projeto precisa para instalar, caso você deseja ver quais pacoste estão sendo usados, basta acessar o arquivo `composer.json`.

<br>
<hr>

**Configuração do banco de dados** <br>
    No arquivo `.env` você pode configurar qual banco de dados você deseja usar, por padrão irá vir o PostgresSQL, mas você pode confirguar como deseja, para que as configurações funcionem você precisa configurar seu arquivo php.ini e ativar as extensões do banco que ira usar.

    DATABASE_URL="sqlite:///%kernel.project_dir%/var/data.db" <br>
    DATABASE_URL="mysql://db_user:db_password@127.0.0.1:3306/db_name" <br>
    DATABASE_URL="postgresql://postgres:123@127.0.0.1:5432/VoxTecnologia?"utf8

Caso seja usado o PostegreSQL é preciso usar as seguintes configurações: <br>
    - db_user: postgresql <br>
    - db_password: 123 <br>
    - db_local: 127.0.0.1 <br>
    - db_port: 5432 <br>
    - db_name: VoxTecnologia


<br>
<hr>
<br>
Após a configuração do banco escreva o seguinte código no seu terminal <br>

    php bin\console doctrine:database:create

Esse comando irá criar seu banco de dados sem que você precise escrever SQL <br>

depois escreva: <br>
`php bin/console doctrine:migrations:migrate` <br>
esse comando ira executar o SQL necessário para que seja criada as tabelas no banco que foi criado, para você ver qual como esta sendo executado, pode ir na pasta `src` -> `Migrations` e abri o arquivo da migration.

<hr>

Para subir o servidor você pode executar no seu terminal:

`symfony serve`

Para esse como funcionar é necessário ter o Symfony CLI instalado na sua maquina, você pode acessar https://symfony.com/download para baixar se quiser ou você pode executar:

`php -S localhost:8080 -t public`

Esse comando irá subir um servidor que ja vem embutido no PHP sendo assim não sendo necessário usar o APACHE.

<br>
<hr>

Rotas suportadas:

- **GET**
- **POST**
- **PUT**
- **DELETE**

<hr>
<br>

**Rotas Empresa**

`GET` -> `/empresas` -> **Lista todas as empresas**; `200` <br>
`POST` -> `/empresas` -> **Envia os dados para criar uma nova empresa**; `201` <br>
`PUT` -> `/empresa/{id}/update` -> **Atualiza empresa existente**; `200` ou caso não seja feita a atualização `204` <br>
`DELETE` -> `/empresa/{id}/delete` -> **Apaga uma empresa**; `204` ou caso não seja deletado `400` <br>
`GET` -> `/empresa/{id}` -> **Busca uma empresa pelo id**; `200` ou caso não encontre irá retornar `204`

<br><hr>

**Rotas Sócio**

`GET` -> `/socios` -> **Lista todas as sócios**; `200` <br>
`POST` -> `/socios` -> **Envia os dados para criar um novo sócio**; `201` <br>
`PUT` -> `/socio/{id}/update` -> **Atualiza sócio existente**; `200` ou caso não seja feita a atualização `204` <br>
`DELETE` -> `/socio/{id}/delete` -> **Apaga um sócio**; `204` ou caso não seja deletado `400` <br>
`GET` -> `/socio/{id}` -> **Busca um sócio pelo id**; `200` ou caso não encontre irá retornar `204` <br>
`GET` -> `/socio/empresa/{id}` **Buscar empresa pelo sócio**; `200` caso não encontre a empresa irá retornar `404`
