<style>
    #itemClose {
        cursor: pointer;
    }
</style>
<!-- modal -->
<div class="modal fade" id="modal-transaksi" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="font-weight-bold float-right mb-4 text-primary">Pembayaran</h5>
                <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <form action="<?= base_url('Dashboard/prosesPayment') ?>" method="post" onsubmit="return cekPembayaran(this)">
                <div class="modal-body">
                    <div class="form-group col">
                        <label for="exampleInputEmail1" class="font-weight-bold">Total Bayar</label>
                        <input type="text" class="form-control" readonly name="jml_bayar">
                    </div>
                    <div class="form-group col">
                        <label for="exampleInputEmail1" class="font-weight-bold">Bayar</label>
                        <input type="text" class="form-control" name="bayar" required autocomplete="off">
                    </div>
                    <div class="form-group col">
                        <label for="exampleInputEmail1" class="font-weight-bold">Kembalian</label>
                        <input type="text" class="form-control" readonly name="kembalian">
                    </div>
                    <input type="submit" name="submit" value="Submit" class="btn btn-primary ml-2">
                </div>
            </form>
        </div>
    </div>
</div>

<div class="container-fluid">
    <div class="row">
        <div class="col">
            <div class="card shadow mb-4" style="font-size: 14px;">
                <!-- Card Header - Dropdown -->
                <div
                    class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                        <div class="col-auto">
                            <h5 class="font-weight-bold text-primary">Transaksi</h5>
                        </div>
                </div>
                <!-- Card Body -->
                <div class="card-body">
                    <div class="row">
                        <div class="form-group col-sm-3">
                            <label for="exampleInputEmail1" class="font-weight-bold">No. Invoice</label>
                            <input type="text" class="form-control" name="nomor_invoice" readonly value="123135">
                        </div>
                        <div class="form-group col-sm-3">
                            <label for="exampleInputEmail1" class="font-weight-bold">Nama Pelanggan</label>
                            <input type="text" class="form-control" name="nama_pelanggan" placeholder="Optional">
                        </div>
                    </div>
                    <div class="row mt-2">
                        <div class="form-group col-sm-3">
                            <label for="exampleInputEmail1" class="font-weight-bold">Kode Product</label>
                            <input type="text" class="form-control" name="kd_produk" required>
                        </div>
                        <div class="form-group mr-3">
                            <label for="exampleInputEmail1" class="font-weight-bold">Diskon</label>
                            <input type="text" class="form-control" name="diskon">
                        </div>
                        <div class="form-group">
                            <label for="exampleInputEmail1" class="font-weight-bold">Qty</label>
                            <input type="number" class="form-control" name="jml" value="1" required>
                        </div>
                        <div class="col-sm-3">
                            <div class="mb-2 font-weight-bold">Action</div>
                            <button class="btn btn-danger" onclick="deleteTransaksiItem()"><i class="fas fa-trash"></i></button>
                            <button class="btn btn-success" data-toggle="modal" id="submitPayment" data-target="#modal-transaksi"><i class="fas fa-sign-in-alt"></i></button>
                        </div>
                    </div>
                    <small class="text-danger" id="msgError"></small>
                    <h4 class="font-weight-bold mb-4 text-primary float-right">Total Bayar : <span id="totalBayar"></span></h4>
                    
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>Name Product</th>
                                <th>Qty</th>
                                <th>Harga</th>
                                <th>Sub Total</th>
                                <th>Diskon</th>
                                <th>Total</th>
                                <th>#</th>
                            </tr>
                        </thead>
                        <tbody id="transaksiBody">
                        <?php if(count($tLast)) : ?>
                            <?php 
                                $subTotal; $total;
                                foreach($tLast as $t) : ?>
                                <tr>
                                    <td><?= $t["nama_produk"]; ?></td>
                                    <td><?= $t["jml_beli"]; ?></td>
                                    <td><?= number_format($t["hrg_jual"],0,',','.'); ?></td>
                                    <td>
                                        <?php 
                                            $subTotal = $t["jml_beli"]*$t["hrg_jual"];
                                            echo number_format($subTotal,0,',','.'); 
                                        ?>
                                    </td>
                                    <td><?= number_format($t["diskon"],0,',','.'); ?></td>
                                    <td>
                                        <?php 
                                            $total = $subTotal - $t['diskon'];
                                            echo number_format($total, 0,',','.');
                                        ?>
                                    </td><td class="text-center text-danger" onclick="deleteTransaksiItem(<?= $t['id_item']; ?>)"><i class="fas fa-window-close"></i></a></td>
                                </tr>
                            <?php endforeach; ?>
                        <?php endif; ?> 
                        </tbody>
                        
                    </table>
           
                </div>
            </div>
        </div>
    </div>   
</div>

<span class="listProduk" data-toggle="modal" data-target="#listProduk"></span>

