<?php

$host = "localhost";
$user = "root";
$pass = "";
$db   = "ipil_makarenko";

$conn = mysqli_connect($host, $user, $pass, $db);

if (!$conn) {
    die("Erro de conexão: " . mysqli_connect_error());
}

mysqli_set_charset($conn, "utf8");