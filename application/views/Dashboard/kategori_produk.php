<div class="container-fluid">
    <!-- DataTales Example -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <div class="row justify-content-between align-items-center">
                <div class="col-auto">
                    <h6 class="m-0 font-weight-bold text-primary">List Kategori</h6>
                </div>
                <div class="col-auto">
                    <span class="btn btn-success" data-toggle="modal" data-target="#addKategori"><i class="fas fa-cart-plus"></i> Add Kategory</span>
                </div>
            </div>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered " id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Nama Kategori</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $i=1;
                        foreach($kategori as $item) : ?>
                            <tr>
                                <td><?= $i++; ?></td>
                                <td><?= $item["nama_kategori"]; ?></td>
                                <td class="text-center">
                                    <a class="btn btn-danger" onclick="deleteData('<?= $item['id_kategori'] ?>')"><i class="fas fa-trash-alt"></i></a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Tambah Modal -->
    <div class="modal fade" id="addKategori" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Tambah Kategori</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <form method="post" id="formInsertKategori">
                    <div class="modal-body">
                        <div class="msg"></div>
                        <div class="form-row">
                            <div class="form-group col">
                                <label for="exampleInputEmail1" class="font-weight-bold">Nama Kategori</label>
                                <input type="text" class="form-control" name="nama_kategori" required>
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

        $("#formInsertKategori").submit(e => {
            e.preventDefault()
            $.ajax({
                url: `<?= base_url('Dashboard/insertKategory') ?>`,
                type: "POST", 
                data: {
                    kategory: $("input[name='nama_kategori']").val()
                },
                dataType: "json",
                success: (response) => {
                    location.reload(true)
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
        function deleteData(id_kategori) {
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
                    window.location.href = `<?= base_url('Dashboard/deleteKategori/') ?>${id_kategori}`
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