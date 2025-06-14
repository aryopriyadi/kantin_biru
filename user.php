<?php
include "proses/connect.php";
$query = mysqli_query($conn, "SELECT * FROM tb_user ORDER BY level ASC");
while ($record = mysqli_fetch_array($query)) {
    $result[] = $record;
}
?>

<div class="col-lg-10 mt-2 rounded">
    <div class="card">
        <div class="card-header">
            Halaman User
        </div>
        <div class="card-body">
            <div class="row mb-2">
                <div class="col d-flex justify-content-end">
                    <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modaladduser"><i class="bi bi-person-plus"></i></button>
                </div>
            </div>

            <!-- Start Modal Add User -->
            <div class="modal fade" id="modaladduser" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-xl modal-fullscreen-md-down">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h1 class="modal-title fs-5" id="exampleModalLabel">Add User</h1>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <form class="needs-validation" novalidate action="proses/prosesinputuser.php" method="POST">
                                <div class="row">
                                    <div class="col-lg-6">
                                        <div class="form-floating mb-2">
                                            <input type="text" class="form-control" id="floatingInput" placeholder="Your Name" name="nama" required>
                                            <label for="floatingInput">Nama</label>
                                            <div class="invalid-feedback"> Masukkan Nama Anda</div>
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="form-floating mb-2">
                                            <input type="email" class="form-control" id="floatingInput" placeholder="name@example.com" name="username" required>
                                            <label for="floatingPassword">Username</label>
                                            <div class="invalid-feedback"> Masukkan Username Anda</div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-4">
                                        <div class="form-floating mb-2">
                                            <select class="form-select" aria-label="Default select example" name="level" required>
                                                <option value="" hidden>Access Level</option>
                                                <option value="1">1 - Super Admin</option>
                                                <option value="2">2 - Bidang 3 SMF</option>
                                                <option value="3">3 - Fungsio Kantin</option>
                                                <option value="4">4 - Dapur</option>
                                            </select>
                                            <label for="floatingInput">Access Level</label>
                                            <div class="invalid-feedback"> Pilih Access Level</div>
                                        </div>
                                    </div>
                                    <div class="col-lg-8">
                                        <div class="form-floating mb-2">
                                            <input type="number" class="form-control" id="floatingInput" placeholder="Nomor Induk Mahasiswa" name="nim" required>
                                            <label for="floatingInput">NIM</label>
                                            <div class="invalid-feedback"> Masukkan NIM Anda</div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-12">
                                        <div class="form-floating mb-2">
                                            <input type="password" class="form-control" id="floatingPassword" placeholder="Password" name="password" required>
                                            <label for="floatingPassword">Password</label>
                                            <div class="invalid-feedback"> Masukkan Password Anda</div>
                                        </div>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                    <button type="submit" class="btn btn-primary" name="input_user_validate" value="password">Save changes</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <!-- End Modal Add User -->

            <!-- Start Modal View User -->
            <?php foreach ($result as $row) { ?>
                <div class="modal fade" id="modalviewuser<?php echo $row['id'] ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-xl modal-fullscreen-md-down">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h1 class="modal-title fs-5" id="exampleModalLabel">User Details</h1>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <form class="needs-validation" novalidate action="proses/prosesinputuser.php" method="POST">
                                    <div class="row">
                                        <div class="col-lg-6">
                                            <div class="form-floating mb-2">
                                                <input type="text" class="form-control" id="floatingInput" placeholder="Your Name" name="nama" value="<?php echo $row['nama'] ?>" disabled>
                                                <label for="floatingInput">Nama</label>
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="form-floating mb-2">
                                                <input type="email" class="form-control" id="floatingInput" placeholder="name@example.com" name="username" value="<?php echo $row['username'] ?>" disabled>
                                                <label for="floatingPassword">Username</label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-lg-6">
                                            <div class="form-floating mb-2">
                                                <select disabled class="form-select" aria-label="Default select example" id="" name="level">
                                                    <?php
                                                    $data = array("Super Admin", "Cashier", "Waiter", "Kitchen");
                                                    foreach ($data as $key => $value) {
                                                        if ($row['level'] == $key + 1) {
                                                            echo "<option selected value='$key'> $value </option>";
                                                        } else {
                                                            echo "<option value='$key'> $value </option>";
                                                        }
                                                    } ?>
                                                </select>
                                                <label for="floatingPassword">Access Level</label>
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="form-floating mb-2">
                                                <input type="number" class="form-control" id="floatingInput" placeholder="Nomor Induk Mahasiswa" name="nim" value="<?php echo $row['nim'] ?>" disabled>
                                                <label for="floatingInput">NIM</label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-lg-12">
                                            <div class="form-floating mb-2">
                                                <input type="text" class="form-control" id="floatingPassword" placeholder="Password" name="password" value="<?php echo $row['password'] ?>" disabled>
                                                <label for="floatingPassword">Password</label>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            <?php } ?>
            <!-- End Modal View User -->

            <!-- Start Modal Editing User -->
            <?php foreach ($result as $row) { ?>
                <div class="modal fade" id="modaledit<?php echo $row['id'] ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-xl modal-fullscreen-md-down">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h1 class="modal-title fs-5" id="exampleModalLabel">Edit Data User</h1>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <form class="needs-validation" novalidate action="proses/prosesedituser.php" method="POST">
                                    <input type="hidden" value="<?php echo $row['id'] ?>" name="id">
                                    <div class="row">
                                        <div class="col-lg-6">
                                            <div class="form-floating mb-2">
                                                <input type="text" class="form-control" id="floatingInput" placeholder="Your Name" name="nama" value="<?php echo $row['nama'] ?>" required>
                                                <label for="floatingInput">Nama</label>
                                                <div class="invalid-feedback"> Masukkan Nama Anda</div>
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="form-floating mb-2">
                                                <input <?php echo ($row['username'] == $_SESSION['username_kantinbiru']) ? 'disabled' : ''; ?>
                                                    type="email" class="form-control" id="floatingInput" placeholder="name@example.com" name="username" value="<?php echo $row['username'] ?>" required>
                                                <label for="floatingPassword">Username</label>
                                                <div class="invalid-feedback"> Masukkan Username Anda</div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-lg-6">
                                            <div class="form-floating mb-2">
                                                <select class="form-select" aria-label="Default select example" id="" name="level" required>
                                                    <?php
                                                    $data = array("Super Admin", "Bidang 3 SMF", "Fungsio Kantin", "Dapur");
                                                    foreach ($data as $key => $value) {
                                                        if ($row['level'] == $key + 1) {
                                                            echo "<option selected value=" . ($key + 1) . "> $value </option>";
                                                        } else {
                                                            echo "<option value=" . ($key + 1) . "> $value </option>";
                                                        }
                                                    } ?>
                                                </select>
                                                <label for="floatingPassword">Access Level</label>
                                                <div class="invalid-feedback">Pilih Access Level</div>
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="form-floating mb-2">
                                                <input type="number" class="form-control" id="floatingInput" placeholder="Nomor Induk Mahasiswa" name="nim" value="<?php echo $row['nim'] ?>" required>
                                                <label for="floatingInput">NIM</label>
                                                <div class="invalid-feedback"> Masukkan NIM Anda</div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-lg-12">
                                            <div class="form-floating mb-2">
                                                <input type="text" class="form-control" id="floatingPassword" placeholder="Password" name="password" value="<?php echo $row['password'] ?>" required>
                                                <label for="floatingPassword">Password</label>
                                                <div class="invalid-feedback"> Masukkan Password Anda</div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                        <button type="submit" class="btn btn-primary" name="input_user_validate" value="password" <?php echo ($row['username'] == $_SESSION['username_kantinbiru']) ? 'disabled' : ''; ?> >Save changes</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            <?php } ?>
            <!-- End Modal Editing User -->

            <!-- Start Modal Deleting User -->
            <?php foreach ($result as $row) { ?>
                <div class="modal fade" id="modaldelete<?php echo $row['id'] ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-md modal-fullscreen-md-down">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h1 class="modal-title fs-5" id="exampleModalLabel">Deleting User</h1>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <form action="proses/prosesdeleteuser.php" method="POST">
                                    <input type="hidden" value="<?php echo $row['id'] ?>" name="id">
                                    <div class="col-lg-12">
                                        <?php
                                        if ($row['username'] == $_SESSION['username_kantinbiru']) {
                                            echo "<div class='alert alert-danger'> Anda tidak dapat menghapus akun sendiri</div>";
                                        } else {
                                            echo "Apakah Anda Yakin Akan Menghapus User <b>$row[username]</b>";
                                        } ?>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button>
                                        <button type="submit" class="btn btn-primary" name="delete_user_validate" <?php echo ($row['username'] == $_SESSION['username_kantinbiru']) ? 'disabled' : ''; ?> value="1" >Confirm</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            <?php } ?>
            <!-- End Modal Deleting User -->

            <!-- Start Modal Resetting Password -->
            <?php foreach ($result as $row) { ?>
                <div class="modal fade" id="modalresetpassword<?php echo $row['id'] ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-md modal-fullscreen-md-down">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h1 class="modal-title fs-5" id="exampleModalLabel">Reset Password</h1>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <form action="proses/prosesresetpassword.php" method="POST">
                                    <input type="hidden" value="<?php echo $row['id'] ?>" name="id">
                                    <div class="col-lg-12">
                                        <?php
                                        if ($row['username'] == $_SESSION['username_kantinbiru']) {
                                            echo "<div class='alert alert-danger'> Anda tidak dapat mereset password anda sendiri</div>";
                                        } else {
                                            echo "Apakah Anda Yakin Akan Mereset Password User <b>$row[username]</b>
                                            menjadi password bawaan yaitu <b>password</b>??";
                                        } ?>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button>
                                        <button type="submit" class="btn btn-primary" name="reset_user_validate" <?php echo ($row['username'] == $_SESSION['username_kantinbiru']) ? 'disabled' : ''; ?> value="1" >Confirm</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            <?php } ?>
            <!-- End Modal Resetting Password -->

            <?php
            if (empty($result)) {
                echo "<div class='alert alert-warning' role='alert'>Data User kosong!</div>";
            } else { ?>
                <!-- table class hover -->
                <div class="table-responsive mt-2">
                    <table class="table table-hover" id="example">
                        <thead>
                            <tr>
                                <th scope="col">No</th>
                                <th scope="col">Nama</th>
                                <th scope="col">Username</th>
                                <th scope="col">Level</th>
                                <th scope="col">NIM</th>
                                <!-- <th scope="col">Password</th> -->
                                <th scope="col">Action</th>
                            </tr>
                        </thead>
                        <tbody>

                            <?php
                            $no = 1;
                            foreach ($result as $row) { ?>
                                <tr>
                                    <th scope="row"><?php echo $no++ ?></th>
                                    <td><?php echo $row['nama'] ?></td>
                                    <td><?php echo $row['username'] ?></td>
                                    <td><?php
                                        if ($row['level'] == 1) {
                                            echo "Super Admin";
                                        } else if ($row['level'] == 2) {
                                            echo "Bidang 3 SMF";
                                        } else if ($row['level'] == 3) {
                                            echo "Fungsio Kantin";
                                        } else if ($row['level'] == 4) {
                                            echo "Kitchen (Dapur)";
                                        } else {
                                            echo "Tidak ada access level";
                                        }
                                        ?></td>
                                    <td><?php echo $row['nim'] ?></td>
                                    <!-- <td><?php echo $row['password'] ?></td> -->
                                    <td class="d-flex">
                                        <button class="btn btn-success btn-sm me-1" data-bs-toggle="modal" data-bs-target="#modalviewuser<?php echo $row['id'] ?>"><i class="bi bi-info-circle"></i></button>
                                        <button class="btn btn-warning btn-sm me-1" data-bs-toggle="modal" data-bs-target="#modaledit<?php echo $row['id'] ?>"><i class="bi bi-pen"></i></button>
                                        <button class="btn btn-danger btn-sm me-1" data-bs-toggle="modal" data-bs-target="#modaldelete<?php echo $row['id'] ?>"><i class="bi bi-trash"></i></button>
                                        <button class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#modalresetpassword<?php echo $row['id'] ?>"><i class="bi bi-key-fill"></i></button>
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