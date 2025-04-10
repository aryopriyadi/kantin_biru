<?php
include "proses/connect.php";
$query = mysqli_query($conn, "SELECT * FROM tb_menu");
while ($row = mysqli_fetch_array($query)) {
    $result[] = $row;
}
?>

<div class="col-lg-10 mt-2 rounded">
    <?php
    if (empty($result)) {
        echo "<div class='alert alert-warning' role='alert'>Galeri Menu kosong!</div>";
    } else { ?>
        <!-- Carousel Start -->
        <div id="carouselExampleCaptions" class="carousel slide" data-bs-slide="carousel">
            <div class="carousel-indicators">
                <?php
                $slide = 0;
                $firstSlideButton = true;
                foreach ($result as $dataTombol) {
                    ($firstSlideButton) ? $aktif = "active" : $aktif = "";
                    $firstSlideButton = false;
                ?>
                    <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="<?php echo $slide ?>" class="<?php echo $aktif ?>" aria-current="true" aria-label="Slide <?php echo $slide + 1 ?>"></button>
                <?php $slide++;
                } ?>
            </div>
            <div class="carousel-inner rounded">
                <?php
                $firstSlide = true;
                foreach ($result as $data) {
                    ($firstSlide) ? $aktif = 'active' : $aktif = "";
                    $firstSlide = false;
                ?>
                    <div class="carousel-item <?php echo $aktif ?>">
                        <img src="assets/img/<?php echo $data['foto'] ?>" class="img-fluid object-fit-fill border rounded w-100" style="height:500px; width:1000px" alt="Carousel">
                        <div class="carousel-caption d-none d-md-block">
                            <h5><?php echo $data['nama_menu'] ?></h5>
                            <p><?php echo $data['deskripsi'] ?></p>
                        </div>
                    </div>
                <?php } ?>
            </div>
            <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Previous</span>
            </button>
            <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Next</span>
            </button>
        </div>
        <!-- Carousel End -->
    <?php } ?>

    <div class="card mt-4">
        <div class="card-body text-center">
            <h5 class="card-title">Selamat Datang di Kantin Biru FTI UKSW</h5>
            <p class="card-text">1 Korintus 16 : 14 = "Lakukan segala pekerjaanmu dalam Kasih!"</p>
            <a href="order" class="btn btn-primary"> Silahkan Order </a>
        </div>
    </div>
</div>