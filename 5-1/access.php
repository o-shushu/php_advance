<?php
$host = 'localhost';
$username = 'root';
$passwd = 'wangzzWZZ';
$dbname = 'cafe';
$dsn = 'mysql:dbname=cafe;host=localhost;charset=utf8';
$link = mysqli_connect($host,$username,$passwd,$dbname);
$link_PDO = new PDO($dsn,$username,$passwd);
?>