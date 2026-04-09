<?php

$url = "http://localhost/kinus/inventaris/";

$host = 'localhost';
$username = 'root';
$password = '';
$database = 'inventaris';

$conn = new mysqli($host, $username, $password, $database);

if ($conn->connect_error) {
    die('Koneksi gagal: ' . $conn->connect_error);
}


