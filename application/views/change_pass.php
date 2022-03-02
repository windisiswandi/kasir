 <div class="row justify-content-center">

        <div class="col-md-6">
            <div class="card o-hidden border-0 shadow-lg my-5">
                <div class="card-body p-0">
                    <div class="p-5">
                        <div class="text-center">
                            <h1 class="h4 text-gray-900 mb-4">Change Password</h1>
                        </div>
                        <form class="user" method="post">
                            <div class="form-group">
                                <input type="password" class="form-control form-control-user mb-4" placeholder="New Password" name="password">
                                <input type="password" class="form-control form-control-user" placeholder="Confiem New Password" name="repeat_pass">
                                <?= form_error("repeat_pass", '<small class="text-danger ml-3 mt-2">', '</small>'); ?>
                            </div>
                            <button type="submit" class="btn btn-primary btn-user btn-block">
                                Change Password
                            </button>
                        </form>
                        <hr>
                    </div>
                </div>
            </div>

        </div>

    </div>