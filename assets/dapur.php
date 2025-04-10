<?php
include "proses/connect.php";
$query = mysqli_query($conn, "SELECT * FROM tb_list_order
LEFT JOIN tb_order ON tb_order.id_order = tb_list_order.kode_order
LEFT JOIN tb_menu ON tb_menu.id = tb_list_order.menu
LEFT JOIN tb_bayar ON tb_bayar.id_bayar = tb_order.id_order
-- WHERE tb_list_order.status_menu != 3
ORDER BY tb_list_order.kode_order DESC");

$result = [];
while ($record = mysqli_fetch_array($query)) {
    $result[] = $record;
}
$select_menu = mysqli_query($conn, "SELECT id, nama_menu FROM tb_menu");
?>

<div class="col-lg-10 mt-2 rounded">
    <div class="card">
        <div class="card-header">
            Halaman Dapur
        </div>
        <div class="card-body">
            <?php if (empty($result)) {
                echo "<div class='alert alert-warning' role='alert'>Data Antrian Dapur kosong!</div>";
            } else {
                foreach ($result as $row) { ?>

                    <!-- Start Modal Accepting Menu Order-->
                    <div class="modal fade" id="terimaorder<?php echo $row['id_list_order'] ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-lg modal-fullscreen-md-down">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h1 class="modal-title fs-5" id="exampleModalLabel">Terima Order Menu</h1>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <form class="needs-validation" novalidate action="proses/prosesterimaorder.php" method="POST">
                                        <input type="hidden" name="id" value="<?php echo $row['id_list_order'] ?>">
                                        <div class="row">
                                            <div class="col-lg-8">
                                                <div class="form-floating mb-2">
                                                    <select disabled class="form-select" name="menu" id="">
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
                                                    <input disabled type="number" class="form-control" id="floatingInput" placeholder="Jumlah Pesanan" name="jumlah" required value="<?php echo $row['jumlah'] ?>">
                                                    <label for="floatingPassword">Jumlah Pesanan</label>
                                                    <div class="invalid-feedback"> Masukkan Jumlah Pesanan</div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-lg-12">
                                                <div class="form-floating mb-2">
                                                    <input disabled type="text" class="form-control" id="floatingInput" placeholder="Catatan" name="catatan" value="<?php echo $row['catatan_menu'] ?>">
                                                    <label for="floatingInput">Catatan Pesanan</label>
                                                    <div class="invalid-feedback"> Masukkan Catatan Pesanan Anda</div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                            <button type="submit" class="btn btn-primary" name="terima_order_validate" value="1">Upload changes</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- End Modal Accepting Menu Order -->

                    <!-- Start Modal Menu Order Siap Saji-->
                    <div class="modal fade" id="siapsaji<?php echo $row['id_list_order'] ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-lg modal-fullscreen-md-down">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h1 class="modal-title fs-5" id="exampleModalLabel">Order Menu Siap Saji</h1>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <form class="needs-validation" novalidate action="proses/prosesordermenusiapsaji.php" method="POST">
                                        <input type="hidden" name="id" value="<?php echo $row['id_list_order'] ?>">
                                        <div class="row">
                                            <div class="col-lg-8">
                                                <div class="form-floating mb-2">
                                                    <select disabled class="form-select" name="menu" id="">
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
                                                    <input disabled type="number" class="form-control" id="floatingInput" placeholder="Jumlah Pesanan" name="jumlah" required value="<?php echo $row['jumlah'] ?>">
                                                    <label for="floatingPassword">Jumlah Pesanan</label>
                                                    <div class="invalid-feedback"> Masukkan Jumlah Pesanan</div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-lg-12">
                                                <div class="form-floating mb-2">
                                                    <input disabled type="text" class="form-control" id="floatingInput" placeholder="Catatan" name="catatan" value="<?php echo $row['catatan_menu'] ?>">
                                                    <label for="floatingInput">Catatan Pesanan</label>
                                                    <div class="invalid-feedback"> Masukkan Catatan Pesanan Anda</div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                            <button type="submit" class="btn btn-primary" name="order_menu_siap_saji_validate" value="1">Upload changes</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- End Modal Menu Order Siap Saji -->

                    <!-- Start Modal Menu Order Diterima-->
                    <div class="modal fade" id="diterima<?php echo $row['id_list_order'] ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-lg modal-fullscreen-md-down">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h1 class="modal-title fs-5" id="exampleModalLabel">Order Menu Siap Saji</h1>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <form class="needs-validation" novalidate action="proses/prosesordermenuditerima.php" method="POST">
                                        <input type="hidden" name="id" value="<?php echo $row['id_list_order'] ?>">
                                        <div class="row">
                                            <div class="col-lg-8">
                                                <div class="form-floating mb-2">
                                                    <select disabled class="form-select" name="menu" id="">
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
                                                    <input disabled type="number" class="form-control" id="floatingInput" placeholder="Jumlah Pesanan" name="jumlah" required value="<?php echo $row['jumlah'] ?>">
                                                    <label for="floatingPassword">Jumlah Pesanan</label>
                                                    <div class="invalid-feedback"> Masukkan Jumlah Pesanan</div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-lg-12">
                                                <div class="form-floating mb-2">
                                                    <input disabled type="text" class="form-control" id="floatingInput" placeholder="Catatan" name="catatan" value="<?php echo $row['catatan_menu'] ?>">
                                                    <label for="floatingInput">Catatan Pesanan</label>
                                                    <div class="invalid-feedback"> Masukkan Catatan Pesanan Anda</div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                            <button type="submit" class="btn btn-primary" name="order_menu_diterima_validate" value="1">Upload changes</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- End Modal Menu Order Diterima -->
                <?php } ?>

                <!-- table class hover -->
                <div class="table-responsive mt-2">
                    <table class="table table-hover" id="example">
                        <thead>
                            <tr class="text-nowrap">
                                <th scope="col">No</th>
                                <!-- <th scope="col">Kode Order</th> -->
                                <th scope="col">Nama</th>
                                <th scope="col">Waktu Order</th>
                                <th scope="col">Nama Menu</th>
                                <!-- <th scope="col">Meja</th> -->
                                <th scope="col">Qty</th>
                                <th scope="col">Notes</th>
                                <th scope="col">Status</th>
                                <th scope="col">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $no = 1;
                            foreach ($result as $row) {
                                if ($row['status_menu'] != 3) { ?>
                                    <tr>
                                        <td><?php echo $no++ ?></td>
                                        <!-- <td><?php echo $row['kode_order'] ?></td> -->
                                        <td><?php echo $row['pelanggan'] ?></td>
                                        <td><?php echo $row['waktu_order'] ?></td>
                                        <td><?php echo $row['nama_menu'] ?></td>
                                        <td><?php echo $row['jumlah'] ?></td>
                                        <!-- <td><?php echo $row['meja'] ?></td> -->
                                        <td><?php echo $row['catatan_menu'] ?></td>
                                        <td><?php if ($row['status_menu'] == 1) {
                                                echo "<span class='badge text-bg-warning'>Diproses Dapur</span>";
                                            } elseif ($row['status_menu'] == 2) {
                                                echo "<span class='badge text-bg-success'>Siap Saji</span>";
                                            } elseif ($row['status_menu'] == 3) {
                                                echo "<span class='badge text-bg-primary'>Diterima</span>";
                                            } else {
                                                echo "<span class='badge text-bg-secondary'>Belum Diproses</span>";
                                            } ?></td>
                                        <td>
                                            <div class="d-flex">
                                                <button class="<?php echo ($row['status_menu'] == 1 || $row['status_menu'] == 2 || $row['status_menu'] == 3) ? "btn btn-secondary btn-sm disabled me-1" : "btn btn-warning btn-sm me-1"; ?>" data-bs-toggle="modal" data-bs-target="#terimaorder<?php echo $row['id_list_order'] ?>"><i class="bi bi-clipboard-check"></i></button>
                                                <button class="<?php echo ($row['status_menu'] != 1) ? "btn btn-secondary btn-sm disabled me-1" : "btn btn-success btn-sm me-1"; ?>" data-bs-toggle="modal" data-bs-target="#siapsaji<?php echo $row['id_list_order'] ?>"><i class="bi bi-check-all"></i></button>
                                                <button class="<?php echo ($row['status_menu'] != 2) ? "btn btn-secondary btn-sm disabled me-1" : "btn btn-primary btn-sm me-1"; ?>" data-bs-toggle="modal" data-bs-target="#diterima<?php echo $row['id_list_order'] ?>"><i class="bi bi-bag-check"></i></button>
                                            </div>
                                        </td>
                                    </tr>
                            <?php }
                            } ?>
                        </tbody>
                    </table>
                </div>
            <?php } ?>
        </div>
    </div>
</div>