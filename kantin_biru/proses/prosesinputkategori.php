<?php
include "connect.php";
$jenismenu = (isset($_POST['jenismenu'])) ? htmlentities($_POST['jenismenu']) : "";
$kategori = (isset($_POST['kategori'])) ? htmlentities($_POST['kategori']) : "";

if (!empty($_POST['input_kategori_validate'])) {
    $select = mysqli_query($conn, "SELECT kategori_menu FROM tb_kategori_menu WHERE kategori_menu = '$kategori'");
    if (mysqli_num_rows($select) > 0) {
        $message = '<script>alert("Kategori Menu sudah tersedia"); window.location="../kategori" </script>';
    } else {
        $query = mysqli_query($conn, "INSERT INTO tb_kategori_menu (jenis_menu, kategori_menu) VALUES ('$jenismenu', '$kategori')");
        if (!$query) {
            $message = '<script>alert("Data Gagal disimpan"); window.location="../kategori" </script>';
        } else {
            $message = '<script>alert("Data Berhasil disimpan"); window.location="../kategori" </script>';
        }
    }
}
echo $message;
