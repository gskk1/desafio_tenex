# Desafio API REST em PHP

Este desafio foi realizado de acordo com as instruções encontradas no link (https://drive.google.com/file/d/12pNOPl4d3UE4mU-qcyUdkBJJP5p3QT5Z/view)

## Instruções para Utilização da API

Siga os passos abaixo para configurar e utilizar a API:

### 1. Criar o Banco de Dados

- Para configurar o banco de dados necessário para o funcionamento da API, utilize os comandos SQL fornecidos no arquivo `database.sql` localizado na raiz deste projeto.
- O banco de dados será criado com o nome especificado no arquivo de configuração.

### 2. Configuração do Usuário e Senha

- Utilize o usuário `"root"` e a senha `"1234"` para acessar o banco de dados.
- Caso deseje alterar o usuário ou a senha, edite o arquivo `index.php` e modifique a linha:

    ```php
    $database = new Database("localhost", "carne_db", "root", "1234");
    ```

  Substitua `"root"` e `"1234"` pelos seus dados de usuário e senha preferidos.

### 3. Rodando a API

- Para iniciar a API, execute o seguinte comando no terminal, no diretório onde se encontra o arquivo `index.php`:

    ```bash
    php -S localhost:<porta>
    ```

  Substitua `<porta>` pelo número da porta desejada (por exemplo, `8000`).

### 4. Testando a API

- Uma vez que o servidor esteja rodando, você pode acessar e testar os endpoints da API através de um cliente HTTP, como Postman ou cURL.
