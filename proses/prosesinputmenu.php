<?php
include "connect.php";

$nama_menu = (isset($_POST['nama_menu'])) ? mysqli_real_escape_string($conn, $_POST['nama_menu']) : "";
$kategori_menu = (isset($_POST['kategori_menu'])) ? mysqli_real_escape_string($conn, $_POST['kategori_menu']) : "";
$harga = (isset($_POST['harga'])) ? mysqli_real_escape_string($conn, $_POST['harga']) : "";
$stock = (isset($_POST['stock']) && !empty($_POST['stock'])) ? mysqli_real_escape_string($conn, $_POST['stock']) : null;
$deskripsi = (isset($_POST['deskripsi'])) ? mysqli_real_escape_string($conn, $_POST['deskripsi']) : "";

$kode_rand = rand(10000, 99999) . "-";
$target_dir = "../assets/img/" . $kode_rand;
$target_file = $target_dir . basename($_FILES['foto']['name']);
$imageType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

if (!empty($_POST['input_menu_validate'])) { // Validate image
    $check = getimagesize($_FILES['foto']['tmp_name']);
    if ($check === false) {
        $message = "file gambar tidak diketahui";
        $statusUpload = 0;
    } else {
        $statusUpload = 1;
        if (file_exists($target_file)) {
            $message = "nama file sudah tersedia";
            $statusUpload = 0;
        } else {
            if ($_FILES['foto']['size'] > 5000000) {
                $message = "ukuran file foto terlalu besar";
                $statusUpload = 0;
            } else {
                if ($imageType != "jpg" && $imageType != "png" && $imageType != "jpeg" && $imageType != "gif") {
                    $message = "upload file dengan ekstensi jpg, png, jpeg dan gif";
                    $statusUpload = 0;
                }
            }
        }
    }

    if ($statusUpload == 0) {
        $message = '<script> alert("' . $message . ', foto tidak dapat diupload "); window.location="../menu" </script>';
    } else {
        $select = mysqli_query($conn, "SELECT * FROM tb_menu WHERE nama_menu = '$nama_menu'");
        if (mysqli_num_rows($select) > 0) {
            $message = '<script>alert("nama menu sudah tersedia"); window.location="../menu" </script>';
        } else {
            if (move_uploaded_file($_FILES['foto']['tmp_name'], $target_file)) { // Prepare the SQL query with conditional handling for NULL stock
                $query = "INSERT INTO tb_menu (foto, nama_menu, kategori, harga, stock, deskripsi) VALUES ('" . $kode_rand . $_FILES['foto']['name'] . "', '$nama_menu', '$kategori_menu', '$harga', ";
                $query .= ($stock === null) ? "NULL" : "'" . $stock . "'";
                $query .= ", '$deskripsi')";
                if (mysqli_query($conn, $query)) {
                    $message = '<script> window.location="../menu" </script>';
                } else {
                    $message = '<script>alert("Data Gagal disimpan"); window.location="../menu" </script>';
                }
            } else {
                $message = '<script>alert("terjadi kesalahan, file tidak dapat diupload"); window.location="../menu" </script>';
            }
        }
    }
}
echo $message;
