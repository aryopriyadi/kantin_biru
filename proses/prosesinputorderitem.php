<?php
session_start();
include "connect.php";

if (!empty($_POST['input_orderitem_validate'])) {
    $kode_order = isset($_POST['kode_order']) ? intval($_POST['kode_order']) : 0;
    $meja = isset($_POST['meja']) ? htmlspecialchars(trim($_POST['meja'])) : "";
    $pelanggan = isset($_POST['pelanggan']) ? htmlspecialchars(trim($_POST['pelanggan'])) : "";

    // Check if kode_order exists in tb_order
    $stmt = $conn->prepare("SELECT id_order FROM tb_order WHERE id_order = ?");
    $stmt->bind_param("i", $kode_order);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        $success = true;
        $conn->begin_transaction(); // Start transaction

        foreach ($_POST['id_menu'] as $menu_id) {
            $menu_id = intval($menu_id);
            $jumlah = isset($_POST['jumlah'][$menu_id]) ? intval($_POST['jumlah'][$menu_id]) : 0;
            $catatan = isset($_POST['catatan'][$menu_id]) ? htmlspecialchars(trim($_POST['catatan'][$menu_id])) : "";

            if ($jumlah <= 0) {
                $message = '<script>alert("Jumlah pesanan harus lebih dari nol."); window.location="../?x=orderitem&order=' . $kode_order . '&meja=' . $meja . '&pelanggan=' . $pelanggan . '";</script>';
                $success = false;
                break;
            }

            // Check if menu_id exists in tb_list_order
            $stmt_menu = $conn->prepare("SELECT * FROM tb_list_order WHERE menu = ? AND kode_order = ?");
            $stmt_menu->bind_param("ii", $menu_id, $kode_order);
            $stmt_menu->execute();
            $stmt_menu->store_result();

            if ($stmt_menu->num_rows > 0) {
                $message = '<script>alert("Item Menu yang dipilih sudah tersedia "); window.location="../?x=orderitem&order=' . $kode_order . '&meja=' . $meja . '&pelanggan=' . $pelanggan . '";</script>';
                $success = false;
                break;
            } else {
                // Insert into tb_list_order
                $stmt_insert = $conn->prepare("INSERT INTO tb_list_order (menu, kode_order, jumlah, catatan_menu) VALUES (?, ?, ?, ?)");
                $stmt_insert->bind_param("iiis", $menu_id, $kode_order, $jumlah, $catatan);
                if (!$stmt_insert->execute()) {
                    $message = '<script>alert("Data Gagal Ditambahkan: ' . $stmt_insert->error . '"); window.location="../?x=orderitem&order=' . $kode_order . '&meja=' . $meja . '&pelanggan=' . $pelanggan . '";</script>';
                    $success = false;
                    break;
                }
            }
        }

        if ($success) {
            $conn->commit(); // Commit transaction
            $message = '<script>alert("Data Berhasil Ditambahkan"); window.location="../?x=orderitem&order=' . $kode_order . '&meja=' . $meja . '&pelanggan=' . $pelanggan . '";</script>';
        } else {
            $conn->rollback(); // Rollback transaction
        }
    } else {
        $message = '<script>alert("Kode Order tidak ditemukan"); window.location="../?x=orderitem&order=' . $kode_order . '&meja=' . $meja . '&pelanggan=' . $pelanggan . '";</script>';
    }
    $stmt->close();
}
echo $message;
?>
