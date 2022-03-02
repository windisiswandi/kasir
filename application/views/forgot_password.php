<!-- Outer Row -->
    <div class="row justify-content-center">

        <div class="col-md-6">
            <div class="card o-hidden border-0 shadow-lg my-5">
                <div class="card-body p-0">
                    <div class="p-5">
                        <?= $this->session->userdata("errorChangePassword"); ?>
                        <?php $this->session->unset_userdata("errorChangePassword"); ?>
                        <div class="text-center">
                            <h1 class="h4 text-gray-900 mb-2">Forgot Your Password?</h1>
                            <p class="mb-4">We get it, stuff happens. Just enter your email address below
                                and we'll send you a link to reset your password!</p>
                        </div>
                        <form class="user" method="post">
                            <div class="form-group">
                                <input type="email" class="form-control form-control-user"
                                    id="exampleInputEmail" aria-describedby="emailHelp"
                                    placeholder="Enter Email Address..." required name="email">
                            </div>
                            <button type="submit" class="btn btn-primary btn-user btn-block">
                                Reset Password
                            </button>
                        </form>
                        <hr>
                    </div>
                </div>
            </div>

        </div>

    </div>