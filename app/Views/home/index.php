<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <title>Peta Sebaran Sekolah</title>
    <meta name="description" content="">
    <meta name="keywords" content="">

    <link href="<?= base_url('img/lambang-kabupaten-sambas.png') ?>" rel="icon">
    <link href="<?= base_url('img/lambang-kabupaten-sambas.png') ?>" rel="apple-touch-icon">

    <link href="https://fonts.googleapis.com" rel="preconnect">
    <link href="https://fonts.gstatic.com" rel="preconnect" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&family=Raleway:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&family=Inter:wght@100;200;300;400;500;600;700;800;900&display=swap" rel="stylesheet">

    <link href="<?= base_url('Dewi-1.0.0') ?>/assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="<?= base_url('Dewi-1.0.0') ?>/assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
    <link href="<?= base_url('Dewi-1.0.0') ?>/assets/vendor/aos/aos.css" rel="stylesheet">
    <link href="<?= base_url('Dewi-1.0.0') ?>/assets/vendor/glightbox/css/glightbox.min.css" rel="stylesheet">
    <link href="<?= base_url('Dewi-1.0.0') ?>/assets/vendor/swiper/swiper-bundle.min.css" rel="stylesheet">

    <link href="<?= base_url('Dewi-1.0.0') ?>/assets/css/main.css" rel="stylesheet">

    <link href="https://api.mapbox.com/mapbox-gl-js/v3.4.0/mapbox-gl.css" rel="stylesheet">

    <style>
        #map {
            height: 800px;
            width: 100%;
        }

        .mapboxgl-ctrl-bottom-right .filter-control-container {
            margin: 10px;
        }

        .filter-control-container {
            background-color: white;
            padding: 10px 15px;
            border-radius: 5px;
            box-shadow: 0 1px 5px rgba(0, 0, 0, 0.4);
            width: 250px;
        }

        .filter-control-container h5 {
            margin-top: 0;
            margin-bottom: 15px;
            font-size: 16px;
        }

        .filter-group {
            margin-bottom: 10px;
        }

        .filter-control-container .form-label {
            margin-bottom: 8px;
            font-weight: bold;
            font-size: 14px;
            display: block;
        }

        .checkbox-item {
            display: flex;
            align-items: center;
            margin-bottom: 8px;
        }

        .checkbox-item input[type="checkbox"] {
            margin-right: 8px;
            width: 16px;
            height: 16px;
            cursor: pointer;
        }

        .checkbox-item label {
            font-size: 14px;
            cursor: pointer;
            flex-grow: 1;
        }

        @media (max-width: 768px) {
            #map {
                height: 70vh;
            }

            .mapboxgl-ctrl-bottom-right {
                right: 0;
                bottom: 0;
                left: 0;
                width: 100%;
                display: flex;
                justify-content: center;
            }

            .filter-control-container {
                width: calc(100% - 20px);
                margin-bottom: 10px;
                box-sizing: border-box;
            }

            .filter-toggle {
                cursor: pointer;
            }

            .filter-toggle::after {
                content: '\F282';
                font-family: 'bootstrap-icons';
                font-size: 14px;
                transition: transform 0.3s ease;
            }

            .filter-content {
                max-height: 200px;
                overflow-y: auto;
                transition: max-height 0.3s ease-in-out, visibility 0.3s;
                visibility: visible;
            }

            .filter-control-container:not(.is-open) .filter-content {
                max-height: 0;
                visibility: hidden;
                margin-top: -15px;
            }

            .filter-control-container:not(.is-open) .filter-toggle::after {
                transform: rotate(180deg);
            }
        }
    </style>
</head>

