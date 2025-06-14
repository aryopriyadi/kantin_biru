<?php
include "proses/connect.php";
date_default_timezone_set('Asia/Jakarta');

// Query baru: group by DATE(waktu_order) dan sum total_harga per hari
$query = mysqli_query($conn, "SELECT DATE(waktu_order) AS order_date, SUM(harga * jumlah) AS total_harga 
FROM tb_order 
LEFT JOIN tb_user ON tb_user.id = tb_order.pelayan
LEFT JOIN tb_list_order ON tb_list_order.kode_order = tb_order.id_order
LEFT JOIN tb_menu ON tb_menu.id = tb_list_order.menu
JOIN tb_bayar ON tb_bayar.id_bayar = tb_order.id_order
WHERE tb_bayar.tipe = 2
GROUP BY DATE(waktu_order)
ORDER BY order_date DESC");

$result = []; // Inisialisasi array hasil query

while ($record = mysqli_fetch_array($query)) {
    $result[] = $record;
}
?>

<div class="col-lg-10 mt-2 rounded">
    <div class="card">
        <div class="card-header">
            Halaman Akumulasi Pembayaran QRIS Report (per Hari)
        </div>
        <div class="card-body">
            <?php if (empty($result)) { ?>
                <div class='alert alert-warning' role='alert'>Data History Pembayaran Kosong!</div>
            <?php } else { ?>
                <div class="table-responsive mt-2">
                    <table class="table table-hover" id="example">
                        <thead>
                            <tr class="text-nowrap">
                                <th scope="col">No</th>
                                <th scope="col">Tanggal</th>
                                <th scope="col">Total Harga</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $no = 1;
                            foreach ($result as $row) { ?>
                                <tr>
                                    <th scope="row"><?php echo $no++; ?></th>
                                    <!-- Tanggal dalam format YYYY-MM-DD -->
                                    <td><?php echo $row['order_date']; ?></td>
                                    <!-- Format angka dengan ribuan dipisah titik -->
                                    <td><?php echo number_format((int)$row['total_harga'], 0, ',', '.'); ?></td>
                                </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>
            <?php } ?>
        </div>
    </div>
</div>