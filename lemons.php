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

function time_elapsed_string($datetime, $full = false) {
     $now = new DateTime;
     $ago = new DateTime($datetime);
     $diff = $now->diff($ago);
 
     $diff->w = floor($diff->d / 7);
     $diff->d -= $diff->w * 7;
 
     $string = array(
         'y' => 'year',
         'm' => 'month',
         'w' => 'week',
         'd' => 'day',
         'h' => 'hour',
         'i' => 'minute',
         's' => 'second',
     );
     foreach ($string as $k => &$v) {
         if ($diff->$k) {
             $v = $diff->$k . ' ' . $v . ($diff->$k > 1 ? 's' : '');
         } else {
             unset($string[$k]);
         }
     }
 
     if (!$full) $string = array_slice($string, 0, 1);
     return $string ? implode(', ', $string) . ' ago' : 'just now';
 }