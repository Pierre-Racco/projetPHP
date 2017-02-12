# Projet PHP uframework

## Pierre Racco et Pierre Couy-Perrais

### Initialisation Docker

    docker run -d \
    --volume /var/lib/mysql \
    --name data_mysql \
    --entrypoint /bin/echo \
    busybox \
    "mysql data-only container"

--- 

    docker run -d -p 3306 \
    --name mysql \
    --volumes-from data_mysql \
    -e MYSQL_USER=uframework \
    -e MYSQL_PASS=p4ssw0rd \
    -e ON_CREATE_DB=uframework \
    tutum/mysql

---

	docker ps 
	-> <port>

--- 
	
	mysql uframework -h127.0.0.1 -P<port> -uuframework -pp4ssw0rd < app/config/schema.sql

---

	Identifiants de connexion dans app/config/config.php si besoin d'être changés

---

### Projet PHP

	composer install

---
	[racine de l'archive]
	php -S localhost:8000 -t ./web


### FAIT

#### Status

	GET /statuses
	GET /statuses/{id}
	GET /statuses?{criteres}
	POST /statuses
	DELETE /statuses/{id}

#### Authentification

	GET /login
	GET /logout
	GET /signin
	POST /login
	POST /signin

	Fonctionnelle en session
	Non fonctionnelle pour l'API

#### Tests

	A rectifier
