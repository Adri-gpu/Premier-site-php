<?php
$user = 'c19011540';
$pass = 'B7sFGgrnPoMFGEE';
$dbh = new PDO('mysql:host=localhost;dbname=c19011540', $user, $pass);

$dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
$dbh->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_OBJ);