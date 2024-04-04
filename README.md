Maxim Pukh: Symfony Test Application
========================

Requirements
------------

* PHP 8.2.0 or higher;
* PDO-SQLite PHP extension enabled;
* The [usual Symfony application requirements][2];
* Docker v4.20 or higher;
* Docker Compose v2.24 or higher.

Installation
------------

**1.** Run the database

```bash
cd itacwt_test/
docker-compose up -d
```

**2.** [Download Symfony CLI][4] and use the `symfony` binary installed
on your computer

**3.** Clone the repo, install the packages and run the server

```bash
cd itacwt_test/
symfony composer install
echo "APP_ENV=prod" > .env.local 
symfony serve -d --port=7777
```

**4.** Apply the migrations

```bash
cd itacwt_test/
symfony console doctrine:migrations:migrate
```

Usage
-----

Open the `requests.http` and run them

Mind **http** or **https**

Tests
-----
**1.** Do it once: prepare the database:
```bash
symfony console doctrine:database:create --env=test
symfony console doctrine:schema:create --env=test
```

**2.** Execute this command to run tests:

```bash
cd itacwt_test/
php bin/phpunit
```

[1]: https://symfony.com/doc/current/best_practices.html
[2]: https://symfony.com/doc/current/setup.html#technical-requirements
[3]: https://symfony.com/doc/current/setup/web_server_configuration.html
[4]: https://symfony.com/download
[5]: https://symfony.com/book
[6]: https://getcomposer.org/