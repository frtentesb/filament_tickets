# filament_tickets

# Atividades Realizadas (22/01/25):

-   FEITO - DrawSql -> Criar duas tabelas e seus relacionamentos

-   FEITO - Tabelas (Inventario e uma Transação_Inventario (essa vai rasterar as entradas e saidas dos nossos itens))

-   FEITO - Criar a model e migration dessas duas tabelas no nosso projeto

-   FEITO - Realizar commit do GitHub

-   FEIT0 - Criação de Painel Admin

-   FEITO - Alteração do Seeder para cadastro do primeiro Usuario

-   FEITO - Criação de Middleware para validação de Usuario ADM (Acesso ao painel Restrito)

-   FEITO - Ativação do plugin de profile

-   FEITO - Criação de pagina de cadastro Personalizada

-   FEITO - Testes de Login e cadastramento de usuarios.

-   FEITO - Teste de commit e push

-   FEITO - Criação da primeira Resource (TIcket)

# Atividades Realizadas (23/01/25):

-   FEITO - Criação das Enums

-   FEITO - Estruturar parte das Models

-   FEITO - Criação da resources de Fabricantes, Produtos e Tickes (Painel Adm)

-   FEITO - Criação de RelationManager do TIcke response com a Resource do Admin

-   FEITO - Criação dos Primeiros Relacionamentos

# Atividades Realizadas (24/01/25):

-   FEITO WALLACE - Ajuste no filtro da resource de produto (Veja explicação no comentario do codigo fonte)
-   FEITO WALLACE - Redirecionamento correto da notificação para abrir ticket no painel adm
-   FEITO WALLACE - Adição correta de icones (Ontem vc estava digitando errado o nome dos mesmos)

# Atividades para executar (24/01/25):

1. Ajustar os campos das suas resources, organize melhor pensando na USABILIDADE e na Logica de abertura/preenchimento dos itens

2. Estruturar o restante das Models

3. Criação de demais resources

# Comandos Utilizados

1. Subir container - docker compose up -d

2. Entrar no container - docker compose exec app bash

3. Criar Model e migration - php artisan make:model NomeDaModel -m

4. Criar middleware - php artisan make:Middleware NomeDoMiddleware

5. Rodar Migrations no Banco - php artisan migration

6. Rodar Migrations no Banco (Dropar tabelas existente e Recriar) - php artisan migration:fresh

7. Rodar Seed: php arisan db:seed (caso tabelas ja existam) | php artisan migration --seed (Caso no momento da criação)

8. Linkar repositorio de arquivos: php artisan storage:link (So precisa fazer 1 vez)
