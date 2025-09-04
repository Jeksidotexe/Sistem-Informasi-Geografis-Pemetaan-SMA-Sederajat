<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <meta name="csrf-token" content="<?= csrf_hash() ?>">
    <link rel="icon" href="<?= base_url('img/lambang-kabupaten-sambas.png') ?>">
    <title><?= $title ?></title>

    <script src="https://code.iconify.design/iconify-icon/1.0.7/iconify-icon.min.js"></script>

    <?= $this->renderSection('header') ?>
    <!-- Simple bar CSS -->
    <link rel="stylesheet" href="<?= base_url('tinydash-master') ?>/css/simplebar.css">
    <!-- Fonts CSS -->
    <link href="https://fonts.googleapis.com/css2?family=Overpass:ital,wght@0,100;0,200;0,300;0,400;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">
    <!-- Icons CSS -->
    <link rel="stylesheet" href="<?= base_url('tinydash-master') ?>/css/feather.css">
    <link rel="stylesheet" href="<?= base_url('tinydash-master') ?>/css/dataTables.bootstrap4.css">
    <!-- Date Range Picker CSS -->
    <link rel="stylesheet" href="<?= base_url('tinydash-master') ?>/css/daterangepicker.css">
    <!-- App CSS -->
    <link rel="stylesheet" href="<?= base_url('tinydash-master') ?>/css/app-light.css" id="lightTheme">
    <link rel="stylesheet" href="<?= base_url('tinydash-master') ?>/css/app-dark.css" id="darkTheme" disabled>

    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2-bootstrap4-theme@1.0.0/dist/select2-bootstrap4.min.css">
    <style>
        .swal-custom-popup {
            width: 400px !important;
            /* Ubah lebar sesuai keinginan */
            font-size: 1rem !important;
            /* Ukuran font dasar */
        }

        .swal-custom-popup .swal2-title {
            font-size: 1.25rem !important;
            /* Perkecil ukuran judul */
        }

        .swal-custom-popup .swal2-html-container {
            font-size: 0.9rem !important;
            /* Perkecil ukuran teks konten */
        }
    </style>
</head>

<body class="vertical  light  ">
    <div class="wrapper">
        <!-- start header section -->
        <?= $this->include('layouts/header'); ?>
        <!-- end header section -->

        <!-- start sidebar section -->
        <?= $this->include('layouts/sidebar'); ?>
        <!-- end sidebar section -->

        <main role="main" class="main-content">
            <?= $this->renderSection('container') ?> <!-- .container-fluid -->
        </main> <!-- main -->
    </div> <!-- .wrapper -->
    <script src="<?= base_url('tinydash-master') ?>/js/jquery.min.js"></script>
    <script src="<?= base_url('tinydash-master') ?>/js/popper.min.js"></script>
    <script src="<?= base_url('tinydash-master') ?>/js/moment.min.js"></script>
    <script src="<?= base_url('tinydash-master') ?>/js/bootstrap.min.js"></script>
    <script src="<?= base_url('tinydash-master') ?>/js/simplebar.min.js"></script>
    <script src='<?= base_url('tinydash-master') ?>/js/daterangepicker.js'></script>
    <script src='<?= base_url('tinydash-master') ?>/js/jquery.stickOnScroll.js'></script>
    <script src="<?= base_url('tinydash-master') ?>/js/tinycolor-min.js"></script>
    <script src="<?= base_url('tinydash-master') ?>/js/config.js"></script>
    <script src="<?= base_url('tinydash-master') ?>/js/d3.min.js"></script>
    <script src="<?= base_url('tinydash-master') ?>/js/topojson.min.js"></script>
    <script src="<?= base_url('tinydash-master') ?>/js/datamaps.all.min.js"></script>
    <script src="<?= base_url('tinydash-master') ?>/js/datamaps-zoomto.js"></script>
    <script src="<?= base_url('tinydash-master') ?>/js/datamaps.custom.js"></script>
    <script src="<?= base_url('tinydash-master') ?>/js/Chart.min.js"></script>
    <script src='<?= base_url('tinydash-master') ?>/js/jquery.dataTables.min.js'></script>
    <script src='<?= base_url('tinydash-master') ?>/js/dataTables.bootstrap4.min.js'></script>
    <script>
        /* defind global options */
        Chart.defaults.global.defaultFontFamily = base.defaultFontFamily;
        Chart.defaults.global.defaultFontColor = colors.mutedColor;
    </script>
    <script src="<?= base_url('tinydash-master') ?>/js/gauge.min.js"></script>
    <script src="<?= base_url('tinydash-master') ?>/js/jquery.sparkline.min.js"></script>
    <script src="<?= base_url('tinydash-master') ?>/js/apexcharts.min.js"></script>
    <script src="<?= base_url('tinydash-master') ?>/js/apexcharts.custom.js"></script>
    <script src="<?= base_url('tinydash-master') ?>/js/apps.js"></script>
    <!-- Global site tag (gtag.js) - Google Analytics -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=UA-56159088-1"></script>
    <script>
        window.dataLayer = window.dataLayer || [];

        function gtag() {
            dataLayer.push(arguments);
        }
        gtag('js', new Date());
        gtag('config', 'UA-56159088-1');
    </script>

    <?= $this->renderSection('scripts') ?>


    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <!-- SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <?php if (session()->getFlashdata('success')): ?>
        <script>
            Swal.fire({
                icon: 'success',
                title: 'Berhasil Login!',
                text: '<?= session()->getFlashdata('success') ?>',
                padding: '2em',
                confirmButtonText: 'OK',
                customClass: { // <-- TAMBAHKAN INI
                    popup: 'swal-custom-popup'
                }
            });
        </script>
    <?php endif; ?>
</body>

</html>