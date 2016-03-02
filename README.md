
Potato ORM
----------

[![Coverage Status](https://coveralls.io/repos/github/andela-tolotin/Potato-ORM/badge.svg?branch=test)](https://coveralls.io/github/andela-tolotin/Potato-ORM?branch=test) [![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/andela-tolotin/Potato-ORM/badges/quality-score.png?b=test)](https://scrutinizer-ci.com/g/andela-tolotin/Potato-ORM/?branch=test) [![Build Status](https://travis-ci.org/andela-tolotin/Potato-ORM.svg?branch=test)](https://travis-ci.org/andela-tolotin/Potato-ORM)

Potato-ORM is a simple agnostic ORM (Object Relational Mapping) package that can perform basic CRUD (Create, Read, Update and Delete) operations.

How to use this package 
-----------------------
Composer installation is required before using this package. To  install a composer,  try running this command on your terminal.

    $ curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin

Installation
============

PHP 5.5+ and Composer are required. 

Via composer

    $ composer require Laztopaz/potatoORM

Install
=======

    $ composer install 
After you have installed the package via composer, then you are set to go. Next line of action is  to create a class that extends a base Model class under the nameapace Laztopaz/potatoORM. For instance, a class for users or Users table should look like this:

    <?php
    
    use Laztopaz\potatoORM;
    
    class User extends BaseClass {
       
    }

You also need set your environment variables to define your database parameters.

    databaseName      = xxxxxxx
    databaseDriver    = mysql
    databaseUsername  = xxxxxxx
    databasePassword  = xxxxxxx
    databasePort      = 33060
    databaseHost      = 127.0.0.1:33060

The default database driver used for this package is mysql. If you wish to change to a new database, define the database parameters in the environment variable file. 

Support for database drivers
=======================
This package supports the following drivers;

    1. MySQL 
    2. Postgres 
    3. SQLite

To save a new record, you will need to instatiation the class that extends the base model class. Assume your model class is User.

Save a new record
===============
    <?php
    
    $user          = new User();
    $user->name    = "Temitope Olotin";
    $user->gender  = "Male";
    $user->alias   = "Laztopaz";
    $user->class   = "14";
    $user->stack   = "php/laravel";
    $user->save();

Read all records from the users table
=====================================

 <?php
    
    $users = User::getAll();

    print_r($users);
   


Update an existing record
============================

    <?php
    
    $user         = User::find(1);
    $user->name   = "Olotin Temitope";
    $user->stack  = "Java/Android";
    $user->alias  = "Laztopaz";
    $user->save();

Delete a record
==================

    <?php 
    
    User::destroy(1);

To make this package degrade gracefully,  you will need to wrap it around  try and catch so that all exceptions are caught. For instance, to catch exception on save new record try this.

     <?php
        
        try {
          
            $user         = new User();
            $user->name   = "Temitope Olotin";
            $user->gender = "Male";
            $user->alias  = "Laztopaz";
            $user->class  = "14";
            $user->stack  = "php/laravel";
            $user->save();
       } catch (Exception $e) {
             echo $e->getMessage();
        }

Read all records from the users table
       
     <?php
         try {

             $users = User::getAll();
             print_r($users);
         } catch (Exception $e) {
               echo $e->getMessage();
          }

   
Also for find and update method, you can also wrap it around try and catch.

    <?php
        
      try {

          $user         = User::find(1);
          $user->name   = "Olotin Temitope";
          $user->stack  = "Java/Android";
          $user->alias  = "Laztopaz";
          $user->save();
     } catch (Exception $e) {
           echo $e->getMessage();
      }
For deleting a record too, It is expected that you wrapped your code around try and catch also.

    <?php
    
      try {
          User::destroy(1);
     } catch (Exception $e) {
           echo $e->getMessage();
      }


Testing
======
Run this command on your terminal

    $ composer test or phpunit test

Contributing
==========

To contribute and extend the scope of this package, Please check out [CONTRIBUTING file](https://github.com/andela-tolotin/Potato-ORM/blob/test/contribution.md) for detailed contribution guidelines.

Credit
=====

Potato ORM Package  is created and maintained by Temitope Olotin.