<!-- Modal list produk -->
<div class="modal fade" id="listProduk" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Daftar Produk</h5>
                <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body" style="font-size: 16px;">
                <div class="table-responsive">
                    <table class="table table-bordered " id="dataTable" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>Foto</th>
                                <th>Nama Produk</th>
                                <th>Harga</th>
                                <th>Kategory</th>
                                <th>Stok</th>
                                <th>Ket</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach($produks as $item) : ?>
                                <tr>
                                    <td>
                                        <?php if($item['foto_produk']) : ?>
                                            <img src="<?= base_url('assets/img/imgProduk/').$item['foto_produk']; ?>" width="50">
                                        <?php else : ?>
                                            <img src="<?= base_url('assets/img/imgProduk/no_image.jpg'); ?>" width="50">
                                        <?php endif; ?>
                                    </td>
                                    <td><?= $item["nama_produk"]; ?></td>
                                    <td><?= number_format($item["hrg_jual"],0,',','.'); ?></td>
                                    <td><?= $item["nama_kategori"]; ?></td>
                                    <td><?= $item["stok_produk"]; ?></td>
                                    <td><?= $item["ket_produk"]; ?></td>
                                    <td class="text-center">
                                        <?php if($item['stok_produk'] > 0) : ?>
                                            <button onclick="pilihItem(`<?= $item['kd_produk']; ?>`)" class="btn btn-success">Pilih</button>
                                        <?php else : ?>
                                            <button class="btn btn-secondary">Pilih</button>
                                        <?php endif; ?>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<?php if($this->session->userdata("crudsukses")) : ?>
    <script>
        Swal.fire({
            title: "Success",
            text: '<?= $this->session->userdata("crudsukses") ?>',
            icon: "success",
            timer: 1000,
            showConfirmButton: false
        })
    </script>
<?php $this->session->unset_userdata("crudsukses"); ?>
<?php endif; ?>

<script>
    $(document).ready(function () {
        $("body ul.navbar-nav").addClass("toggled");
        totalBayar()


        $("input[name='kd_produk']").focus()
        
        // $("input[name='kd_produk'], input[name='jml'], input[name='diskon']").keydown(e => {
        //     if (e.keyCode == 13) insertTransaksi()
        //     else if (e.keyCode == 32) $('.listProduk').click()
        // })

        $("input[name='bayar']").keyup(e => {
            var bayar = $("input[name='bayar']").val().replace(/\./gi, "").replace("Rp ", ""),
                jml_bayar = $("input[name='jml_bayar']").val().replace(/\./gi, "").replace("Rp ", ""),
                kembalian = parseInt(bayar) - parseInt(jml_bayar);
            $("input[name='kembalian']").val(new Intl.NumberFormat("id-ID", { style: "currency", currency: "IDR",minimumFractionDigits: 0 }).format(kembalian))
        })

        $(window).keydown(e => {
            if (e.keyCode == 13) insertTransaksi()
            else if (e.keyCode == 27) $("input[name='kd_produk']").focus()
            else if (e.keyCode == 39) $("#submitPayment").click()
            else if (e.keyCode == 32) $('.listProduk').click()
            else if (e.keyCode == 46) deleteTransaksiItem()
            
        })

    })

    new AutoNumeric("input[name='bayar']", {
        currencySymbol : 'Rp ',
        decimalCharacter : ',',
        digitGroupSeparator : '.'
    })

    function deleteTransaksiItem(id_produk = null) {
        if (!id_produk) { 
            $.ajax({
                url: `<?= base_url('Dashboard/deleteItemTransaksi/') ?>`,
                success: response => {
                    window.location.href = `<?= base_url("Dashboard/transaksi") ?>`
                },
                error: (err, throwErorr) => {
                    alert(`${err.status}\n${err.responseText}\n${throwErorr}`)
                }
            })
        }else {
            $.ajax({
                type: "POST",
                url: "<?= base_url('Dashboard/deleteItemTransaksi/') ?>",
                data: {
                    id:  id_produk
                },
                success: response => {
                    $("#transaksiBody").html(response)
                    totalBayar()
                },
                error: (err, throwErorr) => {
                    alert(`${err.status}\n${err.responseText}\n${throwErorr}`)
                    
                }
            })
        }
    }

    function insertTransaksi() {
        $.ajax({
            type: "POST",
            url: "<?= base_url('Dashboard/insertTransaksi/') ?>",
            data: {
                kd_produk:  $("input[name='kd_produk']").val(),
                diskon: $("input[name='diskon']").val(),
                qty: $("input[name='jml']").val()
            },
            success: response => {
                var data = response
                try {
                    data = JSON.parse(data)
                    $("#msgError").text(data.msg)
                }catch(err){
                    $("input[name='kd_produk']").val('')
                    $("input[name='diskon']").val('')
                    $("input[name='jml']").val('1')
                    $("#transaksiBody").html(response)
                    $("#msgError").text("")
                    totalBayar()
                    $("input[name='kd_produk']").focus()
                }
            }
        })
    }

    function totalBayar() {
        $.ajax({
            type: "POST",
            url: "<?= base_url('Dashboard/totalBayar/') ?>",
            dataType: "json",
            data: {
                id_user: `<?= $dataUser["id_user"]; ?>`
            },
            success: response => {
                $("#totalBayar").text(response.totalBayar)
                $("input[name='jml_bayar']").val(response.totalBayar)
            }
        })
    }

    function cekPembayaran(nilai) {
        var bayar = $("input[name='bayar']").val().replace(/\./gi, "").replace("Rp ", ""),
                jml_bayar = $("input[name='jml_bayar']").val().replace(/\./gi, "").replace("Rp ", ""),
                kembalian = parseInt(bayar) - parseInt(jml_bayar);

        if (parseInt(jml_bayar) == 0) {
            Swal.fire({
                title: "Failed",
                html: 'Lakukan transaksi terlebih dahulu',
                icon: "error",
                showConfirmButton: true
            })

            return false;
        }else {
            if (kembalian < 0) {
                Swal.fire({
                    title: "Pembayaran Failed",
                    html: 'Pastikan uang pembayaran lebih besar atau sama dengan <b>Total Bayar</b>',
                    icon: "error",
                    showConfirmButton: true
                })
                return false;
            }else {
                nilai.jml_bayar.value = parseInt(jml_bayar);
                return true;
            }
        }
    }

    function pilihItem(kd_produk) {
        $("input[name='kd_produk']").val(kd_produk)
        $('.close').click()
        $("input[name='kd_produk']").focus()
    }
</script>