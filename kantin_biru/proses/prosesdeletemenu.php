<?php
include "connect.php";
$id = (isset($_POST['id'])) ? htmlentities($_POST['id']) : "";
$foto = (isset($_POST['foto'])) ? htmlentities($_POST['foto']) : "";

if (!empty($_POST['delete_menu_validate'])) {
    $query = mysqli_query($conn, "DELETE FROM tb_menu WHERE id = '$id'");
    if (!$query) {
        $message = '<script> alert("Data Gagal dihapus"); window.location="../menu" </script>';
    } else {
        unlink("../assets/img/$foto");
        $message = '<script> alert("Data Berhasil dihapus"); window.location="../menu" </script>';
    }
} 
echo $message;