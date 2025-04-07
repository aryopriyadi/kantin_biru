<?php
// use LDAP\Result;
include "proses/connect.php";
// $query = mysqli_query($conn, "SELECT * FROM tb_menu LEFT JOIN tb_kategori_menu ON tb_kategori_menu.id = tb_menu.kategori");
// $query = mysqli_query($conn, "SELECT tb_menu.*, tb_kategori_menu.kategori_menu FROM tb_menu LEFT JOIN tb_kategori_menu ON tb_kategori_menu.id = tb_menu.kategori GROUP BY tb_menu.id");
// $query = mysqli_query($conn, "SELECT tb_menu.*, tb_kategori_menu.* FROM tb_menu LEFT JOIN tb_kategori_menu ON tb_kategori_menu.id = tb_menu.kategori");
$query = mysqli_query($conn, "SELECT tb_menu.id, tb_menu.nama_menu, tb_menu.foto, tb_menu.harga, tb_menu.stock, tb_menu.deskripsi, tb_menu.kategori, tb_kategori_menu.kategori_menu, tb_kategori_menu.jenis_menu FROM tb_menu LEFT JOIN tb_kategori_menu ON tb_kategori_menu.id_kategori = tb_menu.kategori ORDER BY tb_menu.nama_menu ASC");
while ($record = mysqli_fetch_array($query)) {
    $result[] = $record;
}
$kategori_menu = mysqli_query($conn, "SELECT id_kategori, kategori_menu FROM tb_kategori_menu");
?>

