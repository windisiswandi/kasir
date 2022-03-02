
<?php if($this->session->userdata("sregister")) : ?>
    <div class="modal-alert">
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <h4 class="alert-heading font-weight-bold">Well done!</h4>
            <p>You have successfully registered. Please check <a href="https://gmail.com" target="_blank" class="font-weight-bold">your email</a> for account activation.</p>
            <hr>
            <p class="mb-0">You can't login use your account before doing it</p>.
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    </div>
<?php $this->session->unset_userdata("sregister"); ?>
<?php endif; ?>
<div class="row justify-content-center">

<div class="col-md-6">

    <div class="card o-hidden border-0 shadow-lg my-5">
        <div class="card-body p-0">
            <!-- Nested Row within Card Body -->
            <div class="p-5">
                <div class="text-center">
                    <h1 class="h4 text-gray-900 mb-4">Welcome Back!</h1>
                </div>
                <?= $this->session->userdata("errorLogin"); ?>
                <?php $this->session->unset_userdata("errorLogin"); ?>
                <form class="user" method="post">
                    <div class="form-group">
                        <input type="email" class="form-control form-control-user" aria-describedby="emailHelp"
                            placeholder="Enter Email Address..." name="email" value="<?= set_value('email'); ?>">
                    </div>
                    <div class="form-group">
                        <input type="password" class="form-control form-control-user" placeholder="Password" name="password" value="<?= set_value('password'); ?>">
                    </div>
                    <div class="form-group">
                        <div class="custom-control custom-checkbox small">
                            <input type="checkbox" class="custom-control-input" id="customCheck" name="remember">
                            <label class="custom-control-label" for="customCheck">Remember
                                Me</label>
                        </div>
                    </div>
                    <input type="submit" value="Login" class="btn btn-primary btn-user btn-block" name="btnLogin" />
                    <hr>
                    <a href="index.html" class="btn btn-google btn-user btn-block">
                        <i class="fab fa-google fa-fw"></i> Login with Google
                    </a>
                    <a href="index.html" class="btn btn-facebook btn-user btn-block">
                        <i class="fab fa-facebook-f fa-fw"></i> Login with Facebook
                    </a>
                </form>
                <hr>
                <div class="text-center">
                    <a class="small" href="<?= base_url("Auth/forgot_password"); ?>">Forgot Password?</a>
                </div>
                <div class="text-center">
                    <a class="small" href="<?= base_url("Auth/register"); ?>">Create an Account!</a>
                </div>
            </div>
        </div>
    </div>

</div>

</div>