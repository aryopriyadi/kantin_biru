<?php
include "proses/connect.php";

// Modify the query to include the 'tipe' column from tb_bayar
$query = mysqli_query($conn, "SELECT *, SUM(harga*jumlah) AS total_harga, tb_order.catatan, tb_bayar.tipe 
FROM tb_list_order 
LEFT JOIN tb_order ON tb_order.id_order = tb_list_order.kode_order
LEFT JOIN tb_menu ON tb_menu.id = tb_list_order.menu
LEFT JOIN tb_bayar ON tb_bayar.id_bayar = tb_order.id_order
GROUP BY id_list_order HAVING tb_list_order.kode_order = $_GET[order]");

$kode = $_GET['order'];
$meja = $_GET['meja'];
$pelanggan = $_GET['pelanggan'];
$paymentExists = false; // New variable to track payment status
$tipe_bayar = ''; // Variable to store the tipe_bayar value

while ($record = mysqli_fetch_array($query)) {
    $result[] = $record;
    $total_harga = $record['total_harga'];
    $catatan = $record['catatan'];
    if (!empty($record['id_bayar'])) { // Check if payment exists
        $paymentExists = true; // Set to true if a payment record is found
        $tipe_bayar = $record['tipe']; // Store the tipe value
    }
}

// Function to convert tipe value to readable string
function getTipeBayar($tipe) {
    switch ($tipe) {
        case 1:
            return 'Cash/Tunai';
        case 2:
            return 'QRIS';
        default:
            return 'Belum Dibayar';
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
                    <div class="col-lg-3">
                        <div class="form-floating mb-2">
                            <input type="text" class="form-control" id="kodeorder" value="<?php echo $kode; ?>" disabled>
                            <label for="kodeorder">Kode Order</label>
                        </div>
                    </div>
                    <div class="col-lg-3">
                        <div class="form-floating mb-2">
                            <input type="text" class="form-control" id="nomormeja" disabled value="<?php echo $meja; ?>">
                            <label for="nomormeja">Nomor Meja</label>
                        </div>
                    </div>
                    <div class="col-lg-3">
                        <div class="form-floating mb-2">
                            <input type="text" class="form-control" id="pelanggan" disabled value="<?php echo $pelanggan; ?>">
                            <label for="pelanggan">Nama Pelanggan</label>
                        </div>
                    </div>
                    <div class="col-lg-3">
                        <div class="form-floating mb-2">
                            <!-- Set the value attribute to the tipe_bayar variable -->
                            <input type="text" class="form-control" id="tipe_bayar" disabled value="<?php echo getTipeBayar($tipe_bayar); ?>">
                            <label for="tipe_bayar">Tipe Bayar</label>
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

            <!-- table class hover -->
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr class="text-nowrap">
                            <th scope="col">Nama Menu</th>
                            <th scope="col">Harga Menu</th>
                            <th scope="col">Quantity</th>
                            <!-- <th scope="col">Status</th> -->
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
                                <!-- <td><?php if (isset($row['status_menu'])) {
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
                                            } ?> </td> -->
                                <td><?php echo $row['catatan_menu'] ?></td>
                                <td><?php echo number_format((int)$row['total_harga'], 0, ',', '.') ?></td>
                            </tr>
                        <?php $total += $row['total_harga'];
                        } ?>
                    </tbody>
                    <tr>
                        <td colspan="4" class="fw-bold"><b>Grand Total Harga</td>
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
            font-family: Arial, sans-serif;
            width: 300px;
            margin: 0 auto;
            border: 1px solid #000;
            padding: 10px;
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
                    <tr>
                        <td colspan="3" style="text-align: right;">Tipe Pembayaran:</td>
                        <td><?php echo getTipeBayar($tipe_bayar); ?></td>
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
