BasicAPI
===============

## Requirements ##
- docker
- docker-compose

## Install ##

- copy config file

    ```
    cp .env.dist .env

- run docker

    ```
    docker-compose up -d

- go to php container

    ```
    docker exec -it basicapi-php-fpm bash

- execute framework console commands

    ```
    composer install
    php bin/console doctrine:migrations:migrate
    php bin/console doctrine:fixtures:load
    php bin/console cache:clear
    php bin/console assets:install

## API pages ##

    http://localhost:8888/api/doc
    http://localhost:8888/api/doc.json
