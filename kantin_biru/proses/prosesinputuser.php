<?php
include "connect.php";
$nama = (isset($_POST['nama'])) ? htmlentities($_POST['nama']) : "";
$username = (isset($_POST['username'])) ? htmlentities($_POST['username']) : "";
$level = (isset($_POST['level'])) ? htmlentities($_POST['level']) : "";
$nim = (isset($_POST['nim'])) ? htmlentities($_POST['nim']) : "";
// $password = md5($_POST['password']);
// $password = (isset($_POST['password'])) ? htmlentities($_POST['password']) : "";
$password = (isset($_POST['password'])) ? md5(htmlentities($_POST['password'])) : "";

if (!empty($_POST['input_user_validate'])) {
    $select = mysqli_query($conn, "SELECT * FROM tb_user WHERE username = '$username'");
    if (mysqli_num_rows($select) > 0) {
        $message = '<script>alert("Username sudah tersedia"); window.location="../user" </script>';
    } else {
        $query = mysqli_query($conn, "INSERT INTO tb_user (nama, username, level, nim, password) VALUES ('$nama', '$username', '$level', '$nim', '$password')");
        if (!$query) {
            // die("Query Error: ". mysqli_error($conn));
            // $message = "Error: ". mysqli_error($conn);
            $message = '<script>alert("Data Gagal disimpan"); window.location="../user" </script>';
        } else {
            // echo "<script>alert('Data berhasil disimpan');window.location='customer.php'</script>";
            // mysqli_close($conn);
            // $message = "Data berhasil disimpan";
            $message = '<script>alert("Data Berhasil disimpan"); window.location="../user" </script>';
        }
    }
}
echo $message;
