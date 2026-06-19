<?php

// For backward compatibility with old code structure
// This provides the same connection as koneksi.php from the old project

$servername = getenv('DB_HOST') ?: "localhost";
$username = getenv('DB_USERNAME') ?: "root";
$password = getenv('DB_PASSWORD') ?: "";
$dbname = getenv('DB_DATABASE') ?: "puskesmas-pf";

$koneksi = new mysqli($servername, $username, $password, $dbname);

if ($koneksi->connect_error) {
    die("Koneksi gagal: " . $koneksi->connect_error);
}

$koneksi->set_charset("utf8");
?>
