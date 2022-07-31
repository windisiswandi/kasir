<div class="container-fluid">
    <div class="row">
        <div class="col-lg-8">
            <div class="card shadow mb-4">
                <!-- Card Header - Dropdown -->
                <div
                    class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                    <h3 class="m-0 font-weight-bold text-primary">Update Product</h3>
                </div>
                <!-- Card Body -->
                <div class="card-body">
                    <form method="post">
                        <div class="msg"></div>
                        <div class="form-row">
                            <div class="form-group col">
                                <label for="exampleInputEmail1" class="font-weight-bold">Kode Product</label>
                                <input type="text" class="form-control" name="kd_produk" required value="<?= $kd_produk; ?>">
                            </div>
                            <div class="form-group col">
                                <label for="exampleInputEmail1" class="font-weight-bold">Name Product</label>
                                <input type="text" class="form-control" name="nama_produk" required value="<?= $nama_produk; ?>">
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group col">
                                <label for="exampleInputPassword1" class="font-weight-bold">Product Price</label>
                                <div class="input-group mb-2">
                                    <div class="input-group-prepend">
                                        <div class="input-group-text">Rp</div>
                                    </div>
                                    <input type="number" class="form-control" name="hrg_produk" required value="<?= $hrg_produk; ?>">
                                </div>
                            </div>
                            <div class="form-group col">
                                <label for="exampleInputPassword1" class="font-weight-bold">Selling Price</label>
                                <div class="input-group mb-2">
                                    <div class="input-group-prepend">
                                        <div class="input-group-text">Rp</div>
                                    </div>
                                    <input type="number" class="form-control" name="hrg_jual" required value="<?= $hrg_jual; ?>">
                                </div>
                            </div>
                        </div>

                        <div class="form-row">
                            <div class="form-group col">
                                <label for="exampleInputEmail1" class="font-weight-bold">Stok</label>
                                <input type="number" class="form-control" name="stok" required value="<?= $stok; ?>">
                            </div>
                            <div class="form-group col">
                                <label class="font-weight-bold" style="margin-right: 10px;">Kategory</label><span class="badge bg-primary" onclick="addKategory()"><i class="fas fa-plus text-white"></i></span>
                                <select class="custom-select mr-sm-2" name="id_kategory">
                                    <?php foreach($produk_kategory as $ctg) : ?>
                                        <?php if($ctg["id_kategory"] == $id_kategory) : ?> 
                                            <option value="<?= $ctg['id_kategory']; ?>" selected><?= $ctg["kategory"]; ?></option>                               
                                        <?php else : ?>
                                            <option value="<?= $ctg['id_kategory']; ?>"><?= $ctg["kategory"]; ?></option>                               
                                        <?php endif; ?>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>
                        <div class="form-row align-items-center" id="formKategory">
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
                        <input type="submit" class="btn btn-primary" name="submit" value="Submit">
                    </form>
                </div>
            </div>
        </div>
    </div>
    
</div>
<script>
    updateKategory()
    $("#formKategory").slideToggle();
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
                alert(err);
            }
        })
    }
</script>