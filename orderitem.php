<?php
include "proses/connect.php";
$query = mysqli_query($conn, "SELECT *, SUM(harga*jumlah) AS total_harga, tb_order.*, tb_bayar.*, tb_menu.* FROM tb_list_order 
LEFT JOIN tb_order ON tb_order.id_order = tb_list_order.kode_order
LEFT JOIN tb_menu ON tb_menu.id = tb_list_order.menu
LEFT JOIN tb_bayar ON tb_bayar.id_bayar = tb_order.id_order
GROUP BY id_list_order HAVING tb_list_order.kode_order = $_GET[order] ORDER BY tb_menu.nama_menu ASC");

$kode = $_GET['order'];
$meja = $_GET['meja'];
$pelanggan = $_GET['pelanggan'];
$paymentExists = false; // New variable to track payment status

$result = []; // Initialize $result as an empty array

while ($record = mysqli_fetch_array($query)) {
    $result[] = $record;
    $total_harga = $record['total_harga'];
    $catatan = $record['catatan'];
    if (!empty($record['id_bayar'])) { // Check if payment exists
        $paymentExists = true; // Set to true if a payment record is found
    }
}
$select_menu = mysqli_query($conn, "SELECT tb_menu.id, tb_menu.nama_menu, tb_menu.foto, tb_menu.harga, tb_menu.stock, tb_menu.deskripsi, tb_menu.kategori, tb_kategori_menu.kategori_menu, tb_kategori_menu.jenis_menu FROM tb_menu LEFT JOIN tb_kategori_menu ON tb_kategori_menu.id_kategori = tb_menu.kategori ORDER BY tb_menu.nama_menu ASC");
?>

<div class="col-lg-10 mt-2 rounded">
    <div class="card">
        <div class="card-header">
            Halaman Order Item Menu
        </div>
        <div class="card-body">
            <div class="row mb-2">
                <div class="row">
                    <div class="col-lg-10">
                        <td><a class="btn btn-secondary btn-md" href="order"><i class="bi bi-arrow-left-circle"> Back</i></a></td>
                        <button class="btn btn-warning btn-md" onclick="cetakStruk()"><i class="bi bi-file-earmark-arrow-down"> Print</i></button>
                    </div>
                    <div class="col-lg-2">
                        <button class="<?php echo $paymentExists ? "btn btn-secondary btn-md disabled" : "btn btn-primary btn-md"; ?>" data-bs-toggle="modal" data-bs-target="#tambahItem"><i class="bi bi-bag-plus"> Add</i></button>
                        <button class="<?php echo $paymentExists ? "btn btn-secondary btn-md disabled" : "btn btn-success btn-md"; ?>" data-bs-toggle="modal" data-bs-target="#bayarItem"><i class="bi bi-cash-coin"> Pay</i></button>
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
                            <input type="text" class="form-control" id="catatan" disabled
                                value="<?php if (empty($catatan)) {
                                            echo "Data Catatan Kosong!";
                                        } else {
                                            echo $catatan;
                                        } ?>">
                            <label for="nomormeja">Catatan Pesanan</label>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Start Modal Add New Item Order -->
            <div class="modal fade" id="tambahItem" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-xl modal-fullscreen-md-down">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h1 class="modal-title fs-5" id="exampleModalLabel">Add Item Order</h1>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <form class="needs-validation" novalidate action="proses/prosesinputorderitem.php" method="POST">
                                <div class="table-responsive mt-2">
                                    <table class="table table-hover" id="example">
                                        <thead>
                                            <tr class="text-nowrap">
                                                <th scope="col">No</th>
                                                <th scope="col">Foto</th>
                                                <!-- <th scope="col">id</th> -->
                                                <th scope="col">Nama Menu</th>
                                                <!-- <th scope="col">Deskripsi</th> -->
                                                <!-- <th scope="col">Kategori</th> -->
                                                <th scope="col">Harga</th>
                                                <th scope="col">Action</th>
                                                <th scope="col">Jumlah</th>
                                                <th scope="col">Catatan</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php $no = 1;
                                            foreach ($select_menu as $value) { ?>
                                                <tr>
                                                    <th scope="row"><?php echo $no++ ?></th>
                                                    <td>
                                                        <div style="width: 80px;"><img src="assets/img/<?php echo $value['foto'] ?>" class="img-thumbnail" alt="images"></div>
                                                    </td>
                                                    <input type="hidden" name="nama_menu[]" value="<?php echo $value['nama_menu'] ?>">
                                                    <input type="hidden" name="kode_order" value="<?php echo $kode; ?>">
                                                    <input type="hidden" name="meja" value="<?php echo $meja ?>">
                                                    <input type="hidden" name="pelanggan" value="<?php echo $pelanggan ?>"> 
                                                    <td><?php echo $value['nama_menu'] ?></td>
                                                    <!-- <td><?php echo $value['deskripsi'] ?></td> -->
                                                    <!-- <td><?php echo $value['kategori_menu'] ?></td> -->
                                                    <td><?php echo number_format((int)$value['harga'], 0, ',', '.')  ?></td>
                                                    <td>
                                                        <div class="form-check form-switch">
                                                            <input class="form-check-input" type="checkbox" id="item_<?php echo $value['id'] ?>" name="id_menu[]" value="<?php echo $value['id'] ?>"> <!-- Unique ID and name -->
                                                            <label class="form-check-label" for="item_<?php echo $value['id'] ?>">Buy</label>
                                                        </div>
                                                    </td>
                                                    <td> <input type="number" class="form-control quantity-input" id="quantity_<?php echo $value['id']; ?>" name="jumlah[<?php echo $value['id']; ?>]" value="" min="0" disabled></td> <!-- Unique ID and name -->
                                                    <td><input type="text" class="form-control notes-input" id="notes_<?php echo $value['id']; ?>" name="catatan[<?php echo $value['id']; ?>]" disabled></td> <!-- Unique ID and name -->
                                                </tr>
                                            <?php } ?>
                                        </tbody>
                                    </table>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                        <button type="submit" class="btn btn-primary" name="input_orderitem_validate" value="1">Upload changes</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <!-- End Modal Add New Item Order -->

            <script>
                // Function to toggle quantity and notes input based on checkbox state.  Improved for efficiency.
                const checkboxes = document.querySelectorAll('input[name="id_menu[]"]');
                checkboxes.forEach(checkbox => {
                    checkbox.addEventListener('change', function() {
                        const itemId = this.value;
                        document.getElementById(`quantity_${itemId}`).disabled = !this.checked;
                        document.getElementById(`notes_${itemId}`).disabled = !this.checked;
                        // Set default value to 0 if unchecked
                        if (!this.checked) {
                            document.getElementById(`quantity_${itemId}`).value = 0;
                        }
                    });
                });
            </script>


            <?php
            if (empty($result)) {
                echo "<div class='alert alert-warning' role='alert'>Data Order Pelanggan kosong!</div>";
            } else { ?>

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
                                <th scope="col">Action</th>
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
                                    <td>
                                        <div class="d-flex">
                                            <button class="<?php echo $paymentExists ? "btn btn-secondary btn-sm disabled me-1" : "btn btn-warning btn-sm me-1"; ?>" data-bs-toggle="modal" data-bs-target="#modaleditlistorder<?php echo $row['id_list_order'] ?>"><i class="bi bi-pen"></i></button>
                                            <button class="<?php echo $paymentExists ? "btn btn-secondary btn-sm disabled" : "btn btn-danger btn-sm"; ?>" data-bs-toggle="modal" data-bs-target="#modaldeletelistorder<?php echo $row['id_list_order'] ?>"><i class="bi bi-trash"></i></button>
                                        </div>
                                    </td>
                                </tr>
                            <?php $total += $row['total_harga'];
                            } ?>
                        </tbody>
                        <tr>
                            <td colspan="5" class="fw-bold"><b>Grand Total Harga</td>
                            <td class="fw-bold"><?php echo number_format((int)$total, 0, ',', '.') ?></b></td>
                            <td>
                                <button class="<?php echo $paymentExists ? "btn btn-secondary btn-sm disabled me-1" : "btn btn-primary btn-sm me-1"; ?>" data-bs-toggle="modal" data-bs-target="#tambahItem"><i class="bi bi-bag-plus"></i></button>
                                <button class="<?php echo $paymentExists ? "btn btn-secondary btn-sm disabled" : "btn btn-success btn-sm"; ?>" data-bs-toggle="modal" data-bs-target="#bayarItem"><i class="bi bi-cash-coin"></i></button>
                            </td>
                        </tr>
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
    </div>
</div>

<script>
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