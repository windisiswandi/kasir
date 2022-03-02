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
                        <div class="form-row">
                            <div class="form-group col">
                                <label for="exampleInputEmail1" class="font-weight-bold">Kode Product</label>
                                <input type="text" class="form-control" name="kd_produk" required value="<?= $kd_produk; ?>">
                            </div>
                            <div class="form-group col">
                                <label for="exampleInputEmail1" class="font-weight-bold">Name Product</label>
                                <input type="text" class="form-control" name="name_produk" required value="<?= $name_produk; ?>">
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
                                <input type="number" class="form-control" name="stok" required value="<?= $stok_produk; ?>">
                            </div>
                            <div class="form-group col">
                                <label for="exampleInputEmail1" class="font-weight-bold">Volume</label>
                                <input type="text" class="form-control" name="volume" required placeholder="Example: Kg, Pack, etc...">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="font-weight-bold">Kategory</label>
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
                        <input type="submit" class="btn btn-primary" name="submit" value="Submit">
                    </form>
                </div>
            </div>
        </div>
    </div>
    
</div>