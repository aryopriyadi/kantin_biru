<?php
include "proses/connect.php";
date_default_timezone_set('Asia/Jakarta');

$query = mysqli_query($conn, "SELECT tb_order.*, tb_bayar.*, nama, SUM(harga*jumlah) AS total_harga FROM tb_order 
LEFT JOIN tb_user ON tb_user.id = tb_order.pelayan
LEFT JOIN tb_list_order ON tb_list_order.kode_order = tb_order.id_order
LEFT JOIN tb_menu ON tb_menu.id = tb_list_order.menu
JOIN tb_bayar ON tb_bayar.id_bayar = tb_order.id_order
GROUP BY id_order ORDER BY waktu_order DESC");

$result = []; // Initialize result array
while ($record = mysqli_fetch_array($query)) {
    $result[] = $record; // Store each record in the result array
} ?>

<div class="col-lg-10 mt-2 rounded">
    <div class="card">
        <div class="card-header">
            Halaman History Order Sales Report
        </div>
        <div class="card-body">
            <?php
            if (empty($result)) {
                echo "<div class='alert alert-warning' role='alert'>Data History Penjualan Kosong!</div>";
            } else { ?>
                <!-- table class hover -->
                <div class="table-responsive mt-2">
                    <table class="table table-hover" id="example">
                        <thead>
                            <tr class="text-nowrap">
                                <th scope="col">No</th>
                                <th scope="col">Kode Order</th>
                                <th scope="col">Pelanggan</th>
                                <!-- <th scope="col">Meja</th> -->
                                <th scope="col">Bayar</th>
                                <th scope="col">Total</th>
                                <th scope="col">Pelayan</th>
                                <th scope="col">Status</th>
                                <th scope="col">Waktu Order</th>
                                <th scope="col">Waktu Bayar</th>
                                <th scope="col">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $no = 1;
                            foreach ($result as $row) { ?>
                                <tr>
                                    <th scope="row"><?php echo $no++ ?></th>
                                    <td><?php echo $row['id_order'] ?></td>
                                    <td><?php echo $row['pelanggan'] ?></td>
                                    <!-- <td><?php echo $row['meja'] ?></td> -->
                                    <td><?php echo number_format((int)$row['nominal_uang'], 0, ',', '.') ?></td>
                                    <td><?php echo number_format((int)$row['total_harga'], 0, ',', '.') ?></td>
                                    <td><?php echo $row['nama'] ?></td>
                                    <td><?php if (!empty($row['id_bayar'])) {
                                            echo "<span class='badge text-bg-success'>Paid</span>";
                                        } else {
                                            echo "<span class='badge text-bg-warning'>UnPaid</span>";
                                        } ?></td>
                                    <td><?php echo $row['waktu_order'] ?></td>
                                    <td><?php echo $row['waktu_bayar'] ?></td>
                                    <td><a class="btn btn-success btn-sm me-1" href="./?x=viewitem&order=<?php echo $row['id_order'] . "&meja=" . $row['meja'] . "&pelanggan=" . $row['pelanggan'] ?>"><i class="bi bi-info-circle"></i></a></td>
                                </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>
            <?php } ?>
        </div>
    </div>
</div>