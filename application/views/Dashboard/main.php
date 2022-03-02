<div class="container-fluid">
    <!-- Content Row -->
    <?php if(strtolower($dataUser["role_id"]) == 1) : ?>
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <div class="row justify-content-between align-items-center">
                    <div class="col-auto">
                        <h6 class="m-0 font-weight-bold text-primary">Data User</h6>
                    </div>
                    <div class="col-auto">
                        <a class="btn btn-success" href="<?= base_url('Dashboard/insertUser'); ?>">+ Administrator</a>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Active</th>
                                <th>Role</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $i=1;
                            foreach($users as $user) : ?>
                            
                            <?php if(!($user["role_id"] == 1)) : ?>
                                <tr>
                                    <td><?= $i++; ?></td>
                                    <td><?= $user["name_user"]; ?></td>
                                    <td><?= $user["email"]; ?></td>
                                    <td>
                                        <?php if($user["is_active"]) : ?>
                                            <span class="badge badge-success">active</span>
                                        <?php else : ?>
                                            <span class="badge badge-danger">not active</span>
                                        <?php endif; ?>
                                    </td>
                                    <td><?= $user["role"]; ?></td>

                                    <td class="text-center">
                                        <span class="btn btn-danger" onclick="deleteData('<?= $user['id_user'] ?>')">Hapus</span>
                                    </td>
                                </tr>
                            <?php endif; ?>

                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <script>
            function deleteData(id) {
                Swal.fire({
                title: 'Are you sure ?',
                text: "This will permanently delete the user",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        window.location.href = `<?= base_url('Crud_user/delete/') ?>${id}`
                    }
                })
            }
        </script>

    <?php else : ?>
        <?php 
            $dataTransaksi = $this->dbuser->get_where("transaksi", ["tgl_transaksi" => date("Y-m-d")])->result_array();
            $pembayaran = $this->dbuser->get("pembayaran")->result_array();
            foreach ($dataTransaksi as $data) {
                foreach ($pembayaran as $d) {
                    if ($data["kode_pembayaran"] == $d["kode_pembayaran"]) {

                    }
                }
            }    
        ?>
        <div class="row">
            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card border-left-primary shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                    Earnings (Today)</div>
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
                                    Product sold</div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800"><?= $productSold; ?></div>
                            </div>
                            <div class="col-auto">
                                <i class="fab fa-product-hunt text-gray-300 fa-2x"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
         <!-- DataTales Example -->
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <div class="row justify-content-between align-items-center">
                    <div class="col-auto">
                        <h6 class="m-0 font-weight-bold text-primary">Total Product : <?= count($produks); ?></h6>
                    </div>
                    <div class="col-auto">
                        <span class="btn btn-success" data-toggle="modal" data-target="#addModal"><i class="fas fa-cart-plus"></i> Add Product</span>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Name</th>
                                <th>Product Price</th>
                                <th>Kategory</th>
                                <th>Stok</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $i=1;
                            foreach($produks as $item) : ?>
                                <tr>
                                    <td><?= $i++; ?></td>
                                    <td><?= $item["name_produk"]; ?></td>
                                    <td><?= "Rp " . number_format($item["hrg_jual"],2,',','.'); ?></td>
                                    <td><?= $item["kategory"]; ?></td>
                                    <td><?= $item["stok_produk"]; ?></td>
                                    <td class="text-center">
                                        <a href="<?= base_url("Dashboard/updateProduk/").$item['kd_produk'] ?>" class="btn btn-primary"><i class="fas fa-edit"></i></a>
                                        <a class="btn btn-danger" onclick="deleteData('<?= $item['kd_produk'] ?>')"><i class="fas fa-trash-alt"></i></a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <script>
            function deleteData(kd_produk) {
                Swal.fire({
                title: 'Are you sure ?',
                text: "This will permanently delete the product",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        window.location.href = `<?= base_url('Dashboard/deleteProduk/') ?>${kd_produk}`
                    }
                })
            }
        </script>
    <?php endif; ?>
    <!-- Content Row -->
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