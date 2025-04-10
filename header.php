<?php
include "proses/connect.php";
$query = mysqli_query($conn, "SELECT * FROM tb_user WHERE username='$_SESSION[username_kantinbiru]'");
$records = mysqli_fetch_array($query);
?>

<nav class="navbar navbar-expand navbar-dark bg-primary sticky-top">
    <div class="container-lg">
        <a class="navbar-brand" href="."><i class="bi bi-cup-hot"></i> Kantin Biru FTI <i class="bi bi-shop"></i></a>
        <div class="collapse navbar-collapse justify-content-end" id="navbarNavDropdown">
            <ul class="navbar-nav">
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false"> <?php echo $hasil['nama']; ?> </a>
                    <ul class="dropdown-menu dropdown-menu-end mt-2">
                        <li><a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#modalprofile"><i class="bi bi-person-circle"></i> Change Profile</a></li>
                        <li><a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#modalpassword"><i class="bi bi-key"></i> Change Password</a></li>
                        <li><a class="dropdown-item" href="logout"><i class="bi bi-power"></i> Logout</a></li>
                    </ul>
                </li>
            </ul>
        </div>
    </div>
</nav>

<!-- Start Modal Changing Password -->
<div class="modal fade" id="modalpassword" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-fullscreen-md-down">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalLabel">Change Password</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form class="needs-validation" novalidate action="proses/prosesubahpassword.php" method="POST">
                    <div class="row">
                        <div class="col-lg-6">
                            <div class="form-floating mb-2">
                                <input disabled type="email" class="form-control" id="floatingInput" placeholder="name@example.com" name="username" value="<?php echo $_SESSION['username_kantinbiru'] ?>">
                                <label for="floatingPassword">Username</label>
                                <div class="invalid-feedback"> Username Anda</div>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-floating mb-2">
                                <input type="password" class="form-control" id="floatingPassword" name="passwordlama" required>
                                <label for="floatingPassword">Old Password</label>
                                <div class="invalid-feedback"> Masukkan Password Lama</div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-6">
                            <div class="form-floating mb-2">
                                <input type="password" class="form-control" id="floatingPassword" name="passwordbaru" required>
                                <label for="floatingPassword">New Password</label>
                                <div class="invalid-feedback"> Masukkan Password Baru</div>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-floating mb-2">
                                <input type="password" class="form-control" id="floatingPassword" name="confirmpassword" required>
                                <label for="floatingPassword">Confirm Password</label>
                                <div class="invalid-feedback"> Konfirmasi Password Baru</div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary" name="ubah_password_validate" value="password">Save changes</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<!-- End Modal Changing Password -->

<!-- Start Modal Changing Profile User -->
<div class="modal fade" id="modalprofile" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-fullscreen-md-down">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalLabel">Change Profile Detail</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form class="needs-validation" novalidate action="proses/prosesubahprofile.php" method="POST">
                    <div class="row">
                        <div class="col-lg-4">
                            <div class="form-floating mb-2">
                                <input disabled type="email" class="form-control" id="floatingInput" placeholder="name@example.com" name="username" value="<?php echo $_SESSION['username_kantinbiru'] ?>">
                                <label for="floatingPassword">Username</label>
                                <div class="invalid-feedback"> Username Anda</div>
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="form-floating mb-2">
                                <input type="text" class="form-control" id="floatingNama" name="nama" required value="<?php echo $records['nama'] ?>">
                                <label for="floatingPassword">Nama</label>
                                <div class="invalid-feedback"> Masukkan Nama Anda</div>
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="form-floating mb-2">
                                <input type="number" class="form-control" id="floatingNumber" name="nim" required value="<?php echo $records['nim'] ?>">
                                <label for="floatingPassword">NIM</label>
                                <div class="invalid-feedback"> Masukkan NIM Anda</div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary" name="ubah_profile_validate" value="1">Save changes</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<!-- End Modal Changing Profile User -->
