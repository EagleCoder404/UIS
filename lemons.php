<?php

//When Life gives you lemons

//make functions

function getCon()
{
     $host = '127.0.0.1';
     $db   = 'uis';
     $user = 'uis';
     $pass = 'uis';
     $charset = 'utf8mb4';

     $dsn = "mysql:host=$host;dbname=$db;charset=$charset";
     $options = [
          PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
          PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
          PDO::ATTR_EMULATE_PREPARES   => false
     ];
     try {
          $pdo = new PDO($dsn, $user, $pass, $options);
     } catch (\PDOException $e) {
          throw new \PDOException($e->getMessage(), (int)$e->getCode());
     }
     return $pdo;
}


function accessAdmin()
{
     session_start();
     if ($_SESSION['type'] != 'a')
     {
          header("location:/UIS/app/");
          die();
     }
}
function accessTeacher()
{
     session_start();
     if ($_SESSION['type'] != 't')
     {
          header("location:/UIS/app/");
          die();
     }
}
function accessStudent(){
     if ($_SESSION['type'] != 's')
     {
          header("location:/UIS/app/");
          die();
     }
}
