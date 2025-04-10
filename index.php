<?php
session_start();
if (isset($_GET['x']) && $_GET['x'] == 'home') {
    $page = "home.php";
    include "main.php";
} else if (isset($_GET['x']) && $_GET['x'] == 'menu') {
    $page = "menu.php";
    include "main.php";
} else if (isset($_GET['x']) && $_GET['x'] == 'kategori') {
    $page = "kategori.php";
    include "main.php";
} else if (isset($_GET['x']) && $_GET['x'] == 'order') {
    $page = "order.php";
    include "main.php";
} else if (isset($_GET['x']) && $_GET['x'] == 'dapur') {
    $page = "dapur.php";
    include "main.php";
} else if (isset($_GET['x']) && $_GET['x'] == 'orderitem') {
    $page = "orderitem.php";
    include "main.php";
} else if (isset($_GET['x']) && $_GET['x'] == 'user') {
    if ($_SESSION['level_kantinbiru'] == 1) {
        $page = "user.php";
        include "main.php";
    } else {
        $page = "home.php";
        include "main.php";
    }
} else if (isset($_GET['x']) && $_GET['x'] == 'report') {
    if ($_SESSION['level_kantinbiru'] == 1) {
        $page = "report.php";
        include "main.php";
    } else {
        $page = "home.php";
        include "main.php";
    }
} else if (isset($_GET['x']) && $_GET['x'] == 'viewitem') {
    if ($_SESSION['level_kantinbiru'] == 1) {
        $page = "viewitem.php";
        include "main.php";
    } else {
        $page = "home.php";
        include "main.php";
    }
} else if (isset($_GET['x']) && $_GET['x'] == 'charts') {
    if ($_SESSION['level_kantinbiru'] == 1) {
        $page = "charts.php";
        include "main.php";
    } else {
        $page = "home.php";
        include "main.php";
    }
} else if (isset($_GET['x']) && $_GET['x'] == 'login') {
    include "login.php";
} else if (isset($_GET['x']) && $_GET['x'] == 'logout') {
    include "proses/proseslogout.php";
} else {
    $page = "home.php";
    include "main.php";
}
