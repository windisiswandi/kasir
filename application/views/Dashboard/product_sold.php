<div class="container-fluid">
<div class="card shadow mb-4">
    <div class="card-header py-3">
        <div class="row justify-content-between align-items-center">
            <div class="col-auto">
                <h6 class="m-0 font-weight-bold text-primary">Riwayat Transaksi</h6>
            </div>
            <div class="col-auto">
                <a class="btn btn-primary" href="<?= base_url('Dashboard/riwayat_transaksi/day') ?>">Riwayat Hari ini</a>
            </div>
        </div>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>No. Resi</th>
                        <th>Tgl Transaksi</th>
                        <th>Name</th>
                        <th>Kategory</th>
                        <th>Qty</th>
                        <th>Product Price</th>
                        <th>Total Product Price</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $i=1;
                    foreach($product_sold as $item) : ?>
                        <tr>
                            <td><?= $i++; ?></td>
                            <td><?= $item["no_resi"]; ?></td>
                            <td><?= $item["tgl_beli"]; ?></td>
                            <td><?= $item["nama_produk"]; ?></td>
                            <td><?= $item["kategory"]; ?></td>
                            <td><?= $item["jml_beli"]; ?></td>
                            <td><?= "Rp " . number_format($item["hrg_jual"],0,',','.'); ?></td>
                            <td>
                                <?php 
                                    $hrg_total = $item["jml_beli"] * $item["hrg_jual"];
                                    echo "Rp " . number_format($hrg_total,0,',','.');
                                ?>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
</div>
