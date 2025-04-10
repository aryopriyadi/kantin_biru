<?php
include "proses/connect.php";
include "main.php";
$query = mysqli_query($conn, "SELECT * FROM tb_kategori_menu");
while ($record = mysqli_fetch_array($query)) {
    $result[] = $record;
} ?>

<div class="col-lg-10 mt-2 rounded">
    <div class="card">
        <div class="card-header">
            Halaman Kategori Menu
        </div>
        <div class="card-body">
            <div class="row mb-2">
                <div class="col d-flex justify-content-end">
                    <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modaladdkategori"><i class="bi bi-clipboard2-plus"></i></button>
                </div>
            </div>

            <!-- Start Modal Add Kategori -->
            <div class="modal fade" id="modaladdkategori" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-lg modal-fullscreen-md-down">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h1 class="modal-title fs-5" id="exampleModalLabel">Add Categories</h1>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <form class="needs-validation" novalidate action="proses/prosesinputkategori.php" method="POST">
                                <div class="row">
                                    <div class="col-lg-6">
                                        <div class="form-floating mb-2">
                                            <select class="form-select" name="jenismenu" id="">
                                                <option value="1">Makanan</option>
                                                <option value="2">Minuman</option>
                                                <option value="3">Barang-Barang</option>
                                            </select>
                                            <label for="floatingInput">Jenis Menu</label>
                                            <div class="invalid-feedback"> Masukkan Jenis Menu</div>
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="form-floating mb-2">
                                            <input type="text" class="form-control" id="floatingInput" placeholder="kategori menu" name="kategori" required>
                                            <label for="floatingPassword">Kategori Menu</label>
                                            <div class="invalid-feedback"> Masukkan Kategori Menu</div>
                                        </div>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                    <button type="submit" class="btn btn-primary" name="input_kategori_validate" value="1">Save changes</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <!-- End Modal Add Kategori -->

            <?php
            if (empty($result)) {
                echo "<div class='alert alert-warning' role='alert'>Data Kategori Menu kosong!</div>";
            } else { ?>
                <!-- Start Modal Editing Kategori -->
                <?php foreach ($result as $row) { ?>
                    <div class="modal fade" id="modaleditkategori<?php echo $row['id_kategori'] ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-lg modal-fullscreen-md-down">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h1 class="modal-title fs-5" id="exampleModalLabel">Edit Kategori Menu</h1>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <form class="needs-validation" novalidate action="proses/proseseditkategori.php" method="POST">
                                        <input type="hidden" value="<?php echo $row['id_kategori'] ?>" name="id_kategori_menu">
                                        <div class="row">
                                            <div class="col-lg-6">
                                                <div class="form-floating mb-2">
                                                    <select class="form-select" aria-label="Default select example" id="" name="jenis_menu">
                                                        <?php
                                                        $data = array("Makanan", "Minuman", "Barang-Barang");
                                                        foreach ($data as $key => $value) {
                                                            if ($row['jenis_menu'] == $key + 1) {
                                                                echo "<option selected value=" . ($key + 1) . "> $value </option>";
                                                            } else {
                                                                echo "<option value=" . ($key + 1) . "> $value </option>";
                                                            }
                                                        } ?>
                                                    </select>
                                                    <label for="floatingInput">Jenis Menu</label>
                                                    <div class="invalid-feedback"> Masukkan Jenis Menu</div>
                                                </div>
                                            </div>
                                            <div class="col-lg-6">
                                                <div class="form-floating mb-2">
                                                    <input type="text" class="form-control" id="floatingInput" placeholder="kategori menu" name="kategori" value="<?php echo $row['kategori_menu'] ?>" required>
                                                    <label for="floatingPassword">Kategori Menu</label>
                                                    <div class="invalid-feedback"> Masukkan Kategori Menu</div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                            <button type="submit" class="btn btn-primary" name="input_kategori_validate" value="1">Save changes</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php } ?>
                <!-- End Modal Editing Kategori -->

                <!-- Start Modal Deleting Kategori -->
                <?php foreach ($result as $row) { ?>
                    <div class="modal fade" id="modaldeletekategori<?php echo $row['id_kategori'] ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-md modal-fullscreen-md-down">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h1 class="modal-title fs-5" id="exampleModalLabel">Deleting Kategori Menu</h1>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <form action="proses/prosesdeletekategori.php" method="POST">
                                        <input type="hidden" value="<?php echo $row['id_kategori'] ?>" name="id">
                                        <div class="col-lg-12">
                                            Apakah Anda ingin menghapus kategori menu <b><?php echo $row['kategori_menu'] ?></b>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button>
                                            <button type="submit" class="btn btn-primary" name="delete_kategori_validate" value="1">Confirm</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php } ?>
                <!-- End Modal Deleting Kategori -->

                <!-- table class hover -->
                <div class="table-responsive mt-2">
                    <table class="table table-hover" id="example">
                        <thead>
                            <tr>
                                <th scope="col">Nomor</th>
                                <th scope="col">Jenis Menu</th>
                                <th scope="col">Nama Kategori Menu</th>
                                <th scope="col">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $no = 1;
                            foreach ($result as $row) { ?>
                                <tr>
                                    <th scope="row"><?php echo $no++ ?></th>
                                    <td><?php
                                        if (isset($row['jenis_menu'])) {
                                            if ($row['jenis_menu'] == 1) {
                                                echo "Makanan";
                                            } else if ($row['jenis_menu'] == 2) {
                                                echo "Minuman";
                                            } else if ($row['jenis_menu'] == 3) {
                                                echo "Barang-Barang";
                                            } else {
                                                echo "Barang Tidak Tersedia";
                                            }
                                        } else {
                                            echo "Jenis Menu Tidak Ditemukan";
                                        } ?> </td>
                                    <td><?php echo $row['kategori_menu'] ?></td>
                                    <td class="d-flex">
                                        <button class="btn btn-warning btn-sm me-1" data-bs-toggle="modal" data-bs-target="#modaleditkategori<?php echo $row['id_kategori'] ?>"><i class="bi bi-pen"></i></button>
                                        <button class="btn btn-danger btn-sm me-1" data-bs-toggle="modal" data-bs-target="#modaldeletekategori<?php echo $row['id_kategori'] ?>"><i class="bi bi-trash"></i></button>
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
