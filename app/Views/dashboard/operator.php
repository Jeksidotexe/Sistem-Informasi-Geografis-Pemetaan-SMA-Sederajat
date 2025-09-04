<?= $this->extend('layouts/master') ?>

<?= $this->section('container') ?>
<div class="container-fluid">
    <div class="page-inner">
        <div class="row">
            <div class="col-md-12">
                <div class="card shadow-sm">
                    <div class="card-body text-center py-5">

                        <i class="fas fa-user-shield fa-4x text-primary mb-4"></i>

                        <h1 class="display-4">Selamat Datang!</h1>

                        <p class="lead">
                            Anda login sebagai <strong>Operator</strong>.
                        </p>

                        <p class="text-muted mb-4">
                            Silakan gunakan menu navigasi untuk memulai pekerjaan Anda.
                        </p>

                        <a href="<?= base_url('sekolah') ?>" class="btn btn-lg btn-success">
                            <span class="fe fe-24 fe-chevrons-right"></span> Lihat Data Sekolah
                        </a>

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>