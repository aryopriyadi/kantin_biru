<?php
session_start();
include "connect.php";
$id = (isset($_POST['id'])) ? htmlentities($_POST['id']) : "";
$passwordlama = (isset($_POST['passwordlama'])) ? md5(htmlentities($_POST['passwordlama'])) : "";
$passwordbaru = (isset($_POST['passwordbaru'])) ? md5(htmlentities($_POST['passwordbaru'])) : "";
$confirmpassword = (isset($_POST['confirmpassword'])) ? md5(htmlentities($_POST['confirmpassword'])) : "";

if (!empty($_POST['ubah_password_validate'])) {
    $query = mysqli_query($conn, "SELECT * FROM tb_user WHERE username = '$_SESSION[username_kantinbiru]' AND password = '$passwordlama'");
    $hasil = mysqli_fetch_array($query);
    if ($hasil) {
        if ($passwordbaru == $confirmpassword) {
            $query = mysqli_query($conn, "UPDATE tb_user SET password='$passwordbaru' WHERE username = '$_SESSION[username_kantinbiru]'");
            if ($query) {
                $message = '<script> alert("Password Berhasil Diperbarui"); window.history.back() </script>';
            } else {
                $message = '<script> alert("Password Gagal Diperbarui"); window.history.back() </script>';
            }
        } else {
            $message = '<script> alert("Password Baru dan Konfirmasi Password harus sama"); window.history.back() </script>';
        }
    } else {
        $message = '<script> alert("Password Lama Tidak Sesuai"); window.history.back() </script>';
    }
} else {
    header('location:../home');
}
echo $message;
