<div class="container-fluid">
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
                    <table class="table table-bordered " id="dataTable" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Nama Produk</th>
                                <th>Harga</th>
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
                                    <td><?= $item["nama_produk"]; ?></td>
                                    <td><?= "Rp " . number_format($item["hrg_jual"],0,',','.'); ?></td>
                                    <td><?= $item["nama_kategori"]; ?></td>
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

    <!-- Tambah Modal -->
    <div class="modal fade" id="addModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Tambah produk</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <form action="<?= base_url("Dashboard/addProduct") ?>" method="post" enctype="multipart/form-data">
                    <div class="modal-body">
                        <div class="msg"></div>
                        <div class="form-row">
                            <div class="form-group col">
                                <label for="exampleInputEmail1" class="font-weight-bold">Kode Produk</label>
                                <input type="text" class="form-control" name="kd_produk" required>
                            </div>
                            <div class="form-group col">
                                <label for="exampleInputEmail1" class="font-weight-bold">Nama Produk</label>
                                <input type="text" class="form-control" name="nama_produk" required>
                            </div>
                            <div class="form-group col">
                                <label for="exampleInputPassword1" class="font-weight-bold">Harga Beli</label>
                                <div class="input-group mb-2">
                                    <div class="input-group-prepend">
                                        <div class="input-group-text">Rp</div>
                                    </div>
                                    <input type="number" class="form-control" name="hrg_beli" required>
                                </div>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group col">
                                <label for="exampleInputPassword1" class="font-weight-bold">Harga Jual</label>
                                <div class="input-group mb-2">
                                    <div class="input-group-prepend">
                                        <div class="input-group-text">Rp</div>
                                    </div>
                                    <input type="number" class="form-control" name="hrg_jual">
                                </div>
                            </div>
                            
                            <div class="form-group col">
                                <label for="exampleInputEmail1" class="font-weight-bold">Stok</label>
                                <input type="number" class="form-control" name="stok" required >
                            </div>
                            
                            <div class="form-group col">
                                <label for="exampleInputEmail1" class="font-weight-bold">Min Stok</label>
                                <input type="number" class="form-control" value='5' name="notice_stok">
                            </div>
                        </div>

                        <div class="form-row">
                            <div class="form-group col">
                                <label for="exampleInputEmail1" class="font-weight-bold">Foto</label>
                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">Upload</span>
                                    </div>
                                    <div class="custom-file">
                                        <input type="file" class="custom-file-input" id="inputGroupFile01" name="file_foto">
                                        <label class="custom-file-label" for="inputGroupFile01">Choose file</label>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group col">
                                <label class="font-weight-bold" style="margin-right: 10px;">Kategory</label><span class="badge bg-success" onclick="addKategory()"><i class="fas fa-plus text-white"></i></span>
                                <select class="custom-select mr-sm-2" name="id_kategori">
                                    <?php foreach($produk_kategory as $ctg) : ?>
                                        <option value="<?= $ctg['id_kategori']; ?>"><?= $ctg["nama_kategori"]; ?></option>                               
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group col">
                                <label for="exampleInputEmail1" class="font-weight-bold">Keterangan</label>
                                <textarea name="ket_produk" class="form-control" id="exampleFormControlTextarea1" rows="3" placeholder="Optional"></textarea>
                            </div>
                        </div>
                        <div class="form-row align-items-center" id="formKategory" style="display: none;">
                            <div class="form-group col-auto">
                                <button type="button" class="close" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="form-group col">
                                <input type="text" class="form-control" name="kategory" placeholder="Kategory">
                            </div>
                            <div class="form-group col">
                                <div class="btn btn-success" id="btnkategory"><i class="fas fa-plus text-white"></i></div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <input class="btn btn-secondary" type="reset" value="reset">
                        <input class="btn btn-success" type="submit" value="Submit">
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        // updateKategory()
        
        function addKategory() {
            $("#formKategory").slideToggle();
        }

        $("#formKategory .close").click(() => {
            $("#formKategory").slideToggle()
            $("input[name='kategory']").val('')
        })

        $("#btnkategory").click(e => {
            $.ajax({
                url: `<?= base_url('Dashboard/insertKategory') ?>`,
                type: "POST", 
                data: {
                    kategory: $("input[name='kategory']").val()
                },
                dataType: "json",
                success: (response) => {
                    // $("#formKategory").slideToggle();
                    $("input[name='kategory']").val('')
                    if (response.status) {
                        $(".msg").html(`<div class="alert alert-success alert-dismissible fade show" role="alert">
                            <strong>${response.msg}</strong>
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>`)

                        updateKategory()
                    }else {
                        $(".msg").html(`<div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <strong>${response.msg}</strong>
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>`)
                    }
                }
            })
        })

        function updateKategory() {
            $.ajax({
                url: `<?= base_url('Dashboard/updateKategory') ?>`,
                type: "GET",
                dataType: "json",
                success: (response) => {
                    var option = ""
                    response.data.forEach(element => {
                        option += `<option value="${element.id_kategory}">${element.kategory}</option>`;
                    });

                    $("select[name='id_kategory']").html(option)
                },
                error: err => {
                    alert('kesalahan pada update kategori');
                }
            })
        }
    </script>

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
    <!-- Content Row -->
</div>

<?php if($this->session->userdata("crudfailed")) : ?>
    <script>
        Swal.fire({
            title: "Failed",
            text: '<?= $this->session->userdata("crudfailed") ?>',
            icon: "error",
            showConfirmButton: true
        })
    </script>
<?php $this->session->unset_userdata("crudfailed"); ?>
<?php endif; ?>

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