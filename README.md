#  Deploymnet with Docker

1. run docker-compose up -d
2. to get docker container id - do docker container ls
2. get into the container docker exec -it containerid /bin/bash
3. composer update inside docker 
4. add your hostname to /etc/hosts (you can access dev.machinetest.com)

#  Deploymnet without Docker 
1. create database in mysql and add to .env 
2. php artisan serve

# Seeding
php artisan db:seed

# Link storage
php artisan storage:link

# migrate
php artisan migrate


