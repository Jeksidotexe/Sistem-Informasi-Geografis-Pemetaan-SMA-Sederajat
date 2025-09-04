<?= $this->extend('layouts/master') ?>

<?= $this->section('container') ?>
<div class="container-fluid">
    <!-- Header Halaman dengan Tanggal -->
    <div class="row justify-content-center">
        <div class="col">
            <h2 class="h3 mb-4 page-title">Dashboard</h2>
        </div>
        <div class="col-auto">
            <form class="form-inline">
                <div class="form-group d-none d-lg-inline">
                    <div class="px-2 py-2 text-muted">
                        <i class="fe fe-calendar fe-16"></i>
                        <span class="small ml-2" id="current-date">Memuat tanggal...</span>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Card Statistik dengan Ikon Baru -->
    <div class="row">
        <div class="col-md-6 col-xl-3 mb-4">
            <div class="card shadow border-0">
                <div class="card-body">
                    <div class="row align-items-center">
                        <div class="col-3 text-center">
                            <span class="circle circle-sm bg-primary">
                                <i class="fe fe-map-pin fe-16 text-white"></i>
                            </span>
                        </div>
                        <div class="col pr-0">
                            <p class="small text-muted mb-0">Total Kecamatan</p>
                            <span class="h3 mb-0" id="total-kecamatan">0</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-6 col-xl-3 mb-4">
            <div class="card shadow border-0">
                <div class="card-body">
                    <div class="row align-items-center">
                        <div class="col-3 text-center">
                            <span class="circle circle-sm bg-primary">
                                <i class="fe fe-map fe-16 text-white"></i>
                            </span>
                        </div>
                        <div class="col pr-0">
                            <p class="small text-muted mb-0">Total Desa</p>
                            <span class="h3 mb-0" id="total-desa">0</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-6 col-xl-3 mb-4">
            <div class="card shadow border-0">
                <div class="card-body">
                    <div class="row align-items-center">
                        <div class="col-3 text-center">
                            <span class="circle circle-sm bg-success">
                                <i class="fe fe-home fe-16 text-white"></i>
                            </span>
                        </div>
                        <div class="col pr-0">
                            <p class="small text-muted mb-0">Sekolah Negeri</p>
                            <span class="h3 mb-0" id="total-negeri">0</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-6 col-xl-3 mb-4">
            <div class="card shadow border-0">
                <div class="card-body">
                    <div class="row align-items-center">
                        <div class="col-3 text-center">
                            <span class="circle circle-sm bg-warning">
                                <i class="fe fe-briefcase fe-16 text-white"></i>
                            </span>
                        </div>
                        <div class="col pr-0">
                            <p class="small text-muted mb-0">Sekolah Swasta</p>
                            <span class="h3 mb-0" id="total-swasta">0</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Card dengan ikon Iconify baru dan terpusat -->
        <div class="col-md-6 col-xl-3 mb-4">
            <div class="card shadow border-0">
                <div class="card-body">
                    <div class="row align-items-center">
                        <div class="col-3 text-center">
                            <span class="circle circle-sm" style="background-color: #4e73df; display: flex; align-items: center; justify-content: center;">
                                <iconify-icon icon="mdi:school-outline" class="text-white" style="font-size: 20px;"></iconify-icon>
                            </span>
                        </div>
                        <div class="col pr-0">
                            <p class="small text-muted mb-0">Total SMA</p>
                            <span class="h3 mb-0" id="total-sma">0</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-6 col-xl-3 mb-4">
            <div class="card shadow border-0">
                <div class="card-body">
                    <div class="row align-items-center">
                        <div class="col-3 text-center">
                            <span class="circle circle-sm" style="background-color: #1cc88a; display: flex; align-items: center; justify-content: center;">
                                <iconify-icon icon="clarity:tools-solid" class="text-white" style="font-size: 20px;"></iconify-icon>
                            </span>
                        </div>
                        <div class="col pr-0">
                            <p class="small text-muted mb-0">Total SMK</p>
                            <span class="h3 mb-0" id="total-smk">0</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-6 col-xl-3 mb-4">
            <div class="card shadow border-0">
                <div class="card-body">
                    <div class="row align-items-center">
                        <div class="col-3 text-center">
                            <span class="circle circle-sm" style="background-color: #f6c23e; display: flex; align-items: center; justify-content: center;">
                                <iconify-icon icon="mdi:islam" class="text-white" style="font-size: 20px;"></iconify-icon>
                            </span>
                        </div>
                        <div class="col pr-0">
                            <p class="small text-muted mb-0">Total MA</p>
                            <span class="h3 mb-0" id="total-ma">0</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-6 col-xl-3 mb-4">
            <div class="card shadow border-0">
                <div class="card-body">
                    <div class="row align-items-center">
                        <div class="col-3 text-center">
                            <span class="circle circle-sm" style="background-color: #e74a3b; display: flex; align-items: center; justify-content: center;">
                                <iconify-icon icon="mdi:human-handsup" class="text-white" style="font-size: 20px;"></iconify-icon>
                            </span>
                        </div>
                        <div class="col pr-0">
                            <p class="small text-muted mb-0">Total SLB</p>
                            <span class="h3 mb-0" id="total-slb">0</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Chart Section (Tidak Berubah) -->
    <div class="row my-4">
        <div class="col-md-12">
            <div class="card shadow">
                <div class="card-header">
                    <strong class="card-title">Jumlah Sekolah per Kecamatan</strong>
                </div>
                <div class="card-body">
                    <div class="chart-box">
                        <div id="Chart"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script>
    $(document).ready(function() {
        // --- FUNGSI BARU: Menampilkan Tanggal ---
        function displayCurrentDate() {
            const options = {
                weekday: 'long',
                year: 'numeric',
                month: 'long',
                day: 'numeric'
            };
            document.getElementById('current-date').innerText = new Date().toLocaleDateString('id-ID', options);
        }

        // Fungsi loadStatData (Tidak berubah)
        function loadStatData() {
            $.ajax({
                url: "<?= base_url('dashboard/getData') ?>",
                method: 'GET',
                dataType: 'json',
                success: function(response) {
                    if (response.success && response.data) {
                        const data = response.data;
                        $('#total-kecamatan').text(data.total_kecamatan || 0);
                        $('#total-desa').text(data.total_desa || 0);
                        $('#total-negeri').text(data.total_negeri || 0);
                        $('#total-swasta').text(data.total_swasta || 0);
                        $('#total-sma').text(data.total_sma || 0);
                        $('#total-smk').text(data.total_smk || 0);
                        $('#total-ma').text(data.total_ma || 0);
                        $('#total-slb').text(data.total_slb || 0);
                    }
                },
                error: function(xhr, status, error) {
                    console.error("Error fetching stat data: ", error);
                }
            });
        }

        // Fungsi loadChartData (Tidak berubah)
        function loadChartData() {
            $.ajax({
                url: "<?= base_url('dashboard/getChartData') ?>",
                method: 'GET',
                dataType: 'json',
                success: function(response) {
                    if (response.success && response.data && response.data.length > 0) {
                        const chartData = response.data;
                        let categories = [],
                            seriesSma = [],
                            seriesSmk = [],
                            seriesMa = [],
                            seriesSlb = [];
                        chartData.forEach(item => {
                            categories.push(item.nama_kecamatan);
                            seriesSma.push(parseInt(item.total_sma) || 0);
                            seriesSmk.push(parseInt(item.total_smk) || 0);
                            seriesMa.push(parseInt(item.total_ma) || 0);
                            seriesSlb.push(parseInt(item.total_slb) || 0);
                        });
                        renderBarChart(categories, seriesSma, seriesSmk, seriesMa, seriesSlb);
                    } else {
                        document.querySelector("#Chart").innerHTML = '<div class="text-center p-4 text-muted">Tidak ada data untuk ditampilkan.</div>';
                    }
                },
                error: function(xhr, status, error) {
                    console.error("Error fetching chart data: ", error);
                    document.querySelector("#Chart").innerHTML = '<div class="text-center p-4 text-danger">Gagal memuat data chart.</div>';
                }
            });
        }

        // Fungsi renderBarChart (Tidak berubah)
        function renderBarChart(categories, sma, smk, ma, slb) {
            document.querySelector("#Chart").innerHTML = '';
            var options = {
                series: [{
                    name: 'SMA',
                    data: sma
                }, {
                    name: 'SMK',
                    data: smk
                }, {
                    name: 'MA',
                    data: ma
                }, {
                    name: 'SLB',
                    data: slb
                }],
                chart: {
                    type: 'bar',
                    height: 400,
                    fontFamily: 'Overpass, sans-serif',
                    toolbar: {
                        show: false
                    },
                    animations: {
                        enabled: true,
                        speed: 800,
                        animateGradually: {
                            enabled: true,
                            delay: 150
                        },
                        dynamicAnimation: {
                            enabled: true,
                            speed: 350
                        }
                    }
                },
                plotOptions: {
                    bar: {
                        horizontal: false,
                        Width: '75%',
                        borderRadius: 8,
                        dataLabels: {
                            position: 'top'
                        },
                    },
                },
                dataLabels: {
                    enabled: false
                },
                stroke: {
                    show: true,
                    width: 2,
                    colors: ['transparent']
                },
                grid: {
                    borderColor: '#e7e7e7',
                    strokeDashArray: 4
                },
                xaxis: {
                    categories: categories,
                    labels: {
                        style: {
                            colors: '#6c757d',
                            fontSize: '13px'
                        }
                    }
                },
                yaxis: {
                    title: {
                        text: 'Jumlah Sekolah',
                        style: {
                            color: '#6c757d'
                        }
                    },
                    labels: {
                        formatter: function(val) {
                            return val.toFixed(0);
                        }
                    }
                },
                fill: {
                    type: 'gradient',
                    gradient: {
                        shade: 'light',
                        type: "vertical",
                        shadeIntensity: 0.25,
                        inverseColors: true,
                        opacityFrom: 0.85,
                        opacityTo: 0.85,
                        stops: [95, 0, 100]
                    }
                },
                tooltip: {
                    theme: 'dark',
                    y: {
                        formatter: function(val) {
                            return val + " sekolah"
                        }
                    }
                },
                colors: ['#4e73df', '#1cc88a', '#f6c23e', '#e74a3b'],
                legend: {
                    position: 'top',
                    horizontalAlign: 'right',
                    offsetY: -5
                }
            };
            var chart = new ApexCharts(document.querySelector("#Chart"), options);
            chart.render();
        }

        // Panggil semua fungsi saat halaman dimuat
        displayCurrentDate(); // Memanggil fungsi tanggal
        loadStatData();
        loadChartData();
    });
</script>
<?= $this->endSection() ?>