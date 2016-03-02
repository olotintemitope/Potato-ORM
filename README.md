
Potato ORM
----------
Potato-ORM is a simple agnostic ORM (Object Relational Mapping) package that can perform basic CRUD (Create, Read, Update and Delete) operations.

[![Coverage Status](https://coveralls.io/repos/github/andela-tolotin/Potato-ORM/badge.svg?branch=test)](https://coveralls.io/github/andela-tolotin/Potato-ORM?branch=test) [![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/andela-tolotin/Potato-ORM/badges/quality-score.png?b=test)](https://scrutinizer-ci.com/g/andela-tolotin/Potato-ORM/?branch=test) [![Build Status](https://travis-ci.org/andela-tolotin/Potato-ORM.svg?branch=test)](https://travis-ci.org/andela-tolotin/Potato-ORM)

How to use this package 
-----------------------
Composer installation is required before using this package. To  install a composer, you will need to download it first by running this command on your terminal.

    $ curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin

Installation
============

PHP 5.5+ and Composer are required. 

Via composer

    $ composer require Laztopaz/potatoORM

Install
=======

    $ composer install 
After you have installed the package via composer, then you are set to go. Next line of action is  to create a class that extends a base Model class under the nameapace Laztopaz/potatoORM. 

    <?php
    
    use Laztopaz\potatoORM;
    
    class User extends BaseClass {
       
    }

You need set your environment varible and define your database parameters

    databaseName      = xxxxxxx
    databaseDriver    = mysql
    databaseUsername  = xxxxxxx
    databasePassword  = xxxxxxx
    databasePort      = 33060
    databaseHost      = 127.0.0.1:33060

The default database used here is mysql. If you wish to change to a new database, define the database parameters in the environment variable file. You also need to add a table to your newly created database.
You need set your environment varible and define your database parameters

databaseName      = xxxxxxx
databaseDriver    = mysql
databaseUsername  = xxxxxxx
databasePassword  = xxxxxxx
databasePort      = 33060
databaseHost      = 127.0.0.1:33060

The default database used here is mysql. If you wish to change to a new database, define the database parameters in the environment variable file. You also need to add a table to your newly created database, that has the plural of your model class.


<?php

use Laztopaz\potatoORM;

class User extends BaseClass {
    

}

To save a new record, you will need to instatiation the class that extends the base model class. Assume your model class is User.

<?php

$user = new User();
$user->name = "Temitope Olotin";
$user->gender = "Male";
$user->alias = "Laztopaz";
$user->class = "14";
$user->stack = "php/laravel";
$user->save();

To update an existing record 

<?php

$users = User::find(1);
$user = new User();
$user->name = "Olotin Temitope";
$user->stack = "Java/Android";
$user->alias = "Laztopaz";
$user->save();

To delete a record 
<?php 
å
User::destroy(1);

You need set your environment varible and define your database parameters

    databaseName      = xxxxxxx
    databaseDriver    = mysql
    databaseUsername  = xxxxxxx
    databasePassword  = xxxxxxx
    databasePort      = 33060
    databaseHost      = 127.0.0.1:33060

The default database used here is mysql. If you wish to change to a new database, define the database parameters in the environment variable file. You also need to add a table to your newly created database, that has the plural of your model class.

    <?php
    
    use Laztopaz\potatoORM;
    
    class User extends BaseClass {
       
    }

To save a new record, you will need to instatiation the class that extends the base model class. Assume your model class is User.

    <?php
    
    $user = new User();
    $user->name = "Temitope Olotin";
    $user->gender = "Male";
    $user->alias = "Laztopaz";
    $user->class = "14";
    $user->stack = "php/laravel";
    $user->save();

To update an existing record
============================

    <?php
    
    $users = User::find(1);
    $user = new User();
    $user->name = "Olotin Temitope";
    $user->stack = "Java/Android";
    $user->alias = "Laztopaz";
    $user->save();

To delete a record
==================

    <?php 
    
    User::destroy(1);

