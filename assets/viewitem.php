<?php
include "proses/connect.php";
$query = mysqli_query($conn, "SELECT *, SUM(harga*jumlah) AS total_harga, tb_order.catatan FROM tb_list_order 
LEFT JOIN tb_order ON tb_order.id_order = tb_list_order.kode_order
LEFT JOIN tb_menu ON tb_menu.id = tb_list_order.menu
LEFT JOIN tb_bayar ON tb_bayar.id_bayar = tb_order.id_order
GROUP BY id_list_order HAVING tb_list_order.kode_order = $_GET[order]");

$kode = $_GET['order'];
$meja = $_GET['meja'];
$pelanggan = $_GET['pelanggan'];
$paymentExists = false; // New variable to track payment status

while ($record = mysqli_fetch_array($query)) {
    $result[] = $record;
    $total_harga = $record['total_harga'];
    $catatan = $record['catatan'];
    if (!empty($record['id_bayar'])) { // Check if payment exists
        $paymentExists = true; // Set to true if a payment record is found
    }
}
$select_menu = mysqli_query($conn, "SELECT id, nama_menu FROM tb_menu");
?>

<div class="col-lg-10 mt-2 rounded">
    <div class="card">
        <div class="card-header">
            Halaman View Item Report
        </div>
        <div class="card-body">
            <div class="row mb-2">
                <div class="row">
                    <div class="col-lg-12">
                        <td><a class="btn btn-secondary btn-md" href="report"><i class="bi bi-arrow-left-circle"> Back</i></a></td>
                        <td><button class="btn btn-warning btn-md" onclick="cetakStruk()"><i class="bi bi-file-earmark-arrow-down"> Print</i></button></td>
                    </div>
                </div>
            </div>
            <div class="row mb-2">
                <div class="row">
                    <div class="col-lg-4">
                        <div class="form-floating mb-2">
                            <input type="text" class="form-control" id="kodeorder" value="<?php echo $kode; ?>" disabled>
                            <label for="kodeorder">Kode Order</label>
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="form-floating mb-2">
                            <input type="text" class="form-control" id="nomormeja" disabled value="<?php echo $meja; ?>">
                            <label for="nomormeja">Nomor Meja</label>
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="form-floating mb-2">
                            <input type="text" class="form-control" id="pelanggan" disabled value="<?php echo $pelanggan; ?>">
                            <label for="pelanggan">Nama Pelanggan</label>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-12">
                        <div class="form-floating mb-2">
                            <input type="text" class="form-control" id="catatan" disabled value="<?php echo $catatan; ?>">
                            <label for="nomormeja">Catatan Pesanan</label>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Start Modal Add New Item Order -->
            <div class="modal fade" id="tambahItem" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-lg modal-fullscreen-md-down">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h1 class="modal-title fs-5" id="exampleModalLabel">Add Item Order</h1>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <form class="needs-validation" novalidate action="proses/prosesinputorderitem.php" method="POST">
                                <input type="hidden" name="kode_order" value="<?php echo $kode ?>">
                                <input type="hidden" name="meja" value="<?php echo $meja ?>">
                                <input type="hidden" name="pelanggan" value="<?php echo $pelanggan ?>">
                                <div class="row">
                                    <div class="col-lg-8">
                                        <div class="form-floating mb-2">
                                            <select class="form-select" name="menu" id="">
                                                <option selected hidden value="">Pilih Menu</option>
                                                <?php foreach ($select_menu as $value) {
                                                    echo "<option value=" . $value['id'] . ">$value[nama_menu]</option>";
                                                } ?>
                                            </select>
                                            <label for="menu"> Menu Kantin Biru</label>
                                            <div class="invalid-feedback"> Pilih Menu</div>
                                        </div>
                                    </div>
                                    <div class="col-lg-4">
                                        <div class="form-floating mb-2">
                                            <input type="number" class="form-control" id="floatingInput" placeholder="Jumlah Pesanan" name="jumlah" required>
                                            <label for="floatingPassword">Jumlah Pesanan Menu</label>
                                            <div class="invalid-feedback"> Masukkan Jumlah Pesanan</div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-12">
                                        <div class="form-floating mb-2">
                                            <input type="text" class="form-control" id="floatingInput" placeholder="Catatan" name="catatan">
                                            <label for="floatingInput">Catatan Pesanan</label>
                                            <div class="invalid-feedback"> Masukkan Catatan Pesanan Anda</div>
                                        </div>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                    <button type="submit" class="btn btn-primary" name="input_orderitem_validate" value="1">Upload changes</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <!-- End Modal Add New Item Order -->

            <!-- Start Modal Editing Item Order -->
            <?php foreach ($result as $row) { ?>
                <div class="modal fade" id="modaleditlistorder<?php echo $row['id_list_order'] ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-lg modal-fullscreen-md-down">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h1 class="modal-title fs-5" id="exampleModalLabel">Editing Item Order</h1>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <form class="needs-validation" novalidate action="proses/proseseditorderitem.php" method="POST">
                                    <input type="hidden" name="id" value="<?php echo $row['id_list_order'] ?>">
                                    <input type="hidden" name="kode_order" value="<?php echo $kode ?>">
                                    <input type="hidden" name="meja" value="<?php echo $meja ?>">
                                    <input type="hidden" name="pelanggan" value="<?php echo $pelanggan ?>">
                                    <div class="row">
                                        <div class="col-lg-8">
                                            <div class="form-floating mb-2">
                                                <select class="form-select" name="menu" id="">
                                                    <option selected hidden value="">Pilih Menu</option>
                                                    <?php foreach ($select_menu as $value) {
                                                        if ($row['menu'] == $value['id']) {
                                                            echo "<option selected value=$value[id]> $value[nama_menu]</option>";
                                                        } else {
                                                            echo "<option value=$value[id]> $value[nama_menu]</option>";
                                                        }
                                                    } ?>
                                                </select>
                                                <label for="menu"> Menu Kantin Biru</label>
                                                <div class="invalid-feedback"> Pilih Menu</div>
                                            </div>
                                        </div>
                                        <div class="col-lg-4">
                                            <div class="form-floating mb-2">
                                                <input type="number" class="form-control" id="floatingInput" placeholder="Jumlah Pesanan" name="jumlah" required value="<?php echo $row['jumlah'] ?>">
                                                <label for="floatingPassword">Jumlah Pesanan</label>
                                                <div class="invalid-feedback"> Masukkan Jumlah Pesanan</div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-lg-12">
                                            <div class="form-floating mb-2">
                                                <input type="text" class="form-control" id="floatingInput" placeholder="Catatan" name="catatan" value="<?php echo $row['catatan_menu'] ?>">
                                                <label for="floatingInput">Catatan Pesanan</label>
                                                <div class="invalid-feedback"> Masukkan Catatan Pesanan Anda</div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                        <button type="submit" class="btn btn-primary" name="edit_orderitem_validate" value="1">Upload changes</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            <?php } ?>
            <!-- End Modal Editing Item Order -->

            <!-- Start Modal Deleting Item Order -->
            <?php foreach ($result as $row) { ?>
                <div class="modal fade" id="modaldeletelistorder<?php echo $row['id_list_order'] ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-md modal-fullscreen-md-down">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h1 class="modal-title fs-5" id="exampleModalLabel">Deleting Order</h1>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <form action="proses/prosesdeleteorderitem.php" method="POST">
                                    <input type="hidden" value="<?php echo $row['id_list_order'] ?>" name="id">
                                    <input type="hidden" name="kode_order" value="<?php echo $kode ?>">
                                    <input type="hidden" name="meja" value="<?php echo $meja ?>">
                                    <input type="hidden" name="pelanggan" value="<?php echo $pelanggan ?>">
                                    <div class="col-lg-12">
                                        Apakah anda ingin menghapus Order Menu <b><?php echo $row['nama_menu'] ?> ??</b>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button>
                                        <button type="submit" class="btn btn-primary" name="delete_listorder_validate" value="1">Confirm</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            <?php } ?>
            <!-- End Modal Deleting Item Order -->

            <!-- Start Modal Order Payment -->
            <div class="modal fade" id="bayarItem" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-lg modal-fullscreen-md-down">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h1 class="modal-title fs-5" id="exampleModalLabel">Order Payment</h1>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <div class="table-responsive">
                                <table class="table table-hover">
                                    <thead>
                                        <tr class="text-nowrap">
                                            <th scope="col">Nama Menu</th>
                                            <th scope="col">Harga Menu</th>
                                            <th scope="col">Quantity</th>
                                            <th scope="col">Sub Total</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php $total = 0;
                                        foreach ($result as $row) { ?>
                                            <tr>
                                                <td><?php echo $row['nama_menu'] ?></td>
                                                <td><?php echo number_format((int)$row['harga'], 0, ',', '.') ?></td>
                                                <td><?php echo $row['jumlah'] ?></td>
                                                <td><?php echo number_format((int)$row['total_harga'], 0, ',', '.') ?></td>
                                            </tr>
                                        <?php $total += $row['total_harga'];
                                        } ?>
                                    </tbody>
                                    <tr>
                                        <td colspan="3" class="fw-bold"><b>Grand Total Harga</td>
                                        <td class="fw-bold"><?php echo number_format((int)$total, 0, ',', '.') ?></b></td>
                                    </tr>
                                </table>
                            </div>
                            <form class="needs-validation" novalidate action="proses/prosespembayaran.php" method="POST">
                                <input type="hidden" name="kode_order" value="<?php echo $kode ?>">
                                <input type="hidden" name="meja" value="<?php echo $meja ?>">
                                <input type="hidden" name="pelanggan" value="<?php echo $pelanggan ?>">
                                <input type="hidden" name="total" value="<?php echo $total ?>">
                                <div class="row">
                                    <div class="col-lg-12">
                                        <div class="form-floating mb-2">
                                            <input type="number" class="form-control" id="floatingInput" placeholder="nominal uang" name="uang" required>
                                            <label for="floatingInput"> Nominal Bayar</label>
                                            <div class="invalid-feedback"> Masukkan Nominal Pembayaran</div>
                                        </div>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                    <button type="submit" class="btn btn-success" name="payment_validate" value="1"><i class="bi bi-cash-coin"> Pay</i></button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <!-- End Modal Order Payment -->

            <!-- table class hover -->
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr class="text-nowrap">
                            <th scope="col">Nama Menu</th>
                            <th scope="col">Harga Menu</th>
                            <th scope="col">Quantity</th>
                            <th scope="col">Status</th>
                            <th scope="col">Catatan</th>
                            <th scope="col">Sub Total Harga</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $total = 0;
                        foreach ($result as $row) { ?>
                            <tr>
                                <td><?php echo $row['nama_menu'] ?></td>
                                <td><?php echo number_format((int)$row['harga'], 0, ',', '.') ?></td>
                                <td><?php echo $row['jumlah'] ?></td>
                                <td><?php if (isset($row['status_menu'])) {
                                        if ($row['status_menu'] == 1) {
                                            echo "<span class='badge text-bg-warning'>Diproses Dapur</span>";
                                        } else if ($row['status_menu'] == 2) {
                                            echo "<span class='badge text-bg-success'>Siap Saji</span>";
                                        } else if ($row['status_menu'] == 3) {
                                            echo "<span class='badge text-bg-primary'>Diterima</span>";
                                        } else {
                                            echo "<span class='badge text-bg-secondary'>Belum Diproses</span>";
                                        }
                                    } else {
                                        echo "<span class='badge text-bg-secondary'>Belum Diproses</span>";
                                    } ?> </td>
                                <td><?php echo $row['catatan_menu'] ?></td>
                                <td><?php echo number_format((int)$row['total_harga'], 0, ',', '.') ?></td>
                            </tr>
                        <?php $total += $row['total_harga'];
                        } ?>
                    </tbody>
                    <tr>
                        <td colspan="5" class="fw-bold"><b>Grand Total Harga</td>
                        <td class="fw-bold"><?php echo number_format((int)$total, 0, ',', '.') ?></b></td>
                    </tr>
                </table>
            </div>
        </div>
    </div>
</div>

<div id="contentStruk" class="d-none">
    <style>
        #struk-container {
            /* Tambahkan ID unik */
            font-family: Arial, sans-serif;
            width: 300px;
            margin: 0 auto;
            /* Pusatkan struk */
            border: 1px solid #000;
            padding: 10px;
            /* Tambahkan style untuk tampilan yang lebih baik */
        }

        #struk-container h2 {
            text-align: center;
        }

        #struk-container table {
            width: 100%;
            border-collapse: collapse;
        }

        #struk-container th,
        #struk-container td {
            border: 1px solid #000;
            padding: 5px;
            text-align: left;
        }

        #struk-container th {
            background-color: #f2f2f2;
        }
    </style>

    <div id="struk-container"> <!-- Tambahkan ID unik -->
        <h2><i class="bi bi-cup-hot"></i> Struk Pembayaran Kantin Biru <i class="bi bi-shop"></i></h2>
        <p>Kode Order : <?php echo htmlspecialchars($kode); ?></p>
        <p>Pelanggan : <?php echo htmlspecialchars($pelanggan); ?></p>
        <p>Meja : <?php echo htmlspecialchars($meja); ?></p>

        <?php if (!empty($result)) { ?>
            <p>Waktu Order : <?php echo date('d/m/Y H:i:s', strtotime(htmlspecialchars($result[0]['waktu_order']))); ?></p>
            <p>Waktu Bayar : <?php echo (!empty($result[0]['waktu_bayar'])) ? date('d/m/Y H:i:s', strtotime(htmlspecialchars($result[0]['waktu_bayar']))) : 'Belum Dibayar'; ?></p>
            <table>
                <thead>
                    <tr>
                        <th>Menu</th>
                        <th>Harga</th>
                        <th>Quantity</th>
                        <th>Sub Total</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $total = 0;
                    foreach ($result as $row) {
                        $total += $row['total_harga'];
                    ?>
                        <tr>
                            <td><?php echo htmlspecialchars($row['nama_menu']); ?></td>
                            <td><?php echo number_format((int)$row['harga'], 0, ',', '.'); ?></td>
                            <td><?php echo htmlspecialchars($row['jumlah']); ?></td>
                            <td><?php echo number_format((int)$row['total_harga'], 0, ',', '.'); ?></td>
                        </tr>
                    <?php } ?>
                    <tr>
                        <td colspan="3" style="text-align: right;">Grand Total Harga:</td>
                        <td><?php echo number_format((int)$total, 0, ',', '.'); ?></td>
                    </tr>
                </tbody>
            </table>
        <?php } else { ?>
            <p>Tidak ada data order untuk dicetak.</p>
        <?php } ?>
    </div> <!-- End of struk-container -->
</div> <!-- End of contentStruk -->

<script>
    // Fungsi cetak struk pembayaran.
    function cetakStruk() {
        var strukContent = document.getElementById('contentStruk').innerHTML;
        var printWindow = window.open('', '', 'height=1000,width=1000');
        printWindow.document.write('<html><head><title>Cetak Struk Pembayaran</title>');
        printWindow.document.write('</head>');
        printWindow.document.write('<body>' + strukContent + '</body>');
        printWindow.document.close();
        printWindow.print();
        printWindow.close();
    }
</script>