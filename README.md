install docker
 link https://www.docker.com/docker-mac

Install Docker Compose
 link https://docs.docker.com/compose/install/

use port 3306, 80

```bash
git clone https://github.com/pakaya16/worktodotask.git
cd worktodotask
docker-compose up -d
docker ps
```
**copy ContainerID**

**_345a3a6b9831_**        worktodotask_phpfpm   "docker-php-entryp..."   4 minutes ago       Up 4 minutes        9000/tcp                      worktodotask_phpfpm_1

```bash
docker exec -it < dockerID > /bin/bash
cd laravel
composer install
php artisan migrate:refresh --seed

```
open broswer
 http://localhost/
 
 see text laravel
 
open document
 http://localhost/doc