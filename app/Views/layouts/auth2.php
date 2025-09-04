<!DOCTYPE html>
<html lang="en">

<head>
    <title><?= $title ?></title>
    <!-- Meta -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <!-- Favicon icon -->
    <link rel="icon" href="<?= base_url('img/lambang-kabupaten-sambas.png') ?>" type="image/x-icon">
    <!-- Google font-->
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:400,600,800" rel="stylesheet">
    <!-- Required Fremwork -->
    <link rel="stylesheet" type="text/css" href="<?= base_url('Guruable/') ?>assets/css/bootstrap/css/bootstrap.min.css">
    <!-- themify-icons line icon -->
    <link rel="stylesheet" type="text/css" href="<?= base_url('Guruable/') ?>assets/icon/themify-icons/themify-icons.css">
    <!-- ico font -->
    <link rel="stylesheet" type="text/css" href="<?= base_url('Guruable/') ?>assets/icon/icofont/css/icofont.css">
    <!-- Style.css -->
    <link rel="stylesheet" type="text/css" href="<?= base_url('Guruable/') ?>assets/css/style.css">

    <style>
        .custom-bg {
            background-image: url('<?= base_url('img/bg-2.jpg') ?>');
            /* Path ke gambar Anda */
            background-size: cover;
            /* Agar gambar menutupi seluruh layar */
            background-position: center;
            /* Posisi gambar di tengah */
            background-repeat: no-repeat;
            /* Jangan ulangi gambar */
        }

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

<body class="fix-menu">

    <section class="login p-fixed d-flex text-center bg-primary custom-bg">
        <!-- Container-fluid starts -->
        <div class="container">
            <?= $this->renderSection('login2') ?>
            <!-- end of row -->
        </div>
        <!-- end of container-fluid -->
    </section>

    <!-- Warning Section Ends -->
    <!-- Required Jquery -->
    <script type="text/javascript" src="<?= base_url('Guruable/') ?>assets/js/jquery/jquery.min.js"></script>
    <script type="text/javascript" src="<?= base_url('Guruable/') ?>assets/js/jquery-ui/jquery-ui.min.js"></script>
    <script type="text/javascript" src="<?= base_url('Guruable/') ?>assets/js/popper.js/popper.min.js"></script>
    <script type="text/javascript" src="<?= base_url('Guruable/') ?>assets/js/bootstrap/js/bootstrap.min.js"></script>
    <!-- jquery slimscroll js -->
    <script type="text/javascript" src="<?= base_url('Guruable/') ?>assets/js/jquery-slimscroll/jquery.slimscroll.js"></script>
    <!-- modernizr js -->
    <script type="text/javascript" src="<?= base_url('Guruable/') ?>assets/js/modernizr/modernizr.js"></script>
    <script type="text/javascript" src="<?= base_url('Guruable/') ?>assets/js/modernizr/css-scrollbars.js"></script>
    <script type="text/javascript" src="<?= base_url('Guruable/') ?>assets/js/common-pages.js"></script>

    </script>
    <!-- SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        // Menangani error login (Email/Password salah)
        <?php if (session()->getFlashdata('error')) : ?>
            Swal.fire({
                icon: 'error',
                title: 'Login Gagal',
                text: "<?= session()->getFlashdata('error') ?>",
                confirmButtonColor: '#3085d6',
                customClass: {
                    popup: 'swal-custom-popup'
                }
            });
        <?php endif; ?>

        // ✅ PERBAIKAN: Menangani error validasi dari controller
        <?php if (session()->getFlashdata('errors')) : ?>
            Swal.fire({
                icon: 'error',
                title: 'Oops... Terjadi Kesalahan',
                // Menggabungkan array error menjadi satu string dengan pemisah baris baru
                html: "<?= implode('<br>', session()->getFlashdata('errors')) ?>",
                confirmButtonColor: '#3085d6',
                customClass: {
                    popup: 'swal-custom-popup'
                }
            });
        <?php endif; ?>

        // Menangani pesan sukses
        <?php if (session()->getFlashdata('success')) : ?>
            Swal.fire({
                icon: 'success',
                title: 'Berhasil!',
                text: "<?= session()->getFlashdata('success') ?>",
                timer: 1500, // Notifikasi akan hilang setelah 1.5 detik
                showConfirmButton: false,
                customClass: {
                    popup: 'swal-custom-popup'
                }
            });
        <?php endif; ?>
    </script>
</body>

</html>