# TODOLIST

ToDoList is a To do list application, running in Symfony framework.

## Development environment
PHP 7.4
MySQL 8.0.26
Symfony 4.4
Symfony server
Linux Ubuntu
Composer 2.1.8

## Installation

1. Clone Github repository
    - git clone https://github.com/Reididsorg/PhoneTelTest3.git

2. Install dependancies
    - composer install  
    You may alternatively need to run :
    - php composer.phar install  
    (Depending on how you installed Composer)

3. Clone '.env' file at root project and rename it '.env.local', in order to configure environment vars and make any adjustments you need.   
   Specifically : 'DATABASE_URL'.  
   Then, *override* any configuration you need there (instead of changing '.env' directly).
   
4. Setup the database and Install fixtures
    - bin/console doctrine:database:create (or manually create database)
    - bin/console doctrine:migrations:diff
    - bin/console doctrine:migrations:migrate
    - bin/console doctrine:fixtures:load

Open local website in web browser :)

Find API documentation at : http://yourAdressDomain.local

## Codacy Badge
