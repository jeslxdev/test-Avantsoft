# Toy Store US

Este projeto é uma API para gestão de clientes e vendas de uma loja de brinquedos, desenvolvida em Laravel. O frontend/UI é feito em React.

## Stacks Utilizadas
- **Backend:** Laravel (PHP)
- **Frontend/UI:** React
- **Banco de Dados:** SQLite (padrão, pode ser adaptado para outros)
- **Autenticação:** JWT (Tymon JWT Auth)

## Funcionalidades
- Cadastro, listagem, edição e remoção de clientes
- Registro e consulta de vendas
- Relatórios de vendas por dia e por cliente
- Autenticação JWT protegendo rotas sensíveis

## Como rodar o projeto

### 1. Clonar o repositório
```bash
git clone <url-do-repositorio>
cd toy-store-us
```

### 2. Instalar dependências PHP
```bash
composer install
```

### 3. Copiar o arquivo de ambiente e gerar chave
```bash
cp .env.example .env
php artisan key:generate
```

### 4. Configurar o banco de dados
Por padrão, o projeto usa SQLite. Você pode usar outro banco se preferir, basta ajustar o `.env`.

Para SQLite:
```bash
touch database/database.sqlite
```
E no `.env`:
```
DB_CONNECTION=sqlite
DB_DATABASE=/caminho/absoluto/para/database.sqlite
```

### 5. Rodar as migrations
```bash
php artisan migrate
```

### 6. Rodar os seeders (opcional)
```bash
php artisan db:seed
```

### 7. Rodar o servidor de desenvolvimento
```bash
php artisan serve
```

### 8. Rodar os testes
```bash
php artisan test
```

## Frontend
O frontend em React está em outro repositório. Consulte a documentação do frontend para rodar a interface.

---

