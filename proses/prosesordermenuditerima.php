<?php
session_start();
include "connect.php";
$id = isset($_POST['id']) ? htmlentities($_POST['id']) : "";
$catatan = isset($_POST['catatan']) ? htmlentities($_POST['catatan']) : "";

if (!empty($_POST['order_menu_diterima_validate'])) {
    $query = mysqli_query($conn, "UPDATE tb_list_order SET catatan_menu='$catatan', status_menu=3 WHERE id_list_order = '$id'");
    if (!$query) {
        $message = '<script>alert("Order Gagal Disajikan"); window.location="../dapur" </script>';
    } else {
        $message = '<script> window.location="../dapur" </script>';
    }
}
echo $message;
