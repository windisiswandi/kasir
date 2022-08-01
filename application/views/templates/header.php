<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title><?= $title; ?></title>

    <!-- Custom fonts for this template-->
    <script src="<?= base_url('assets/'); ?>vendor/jquery/jquery.min.js"></script>
    <link href="<?= base_url('assets/vendor/fontawesome-free/css/all.min.css'); ?>" rel="stylesheet" type="text/css">
    <link href="<?= base_url('assets/'); ?>vendor/datatables/dataTables.bootstrap4.min.css" rel="stylesheet">
    <script src="<?= base_url('assets/js/autoNumeric.min.js') ?>"></script>
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">

    <link href="<?= base_url('assets/'); ?>css/sb-admin-2.min.css" rel="stylesheet">

    <!-- Custom styles for this template-->
    <link href="<?= base_url('assets/'); ?>css/mycss.css" rel="stylesheet">
    
    <!-- Sweetalert2 -->
    <link href="<?= base_url('assets/'); ?>vendor/sweetalert2/dist/sweetalert2.min.css" rel="stylesheet">
    <script src="<?= base_url('assets/'); ?>vendor/sweetalert2/dist/sweetalert2.min.js"></script>

</head>

<body id="page-top">

    <!-- Page Wrapper -->
    <div id="wrapper">

        <!-- Sidebar -->
        <ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

            <!-- Sidebar - Brand -->
            <a class="sidebar-brand d-flex align-items-center justify-content-center" href="index.html">
                <div class="sidebar-brand-icon rotate-n-15">
                    <i class="fas fa-laugh-wink"></i>
                </div>
                <div class="sidebar-brand-text mx-3">LP Admin</div>
            </a>

            <!-- Divider -->
            <hr class="sidebar-divider">
            <!-- Heading -->
            <div class="sidebar-heading">
                <?= $dataUser["username"]; ?>
            </div>
            <!-- Nav Item - Dashboard -->
            <li class="nav-item active" >
                <a class="nav-link" href="<?= base_url(); ?>" style="padding:16px 15px 5px 15px;">
                    <i class="fas fa-fw fa-tachometer-alt"></i>
                    <span>Dashboard</span></a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="<?= base_url("Dashboard/produks"); ?>" style="padding:10px 15px 10px 15px;">
                    <i class="fas fa-fw fa-tachometer-alt"></i>
                    <span>Produks</span></a>
                <a class="nav-link" href="<?= base_url("Dashboard/kategori_produk"); ?>" style="padding:10px 15px 10px 15px;">
                    <i class="fas fa-fw fa-tachometer-alt"></i>
                    <span>Kategori Produk</span></a>
            </li>

            <!-- Nav Item - Pages Collapse Menu -->

            <!-- Divider -->
            <hr class="sidebar-divider">

            <!-- Heading -->
     
            <div class="sidebar-heading">
                Laporan Penjualan
            </div>

            <!-- Nav Item - Pages Collapse Menu -->
            <li class="nav-item">
                <a class="nav-link" href="<?= base_url('Dashboard/laporan_harian') ?>" style="padding:16px 15px 5px 15px;">
                    <i class="fas fa-table"></i>
                    <span>Laporan Harian</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="<?= base_url('Dashboard/laporan_bulanan') ?>" style="padding:10px 15px 5px 15px;">
                    <i class="fas fa-table"></i>
                    <span>Laporan Bulanan</span>
                </a>
            </li>

            <div class="sidebar-heading" style="margin-top: 20px;">
                Transaksi
            </div>
            <li class="nav-item">
                <a class="nav-link" href="<?= base_url('Dashboard/transaksi') ?>" style="padding:16px 15px 5px 15px;">
                    <i class="fas fa-table"></i>
                    <span>Transaksi</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="<?= base_url('Dashboard/riwayat_transaksi') ?>" style="padding:10px 15px 5px 15px;">
                    <i class="fas fa-table"></i>
                    <span>Riwayat Transaksi</span>
                </a>
            </li>

            <!-- Divider -->
            <hr class="sidebar-divider d-none d-md-block mt-4">

            <!-- Sidebar Toggler (Sidebar) -->
            <div class="text-center d-none d-md-inline">
                <button class="rounded-circle border-0" id="sidebarToggle"></button>
            </div>

        </ul>
        <!-- End of Sidebar -->

        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">

            <!-- Main Content -->
            <div id="content">

                <!-- Topbar -->
                <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">

                    <!-- Sidebar Toggle (Topbar) -->
                    <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
                        <i class="fa fa-bars"></i>
                    </button>

                    <!-- Topbar Navbar -->
                    <ul class="navbar-nav ml-auto">
                        <!-- Nav Item - Messages -->
                        <?php if(count($notice_produk)) : ?>                       
                            <li class="nav-item dropdown no-arrow mx-1">
                                <a class="nav-link dropdown-toggle" href="#" id="messagesDropdown" role="button"
                                    data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <i class="fas fa-envelope fa-fw"></i>
                                    <span class="badge badge-danger badge-counter"><?= count($notice_produk); ?></span>
                                </a>
                                <!-- Dropdown - Messages -->
                                <div class="dropdown-list dropdown-menu dropdown-menu-right shadow animated--grow-in"
                                    aria-labelledby="messagesDropdown">
                                    <h6 class="dropdown-header">
                                        Message Center
                                    </h6>
                                    <?php foreach($notice_produk as $notice) : ?>
                                        <a class="dropdown-item d-flex align-items-center" href="#">
                                            <div class="dropdown-list-image mr-3">
                                                <img class="rounded-circle" src="<?= base_url('assets/img/imgProduk/').$notice['foto_produk']; ?>"
                                                    alt="...">
                                                <div class="status-indicator bg-success"></div>
                                            </div>
                                            <div class="font-weight-bold">
                                                <div class="text-truncate">Stok <?= $notice['nama_produk']; ?> akan habis</div>
                                                <div class="small text-gray-500">Sisa stok : <?= $notice['stok_produk']; ?></div>
                                            </div>
                                        </a>
                                    <?php endforeach; ?>
                                </div>
                            </li>
                        <?php else : ?>
                            <li class="nav-item dropdown no-arrow mx-1">
                                <a class="nav-link dropdown-toggle" href="#" id="messagesDropdown" role="button"
                                    data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <i class="fas fa-envelope fa-fw"></i>
                                </a>
                                <!-- Dropdown - Messages -->
                                <div class="dropdown-list dropdown-menu dropdown-menu-right shadow animated--grow-in"
                                    aria-labelledby="messagesDropdown">
                                    <h6 class="dropdown-header">
                                        Message center
                                    </h6>
                                    <a class="dropdown-item d-flex align-items-center">
                                        <div class="small text-gray-500">Nothing message</div>
                                    </a>
                                </div>
                            </li>
                        <?php endif; ?>

                        <div class="topbar-divider d-none d-sm-block"></div>

                        <!-- Nav Item - User Information -->
                        <li class="nav-item dropdown no-arrow">
                            <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <span class="mr-2 d-none d-lg-inline text-gray-600 small"><?= strtoupper($dataUser["username"]); ?></span>
                                    <img class="img-profile rounded-circle"
                                    src="<?= base_url('assets/'); ?>img/undraw_profile.svg">
                            </a>
                            <!-- Dropdown - User Information -->
                            <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in"
                                aria-labelledby="userDropdown">
                                <a class="dropdown-item" data-toggle="modal" data-target="#logoutModal">
                                    <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
                                    Logout
                                </a>
                            </div>
                        </li>

                    </ul>

                </nav>
                <!-- End of Topbar -->