install docker
 link https://www.docker.com/docker-mac

Install Docker Compose
 link https://docs.docker.com/compose/install/

$ git clone https://github.com/pakaya16/worktodotask.git

$ cd worktodotask
$ docker-conpose up -d
$ docker ps

**_345a3a6b9831_**        worktodotask_phpfpm   "docker-php-entryp..."   4 minutes ago       Up 4 minutes        9000/tcp                      worktodotask_phpfpm_1

copy dockerId

$ docker exec -it < dockerID > /bin/bash
$ cd laravel
$ composer install