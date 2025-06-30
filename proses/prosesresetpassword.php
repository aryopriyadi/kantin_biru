<?php
include "connect.php";
$id = (isset($_POST['id'])) ? htmlentities($_POST['id']) : "";

if (!empty($_POST['reset_user_validate'])) {
    $query = mysqli_query($conn, "UPDATE tb_user SET password=md5('password') WHERE id = '$id'");
    if (!$query) {
        $message = '<script> alert("Password Gagal Direset"); window.location="../user" </script>';
    } else {
        $message = '<script> alert("Password Berhasil Direset menjadi = "Password" "); window.location="../user" </script>';
    }
} echo $message; 