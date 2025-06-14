<?php
session_start();
include "connect.php";

if (!empty($_POST['payment_validate'])) {
    $kode_order = (isset($_POST['kode_order'])) ? htmlspecialchars($_POST['kode_order']) : "";
    $meja = (isset($_POST['meja'])) ? htmlspecialchars($_POST['meja']) : "";
    $pelanggan = (isset($_POST['pelanggan'])) ? htmlspecialchars($_POST['pelanggan']) : "";
    $uang = (isset($_POST['uang'])) ? floatval($_POST['uang']) : 0;
    $total = (isset($_POST['total'])) ? floatval($_POST['total']) : 0;
    $tipe = (isset($_POST['tipe'])) ? floatval($_POST['tipe']) : 0;
    $kembalian = $uang - $total;

    if ($kembalian < 0) { // Check if the nominal bayar is less than the total
        $kekurangan = abs($kembalian); // Calculate the shortage amount
        $message = '<script>alert("Nominal Uang yang diberikan kurang. Kekurangan Rp ' . number_format($kekurangan, 0, ',', '.') . '"); window.location="../?x=orderitem&order=' . $kode_order . '&meja=' . $meja . '&pelanggan=' . $pelanggan . '";</script>';
    } else { // Insert payment details into the database
        $query = mysqli_query($conn, "INSERT INTO tb_bayar (id_bayar, nominal_uang, total_bayar, tipe) VALUES ('$kode_order', '$uang', '$total', '$tipe')");
        if ($query) {
            $message = '<script>alert("Pembayaran Berhasil, kembalian Rp ' . number_format($kembalian, 0, ',', '.') . '"); window.location="../?x=orderitem&order=' . $kode_order . '&meja=' . $meja . '&pelanggan=' . $pelanggan . '";</script>';
        } else {
            $message = '<script>alert("Pembayaran Gagal: ' . mysqli_error($conn) . '"); window.location="../?x=orderitem&order=' . $kode_order . '&meja=' . $meja . '&pelanggan=' . $pelanggan . '";</script>';
        }
    }
} else {
    $message = '<script>alert("Form submission failed"); window.location="../?x=orderitem&order=' . $kode_order . '&meja=' . $meja . '&pelanggan=' . $pelanggan . '";</script>';
}

echo $message;
