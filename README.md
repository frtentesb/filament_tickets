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

# Atividades Realizadas (26/01/25):

-   FEITO WALLACE - Ajuste no filtro da resource de tickts (Organização do Layout / Inclusão query de busca pro enum)
-   FEITO WALLACE - Implantação parcial das models (Inventory / manufacturer/ review)
-   FEITO WALLACE - Identação das resources e models criadas (Retirada de espaços em branco)
-   FEITO WALLACE - Revisão das dúvidas
-   FEITO WALLACE - Implementação resource de estoque e controle de iventario.
-   FEITO WALLACE - Conceitos de Action Table e "Serviços Internos".
-   FEITO WALLACE - Conceitos de disparo de email.

# Atividades Realizadas (28/01/25):

-   Correção de Bug na model de Tickets (Relacionamento com a UserAddresses estava incorreto) **_Veja comentado na Model Ticket_**

-   Fabio: Estudar conceitos aplicados ate o momento para fixar aprendizagem
-   Fabio: implementar na coluna do ticker a data de agendamento
-   Fabio: Implementar disparo de email para cliente quando ticker for agendado
-   Fabio: Implementar Rotina para atualizar Start date quando agendamento for criado

# Comandos Utilizados

1. Subir container - docker compose up -d

2. Entrar no container - docker compose exec app bash

3. Criar Model e migration - php artisan make:model NomeDaModel -m

4. Criar middleware - php artisan make:Middleware NomeDoMiddleware

5. Rodar Migrations no Banco - php artisan migration

6. Rodar Migrations no Banco (Dropar tabelas existente e Recriar) - php artisan migration:fresh

7. Rodar Seed: php arisan db:seed (caso tabelas ja existam) | php artisan migration --seed (Caso no momento da criação)

8. Linkar repositorio de arquivos: php artisan storage:link (So precisa fazer 1 vez)

9. Rodar Queue - php artisan queue:word

10. Ver rotas do sistema: - php artinsa route:list
