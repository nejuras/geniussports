# Genius Sports

# Requirements
```
 - PHP 7.0+
 - Mysql 5.7.x
```

# How to Run dev environment
```
 $ git clone https://github.com/nejuras/geniussports.git
 $ cd path/to/<project>
 $ composer install
 edit .env DATABASE_URL=mysql://db_user:db_password@127.0.0.1:3306/db_name
 $ php bin/console doctrine:database:create
 $ php bin/console doctrine:schema:update --force
 $ php bin/console npm install
 $ php bin/console server:run

```

- Nerijus Juras
