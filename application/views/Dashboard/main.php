<div class="container-fluid">
    <!-- Content Row -->
        <div class="row">
            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card border-left-primary shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                    Pendapat hari ini</div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800"><?= "Rp " . number_format(intval($earningToday['total_bayar']),2,',','.'); ?></div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-dollar-sign fa-2x text-gray-300"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-xl-3 col-md-6 mb-4" onclick="window.open('<?= base_url('Dashboard/riwayat_transaksi/day') ?>', '_self')" style="cursor: pointer;">
                <div class="card border-left-warning shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                    Terjual</div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800"><?= $soldProduk; ?> Produk</div>
                            </div>
                            <div class="col-auto">
                                <i class="fab fa-product-hunt text-gray-300 fa-2x"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
</div>
