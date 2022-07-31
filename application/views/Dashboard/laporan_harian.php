<div class="container-fluid">
    <!-- DataTales Example -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <div class="row justify-content-between align-items-center">
                <div class="col-auto">
                    <h6 class="m-0 font-weight-bold text-primary">Laporan Harian</h6>
                </div>
            </div>
        </div>
        <div class="card-body">
            <form action="<?= base_url("Export/exportHarian") ?>" method="post">
                <div class="row justify-content-between">
                    <div class="col-sm-6">
                        <div class="row">
                            <div class="col-sm-4">
                                <select name="export" class="custom-select">
                                    <option value="excel">EXCEL</option>
                                    <option value="print">PRINT</option>
                                </select>
                            </div>
                            <div class="col-auto">
                                <button type="submit" class="btn btn-dark">Submit</button>
                            </div>
                        </div>
                    </div>
                    <div class="col-auto">
                        <input type="date" name="tanggal" class="form-control" value="<?= date("Y-m-d") ?>" onchange="getLaporanHarian(value)">
                    </div>
                </div>
            </form>
            <div id="laporanBody">
            </div>
        </div>
    </div>
</div>

<script>
    function getLaporanHarian(date) {
        $.ajax({
            url: `<?= base_url("Dashboard/getDataHarian/") ?>${date}`,
            type: "POST",
            success: response => {
                var data = response
                try {
                    data = JSON.parse(data)
                    Swal.fire({
                        title: "Oops",
                        text: data.msg,
                        icon: "error",
                        timer: 1000,
                        showConfirmButton: false
                    })
                } catch (error) {
                    $("#laporanBody").html(response)
                }
            },
            error: err => {
                alert(err.responseText)
            }
        })
    }

    getLaporanHarian("<?= date("Y-m-d") ?>")
</script>