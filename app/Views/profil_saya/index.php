<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Profil Saya</title>

    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link
        href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600&display=swap"
        rel="stylesheet" />

    <link
        rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" />

    <link rel="stylesheet" href="<?= base_url('profile/styles.css') ?>" />
</head>

<body>
    <main class="profile-card">
        <div class="card-header">
            <img src="<?= base_url($foto_profil) ?>" alt="Foto Profil" class="profile-picture" />
        </div>

        <div class="card-body">
            <h1 class="profile-name"><?= esc($nama) ?></h1>
            <p class="profile-title"><?= esc($status) ?></p>

            <p class="profile-description">
                <?= esc($deskripsi) ?>
            </p>

            <hr class="separator" />

            <div class="contact-info">
                <div class="contact-item">
                    <i class="fa-solid fa-envelope"></i>
                    <a href="mailto:<?= esc($email) ?>"><?= esc($email) ?></a>
                </div>
                <div class="contact-item">
                    <i class="fa-solid fa-phone"></i>
                    <a href="tel:+6281234567890"><?= esc($telepon) ?></a>
                </div>
                <div class="contact-item">
                    <i class="fa-solid fa-map-marker-alt"></i>
                    <span>Sambas, Kalimantan Barat</span>
                </div>
            </div>
        </div>
    </main>
</body>

</html>