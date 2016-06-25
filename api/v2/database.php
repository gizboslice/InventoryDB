
<?php
function getDatabase() {
    $dbhost = $_ENV["DATABASE_SERVER"];
    $dbuser = "db161944_eqipmnt";
    $dbpass = "WhatAreTh0se?";
    $dbname = "db161944_inventorydb";
    $mysql_conn_string = "mysql:host=$dbhost;dbname=$dbname";
    $database = new PDO($mysql_conn_string, $dbuser, $dbpass);
    $database->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    return $database;
}