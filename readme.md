# Grandus Docker

## Setup

- install Docker Desktop
- create `.env` file from `.env.example`
- run command

```
docker-compose up --build -d
```

## Structure

- `build` - Dockerfiles to build the container
- `data` - all necessary configs, volumes to access data from containers
- `app` - demo app to test php containers


## Set hosts

add Grandus containers to `/etc/hosts` file

```
127.0.0.1 grandus.test
127.0.0.1 grandus-sync.test
```


## Import DB

- dump database
- place the dump file inside `/data/db`
- create database inside the docker container

```
docker exec -i grandus-db mariadb -u root -padmin    
```

```
CREATE DATABASE grandus_backend_instance11 CHARACTER SET utf8 COLLATE utf8_general_ci;
```

```
docker exec -i grandus-db mariadb -u root -padmin grandus_backend_instance11 < /source/grandus_backend_instance11.sql
```

- or use DB tool like DBeaver

## Basic feature examples

use `docker exec` to run commands inside docker container or open the container in 
Docker Desktop then use the terminal in Exec tab

### Composer install

```
docker exec -i grandus-php cd /protected && composer install
```

### Run migrations 

```
docker exec -i grandus-php php protected/yii migrate
```

