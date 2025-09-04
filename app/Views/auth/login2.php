<?= $this->extend('layouts/auth2') ?>

<?= $this->section('login2') ?>
<div class="row">
    <div class="col-sm-12">
        <!-- Authentication card start -->
        <div class="login-card card-block auth-body mr-auto ml-auto">
            <form action="/login" method="post" class="md-float-material">
                <?= csrf_field() ?>
                <div class="text-center">
                    <img src="<?= base_url('img/logo-login.png') ?>" alt="logo.png" height="100">
                </div>
                <div class="auth-box">
                    <div class="row m-b-20">
                        <div class="col-md-12">
                            <h3 class="text-left txt-primary">Silahkan Login</h3>
                        </div>
                    </div>
                    <hr />
                    <div class="input-group">
                        <input type="email" name="email" id="email" class="form-control" placeholder="Alamat Email" value="<?= old('email') ?>">
                        <span class="md-line"></span>
                    </div>
                    <div class="input-group">
                        <input type="password" name="password" id="password" class="form-control" placeholder="Password">
                        <span class="md-line"></span>
                    </div>
                    <div class="row m-t-25 text-left">
                        <div class="col-sm-7 col-xs-12">
                            <div class="checkbox-fade fade-in-primary">
                                <label>
                                    <input type="checkbox" value="">
                                    <span class="cr"><i class="cr-icon icofont icofont-ui-check txt-primary"></i></span>
                                    <span class="text-inverse">Ingat Saya</span>
                                </label>
                            </div>
                        </div>
                    </div>
                    <div class="row m-t-30">
                        <div class="col-md-12">
                            <button type="submit" class="btn btn-primary btn-md btn-block waves-effect text-center m-b-20">Login</button>
                        </div>
                    </div>
                </div>
            </form>
            <!-- end of form -->
        </div>
        <!-- Authentication card end -->
    </div>
    <!-- end of col-sm-12 -->
</div>
<?= $this->endSection() ?>