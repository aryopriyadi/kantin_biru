<?php
include "proses/connect.php";
include "main.php";
date_default_timezone_set('Asia/Jakarta');

// Fetch all unpaid orders
$query = mysqli_query($conn, "SELECT tb_order.*, tb_bayar.id_bayar, nama, SUM(harga*jumlah) AS total_harga FROM tb_order 
LEFT JOIN tb_user ON tb_user.id = tb_order.pelayan
LEFT JOIN tb_list_order ON tb_list_order.kode_order = tb_order.id_order
LEFT JOIN tb_menu ON tb_menu.id = tb_list_order.menu
LEFT JOIN tb_bayar ON tb_bayar.id_bayar = tb_order.id_order
WHERE tb_bayar.id_bayar IS NULL 
GROUP BY id_order 
ORDER BY waktu_order DESC");

$result = []; // Initialize result array
while ($record = mysqli_fetch_array($query)) {
    $result[] = $record; // Store each record in the result array
}
?>

<div class="col-lg-10 mt-2 rounded">
    <div class="card">
        <div class="card-header">
            Halaman Order Menu
        </div>
        <div class="card-body">
            <div class="row mb-2">
                <div class="col d-flex justify-content-end">
                    <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modaladdmenu"><i class="bi bi-bag-plus"></i></button>
                </div>
            </div>

            <!-- Start Modal Add New Order -->
            <div class="modal fade" id="modaladdmenu" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-lg modal-fullscreen-md-down">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h1 class="modal-title fs-5" id="exampleModalLabel">Add Order</h1>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <form class="needs-validation" novalidate action="proses/prosesinputorder.php" method="POST">
                                <div class="row">
                                    <div class="col-lg-4">
                                        <div class="form-floating mb-2">
                                            <input type="text" class="form-control" id="kodeorder" placeholder="Kode Order" name="kodeorder" value="<?php echo date('ymdHi') . rand(100, 999) ?>" readonly>
                                            <label for="kodeorder">Kode Order</label>
                                            <div class="invalid-feedback"> Masukkan Kode Order</div>
                                        </div>
                                    </div>
                                    <div class="col-lg-4">
                                        <div class="form-floating mb-2">
                                            <input type="number" class="form-control" id="meja" placeholder="Nomor Meja" name="meja" required>
                                            <label for="meja">Nomor Meja</label>
                                            <div class="invalid-feedback"> Masukkan Nomor Meja</div>
                                        </div>
                                    </div>
                                    <div class="col-lg-4">
                                        <div class="form-floating mb-2">
                                            <input type="text" class="form-control" id="pelanggan" placeholder="Nama Pelanggan" name="pelanggan" required>
                                            <label for="pelanggan">Nama Pelanggan</label>
                                            <div class="invalid-feedback"> Masukkan Nama Pelanggan</div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-12">
                                        <div class="form-floating mb-2">
                                            <input type="text" class="form-control" id="catatan" placeholder="catatan" name="catatan">
                                            <label for="catatan">Catatan Pesanan</label>
                                            <div class="invalid-feedback"> Masukkan Catatan Pesanan</div>
                                        </div>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                    <button type="submit" class="btn btn-primary" name="input_order_validate" value="1"> Add New Order</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <!-- End Modal Add New Order -->

            <?php
            if (empty($result)) {
                echo "<div class='alert alert-warning' role='alert'>Data Antrian Order kosong!</div>";
            } else { ?>

                <!-- Start Modal Editing Order -->
                <?php foreach ($result as $row) { ?>
                    <div class="modal fade" id="modaleditorder<?php echo $row['id_order'] ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-xl modal-fullscreen-md-down">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h1 class="modal-title fs-5" id="exampleModalLabel">Editing Order</h1>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <form class="needs-validation" novalidate action="proses/prosesedittorder.php" method="POST">
                                        <div class="row">
                                            <div class="col-lg-4">
                                                <div class="form-floating mb-2">
                                                    <input type="text" class="form-control" id="kodeorder" placeholder="Kode Order" name="kodeorder" value="<?php echo $row['id_order'] ?>" readonly>
                                                    <label for="kodeorder">Kode Order</label>
                                                    <div class="invalid-feedback"> Masukkan Kode Order</div>
                                                </div>
                                            </div>
                                            <div class="col-lg-4">
                                                <div class="form-floating mb-2">
                                                    <input type="number" class="form-control" id="meja" placeholder="Nomor Meja" name="meja" required value="<?php echo $row['meja'] ?>">
                                                    <label for="meja">Nomor Meja</label>
                                                    <div class="invalid-feedback"> Masukkan Nomor Meja</div>
                                                </div>
                                            </div>
                                            <div class="col-lg-4">
                                                <div class="form-floating mb-2">
                                                    <input type="text" class="form-control" id="pelanggan" placeholder="Nama Pelanggan" name="pelanggan" required value="<?php echo $row['pelanggan'] ?>">
                                                    <label for="pelanggan">Nama Pelanggan</label>
                                                    <div class="invalid-feedback"> Masukkan Nama Pelanggan</div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-lg-12">
                                                <div class="form-floating mb-2">
                                                    <input type="text" class="form-control" id="catatan" placeholder="catatan" name="catatan" value="<?php echo $row['catatan'] ?>">
                                                    <label for="catatan">Catatan Pesanan</label>
                                                    <div class="invalid-feedback"> Masukkan Catatan Pesanan</div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                            <button type="submit" class="btn btn-primary" name="edit_order_validate" value="1"> Update Order</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php } ?>
                <!-- End Modal Editing Order -->

                <!-- Start Modal Deleting Order -->
                <?php foreach ($result as $row) { ?>
                    <div class="modal fade" id="modaldeleteorder<?php echo $row['id_order'] ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-md modal-fullscreen-md-down">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h1 class="modal-title fs-5" id="exampleModalLabel">Deleting Order</h1>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <form action="proses/prosesdeleteorder.php" method="POST">
                                        <input type="hidden" value="<?php echo $row['id_order'] ?>" name="kode_order">
                                        <div class="col-lg-12">
                                            Apakah anda ingin menghapus Order atas nama <b><?php echo $row['pelanggan'] ?></b> dengan kode order <b><?php echo $row['id_order'] ?></b>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button>
                                            <button type="submit" class="btn btn-primary" name="delete_order_validate" value="1">Confirm</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php } ?>
                <!-- End Modal Deleting Order -->

                <!-- Start Modal Order Payment -->
                <?php foreach ($result as $row) { 
                    // Fetch order items for the specific order
                    $order_items_query = mysqli_query($conn, "SELECT tb_list_order.*, tb_menu.nama_menu, tb_menu.harga FROM tb_list_order 
                    LEFT JOIN tb_menu ON tb_menu.id = tb_list_order.menu
                    WHERE tb_list_order.kode_order = " . $row['id_order']);
                    $order_items = [];
                    while ($item = mysqli_fetch_array($order_items_query)) {
                        $order_items[] = $item;
                    }
                    $total = 0;
                    foreach ($order_items as $item) {
                        $total += $item['harga'] * $item['jumlah'];
                    }
                ?>
                    <div class="modal fade" id="bayarItem<?php echo $row['id_order'] ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
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
                                                <?php foreach ($order_items as $item) { ?>
                                                    <tr>
                                                        <td><?php echo $item['nama_menu'] ?></td>
                                                        <td><?php echo number_format((int)$item['harga'], 0, ',', '.') ?></td>
                                                        <td><?php echo $item['jumlah'] ?></td>
                                                        <td><?php echo number_format((int)($item['harga'] * $item['jumlah']), 0, ',', '.') ?></td>
                                                    </tr>
                                                <?php } ?>
                                            </tbody>
                                            <tr>
                                                <td colspan="3" class="fw-bold"><b>Grand Total Harga</td>
                                                <td class="fw-bold"><?php echo number_format((int)$total, 0, ',', '.') ?></b></td>
                                            </tr>
                                        </table>
                                    </div>
                                    <form class="needs-validation" novalidate action="proses/prosespembayaran.php" method="POST">
                                        <input type="hidden" name="kode_order" value="<?php echo $row['id_order'] ?>">
                                        <input type="hidden" name="meja" value="<?php echo $row['meja'] ?>">
                                        <input type="hidden" name="pelanggan" value="<?php echo $row['pelanggan'] ?>">
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
                                            <!-- <button class="btn btn-warning btn-md" onclick="cetakStruk('<?php echo $row['id_order'] ?>')"><i class="bi bi-file-earmark-arrow-down"> Print</i></button> -->
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php } ?>
                <!-- End Modal Order Payment -->

                <!-- table class hover -->
                <div class="table-responsive mt-2">
                    <table class="table table-hover" id="example">
                        <thead>
                            <tr class="text-nowrap">
                                <th scope="col">No</th>
                                <th scope="col">Kode Order</th>
                                <th scope="col">Pelanggan</th>
                                <th scope="col">Meja</th>
                                <th scope="col">Total Harga</th>
                                <th scope="col">Status</th>
                                <th scope="col">Waktu Order</th>
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
                                    <td><?php echo $row['meja'] ?></td>
                                    <td><?php echo number_format((int)$row['total_harga'], 0, ',', '.') ?></td>
                                    <td><?php if (!empty($row['id_bayar'])) {
                                            echo "<span class='badge text-bg-success'>Paid</span>";
                                        } else {
                                            echo "<span class='badge text-bg-warning'>UnPaid</span>";
                                        } ?></td>
                                    <td><?php echo $row['waktu_order'] ?></td>
                                    <td>
                                        <div class="d-flex">
                                            <a class="btn btn-success btn-sm me-1" href="./?x=orderitem&order=<?php echo $row['id_order'] . "&meja=" . $row['meja'] . "&pelanggan=" . $row['pelanggan'] ?>"><i class="bi bi-info-circle"></i></a>
                                            <button class="<?php echo !empty($row['id_bayar']) ? "btn btn-secondary btn-sm disabled me-1" : "btn btn-warning btn-sm me-1"; ?>" data-bs-toggle="modal" data-bs-target="#modaleditorder<?php echo $row['id_order'] ?>"><i class="bi bi-pen"></i></button>
                                            <button class="<?php echo !empty($row['id_bayar']) ? "btn btn-secondary btn-sm disabled me-1" : "btn btn-danger btn-sm me-1"; ?>" data-bs-toggle="modal" data-bs-target="#modaldeleteorder<?php echo $row['id_order'] ?>"><i class="bi bi-trash"></i></button>
                                            <button class="<?php echo !empty($row['id_bayar']) ? "btn btn-secondary btn-sm disabled" : "btn btn-success btn-sm"; ?>" data-bs-toggle="modal" data-bs-target="#bayarItem<?php echo $row['id_order'] ?>"><i class="bi bi-cash-coin"></i></button>
                                        </div>
                                    </td>
                                </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>
            <?php } ?>
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

    <div id="struk-container">
        <h2><i class="bi bi-cup-hot"></i> Struk Pembayaran Kantin Biru <i class="bi bi-shop"></i></h2>
        <p id="struk-kode-order"></p>
        <p id="struk-pelanggan"></p>
        <p id="struk-meja"></p>
        <p id="struk-waktu-order"></p>
        <p id="struk-waktu-bayar"></p>
        <table id="struk-table">
            <thead>
                <tr>
                    <th>Menu</th>
                    <th>Harga</th>
                    <th>Quantity</th>
                    <th>Sub Total</th>
                </tr>
            </thead>
            <tbody id="struk-tbody">
            </tbody>
            <tr>
                <td colspan="3" style="text-align: right;">Grand Total Harga:</td>
                <td id="struk-grand-total"></td>
            </tr>
        </table>
    </div>
</div>

<script>
    function cetakStruk(kode_order) {
        // Fetch order details and items via AJAX
        fetch(`proses/fetch_order_details.php?order=${kode_order}`)
            .then(response => response.json())
            .then(data => {
                document.getElementById('struk-kode-order').innerText = `Kode Order : ${data.kode_order}`;
                document.getElementById('struk-pelanggan').innerText = `Pelanggan : ${data.pelanggan}`;
                document.getElementById('struk-meja').innerText = `Meja : ${data.meja}`;
                document.getElementById('struk-waktu-order').innerText = `Waktu Order : ${data.waktu_order}`;
                document.getElementById('struk-waktu-bayar').innerText = `Waktu Bayar : ${data.waktu_bayar || 'Belum Dibayar'}`;

                const tbody = document.getElementById('struk-tbody');
                tbody.innerHTML = '';
                let total = 0;
                data.items.forEach(item => {
                    const row = document.createElement('tr');
                    row.innerHTML = `
                        <td>${item.nama_menu}</td>
                        <td>${item.harga.toLocaleString('id-ID')}</td>
                        <td>${item.jumlah}</td>
                        <td>${(item.harga * item.jumlah).toLocaleString('id-ID')}</td>
                    `;
                    tbody.appendChild(row);
                    total += item.harga * item.jumlah;
                });

                document.getElementById('struk-grand-total').innerText = total.toLocaleString('id-ID');

                // Print the struk
                var strukContent = document.getElementById('contentStruk').innerHTML;
                var printWindow = window.open('', '', 'height=1000,width=1000');
                printWindow.document.write('<html><head><title>Cetak Struk Pembayaran</title>');
                printWindow.document.write('</head>');
                printWindow.document.write('<body>' + strukContent + '</body>');
                printWindow.document.close();
                printWindow.print();
                printWindow.close();
            })
            .catch(error => console.error('Error fetching order details:', error));
    }
</script>
