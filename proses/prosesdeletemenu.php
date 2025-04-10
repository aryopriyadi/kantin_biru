<?php
include "connect.php";

$id = (isset($_POST['id'])) ? htmlentities($_POST['id']) : "";
$foto = (isset($_POST['foto'])) ? htmlentities($_POST['foto']) : "";

if (!empty($_POST['delete_menu_validate'])) {
    mysqli_begin_transaction($conn);
    try { // Delete menu item
        $query = mysqli_query($conn, "DELETE FROM tb_menu WHERE id = '$id'");
        if (!$query) {
            throw new Exception("Failed to delete menu item.");
        } // Delete associated image file if it exists
        if (!empty($foto)) {
            $filePath = "../assets/img/$foto";
            if (file_exists($filePath)) {
                if (!unlink($filePath)) {
                    throw new Exception("Failed to delete image file.");
                }
            }
        }
        mysqli_commit($conn);
        $message = '<script> alert("Data Berhasil dihapus"); window.location="../menu" </script>';
    } catch (Exception $e) {
        mysqli_rollback($conn);
        $message = '<script> alert("Data Gagal dihapus: ' . $e->getMessage() . '"); window.location="../menu" </script>';
    }
}

echo $message;
