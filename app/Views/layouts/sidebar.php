<aside class="sidebar-left border-right bg-white shadow" id="leftSidebar" data-simplebar>
    <a href="#" class="btn collapseSidebar toggle-btn d-lg-none text-muted ml-2 mt-3" data-toggle="toggle">
        <i class="fe fe-x"><span class="sr-only"></span></i>
    </a>
    <nav class="vertnav navbar navbar-light">
        <div class="w-100 mb-4 d-flex">
            <?php
            // Tentukan URL tujuan berdasarkan peran pengguna
            $dashboard_url = (session('user_role') === 'admin') ? base_url('dashboard') : base_url('sekolah');
            ?>
            <a class="navbar-brand mx-auto mt-2 flex-fill text-left" href="<?= $dashboard_url ?>">
                <img src="<?= base_url('img/logo-dashboard.png') ?>" alt="Logo" class="navbar-brand-img brand-sm" style="width: 180px; height: auto;">
            </a>
        </div>

        <ul class="navbar-nav flex-fill w-100 mb-2">
            <li class="nav-item w-100 <?= (uri_string() === 'dashboard') ? 'active' : '' ?>">
                <a class="nav-link" href="<?= base_url('dashboard') ?>">
                    <i class="fe fe-home fe-16"></i>
                    <span class="ml-3 item-text">Dashboard</span>
                </a>
            </li>
        </ul>

        <p class="text-muted nav-heading mt-4 mb-1">
            <span>DATA MASTER</span>
        </p>
        <ul class="navbar-nav flex-fill w-100 mb-2">
            <?php if (session('user_role') === 'admin') : ?>
                <li class="nav-item w-100 <?= (uri_string() === 'kecamatan') ? 'active' : '' ?>">
                    <a class="nav-link" href="<?= base_url('kecamatan') ?>">
                        <i class="fe fe-map fe-16"></i>
                        <span class="ml-3 item-text">Kecamatan</span>
                    </a>
                </li>
                <li class="nav-item w-100 <?= (uri_string() === 'desa') ? 'active' : '' ?>">
                    <a class="nav-link" href="<?= base_url('desa') ?>">
                        <i class="fe fe-map-pin fe-16"></i>
                        <span class="ml-3 item-text">Desa</span>
                    </a>
                </li>
                <li class="nav-item w-100 <?= (uri_string() === 'jenjang_pendidikan') ? 'active' : '' ?>">
                    <a class="nav-link" href="<?= base_url('jenjang_pendidikan') ?>">
                        <i class="fe fe-layers fe-16"></i>
                        <span class="ml-3 item-text">Jenjang Pendidikan</span>
                    </a>
                </li>
            <?php endif; ?>

            <li class="nav-item w-100 <?= (strpos(uri_string(), 'sekolah') !== false) ? 'active' : '' ?>">
                <a class="nav-link" href="<?= base_url('sekolah') ?>">
                    <i class="fe fe-book-open fe-16"></i>
                    <span class="ml-3 item-text">Sekolah</span>
                </a>
            </li>
            <li class="nav-item w-100 <?= (strpos(uri_string(), 'kepala_sekolah') !== false) ? 'active' : '' ?>">
                <a class="nav-link" href="<?= base_url('kepala_sekolah') ?>">
                    <i class="fe fe-user-check fe-16"></i>
                    <span class="ml-3 item-text">Kepala Sekolah</span>
                </a>
            </li>
        </ul>

        <?php if (session('user_role') === 'admin') : ?>
            <p class="text-muted nav-heading mt-4 mb-1">
                <span>PENGGUNA</span>
            </p>
            <ul class="navbar-nav flex-fill w-100 mb-2">
                <li class="nav-item w-100 <?= (uri_string() === 'operator') ? 'active' : '' ?>">
                    <a class="nav-link" href="<?= base_url('operator') ?>">
                        <i class="fe fe-users fe-16"></i>
                        <span class="ml-3 item-text">Operator</span>
                    </a>
                </li>
            </ul>
        <?php endif; ?>

        <p class="text-muted nav-heading mt-4 mb-1">
            <span>SISTEM</span>
        </p>
        <ul class="navbar-nav flex-fill w-100 mb-2">
            <li class="nav-item w-100">
                <a class="nav-link" href="<?= base_url('logout') ?>">
                    <i class="fe fe-log-out fe-16"></i>
                    <span class="ml-3 item-text">Log Out</span>
                </a>
            </li>
        </ul>
    </nav>
</aside>