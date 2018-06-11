Gwenvael Dronka
===============

This application is used for a basic website

[![Build Status](https://travis-ci.org/Darkmira/drop-observer.svg?branch=develop)](https://travis-ci.org/Darkmira/drop-observer)
[![buddy pipeline](https://app.buddy.works/geoffreychameroy/gwenvael-dronka/pipelines/pipeline/134925/badge.svg?token=eae23eb4a245269757ce999d67a5c00771d4cde3c953cf735a0287df6be29452 "buddy pipeline")](https://app.buddy.works/geoffreychameroy/gwenvael-dronka/pipelines/pipeline/134925)

Installing Application
----------------

The easiest way to install this application is by using [Docker](https://www.docker.com/):

```bash
$> cp docker-compose.override.yml.dist docker-compose.override.yml
$> docker-compose up -d
```

After that you'll have to install dependencies and database
(on git bash on windows, you may have to add `winpty` before any docker command)
```bash
$> docker-compose exec app composer install
$> docker-compose exec app php bin/console app:fixtures:load
```

Send Database Modification
------------------------------

For update database on production, we use [DoctrineMigrationBundle](https://symfony.com/doc/master/bundles/DoctrineMigrationsBundle/index.html)
Be sure to clean your database before send a diff

```bash
$> docker-compose exec app php bin/console doctrine:database:drop --force
$> docker-compose exec app php bin/console doctrine:database:create
$> docker-compose exec app php bin/console doctrine:migrations:migrate -n
$> docker-compose exec app php bin/console doctrine:migrations:diff -n
```

You can add some necessary fixtures on the created file in the folder `/app/DoctrineMigrations`

Useful Links
------------

- Website demo [http://gwenvael-dronka.zen-unicorn.fr](http://gwenvael-dronka.zen-unicorn.fr)

Contributors
------------

- Geoffrey Chameroy
- Jennifer Calipel
- Gaël Nicolle
