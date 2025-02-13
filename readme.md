# Grandus Docker

## Setup

- install Docker Desktop
- run command

```
docker-compose up --build -d
```

## Set hosts

add Grandus localhosts to `/etc/hosts` file

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


## Basic feature examples

### Composer install

```
docker exec -i grandus-php cd /protected && composer install
```

### Run migrations 

```
docker exec -i grandus-php php protected/yii migrate
```