<div class="col-lg-10 mt-2 rounded">
    <div class="card">
        <div class="card-header">
            Halaman Menu Makanan & Minuman
        </div>
        <div class="card-body">
            <div class="row mb-2">
                <div class="col d-flex justify-content-end">
                    <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modaladdmenu"><i class="bi bi-patch-plus"></i></button>
                </div>
            </div>

            <!-- Start Modal Add New Menu -->
            <div class="modal fade" id="modaladdmenu" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-xl modal-fullscreen-md-down">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h1 class="modal-title fs-5" id="exampleModalLabel">Add Menu</h1>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <form class="needs-validation" novalidate action="proses/prosesinputmenu.php" method="POST" enctype="multipart/form-data">
                                <div class="row">
                                    <div class="col-lg-6">
                                        <div class="input-group mb-2">
                                            <input type="file" class="form-control py-3" id="inputFile" placeholder="Images" name="foto" required>
                                            <label class="input-group-text">Upload Foto Menu</label>
                                            <div class="invalid-feedback" for="inputFile"> Masukkan Foto Menu</div>
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="form-floating mb-2">
                                            <input type="text" class="form-control" id="floatingInput" placeholder="Nama Menu" name="nama_menu" required>
                                            <label for="floatingPassword">Nama Menu</label>
                                            <div class="invalid-feedback"> Masukkan Nama Menu</div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-4">
                                        <div class="form-floating mb-2">
                                            <select class="form-select" aria-label="Default select example" name="kategori_menu" required>
                                                <option value="" selected hidden>Kategori Menu</option>
                                                <?php foreach ($kategori_menu as $value) {
                                                    echo "<option value=" . $value['id_kategori'] . ">$value[kategori_menu]</option>";
                                                } ?>
                                            </select>
                                            <label for="floatingInput">Kategori Menu</label>
                                            <div class="invalid-feedback"> Pilih Kategori Menu</div>
                                        </div>
                                    </div>
                                    <div class="col-lg-4">
                                        <div class="form-floating mb-2">
                                            <input type="number" class="form-control" id="floatingInput" placeholder="Harga Rupiah" name="harga" required>
                                            <label for="floatingInput">Harga Menu</label>
                                            <div class="invalid-feedback"> Masukkan Harga Menu (Rupiah)</div>
                                        </div>
                                    </div>
                                    <div class="col-lg-4">
                                        <div class="form-floating mb-2">
                                            <input type="number" class="form-control" id="floatingInput" placeholder="Jumlah Stock" name="stock" required>
                                            <label for="floatingInput">Stock</label>
                                            <div class="invalid-feedback"> Masukkan Jumlah Stock Menu</div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-12">
                                        <div class="form-floating mb-2">
                                            <input type="text" class="form-control" id="floatingInput" placeholder="Deskripsi" name="deskripsi">
                                            <label for="floatingInput">Deskripsi Menu</label>
                                            <div class="invalid-feedback"> Masukkan Deskripsi Menu Anda</div>
                                        </div>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                    <button type="submit" class="btn btn-primary" name="input_menu_validate" value="1">Upload changes</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <!-- End Modal Add New Menu -->

            <!-- Start Modal View Detail Menu -->
            <?php
            if (empty($result)) {
                echo "<div class='alert alert-warning' role='alert'>Data Menu Kantin kosong!</div>";
            } else {
                foreach ($result as $row) { ?>
                    <div class="modal fade" id="modalviewmenu<?php echo $row['id'] ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-xl modal-fullscreen-md-down">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h1 class="modal-title fs-5" id="exampleModalLabel">View Detail Menu</h1>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <form class="needs-validation" method="POST" enctype="multipart/form-data">
                                        <div class="row">
                                            <div class="col-lg-4">
                                                <div class="input-group mb-2">
                                                    <img src="assets/img/<?php echo $row['foto'] ?>" class="img-thumbnail" alt="Foto Menu">
                                                </div>
                                            </div>
                                            <div class="col-lg-8">
                                                <div class="row-lg-2 form-floating mb-2">
                                                    <input type="text" class="form-control" id="floatingInput" value="<?php echo $row['nama_menu'] ?>" disabled>
                                                    <label for="floatingPassword">Nama Menu</label>
                                                </div>
                                                <div class="row-lg-2 form-floating mb-2">
                                                    <select class="form-select" aria-label="Default select example" disabled>
                                                        <option value="" selected hidden>Kategori Menu</option>
                                                        <?php foreach ($kategori_menu as $value) {
                                                            if ($row['kategori'] == $value['id_kategori']) {
                                                                echo "<option selected value=" . $value['id_kategori'] . ">$value[kategori_menu]</option>";
                                                            } else {
                                                                echo "<option value=" . $value['id_kategori'] . ">$value[kategori_menu]</option>";
                                                            }
                                                        } ?>
                                                    </select>
                                                    <label for="floatingInput">Kategori Menu</label>
                                                </div>
                                                <div class="row-lg-2 form-floating mb-2">
                                                    <input type="number" class="form-control" id="floatingInput" value="<?php echo number_format((int)$row['harga'], 0, ',', '.') ?>" disabled>
                                                    <label for="floatingInput">Harga Menu</label>
                                                </div>
                                                <div class="row-lg-2 form-floating mb-2">
                                                    <input type="number" class="form-control" id="floatingInput" value="<?php echo $row['stock'] ?>" disabled>
                                                    <label for="floatingInput">Stock</label>
                                                </div>
                                                <div class="row-lg-2 form-floating mb-2">
                                                    <input type="text" class="form-control" id="floatingInput" value="<?php echo $row['deskripsi'] ?>" disabled>
                                                    <label for="floatingInput">Deskripsi Menu</label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php } ?>
                <!-- End Modal View Detail Menu -->

                <!-- Start Modal Editing Menu -->
                <?php foreach ($result as $row) { ?>
                    <div class="modal fade" id="modaleditmenu<?php echo $row['id'] ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-xl modal-fullscreen-md-down">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h1 class="modal-title fs-5" id="exampleModalLabel">Editing Menu</h1>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <form class="needs-validation" novalidate action="proses/proseseditmenu.php" method="POST" enctype="multipart/form-data">
                                        <input type="hidden" name="id" value="<?php echo $row['id'] ?>">
                                        <input type="hidden" name="current_foto" value="<?php echo $row['foto'] ?>">
                                        <div class="row">
                                            <div class="col-lg-6">
                                                <div class="input-group mb-2">
                                                    <input type="file" class="form-control py-3" id="inputFile" placeholder="Images" name="foto">
                                                    <label class="input-group-text">Upload Foto Menu (Opsional) </label>
                                                    <div class="invalid-feedback" for="inputFile"> Masukkan foto menu baru</div>
                                                </div>
                                            </div>
                                            <div class="col-lg-6">
                                                <div class="form-floating mb-2">
                                                    <input type="text" class="form-control" id="floatingInput" placeholder="Nama Menu" name="nama_menu" required value="<?php echo $row['nama_menu'] ?>">
                                                    <label for="floatingPassword">Nama Menu</label>
                                                    <div class="invalid-feedback"> Masukkan Nama Menu</div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-lg-4">
                                                <div class="form-floating mb-2">
                                                    <select class="form-select" aria-label="Default select example" name="kategori_menu" required>
                                                        <option value="" selected hidden>Kategori Menu</option>
                                                        <?php foreach ($kategori_menu as $value) {
                                                            if ($row['kategori'] == $value['id_kategori']) {
                                                                echo "<option selected value=" . $value['id_kategori'] . ">$value[kategori_menu]</option>";
                                                            } else {
                                                                echo "<option value=" . $value['id_kategori'] . ">$value[kategori_menu]</option>";
                                                            }
                                                        } ?>
                                                    </select>
                                                    <label for="floatingInput">Kategori Menu</label>
                                                    <div class="invalid-feedback"> Pilih Kategori Menu</div>
                                                </div>
                                            </div>
                                            <div class="col-lg-4">
                                                <div class="form-floating mb-2">
                                                    <input type="number" class="form-control" id="floatingInput" placeholder="Harga Rupiah" name="harga" required value="<?php echo $row['harga'] ?>">
                                                    <label for="floatingInput">Harga Menu</label>
                                                    <div class="invalid-feedback"> Masukkan Harga Menu (Rupiah)</div>
                                                </div>
                                            </div>
                                            <div class="col-lg-4">
                                                <div class="form-floating mb-2">
                                                    <input type="number" class="form-control" id="floatingInput" placeholder="Jumlah Stock" name="stock" required value="<?php echo $row['stock'] ?>">
                                                    <label for="floatingInput">Stock</label>
                                                    <div class="invalid-feedback"> Masukkan Jumlah Stock Menu</div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-lg-12">
                                                <div class="form-floating mb-2">
                                                    <input type="text" class="form-control" id="floatingInput" placeholder="Deskripsi" name="deskripsi" value="<?php echo $row['deskripsi'] ?>">
                                                    <label for="floatingInput">Deskripsi Menu</label>
                                                    <div class="invalid-feedback"> Masukkan Deskripsi Menu Anda</div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                            <button type="submit" class="btn btn-primary" name="edit_menu_validate" value="1">Upload changes</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php } ?>
                <!-- End Modal Editing Menu -->

                <!-- Start Modal Deleting Menu -->
                <?php foreach ($result as $row) { ?>
                    <div class="modal fade" id="modaldeletemenu<?php echo $row['id'] ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-md modal-fullscreen-md-down">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h1 class="modal-title fs-5" id="exampleModalLabel">Deleting User</h1>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <form action="proses/prosesdeletemenu.php" method="POST">
                                        <input type="hidden" value="<?php echo $row['id'] ?>" name="id">
                                        <input type="hidden" value="<?php echo $row['foto'] ?>" name="foto">
                                        <div class="col-lg-12">
                                            Apakah anda ingin menghapus menu <b><?php echo $row['nama_menu'] ?>??</b>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button>
                                            <button type="submit" class="btn btn-primary" name="delete_menu_validate" value="1">Confirm</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php } ?>
                <!-- End Modal Deleting Menu -->

                <!-- table class hover -->
                <div class="table-responsive mt-2">
                    <table class="table table-hover" id="example">
                        <thead>
                            <tr class="text-nowrap">
                                <th scope="col">No</th>
                                <th scope="col">Foto</th>
                                <th scope="col">Nama Menu</th>
                                <th scope="col">Deskripsi</th>
                                <!-- <th scope="col">Jenis Menu</th> -->
                                <th scope="col">Kategori</th>
                                <th scope="col">Harga</th>
                                <!-- <th scope="col">Stock</th> -->
                                <th scope="col">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $no = 1;
                            foreach ($result as $row) { ?>
                                <tr>
                                    <th scope="row"><?php echo $no++ ?></th>
                                    <td>
                                        <div style="width: 80px;"><img src="assets/img/<?php echo $row['foto'] ?>" class="img-thumbnail" alt="images"></div>
                                    </td>
                                    <td><?php echo $row['nama_menu'] ?></td>
                                    <td><?php echo $row['deskripsi'] ?></td>
                                    <!-- <td><?php echo ($row['jenis_menu'] == 1) ? "Makanan" : "Minuman" ?></td> -->
                                    <!-- <td><?php if ($row['jenis_menu'] == 1) {
                                                    echo "Makanan";
                                                } else if ($row['jenis_menu'] == 2) {
                                                    echo "Minuman";
                                                } else if ($row['jenis_menu'] == 3) {
                                                    echo "Barang-Barang";
                                                } else {
                                                    echo "Barang Tidak Tersedia";
                                                } ?></td> -->
                                    <!-- <td><?php
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
                                                } ?> </td> -->
                                    <td><?php echo $row['kategori_menu'] ?></td>
                                    <td><?php echo number_format((int)$row['harga'], 0, ',', '.')  ?></td>
                                    <!-- <td><?php echo $row['stock'] ?></td> -->
                                    <td>
                                        <div class="d-flex">
                                            <button class="btn btn-success btn-sm me-1" data-bs-toggle="modal" data-bs-target="#modalviewmenu<?php echo $row['id'] ?>"><i class="bi bi-info-circle"></i></button>
                                            <button class="btn btn-warning btn-sm me-1" data-bs-toggle="modal" data-bs-target="#modaleditmenu<?php echo $row['id'] ?>"><i class="bi bi-pen"></i></button>
                                            <button class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#modaldeletemenu<?php echo $row['id'] ?>"><i class="bi bi-trash"></i></button>
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
