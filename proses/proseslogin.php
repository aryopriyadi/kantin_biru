<?php 
session_start();
include "connect.php";
$username = (isset($_POST['username'])) ? htmlentities($_POST['username']) : "";
$password = (isset($_POST['password'])) ? md5(htmlentities($_POST['password'])) : "";

if (!empty($_POST['submit_validate'])) {
    $query = mysqli_query($conn, "SELECT * FROM tb_user WHERE username = '$username' AND password = '$password'");
    $hasil = mysqli_fetch_array($query);
    if ($hasil) {
        $_SESSION['username_kantinbiru'] = $username;
        $_SESSION['level_kantinbiru'] = $hasil['level'];
        $_SESSION['id_kantinbiru'] = $hasil['id'];
        header('location:../home');
    } else { ?>
        <script>
            alert("Invalid username or password");
            window.location = '../login'
        </script>
<?php
    }
} ?>