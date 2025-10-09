<?php
function getDBConnection()
{
    $host = '127.0.0.1';
    $user = 'root';
    $pass = '';
    $db   = 'bakery_demo';
    $conn = new mysqli($host, $user, $pass, $db);
    if ($conn->connect_error) {
        die('DB connect error: ' . $conn->connect_error);
    }
    return $conn;
}
