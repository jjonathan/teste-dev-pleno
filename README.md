# Instalação

- Clonar o respositório para o seu local: `git clone https://github.com/jjonathan/teste-dev-pleno.git`;
- Rodar o comando `composer install` para instalar todas as dependências do Laravel;
- Configurar o arquivo `.env` se baseando nas variáveis do arquivo [.env.example](/.env.example);
- Rodar o comando `php artisan migrate` dentro da pasta root do projeto para rodar as migrations;
- Rodar o comando `php artisan db:seed` para criar dados padrões no banco de dados (na tabela config fica a comissão de 8.5%)
- Rodar o comando `php artisan key:generate` para gerar a chave da aplicação;
- Rodar o comando `php artisan serve` para rodar o servidor interno;
- Rodar o comando `vendor\bin\phpunit` na pasta root do projeto para rodar os testes usando PHPUNIT;
- Seguir o arquivo [COMO_USAR.html](/COMO_USAR.html) para saber como usar cada uma das rotas.