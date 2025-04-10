<?php
session_start();
include "connect.php";
$id = isset($_POST['id']) ? htmlentities($_POST['id']) : "";
$catatan = isset($_POST['catatan']) ? htmlentities($_POST['catatan']) : "";

if (!empty($_POST['terima_order_validate'])) {
    $query = mysqli_query($conn, "UPDATE tb_list_order SET catatan_menu='$catatan', status_menu=1 WHERE id_list_order = '$id'");
    if (!$query) {
        $message = '<script>alert("Order Gagal Diterima Dapur"); window.location="../dapur" </script>';
    } else {
        $message = '<script>alert("Order Berhasil Diterima Dapur"); window.location="../dapur" </script>';
    }
}
echo $message;
