<div class="container-fluid">
    <div class="row">
        <div class="col-lg-7">
            <div class="card shadow mb-4">
                <!-- Card Header - Dropdown -->
                <div
                    class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                    <h3 class="m-0 font-weight-bold text-primary">Add Administrator</h3>
                </div>
                <!-- Card Body -->
                <div class="card-body">
                    <form method="post" enctype="multipart/form-data">
                        <div class="form-group col">
                            <label for="exampleInputEmail1" class="font-weight-bold">Name</label>
                            <input type="text" class="form-control" name="name_user" required >
                        </div>
                        <div class="form-group col">
                            <label for="exampleInputEmail1" class="font-weight-bold">Email</label>
                            <input type="email" class="form-control" name="email" required >
                        </div>
                        <div class="form-group col">
                            <label for="exampleInputEmail1" class="font-weight-bold">Password</label>
                            <input type="password" class="form-control" name="password" required >
                        </div>
                        <div class="form-group col">
                            <label for="exampleInputEmail1" class="font-weight-bold">Image</label>
                            <input type="file" class="form-control-file" name="img">
                        </div>
                        <input type="submit" class="btn btn-primary mt-4" name="submit" value="Submit">
                    </form>
                </div>
            </div>
        </div>
    </div>
    
</div>