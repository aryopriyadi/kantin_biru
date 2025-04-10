<?php
include "connect.php";

// Mendapatkan data dari form
$id = (isset($_POST['id'])) ? htmlentities($_POST['id']) : "";
$nama = (isset($_POST['nama'])) ? htmlentities($_POST['nama']) : "";
$username = (isset($_POST['username'])) ? htmlentities($_POST['username']) : "";
$level = (isset($_POST['level'])) ? htmlentities($_POST['level']) : "";
$nim = (isset($_POST['nim'])) ? htmlentities($_POST['nim']) : "";
$password = (isset($_POST['password'])) ? md5(htmlentities($_POST['password'])) : "";

// Inisialisasi pesan
$message = '';

if (!empty($_POST['input_user_validate'])) {
    // Periksa apakah username diubah dan tidak kosong
    if (!empty($username)) {
        // Periksa keunikan username
        $select = mysqli_query($conn, "SELECT * FROM tb_user WHERE username = '$username' AND id != '$id'");
        if (mysqli_num_rows($select) > 0) {
            $message = '<script>alert("Username sudah tersedia"); window.location="../user";</script>';
        } else {
            // Jika username unik, lakukan update
            $query = mysqli_query($conn, "UPDATE tb_user SET nama='$nama', username='$username', level='$level', nim='$nim', password='$password' WHERE id='$id'");
            if ($query) {
                $message = '<script>alert("Data Berhasil disimpan"); window.location="../user";</script>';
            } else {
                $message = '<script>alert("Data Gagal disimpan"); window.location="../user";</script>';
            }
        }
    } else {
        // Jika username tidak diubah atau kosong, lakukan update tanpa mengubah username
        $query = mysqli_query($conn, "UPDATE tb_user SET nama='$nama', level='$level', nim='$nim', password='$password' WHERE id='$id'");
        if ($query) {
            $message = '<script>alert("Data Berhasil disimpan"); window.location="../user";</script>';
        } else {
            $message = '<script>alert("Data Gagal disimpan"); window.location="../user";</script>';
        }
    }
}

echo $message;
?>
