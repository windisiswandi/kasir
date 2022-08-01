<div class="container-fluid">
    <div class="row">
        <div class="col-lg-12">
            <div class="card shadow mb-4">
                <!-- Card Header - Dropdown -->
                <div
                    class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                    <h3 class="m-0 font-weight-bold text-primary">Update Product</h3>
                </div>
                <!-- Card Body -->
                <div class="card-body row justify-content-between">
                    <div class="col-sm-4">
                        <h6 class="font-weight-bold">Foto Produk</h6>
                        <?php if(@$foto_produk) : ?>
                            <img class="imgProduk" src="<?= base_url('assets/img/imgProduk/').$foto_produk; ?>">
                        <?php else : ?>
                            <img class="imgProduk" src="<?= base_url('assets/img/imgProduk/no_image.jpg'); ?>" >
                        <?php endif; ?>
                    </div>
                    <div class="col-sm-8">   
                        <form method="post" enctype="multipart/form-data">
                            <div class="msg"></div>
                            <div class="form-row">
                                <div class="form-group col">
                                    <label for="exampleInputEmail1" class="font-weight-bold">Kode Product</label>
                                    <input type="text" class="form-control" name="kd_produk" required value="<?= $kd_produk; ?>">
                                </div>
                                <div class="form-group col">
                                    <label for="exampleInputEmail1" class="font-weight-bold">Nama Produk</label>
                                    <input type="text" class="form-control" name="nama_produk" required value="<?= $nama_produk; ?>">
                                </div>

                                <div class="form-group col">
                                    <label for="exampleInputPassword1" class="font-weight-bold">Harga Beli</label>
                                    <div class="input-group mb-2">
                                        <div class="input-group-prepend">
                                            <div class="input-group-text">Rp</div>
                                        </div>
                                        <input type="number" class="form-control" name="hrg_beli" required value="<?= $hrg_beli; ?>">
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
                                        <input type="number" class="form-control" name="hrg_jual" required value="<?= $hrg_jual; ?>">
                                    </div>
                                </div>
                                <div class="form-group col">
                                    <label for="exampleInputEmail1" class="font-weight-bold">Stok</label>
                                    <input type="number" class="form-control" name="stok_produk" required value="<?= $stok_produk; ?>">
                                </div>
                                <div class="form-group col">
                                    <label for="exampleInputEmail1" class="font-weight-bold">Min Stok</label>
                                    <input type="number" class="form-control" name="notice_stok" required value="<?= $notice_stok; ?>">
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
                                    <label class="font-weight-bold" style="margin-right: 10px;">Kategori</label><span class="badge bg-primary" onclick="addKategory()"><i class="fas fa-plus text-white"></i></span>
                                    <select class="custom-select mr-sm-2" name="id_kategori">
                                        <?php foreach($produk_kategory as $ctg) : ?>
                                            <?php if($ctg["id_kategori"] == $id_kategori) : ?> 
                                                <option value="<?= $ctg['id_kategori']; ?>" selected><?= $ctg["nama_kategori"]; ?></option>                               
                                            <?php else : ?>
                                                <option value="<?= $ctg['id_kategori']; ?>"><?= $ctg["nama_kategori"]; ?></option>                               
                                            <?php endif; ?>
                                        <?php endforeach; ?>
                                    </select>
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
                                    <div class="btn btn-primary" id="btnkategory"><i class="fas fa-plus text-white"></i></div>
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-group col">
                                    <label for="exampleInputEmail1" class="font-weight-bold">Keterangan</label>
                                    <textarea name="ket_produk" class="form-control" id="exampleFormControlTextarea1" rows="3" placeholder="Optional"><?= $ket_produk; ?></textarea>
                                </div>
                            </div>
                            <a href="<?= base_url('Dashboard/produks'); ?>" class="btn btn-secondary">Back</a>
                            <input type="submit" class="btn btn-primary" name="submit" value="Submit">
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
</div>
<script>    
    function addKategory() {
        $("#formKategory").slideToggle();
    }

    $(".close").click(() => {
        $("#formKategory").slideToggle()
        $("input[name='kategory']").val('')
    })

    $("#btnkategory").click(e => {
        $.ajax({
            url: `<?= base_url('Dashboard/insertKategory') ?>`,
            type: "POST", 
            data: {
                kategory: $("input[name='kategory']").val(),
                id_kategory: <?= str_shuffle("123456") ?>
            },
            dataType: "json",
            success: (response) => {
                $("#formKategory").slideToggle();
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
            url: `<?= base_url('Dashboard/getKategori') ?>`,
            type: "GET",
            dataType: "json",
            success: (response) => {
                var option = ""
                response.data.forEach(element => {
                    option += `<option value="${element.id_kategory}">${element.kategory}</option>`;
                });

                $("select[name='id_kategori']").html(option)
            },
            error: err => {
                alert(err);
            }
        })
    }
</script>

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