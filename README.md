# Slim REST API

Este projeto é uma API REST simples desenvolvida com [Slim Framework](https://www.slimframework.com/) e estruturada em camadas (Domain, Application, Infrastructure e Presentation). A aplicação disponibiliza operações CRUD de **Usuários** e **Produtos**, utilizando autenticação JWT para proteger a maior parte das rotas.

## Requisitos

- [Docker](https://www.docker.com/) e [Docker Compose](https://docs.docker.com/compose/)

## Configuração

1. Copie o arquivo `.env.example` para `.env` e ajuste as variáveis se necessário:

   ```bash
   cp .env.example .env
   ```

2. Construa e inicie os contêineres:

   ```bash
   docker-compose up -d --build
   ```

   - A aplicação ficará disponível em [http://localhost:8080](http://localhost:8080)
   - O phpMyAdmin poderá ser acessado em [http://localhost:8081](http://localhost:8081)

3. Rode as migrações do banco de dados (Phinx) dentro do contêiner `app`:

   ```bash
   docker-compose exec app vendor/bin/phinx migrate
   ```

Após esses passos a API já estará pronta para uso em seu ambiente local.

## Endpoints principais

- `POST /api/auth/login` &mdash; retorna um token JWT. Utilize-o no cabeçalho `Authorization: Bearer <token>`
- CRUD de produtos (`/api/produtos`) e de usuários (`/api/usuarios`) conforme definido em [`src/Presentation/Http/Routes.php`](src/Presentation/Http/Routes.php)
- Documentação OpenAPI disponível em `/openapi`

As rotas de criação, edição e exclusão exigem autenticação via JWT.

## Migrações

Os arquivos de migração encontram-se em [`database/migrations`](database/migrations). O Phinx é configurado em [`phinx.php`](phinx.php) para utilizar a base MySQL definida no `docker-compose`.

Para criar novas migrações utilize:

```bash
docker-compose exec app vendor/bin/phinx create NomeDaMigracao
```

## Licença

Este projeto está disponibilizado sem garantia de suporte ou manutenção.
