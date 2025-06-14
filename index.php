<?php
session_start();
if (isset($_GET['x']) && $_GET['x'] == 'home') {
    $page = "home.php";
    include "main.php";
} else if (isset($_GET['x']) && $_GET['x'] == 'menu') {
    if ($_SESSION['level_kantinbiru'] == 1 || $_SESSION['level_kantinbiru'] == 2) {
        $page = "menu.php";
        include "main.php";
    } else {
        $page = "home.php";
        include "main.php";
    }
} else if (isset($_GET['x']) && $_GET['x'] == 'kategori') {
    if ($_SESSION['level_kantinbiru'] == 1 || $_SESSION['level_kantinbiru'] == 2) {
        $page = "kategori.php";
        include "main.php";
    } else {
        $page = "home.php";
        include "main.php";
    }
} else if (isset($_GET['x']) && $_GET['x'] == 'order') {
    if ($_SESSION['level_kantinbiru'] == 1 || $_SESSION['level_kantinbiru'] == 2 || $_SESSION['level_kantinbiru'] == 3) {
        $page = "order.php";
        include "main.php";
    } else {
        $page = "home.php";
        include "main.php";
    }
} else if (isset($_GET['x']) && $_GET['x'] == 'dapur') {
    if ($_SESSION['level_kantinbiru'] == 1 || $_SESSION['level_kantinbiru'] == 2 || $_SESSION['level_kantinbiru'] == 4) {
        $page = "dapur.php";
        include "main.php";
    } else {
        $page = "home.php";
        include "main.php";
    }
} else if (isset($_GET['x']) && $_GET['x'] == 'orderitem') {
    if ($_SESSION['level_kantinbiru'] == 1 || $_SESSION['level_kantinbiru'] == 2 || $_SESSION['level_kantinbiru'] == 3) {
        $page = "orderitem.php";
        include "main.php";
    } else {
        $page = "home.php";
        include "main.php";
    }
} else if (isset($_GET['x']) && $_GET['x'] == 'user') {
    if ($_SESSION['level_kantinbiru'] == 1) {
        $page = "user.php";
        include "main.php";
    } else {
        $page = "home.php";
        include "main.php";
    }
} else if (isset($_GET['x']) && $_GET['x'] == 'report') {
    if ($_SESSION['level_kantinbiru'] == 1 || $_SESSION['level_kantinbiru'] == 2) {
        $page = "report.php";
        include "main.php";
    } else {
        $page = "home.php";
        include "main.php";
    }
} else if (isset($_GET['x']) && $_GET['x'] == 'viewitem') {
    if ($_SESSION['level_kantinbiru'] == 1 || $_SESSION['level_kantinbiru'] == 2) {
        $page = "viewitem.php";
        include "main.php";
    } else {
        $page = "home.php";
        include "main.php";
    }
} else if (isset($_GET['x']) && $_GET['x'] == 'charts') {
    if ($_SESSION['level_kantinbiru'] == 1 || $_SESSION['level_kantinbiru'] == 2) {
        $page = "charts.php";
        include "main.php";
    } else {
        $page = "home.php";
        include "main.php";
    }
} else if (isset($_GET['x']) && $_GET['x'] == 'cash') {
    if ($_SESSION['level_kantinbiru'] == 1 || $_SESSION['level_kantinbiru'] == 2) {
        $page = "cash.php";
        include "main.php";
    } else {
        $page = "home.php";
        include "main.php";
    }
} else if (isset($_GET['x']) && $_GET['x'] == 'qris') {
    if ($_SESSION['level_kantinbiru'] == 1 || $_SESSION['level_kantinbiru'] == 2) {
        $page = "qris.php";
        include "main.php";
    } else {
        $page = "home.php";
        include "main.php";
    }
}else if (isset($_GET['x']) && $_GET['x'] == 'login') {
    include "login.php";
} else if (isset($_GET['x']) && $_GET['x'] == 'logout') {
    include "proses/proseslogout.php";
} else {
    $page = "home.php";
    include "main.php";
}
