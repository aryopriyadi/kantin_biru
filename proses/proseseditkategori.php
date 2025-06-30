<?php
include "connect.php";
$id_kategori_menu = (isset($_POST['id_kategori_menu'])) ? htmlentities($_POST['id_kategori_menu']) : "";
$jenis_menu = (isset($_POST['jenis_menu'])) ? htmlentities($_POST['jenis_menu']) : "";
$kategori = (isset($_POST['kategori'])) ? htmlentities($_POST['kategori']) : "";

if (!empty($_POST['input_kategori_validate'])) {
    $select = mysqli_query($conn, "SELECT kategori_menu FROM tb_kategori_menu WHERE kategori_menu = '$kategori'");
    if (mysqli_num_rows($select) > 0) {
        $message = '<script>alert("Kategori Menu sudah tersedia"); window.location="../kategori" </script>';
    } else {
        $query = mysqli_query($conn, "UPDATE tb_kategori_menu SET jenis_menu='$jenis_menu', kategori_menu='$kategori' WHERE id_kategori='$id_kategori_menu'");
        if ($query) {
            $message = '<script> window.location="../kategori" </script>';
        } else {
            $message = '<script> alert("Data Gagal disimpan"); window.location="../kategori" </script>';
        }
    }
}
echo $message;