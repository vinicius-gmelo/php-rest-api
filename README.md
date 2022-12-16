# REST API em PHP
REST API em PHP puro, com interfaces/classes para os modelos do banco, roteador e API.
## Requerimentos
Setar as variáveis de ambiente para o banco e iniciar o servidor. Exemplo:
```sh
$ DB_HOST=localhost DB_PORT=3306 DB_DBNAME=db DB_USER=user DB_PASSWORD=12345; cd public; php -S localhost:8080
```
Ou, utilizando o Composer (o script para setar as variáveis do banco é `src/config/env.sh`):
```sh
$ composer start
```
