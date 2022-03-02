<div class="container-fluid">
    <div class="row">
        <div class="col-lg-10">
            <div class="card shadow mb-4">
                <!-- Card Header - Dropdown -->
                <div
                    class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                    <h3 class="m-0 font-weight-bold text-primary">Update Administrator</h3>
                </div>
                <!-- Card Body -->
                <div class="card-body">
                    <div class="row">
                        <div class="col-auto">
                            <img src="" width="190" height="250">
                        </div>
                        <div class="col">  
                            <form method="post" enctype="multipart/form-data">
                                <input type="hidden" name="id_user" value="<?= $dataUser['id_user'] ?>">
                                <div class="form-group col">
                                    <label for="exampleInputEmail1" class="font-weight-bold">Name</label>
                                    <input type="text" class="form-control" name="name_user" required value="<?= $dataUser['name_user'] ?>">
                                </div>
                                <div class="form-group col">
                                    <label for="exampleInputEmail1" class="font-weight-bold">Email</label>
                                    <input type="email" class="form-control" name="email" required value="<?= $dataUser['email'] ?>">
                                </div>
                                <div class="form-group col">
                                    <label for="exampleInputEmail1" class="font-weight-bold">Image</label>
                                    <input type="file" class="form-control-file" name="img">
                                </div>
                                <input type="submit" class="btn btn-primary mt-4 ml-2" name="submit" value="Submit">
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
</div>