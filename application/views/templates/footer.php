</div>
            <!-- End of Main Content -->

            <!-- Footer -->
            <footer class="sticky-footer bg-white">
                <div class="container my-auto">
                    <div class="copyright text-center my-auto">
                        <span>Copyright &copy; Your Website 2021</span>
                    </div>
                </div>
            </footer>
            <!-- End of Footer -->

        </div>
        <!-- End of Content Wrapper -->

    </div>
    <!-- End of Page Wrapper -->

    <!-- Scroll to Top Button-->
    <a class="scroll-to-top rounded" href="#page-top">
        <i class="fas fa-angle-up"></i>
    </a>

    <!-- Logout Modal-->
    <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Ready to Leave?</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">Select "Logout" below if you are ready to end your current session.</div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                    <a class="btn btn-primary" href="?logout">Logout</a>
                    <?php if(isset($_GET["logout"])) {
                        $this->session->unset_userdata("email");
                        $this->session->unset_userdata("role_id");
                        $this->session->unset_userdata("passwordLogin");
                        redirect("Auth/login");
                    } ?>
                </div>
            </div>
        </div>
    </div>

    <!-- Tambah Modal -->
    <div class="modal fade" id="addModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Add Your Product</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <form action="<?= base_url("Dashboard/addProduct") ?>" method="post">
                    <div class="modal-body">
                        <div class="form-row">
                            <div class="form-group col">
                                <label for="exampleInputEmail1" class="font-weight-bold">Kode Product</label>
                                <input type="text" class="form-control" name="kd_produk" required>
                            </div>
                            <div class="form-group col">
                                <label for="exampleInputEmail1" class="font-weight-bold">Name Product</label>
                                <input type="text" class="form-control" name="name_produk" required>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group col">
                                <label for="exampleInputPassword1" class="font-weight-bold">Product Price</label>
                                <div class="input-group mb-2">
                                    <div class="input-group-prepend">
                                        <div class="input-group-text">Rp</div>
                                    </div>
                                    <input type="number" class="form-control" name="hrg_produk" required>
                                </div>
                            </div>
                            <div class="form-group col">
                                <label for="exampleInputPassword1" class="font-weight-bold">Selling Price</label>
                                <div class="input-group mb-2">
                                    <div class="input-group-prepend">
                                        <div class="input-group-text">Rp</div>
                                    </div>
                                    <input type="number" class="form-control" name="hrg_jual">
                                </div>
                            </div>
                        </div>

                        <div class="form-row">
                            <div class="form-group col">
                                <label for="exampleInputEmail1" class="font-weight-bold">Stok</label>
                                <input type="number" class="form-control" name="stok" required >
                            </div>
                            <div class="form-group col">
                                <label for="exampleInputEmail1" class="font-weight-bold">Satuan</label>
                                <select class="custom-select mr-sm-2" name="id_kategory">
                                    <option value="pcs">pcs</option>
                                    <option value="buah">buah</option>
                                    <option value="btl">botol</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="font-weight-bold">Kategory</label>
                            <select class="custom-select mr-sm-2" name="id_kategory">
                                <?php foreach($produk_kategory as $ctg) : ?>
                                    <option value="<?= $ctg['id_kategory']; ?>"><?= $ctg["kategory"]; ?></option>                               
                                <?php endforeach; ?>
                            </select>
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
    <!-- Bootstrap core JavaScript-->
    <script src="<?= base_url('assets/'); ?>vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

    <!-- Core plugin JavaScript-->
    <script src="<?= base_url('assets/'); ?>vendor/jquery-easing/jquery.easing.min.js"></script>

    <!-- Custom scripts for all pages-->
    <script src="<?= base_url('assets/'); ?>js/sb-admin-2.min.js"></script>

     <!-- Page level plugins -->
    <script src="<?= base_url('assets/'); ?>vendor/datatables/jquery.dataTables.min.js"></script>
    <script src="<?= base_url('assets/'); ?>vendor/datatables/dataTables.bootstrap4.min.js"></script>

    <!-- Page level custom scripts -->
    <script src="<?= base_url('assets/'); ?>js/demo/datatables-demo.js"></script>

 

</body>

</html>