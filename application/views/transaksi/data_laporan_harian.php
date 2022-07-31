<div class="row justify-content-end mt-5 mb-3 text-right">
    <div class="col-sm-2"><span class="text-primary font-weight-bold">Total</span></div>
    <div class="col-sm-1"><span class="font-weight-bold text-primary"><?= $soldProduk; ?></span></div>
    <div class="col-sm-3"><span class="font-weight-bold text-primary"><?= "Rp " . number_format(intval($earningToday["total_bayar"]),0,',','.'); ?></span></div>
</div>
<div class="table-responsive">
    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
        <thead>
            <tr>
                <th>#</th>
                <th>Tgl Transaksi</th>
                <th>Nama Barang</th>
                <th>Product Price</th>
                <th>Qty</th>
                <th>Total Product Price</th>
            </tr>
        </thead>
        <tbody>
            <?php 
            $i = 1;
            foreach($pHarian as $p) : ?>
                <tr>
                    <td><?= $i++; ?></td>
                    <td><?= $p["tgl_beli"]; ?></td>
                    <td><?= $p["nama_produk"]; ?></td>
                    <td><?= "Rp " . number_format($p["hrg_jual"],0,',','.'); ?></td>
                    <td><?= $p["jml_beli"]; ?></td>
                    <td>
                        <?php
                            $total=$p["hrg_jual"]*$p["jml_beli"];
                            echo  "Rp " . number_format($total,0,',','.');
                        ?>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>