<body class="index-page">

    <header id="header" class="header d-flex align-items-center fixed-top">
        <div class="container-fluid container-xl position-relative d-flex align-items-center">
            <a href="<?= base_url('/') ?>" class="logo d-flex align-items-center me-auto">
                <h1 class="sitename">Sistem Informasi Geografis</h1>
            </a>
            <nav id="navmenu" class="navmenu">
                <ul>
                    <li><a href="#home" class="active">Home</a></li>
                    <li><a href="#peta">Peta</a></li>
                    <li><a href="#kontak">Kontak</a></li>
                    <li><a href="<?= base_url('profil') ?>">Profil</a></li>
                </ul>
                <i class="mobile-nav-toggle d-xl-none bi bi-list"></i>
            </nav>
            <a class="cta-btn" href="<?= base_url('login') ?>">Login</a>
        </div>
    </header>

    <main class="main">
        <section id="home" class="hero section dark-background">
            <img src="<?= base_url('img/home-bg.jpg') ?>" alt="" data-aos="fade-in">
            <div class="container d-flex flex-column align-items-center">
                <h2 data-aos="fade-up" data-aos-delay="100">Sebaran Sekolah</h2>
                <p data-aos="fade-up" data-aos-delay="200" class="text-center">Sistem Informasi Geografis untuk melihat lokasi sekolah menengah atas/sederajat di Kabupaten Sambas</p>
                <div class="d-flex mt-4" data-aos="fade-up" data-aos-delay="300">
                    <a href="#peta" class="btn-get-started">Lihat Peta</a>
                </div>
            </div>
        </section>

        <section id="peta" class="about section">
            <!-- Section Title -->
            <div class="container section-title" data-aos="fade-up">
                <h2>PETA</h2>
            </div><!-- End Section Title -->
            <div class="container" data-aos="fade-up">
                <div class="row justify-content-center">
                    <div class="col-12">
                        <div class="card shadow">
                            <div class="card-body position-relative p-0">
                                <div id="map" style="border-radius: 8px;"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <section id="kontak" class="contact section">

            <div class="container section-title" data-aos="fade-up">
                <h2>Kontak</h2>
            </div>
            <div class="container" data-aos="fade-up" data-aos-delay="100">

                <div class="row gy-4">
                    <div class="col-lg-6 ">
                        <div class="row gy-4">

                            <div class="col-lg-12">
                                <div class="info-item d-flex flex-column justify-content-center align-items-center" data-aos="fade-up" data-aos-delay="200">
                                    <i class="bi bi-geo-alt"></i>
                                    <h3>Alamat</h3>
                                    <p>Desa Sekura, Teluk Keramat, Kab. Sambas, kalimantan Barat, ID 79465</p>
                                </div>
                            </div><!-- End Info Item -->

                            <div class="col-md-6">
                                <div class="info-item d-flex flex-column justify-content-center align-items-center" data-aos="fade-up" data-aos-delay="300">
                                    <i class="bi bi-telephone"></i>
                                    <h3>Telepon</h3>
                                    <p>+62 8957 0491 9719</p>
                                </div>
                            </div><!-- End Info Item -->

                            <div class="col-md-6">
                                <div class="info-item d-flex flex-column justify-content-center align-items-center" data-aos="fade-up" data-aos-delay="400">
                                    <i class="bi bi-envelope"></i>
                                    <h3>Email</h3>
                                    <p>zakiptk1@gmail.com</p>
                                </div>
                            </div><!-- End Info Item -->

                        </div>
                    </div>

                    <div class="col-lg-6">
                        <form action="<?= site_url('kontak/kirim') ?>" method="post" class="php-email-form" id="contact-form" data-aos="fade-up" data-aos-delay="200">
                            <div class="row gy-4">
                                <div class="col-md-6">
                                    <input type="text" name="nama" class="form-control" placeholder="Nama Anda">
                                </div>
                                <div class="col-md-6">
                                    <input type="email" class="form-control" name="email" placeholder="Email Anda">
                                </div>
                                <div class="col-md-12">
                                    <input type="text" class="form-control" name="subjek" placeholder="Subjek">
                                </div>
                                <div class="col-md-12">
                                    <textarea class="form-control" name="pesan" rows="4" placeholder="Pesan"></textarea>
                                </div>
                                <div class="col-md-12 text-center">
                                    <button type="submit">Kirim Pesan</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </section>
    </main>

    <footer id="footer" class="footer dark-background">
        <div class="container copyright text-center mt-4">
            <p>&copy; <span>Copyright <?= date('Y') ?>.</span> <strong class="px-1 sitename">Peta Sekolah Kab. Sambas</strong>. <span>All Rights Reserved</span></p>
        </div>
    </footer>

    <a href="#" id="scroll-top" class="scroll-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>
    <div id="preloader"></div>

    <script src="<?= base_url('Dewi-1.0.0') ?>/assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="<?= base_url('Dewi-1.0.0') ?>/assets/vendor/php-email-form/validate.js"></script>
    <script src="<?= base_url('Dewi-1.0.0') ?>/assets/vendor/aos/aos.js"></script>
    <script src="<?= base_url('Dewi-1.0.0') ?>/assets/vendor/glightbox/js/glightbox.min.js"></script>
    <script src="<?= base_url('Dewi-1.0.0') ?>/assets/vendor/purecounter/purecounter_vanilla.js"></script>
    <script src="<?= base_url('Dewi-1.0.0') ?>/assets/vendor/swiper/swiper-bundle.min.js"></script>
    <script src="<?= base_url('Dewi-1.0.0') ?>/assets/vendor/imagesloaded/imagesloaded.pkgd.min.js"></script>
    <script src="<?= base_url('Dewi-1.0.0') ?>/assets/vendor/isotope-layout/isotope.pkgd.min.js"></script>
    <script src="<?= base_url('Dewi-1.0.0') ?>/assets/js/main.js"></script>

    <script src="https://api.mapbox.com/mapbox-gl-js/v3.4.0/mapbox-gl.js"></script>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        // --- 1. INISIALISASI PETA MAPBOX ---
        mapboxgl.accessToken = 'pk.eyJ1IjoieXVzaGFybmFkaSIsImEiOiJjazd2YThmNGgwcTM5M2xtODhvYXg0emtrIn0.mKu3Skdm9aJrFqaWwbK0OA'; // <-- PENTING! Ganti dengan token Anda

        const mapCenter = [108.9994734, 1.4877089]; // Mapbox menggunakan [longitude, latitude]
        const mapZoom = 9;
        const map = new mapboxgl.Map({
            container: 'map',
            // style: 'mapbox://styles/mapbox/dark-v10',
            style: 'mapbox://styles/mapbox/light-v10',
            center: mapCenter,
            zoom: mapZoom
        });

        // Add geolocation control. This is generally good practice.
        var nav = new mapboxgl.NavigationControl();
        map.addControl(nav, 'top-left');

        map.addControl(new mapboxgl.FullscreenControl());
        map.addControl(new mapboxgl.GeolocateControl({
            positionOptions: {
                enableHighAccuracy: true
            },
            trackUserLocation: true,
            showUserHeading: true
        }));

        // --- State & Variabel Global untuk Peta ---
        const baseUrl = '<?= site_url('home/sekolah-json') ?>';
        let currentFilters = {
            jenjang: [],
            status: ['Negeri', 'Swasta']
        };

        // ===== 2. CUSTOM MAPBOX CONTROL UNTUK FILTER =====
        class FilterControl {
            onAdd(map) {
                this._map = map;
                this._container = document.createElement('div');
                this._container.className = 'mapboxgl-ctrl filter-control-container';
                this._container.innerHTML = `
                <h5 class="filter-toggle"><i class="bi bi-funnel-fill"></i> Filter</h5>
                <div class="filter-content">
                    <div class="filter-group">
                        <label class="form-label">Jenjang Pendidikan</label>
                        <div id="jenjang-checkboxes"></div>
                    </div>
                    <div class="filter-group">
                        <label class="form-label">Status Sekolah</label>
                        <div id="status-checkboxes">
                            <div class="checkbox-item">
                                <input type="checkbox" id="status-negeri" value="Negeri" data-filter-type="status" checked>
                                <label for="status-negeri">Negeri</label>
                            </div>
                            <div class="checkbox-item">
                                <input type="checkbox" id="status-swasta" value="Swasta" data-filter-type="status" checked>
                                <label for="status-swasta">Swasta</label>
                            </div>
                        </div>
                        <label class="form-label">Legenda</label>
                        <div style="display: flex; align-items: center; margin-bottom: 5px;">
                            <span style="height: 15px; width: 15px; background-color: #007bff; border-radius: 50%; display: inline-block; margin-right: 8px; border: 1px solid #fff;"></span>
                            <span>Negeri</span>
                        </div>
                        <div style="display: flex; align-items: center;">
                            <span style="height: 15px; width: 15px; background-color: #F35632; border-radius: 50%; display: inline-block; margin-right: 8px; border: 1px solid #fff;"></span>
                            <span>Swasta</span>
                        </div>
                    </div>
                </div>
            `;

                // Hentikan propagasi event agar interaksi dengan filter tidak menggerakkan peta
                this._container.addEventListener('contextmenu', (e) => e.preventDefault());
                this._container.addEventListener('mousedown', (e) => e.stopPropagation());

                // PERBAIKAN: Pasang event listener 'change' di sini, bukan di 'document'
                // Ini memastikan listener hanya aktif pada kontrol ini dan tidak konflik dengan skrip lain.
                this._container.addEventListener('change', (e) => {
                    if (e.target.matches('input[type="checkbox"]')) {
                        const checkbox = e.target;
                        const filterType = checkbox.dataset.filterType;
                        const filterValue = checkbox.value;

                        if (checkbox.checked) {
                            currentFilters[filterType].push(filterValue);
                        } else {
                            currentFilters[filterType] = currentFilters[filterType].filter(item => item !== filterValue);
                        }
                        applyFilters();
                    }
                });

                // Logika toggle untuk mobile
                const toggle = this._container.querySelector('.filter-toggle');
                if (toggle) {
                    toggle.addEventListener('click', () => {
                        this._container.classList.toggle('is-open');
                    });
                }
                // Buka filter secara default di desktop
                if (window.innerWidth > 768) {
                    this._container.classList.add('is-open');
                }

                return this._container;
            }

            onRemove() {
                this._container.parentNode.removeChild(this._container);
                this._map = undefined;
            }
        }

        // --- Fungsi yang akan dipanggil saat peta selesai dimuat ---
        map.on('load', () => {
            // Tambahkan kontrol filter kustom ke peta
            map.addControl(new FilterControl(), 'bottom-right');

            // Setup sumber data dan layer untuk marker & cluster
            map.addSource('sekolah', {
                type: 'geojson',
                data: {
                    "type": "FeatureCollection",
                    "features": []
                },
                cluster: false,
                clusterMaxZoom: 14,
                clusterRadius: 50
            });

            // Layer untuk lingkaran cluster
            map.addLayer({
                id: 'clusters',
                type: 'circle',
                source: 'sekolah',
                filter: ['has', 'point_count'],
                paint: {
                    'circle-color': ['step', ['get', 'point_count'], '#51bbd6', 100, '#f1f075', 750, '#f28cb1'],
                    'circle-radius': ['step', ['get', 'point_count'], 20, 100, 30, 750, 40]
                }
            });

            // Layer untuk teks (jumlah) di dalam cluster
            map.addLayer({
                id: 'cluster-count',
                type: 'symbol',
                source: 'sekolah',
                filter: ['has', 'point_count'],
                layout: {
                    'text-field': '{point_count_abbreviated}',
                    'text-font': ['DIN Offc Pro Medium', 'Arial Unicode MS Bold'],
                    'text-size': 12
                }
            });

            // Layer untuk titik/marker yang tidak di-cluster
            map.addLayer({
                id: 'unclustered-point',
                type: 'circle',
                source: 'sekolah',
                filter: ['!', ['has', 'point_count']],
                paint: {
                    // --- PERUBAHAN DI SINI ---
                    'circle-color': [
                        'match',
                        ['get', 'status'], // Ambil nilai dari properti 'status'
                        'Negeri', '#007bff', // Jika nilainya 'Negeri', beri warna biru
                        'Swasta', '#F35632', // Jika nilainya 'Swasta', beri warna hijau
                        '#6c757d' // Warna default jika status tidak ada/berbeda
                    ],
                    // --- BATAS PERUBAHAN ---
                    'circle-radius': 8, // Sedikit diperbesar agar lebih jelas
                    'circle-stroke-width': 1,
                    'circle-stroke-color': '#fff'
                }
            });

            // === Event Listeners untuk Interaksi Peta ===

            // Klik pada cluster untuk zoom
            map.on('click', 'clusters', (e) => {
                const features = map.queryRenderedFeatures(e.point, {
                    layers: ['clusters']
                });
                const clusterId = features[0].properties.cluster_id;
                map.getSource('sekolah').getClusterExpansionZoom(clusterId, (err, zoom) => {
                    if (err) return;
                    map.easeTo({
                        center: features[0].geometry.coordinates,
                        zoom: zoom
                    });
                });
            });

            // Klik pada titik untuk menampilkan popup
            map.on('click', 'unclustered-point', (e) => {
                const coordinates = e.features[0].geometry.coordinates.slice();
                const properties = e.features[0].properties;

                while (Math.abs(e.lngLat.lng - coordinates[0]) > 180) {
                    coordinates[0] += e.lngLat.lng > coordinates[0] ? 360 : -360;
                }

                const fotoUrl = properties.foto ? `<?= base_url('foto_sekolah/') ?>${properties.foto}` : '<?= base_url('foto_sekolah/default.png') ?>';
                const popupContent = `
               <div style="max-width: 300px; font-family: Arial, sans-serif;">
                <img src="${fotoUrl}" alt="Foto Sekolah" style="width:100%; aspect-ratio: 4 / 3; object-fit: cover; border-radius: 5px;">
                <h5 style="margin-top: 10px; margin-bottom: 8px; font-weight: bold;">${properties.nama_sekolah || 'Nama Sekolah'}</h5>
                <div style="font-size: 14px; line-height: 1.6;">
                    <strong>NPSN:</strong> ${properties.npsn || '-'}<br>
                    <strong>Kepala Sekolah:</strong> ${properties.nama_kepsek || '-'}<br>
                    <strong>Operator:</strong> ${properties.nama_operator || '-'}<br> <strong>Status:</strong> ${properties.status || '-'}<br>
                    <strong>Akreditasi:</strong> ${properties.akreditasi || '-'}<br>
                    <hr style="margin: 6px 0;">
                    <strong>Alamat:</strong> ${properties.alamat || '-'}<br>
                    <strong>Desa/Kelurahan:</strong> ${properties.nama_desa || '-'}<br>
                    <strong>Kecamatan:</strong> ${properties.nama_kecamatan || '-'}
                </div>
            </div>`;

                new mapboxgl.Popup().setLngLat(coordinates).setHTML(popupContent).addTo(map);
            });

            // Ubah cursor menjadi pointer saat hover
            map.on('mouseenter', 'clusters', () => {
                map.getCanvas().style.cursor = 'pointer';
            });
            map.on('mouseleave', 'clusters', () => {
                map.getCanvas().style.cursor = '';
            });
            map.on('mouseenter', 'unclustered-point', () => {
                map.getCanvas().style.cursor = 'pointer';
            });
            map.on('mouseleave', 'unclustered-point', () => {
                map.getCanvas().style.cursor = '';
            });

            // Pemuatan data awal setelah peta & kontrol filter siap
            populateJenjangCheckboxes().then(() => {
                applyFilters();
            });
        });

        // --- Fungsi untuk memuat data sekolah (dimodifikasi untuk Mapbox) ---
        function loadSekolahData(url) {
            const sekolahSource = map.getSource('sekolah');
            if (!sekolahSource) {
                return;
            }

            if (!url.includes('?')) {
                sekolahSource.setData({
                    "type": "FeatureCollection",
                    "features": []
                });
                return;
            }

            fetch(url)
                .then(response => response.json())
                .then(sekolahData => {
                    const geojsonFeatures = sekolahData.map(sekolah => ({
                        type: 'Feature',
                        geometry: {
                            type: 'Point',
                            coordinates: [sekolah.longitude, sekolah.latitude]
                        },
                        properties: sekolah
                    }));
                    sekolahSource.setData({
                        type: 'FeatureCollection',
                        features: geojsonFeatures
                    });
                })
                .catch(error => console.error('Gagal memuat data sekolah:', error));
        }

        // --- Fungsi untuk mengisi checkbox jenjang (TIDAK BERUBAH) ---
        function populateJenjangCheckboxes() {
            // Kontrol filter baru ditambahkan di map.on('load'), jadi kita harus mencari elemennya di sana.
            const container = document.getElementById('jenjang-checkboxes');
            // Tambahkan pengecekan jika container belum ada untuk mencegah error
            if (!container) {
                return Promise.reject("Container checkbox jenjang tidak ditemukan.");
            }
            return fetch('<?= site_url('home/jenjang-json') ?>')
                .then(response => response.json())
                .then(data => {
                    data.forEach(jenjang => {
                        const item = document.createElement('div');
                        item.className = 'checkbox-item';
                        item.innerHTML = `
                        <input type="checkbox" id="jenjang-${jenjang.id_jenjang}" value="${jenjang.id_jenjang}" data-filter-type="jenjang" checked>
                        <label for="jenjang-${jenjang.id_jenjang}">${jenjang.nama_jenjang}</label>
                    `;
                        container.appendChild(item);
                        currentFilters.jenjang.push(jenjang.id_jenjang);
                    });
                })
                .catch(error => console.error('Gagal memuat data jenjang:', error));
        }

        // --- Fungsi untuk menerapkan filter (TIDAK BERUBAH) ---
        function applyFilters() {
            if (currentFilters.jenjang.length === 0 && currentFilters.status.length === 0) {
                const sekolahSource = map.getSource('sekolah');
                if (sekolahSource) {
                    sekolahSource.setData({
                        "type": "FeatureCollection",
                        "features": []
                    });
                }
                return;
            }
            const params = new URLSearchParams();
            currentFilters.jenjang.forEach(id => params.append('jenjang[]', id));
            currentFilters.status.forEach(stat => params.append('status[]', stat));
            const fullUrl = `${baseUrl}?${params.toString()}`;
            loadSekolahData(fullUrl);
        }
    </script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const contactForm = document.getElementById('contact-form');

            contactForm.addEventListener('submit', function(event) {
                event.preventDefault(); // Mencegah form dikirim secara normal

                // Tampilkan notifikasi loading
                Swal.fire({
                    title: 'Mengirim Pesan...',
                    text: 'Mohon tunggu sebentar.',
                    allowOutsideClick: false,
                    didOpen: () => {
                        Swal.showLoading();
                    }
                });

                const formData = new FormData(contactForm);
                const actionUrl = contactForm.getAttribute('action');

                fetch(actionUrl, {
                        method: 'POST',
                        body: formData,
                        headers: {
                            'X-Requested-With': 'XMLHttpRequest' // Penting untuk CI4 isAJAX()
                        }
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.status === 'success') {
                            Swal.fire({
                                icon: 'success',
                                title: 'Berhasil!',
                                text: data.message,
                            });
                            contactForm.reset(); // Kosongkan form setelah berhasil
                        } else if (data.status === 'validation_error') {
                            // Gabungkan semua pesan error, dipisahkan dengan tag line break (<br>)
                            let errorText = Object.values(data.errors).join('<br>');

                            Swal.fire({
                                icon: 'error',
                                title: 'Gagal mengirim pesan!',
                                html: errorText, // Tampilkan pesan error dengan line break
                                customClass: {
                                    htmlContainer: 'text-center'
                                }
                            });
                        } else {
                            // Untuk error lainnya (misal: gagal kirim email)
                            Swal.fire({
                                icon: 'error',
                                title: 'Gagal!',
                                text: data.message,
                            });
                        }
                    })
                    .catch(error => {
                        console.error('Fetch Error:', error);
                        Swal.fire({
                            icon: 'error',
                            title: 'Koneksi Bermasalah',
                            text: 'Tidak dapat terhubung ke server. Silakan coba lagi.',
                        });
                    });
            });
        });
    </script>
</body>

</html>