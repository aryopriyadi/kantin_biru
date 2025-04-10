<?php
include "proses/connect.php";
$query = mysqli_query($conn, "SELECT * FROM tb_menu");
while ($row = mysqli_fetch_array($query)) {
    $result[] = $row;
}

$query_chart = mysqli_query($conn, "SELECT tb_menu.nama_menu, tb_menu.id, SUM(tb_list_order.jumlah) AS total_jumlah FROM tb_menu LEFT JOIN tb_list_order ON tb_menu.id = tb_list_order.menu GROUP BY tb_menu.id ORDER BY tb_menu.id ASC");
?>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<div class="col-lg-10 mt-2 rounded">
    <?php
    if (empty($result)) {
        echo "<div class='alert alert-warning' role='alert'>Chart Penjualan kosong!</div>";
    } else {
        //$result_chart = array();
        while ($record_chart = mysqli_fetch_array($query_chart)) {
            $result_chart[] = $record_chart;
        }
        $array_menu = array_column($result_chart, 'nama_menu');
        $array_menu_quote = array_map(function ($menu) {
            return "'" . $menu . "'";
        }, $array_menu);
        $string_menu = implode(',', $array_menu_quote);
        // echo $string_menu."<br>";
        $array_jumlah_pesanan = array_column($result_chart, 'total_jumlah');
        $string_jumlah_pesanan = implode(',', $array_jumlah_pesanan);
        // echo $string_jumlah_pesanan;
    ?>
        <div class="card mt-4">
            <div class="card-body text-center">
                <div>
                    <canvas id="myChart"></canvas>
                </div>
                <script>
                    const ctx = document.getElementById('myChart');
                    new Chart(ctx, {
                        type: 'bar',
                        data: {
                            labels: [<?php echo $string_menu ?>],
                            datasets: [{
                                label: 'Chart Penjualan Kantin Biru',
                                data: [<?php echo $string_jumlah_pesanan ?>],
                                borderWidth: 1,
                                backgroundColor: [
                                    'rgba(255, 0, 0, 0.35)',
                                    'rgba(0, 0, 255, 0.35)',
                                    'rgba(255, 255, 0, 0.35)',
                                    'rgba(0, 255, 0, 0.35)',
                                    'rgba(255, 0, 255, 0.35)',
                                    'rgba(255, 123, 0, 0.35)'
                                ]
                            }]
                        },
                        options: {
                            scales: {
                                y: {
                                    beginAtZero: true
                                }
                            }
                        }
                    });
                </script>
            </div>
        </div>
    <?php } ?>
</div>