<?php
include "connect.php";
$id = (isset($_POST['id'])) ? htmlentities($_POST['id']) : "";
$nama_menu = (isset($_POST['nama_menu'])) ? htmlentities($_POST['nama_menu']) : "";
$kategori_menu = (isset($_POST['kategori_menu'])) ? htmlentities($_POST['kategori_menu']) : "";
$harga = (isset($_POST['harga'])) ? htmlentities($_POST['harga']) : "";
$stock = (isset($_POST['stock']) && $_POST['stock'] !== '') ? (int)htmlentities($_POST['stock']) : NULL; // Handle empty stock
$deskripsi = (isset($_POST['deskripsi'])) ? htmlentities($_POST['deskripsi']) : "";
$current_foto = (isset($_POST['current_foto'])) ? htmlentities($_POST['current_foto']) : "";

$kode_rand = rand(10000, 99999) . "-";
$target_dir = "../assets/img/" . $kode_rand;
$target_file = $target_dir . basename($_FILES['foto']['name']);
$imageType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

if (!empty($_POST['edit_menu_validate'])) {
    if ($_FILES['foto']['size'] > 0) {
        $check = getimagesize($_FILES['foto']['tmp_name']); // Validate image or not (tmp_name)
        if ($check === false) {
            $message = "file gambar tidak diketahui";
            $statusUpload = 0;
        } else {
            $statusUpload = 1;
            if (file_exists($target_file)) {
                $message = "nama file sudah tersedia";
                $statusUpload = 0;
            } else {
                if ($_FILES['foto']['size'] > 5000000) { // 5mb file
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
            $select = mysqli_query($conn, "SELECT * FROM tb_menu WHERE nama_menu = '$nama_menu' AND id != '$id'");
            if (mysqli_num_rows($select) > 0) {
                $message = '<script>alert("nama menu sudah tersedia"); window.location="../menu" </script>';
            } else {
                if (move_uploaded_file($_FILES['foto']['tmp_name'], $target_file)) {
                    // Handle NULL stock value
                    if ($stock === NULL) {
                        $query = mysqli_query($conn, "UPDATE tb_menu SET foto='" . $kode_rand . $_FILES['foto']['name'] . "', nama_menu='$nama_menu', kategori='$kategori_menu', harga='$harga', stock=NULL, deskripsi='$deskripsi' WHERE id='$id'");
                    } else {
                        $query = mysqli_query($conn, "UPDATE tb_menu SET foto='" . $kode_rand . $_FILES['foto']['name'] . "', nama_menu='$nama_menu', kategori='$kategori_menu', harga='$harga', stock='$stock', deskripsi='$deskripsi' WHERE id='$id'");
                    }
                    if ($query) {
                        $message = '<script> window.location="../menu" </script>';
                    } else {
                        $message = '<script>alert("Data Gagal disimpan"); window.location="../menu" </script>';
                    }
                } else {
                    $message = '<script>alert("terjadi kesalahan, file tidak dapat diupload"); window.location="../menu" </script>';
                }
            }
        }
    } else { // No new image uploaded, update without changing the image
        $select = mysqli_query($conn, "SELECT * FROM tb_menu WHERE nama_menu = '$nama_menu' AND id != '$id'");
        if (mysqli_num_rows($select) > 0) {
            $message = '<script>alert("nama menu sudah tersedia"); window.location="../menu" </script>';
        } else {
            if ($stock === NULL) { // Handle NULL stock value
                $query = mysqli_query($conn, "UPDATE tb_menu SET nama_menu='$nama_menu', kategori='$kategori_menu', harga='$harga', stock=NULL, deskripsi='$deskripsi' WHERE id='$id'");
            } else {
                $query = mysqli_query($conn, "UPDATE tb_menu SET nama_menu='$nama_menu', kategori='$kategori_menu', harga='$harga', stock='$stock', deskripsi='$deskripsi' WHERE id='$id'");
            }
            if ($query) {
                $message = '<script> window.location="../menu" </script>';
            } else {
                $message = '<script>alert("Data Gagal disimpan"); window.location="../menu" </script>';
            }
        }
    }
}
echo $message;
