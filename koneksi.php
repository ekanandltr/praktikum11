<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "db_penjualan";

$koneksi = mysqli_connect($servername, $username, $password, $dbname);

if(!$koneksi) {
	die("Connection failed: ". mysqli_connect_error());
}
?>