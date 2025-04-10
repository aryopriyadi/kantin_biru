<?php
include "connect.php";
$id = (isset($_POST['id'])) ? htmlentities($_POST['id']) : "";

if (!empty($_POST['delete_kategori_validate'])) {
    $select = mysqli_query($conn, "SELECT kategori FROM tb_menu WHERE kategori = '$id'");
    if (mysqli_num_rows($select) > 0) {
        $message = '<script>alert("Kategori Menu telah digunakan di Daftar Menu, kategori tidak dapat dihapus"); window.location="../kategori" </script>';
    } else {
        $query = mysqli_query($conn, "DELETE FROM tb_kategori_menu WHERE id_kategori = '$id'");
        if (!$query) {
            $message = '<script> alert("Data Gagal dihapus"); window.location="../kategori" </script>';
        } else {
            $message = '<script> alert("Data Berhasil dihapus"); window.location="../kategori" </script>';
        }
    }
}
echo $message;
