<?php
$conn = mysqli_connect("kantin_biru_db", "user", "password", "db_kantinbiru");
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}
