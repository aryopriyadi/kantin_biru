<?php
session_start();
include "connect.php";
$kode_order = (isset($_POST['kodeorder'])) ? htmlentities($_POST['kodeorder']) : 0;
$meja = (isset($_POST['meja'])) ? htmlentities($_POST['meja']) : "";
$pelanggan = (isset($_POST['pelanggan'])) ? htmlentities($_POST['pelanggan']) : "";
$catatan = (isset($_POST['catatan'])) ? htmlentities($_POST['catatan']) : "";

if (!empty($_POST['input_order_validate'])) {
    $select = mysqli_query($conn, "SELECT * FROM tb_order WHERE id_order = '$kode_order'");
    if (mysqli_num_rows($select) > 0) {
        $message = '<script>alert("Order yang dimasukkan sudah tersedia"); window.location="../order" </script>';
    } else {
        $query = mysqli_query($conn, "INSERT INTO tb_order (id_order, meja, pelanggan, catatan, pelayan) VALUES ('$kode_order', '$meja', '$pelanggan',  '$catatan', '$_SESSION[id_kantinbiru]')");
        if (!$query) {
            $message = '<script>alert("Data Gagal disimpan: ' . mysqli_error($conn). '"); window.location="../order" </script>';
        } else {
            $message = '<script>alert("Data Berhasil disimpan"); window.location="../?x=orderitem&order='.$kode_order.'&meja='.$meja.'&pelanggan='.$pelanggan.'" </script>';
        }
    }
}
echo $message;
