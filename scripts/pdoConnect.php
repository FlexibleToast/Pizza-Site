<?php
# Import config for credentials path and sql host
require_once('config.php');
# Import credentials
require_once($CREDENTIALS_PATH);
# Connect PDO library to MySQL server
try {
    $dsn = "mysql:host=". $SQL_HOST . ";dbname=Pizza";
    $pdo = new PDO($dsn, $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
}
catch(PDOexception $e){
    echo "Connection to database failed: " . $e->getMessage();
}
?>
