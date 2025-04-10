<?php
session_start();
include "connect.php";
$kode_order = (isset($_POST['kodeorder'])) ? htmlentities($_POST['kodeorder']) : 0;
$meja = (isset($_POST['meja'])) ? htmlentities($_POST['meja']) : "";
$pelanggan = (isset($_POST['pelanggan'])) ? htmlentities($_POST['pelanggan']) : "";
$catatan = (isset($_POST['catatan'])) ? htmlentities($_POST['catatan']) : "";

if (!empty($_POST['edit_order_validate'])) {
    $select = mysqli_query($conn, "SELECT * FROM tb_order WHERE id_order = '$kode_order'");
    $query = mysqli_query($conn, "UPDATE tb_order SET meja='$meja', pelanggan='$pelanggan', catatan='$catatan' WHERE id_order = '$kode_order'");
    if (!$query) {
        $message = '<script>alert("Data Gagal disimpan: ' . mysqli_error($conn) . '"); window.location="../order" </script>';
    } else {
        $message = '<script>alert("Data Berhasil disimpan"); window.location="../order" </script>';
    }
}
echo $message;
