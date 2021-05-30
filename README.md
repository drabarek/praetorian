# praetorian

## Docker:
docker-compose -f ./docker/docker-compose.yml -p praetorian up -d --force-recreate --remove-orphans

docker exec -it praetorian_php-fpm_1 bash

cd ../praetorian/current/backend/

composer install

## Migrations:
php bin/console make:migration

## Host
http://localhost:7501
