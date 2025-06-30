<?php
session_start();
include "connect.php";
$id = (isset($_POST['id'])) ? htmlentities($_POST['id']) : "";
$nama = (isset($_POST['nama'])) ? htmlentities($_POST['nama']) : "";
$nim = (isset($_POST['nim'])) ? htmlentities($_POST['nim']) : "";

if (!empty($_POST['ubah_profile_validate'])) {
    $query = mysqli_query($conn, "UPDATE tb_user SET nama='$nama', nim='$nim' WHERE username = '$_SESSION[username_kantinbiru]'");
    if (!$query) {
        $message = '<script>alert("Profile Gagal Diperbarui"); window.history.back() </script>';
    } else {
        $message = '<script> window.history.back() </script>';
    }
} else {
    $message = '<script>alert("Data Profile Harus Diisi"); window.history.back() </script>';
}
echo $message;
