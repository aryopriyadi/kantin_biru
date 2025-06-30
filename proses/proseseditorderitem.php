<?php
session_start();
include "connect.php";

// Sanitize inputs using prepared statements
$id = isset($_POST['id']) ? $_POST['id'] : 0;
$kode_order = isset($_POST['kode_order']) ? $_POST['kode_order'] : 0;
$meja = isset($_POST['meja']) ? $_POST['meja'] : "";
$pelanggan = isset($_POST['pelanggan']) ? $_POST['pelanggan'] : "";
$catatan = isset($_POST['catatan']) ? $_POST['catatan'] : "";
$menu = isset($_POST['menu']) ? $_POST['menu'] : "";
$jumlah = isset($_POST['jumlah']) ? $_POST['jumlah'] : "";

if (!empty($_POST['edit_orderitem_validate'])) {
    // Check if the menu item already exists in tb_list_order for the given kode_order, excluding the current item
    $stmt = $conn->prepare("SELECT * FROM tb_list_order WHERE menu = ? AND kode_order = ? AND id_list_order != ?");
    $stmt->bind_param("iii", $menu, $kode_order, $id);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        $message = '<script>alert("Item Menu yang dipilih sudah tersedia"); window.location="../?x=orderitem&order=' . $kode_order . '&meja=' . $meja . '&pelanggan=' . $pelanggan . '"</script>';
    } else { // Update the order item
        $stmt = $conn->prepare("UPDATE tb_list_order SET menu = ?, jumlah = ?, catatan_menu = ? WHERE id_list_order = ?");
        $stmt->bind_param("iiss", $menu, $jumlah, $catatan, $id);
        if ($stmt->execute()) {
            $message = '<script> window.location="../?x=orderitem&order=' . $kode_order . '&meja=' . $meja . '&pelanggan=' . $pelanggan . '"</script>';
        } else {
            $message = '<script>alert("Data Gagal diperbarui: ' . $stmt->error . '"); window.location="../?x=orderitem&order=' . $kode_order . '&meja=' . $meja . '&pelanggan=' . $pelanggan . '"</script>';
        }
    }
    $stmt->close();
}
echo $message;
