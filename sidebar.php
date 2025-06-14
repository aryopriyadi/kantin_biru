<div class="col-lg-2">
    <nav class="navbar navbar-expand-lg rounded border mt-2">
        <div class="container-fluid">
            <button class="navbar-toggler" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasNavbar" aria-controls="offcanvasNavbar" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="offcanvas offcanvas-start" tabindex="-1" id="offcanvasNavbar" aria-labelledby="offcanvasNavbarLabel" style="width:fit-content">
                <div class="offcanvas-header">
                    <h5 class="offcanvas-title" id="offcanvasNavbarLabel">Side Bar Menu</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
                </div>
                <div class="offcanvas-body">
                    <ul class="navbar-nav nav-pills flex-column justify-content-end flex-grow-1">
                        <li class="nav-item">
                            <a class="nav-link ps-2 <?php echo ((isset($_GET['x']) && $_GET['x'] == 'home') || !isset($_GET['x'])) ? 'active link-light' : 'link-dark'; ?>" aria-current="page" href="home"><i class="bi bi-house-door"></i> Homepage</a>
                        </li>
                        <?php if ($hasil['level'] == 1 || $hasil['level'] == 2 || $hasil['level'] == 4) { ?>
                            <li class="nav-item">
                                <a class="nav-link ps-2 <?php echo (isset($_GET['x']) && $_GET['x'] == 'dapur') ? 'active link-light' : 'link-dark'; ?>" href="dapur"><i class="bi bi-fire"></i> Dapur</a>
                            </li>
                        <?php } ?>

                        <?php if ($hasil['level'] == 1 || $hasil['level'] == 2 || $hasil['level'] == 3) { ?>
                            <li class="nav-item">
                                <a class="nav-link ps-2 <?php echo (isset($_GET['x']) && $_GET['x'] == 'order') ? 'active link-light' : 'link-dark'; ?>" href="order"><i class="bi bi-card-checklist"></i> Order</a>
                            </li>
                        <?php } ?>

                        <?php if ($hasil['level'] == 1 || $hasil['level'] == 2) { ?>
                            <li class="nav-item">
                                <a class="nav-link ps-2 <?php echo (isset($_GET['x']) && $_GET['x'] == 'menu') ? 'active link-light' : 'link-dark'; ?>" href="menu"><i class="bi bi-cart3"></i> Daftar Menu</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link ps-2 <?php echo (isset($_GET['x']) && $_GET['x'] == 'kategori') ? 'active link-light' : 'link-dark'; ?>" href="kategori"><i class="bi bi-tags"></i> Kategori Menu</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link ps-2 <?php echo (isset($_GET['x']) && $_GET['x'] == 'cash') ? 'active link-light' : 'link-dark'; ?>" href="cash"><i class="bi bi-cash-coin"></i> Cash History</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link ps-2 <?php echo (isset($_GET['x']) && $_GET['x'] == 'qris') ? 'active link-light' : 'link-dark'; ?>" href="qris"><i class="bi bi-qr-code"></i> QRIS History</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link ps-2 <?php echo (isset($_GET['x']) && $_GET['x'] == 'report') ? 'active link-light' : 'link-dark'; ?>" href="report"><i class="bi bi-coin"></i> Order History</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link ps-2 <?php echo (isset($_GET['x']) && $_GET['x'] == 'charts') ? 'active link-light' : 'link-dark'; ?>" href="charts"><i class="bi bi-graph-up-arrow"></i> Sales Chart</a>
                            </li>
                        <?php } ?>

                        <?php if ($hasil['level'] == 1) { ?>
                            <li class="nav-item">
                                <a class="nav-link ps-2 <?php echo (isset($_GET['x']) && $_GET['x'] == 'user') ? 'active link-light' : 'link-dark'; ?>" href="user"><i class="bi bi-people"></i> User</a>
                            </li>
                        <?php } ?>
                    </ul>
                </div>
            </div>
        </div>
    </nav>
</div>