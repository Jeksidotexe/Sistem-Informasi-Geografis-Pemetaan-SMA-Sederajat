<?= $this->extend('layouts/master') ?>

<?= $this->section('container') ?>
<style>
    .foto-sekolah-tabel {
        width: 80px;
        /* Lebar bisa disesuaikan, untuk 1:1, 80px atau 100px cukup bagus */
        aspect-ratio: 1 / 1;
        /* Diubah menjadi 1:1 untuk rasio persegi (kotak) */
        object-fit: cover;
        border-radius: 8px;
        /* Ditingkatkan sedikit agar terlihat lebih bagus sebagai persegi */
        background-color: #e9ecef;
    }
</style>

<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-12">
            <h2 class="mb-2 page-title"><?= esc($title) ?></h2>
            <div class="row my-4">
                <div class="col-md-12">
                    <div class="card shadow">
                        <form action="<?= site_url('sekolah/cetak') ?>" method="post" id="form-cetak" target="_blank">
                            <div class="card-header">
                                <?php if (session('user_role') === 'admin') : ?>
                                    <button type="button" class="btn btn-primary btn-sm" onclick="addForm()">
                                        <i class="fe fe-plus"></i> Tambah
                                    </button>
                                    <button type="submit" class="btn btn-success btn-sm" id="btn-cetak" disabled>
                                        <i class="fe fe-printer"></i> Cetak Data
                                    </button>
                                <?php endif; ?>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table datatables" id="table-sekolah" style="width:100%">
                                        <thead>
                                            <tr>
                                                <th width="5%">
                                                    <input type="checkbox" id="select_all">
                                                </th>
                                                <th width="5%">No</th>
                                                <th>Nama Sekolah</th>
                                                <th>NPSN</th>
                                                <th>Jenjang</th>
                                                <th>Akreditasi</th>
                                                <th>Alamat</th>
                                                <th>Kecamatan</th>
                                                <th>Desa</th>
                                                <th>Status</th>
                                                <th>Latitude</th>
                                                <th>Longitude</th>
                                                <th>Foto</th>
                                                <th width="10%"><i class="fe fe-settings"></i></th>
                                            </tr>
                                        </thead>
                                    </table>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?= $this->include('sekolah/form') ?>
<?= $this->endSection() ?>


<?= $this->section('scripts') ?>
<script>
    let table;

    function toggleCetakButton() {
        // Hitung jumlah checkbox yang tercentang
        let checkedCount = $('.checkbox-cetak:checked').length;
        // Jika ada minimal 1 yg tercentang, aktifkan tombol. Jika tidak, nonaktifkan.
        $('#btn-cetak').prop('disabled', checkedCount === 0);
    }

    $(document).ready(function() {
        // --- INISIALISASI SELECT2 ---
        const selectJenjang = $('#id_jenjang');
        const selectKecamatan = $('#id_kecamatan');
        const selectDesa = $('#id_desa');

        selectJenjang.select2({
            dropdownParent: $('#modal-form'),
            placeholder: 'Pilih Jenjang Pendidikan',
            allowClear: true,
            ajax: {
                url: "<?= site_url('jenjang_pendidikan/select2') ?>",
                dataType: 'json',
                delay: 250,
                processResults: data => ({
                    results: data
                }),
                cache: true
            }
        });

        selectKecamatan.select2({
            dropdownParent: $('#modal-form'),
            placeholder: 'Pilih Kecamatan',
            allowClear: true,
            ajax: {
                url: "<?= site_url('kecamatan/select2') ?>",
                dataType: 'json',
                delay: 250,
                processResults: data => ({
                    results: data
                }),
                cache: true
            }
        });

        selectDesa.select2({
            dropdownParent: $('#modal-form'),
            placeholder: 'Pilih Desa',
            allowClear: true,
            ajax: {
                url: "<?= site_url('desa/select2') ?>",
                dataType: 'json',
                delay: 250,
                data: params => ({
                    term: params.term || '',
                    id_kecamatan: selectKecamatan.val()
                }), // Kirim id_kecamatan
                processResults: data => ({
                    results: data
                }),
                cache: true
            }
        });

        // --- LOGIKA CASCADING DROPDOWN ---
        selectKecamatan.on('change', function() {
            selectDesa.val(null).trigger('change'); // Reset pilihan desa
            if ($(this).val()) {
                selectDesa.prop('disabled', false); // Aktifkan dropdown desa
            } else {
                selectDesa.prop('disabled', true); // Non-aktifkan jika tidak ada kecamatan dipilih
            }
        });

        // --- INISIALISASI DATATABLE ---
        table = $('#table-sekolah').DataTable({
            responsive: true,
            processing: true,
            serverSide: true,
            ajax: {
                url: "<?= site_url('sekolah/data') ?>",
                type: 'GET'
            },
            columns: [{
                    data: 'checkbox',
                    orderable: false,
                    searchable: false
                }, {
                    data: 'DT_RowIndex',
                    orderable: false,
                    searchable: false
                },
                {
                    data: 'nama_sekolah'
                },
                {
                    data: 'npsn'
                },
                {
                    data: 'nama_jenjang'
                },
                {
                    data: 'akreditasi'
                },
                {
                    data: 'alamat'
                },
                {
                    data: 'nama_kecamatan'
                },
                {
                    data: 'nama_desa'
                },
                {
                    data: 'status'
                },
                {
                    data: 'latitude'
                },
                {
                    data: 'longitude'
                },
                {
                    data: 'foto',
                    orderable: false,
                    searchable: false
                },
                {
                    data: 'aksi',
                    orderable: false,
                    searchable: false
                }
            ],
            "drawCallback": function(settings) {
                toggleCetakButton();
            }
        });

        $('#select_all').on('click', function() {
            // Centang/hapus centang semua checkbox di baris tabel
            $('.checkbox-cetak').prop('checked', this.checked);
            toggleCetakButton(); // Update status tombol cetak
        });

        // Event untuk checkbox di setiap baris data
        $('#table-sekolah tbody').on('click', '.checkbox-cetak', function() {
            // Jika ada satu checkbox yang tidak tercentang, maka "select all" juga tidak tercentang
            if (!this.checked) {
                $('#select_all').prop('checked', false);
            }
            // Cek apakah semua checkbox di halaman ini tercentang
            let allChecked = $('.checkbox-cetak:checked').length === $('.checkbox-cetak').length;
            $('#select_all').prop('checked', allChecked);
            toggleCetakButton(); // Update status tombol cetak
        });

        // --- EVENT LISTENER SUBMIT FORM ---
        $('#modal-form form').on('submit', function(e) {
            e.preventDefault();

            // PENTING: Gunakan FormData karena ada upload file
            let formData = new FormData(this);
            let url = $(this).attr('action');

            $.ajax({
                url: url,
                type: 'POST',
                data: formData,
                processData: false, // Wajib false untuk FormData
                contentType: false, // Wajib false untuk FormData
                success: function(response) {
                    if (response.success) {
                        $('#modal-form').modal('hide');
                        table.ajax.reload();
                        Swal.fire({
                            icon: 'success',
                            title: 'Berhasil',
                            text: response.message,
                            timer: 1500,
                            showConfirmButton: false,
                            customClass: {
                                popup: 'swal-custom-popup'
                            }
                        });
                    } else {
                        let errorMsg = response.errors ? Object.values(response.errors).join('<br>') : (response.message || 'Terjadi kesalahan.');
                        Swal.fire({
                            title: 'Gagal!',
                            icon: 'error',
                            html: errorMsg,
                            showCloseButton: true,
                            confirmButtonText: 'Oke',
                            customClass: {
                                popup: 'swal-custom-popup'
                            }
                        });
                    }
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    Swal.fire('Error', 'Terjadi kesalahan pada server: ' + textStatus, 'error');
                }
            });
        });

        // Tampilkan preview saat memilih file
        $('#foto').on('change', function() {
            const [file] = this.files;
            if (file) {
                $('#foto-preview').attr('src', URL.createObjectURL(file));
                $('#foto-preview-container').show();
            }
        });
    });

    function addForm() {
        $('#modal-form').modal('show');
        $('#modal-form .modal-title').text('Tambah Sekolah');
        $('#modal-form form')[0].reset();
        $('#modal-form form').attr('action', "<?= site_url('sekolah/store') ?>");
        $('#modal-form [name=_method]').val('post');

        // Reset semua Select2 dan elemen lain
        $('#id_sekolah').val('');
        $('#id_jenjang, #id_kecamatan, #id_desa').val(null).trigger('change');
        $('#id_desa').prop('disabled', true);
        $('#foto-preview-container').hide();
    }

    function editForm(id_sekolah) {
        addForm(); // Panggil addForm untuk reset
        $('#modal-form .modal-title').text('Edit Sekolah');
        $('#modal-form form').attr('action', `<?= site_url('sekolah/update/') ?>${id_sekolah}`);
        $('#modal-form [name=_method]').val('post'); // Tetap POST untuk method spoofing

        $.get(`<?= site_url('sekolah/') ?>${id_sekolah}`)
            .done(response => {
                // Isi semua field
                $('#id_sekolah').val(response.id_sekolah);
                $('#nama_sekolah').val(response.nama_sekolah);
                $('#npsn').val(response.npsn);
                $('#akreditasi').val(response.akreditasi);
                $('#status').val(response.status);
                $('#alamat').val(response.alamat);
                $('#latitude').val(response.latitude);
                $('#longitude').val(response.longitude);

                // Pre-fill Select2
                if (response.id_jenjang) {
                    $('#id_jenjang').append(new Option(response.nama_jenjang, response.id_jenjang, true, true)).trigger('change');
                }
                if (response.id_kecamatan) {
                    $('#id_kecamatan').append(new Option(response.nama_kecamatan, response.id_kecamatan, true, true)).trigger('change');
                }
                // Aktifkan desa, lalu pre-fill
                $('#id_desa').prop('disabled', false);
                if (response.id_desa) {
                    $('#id_desa').append(new Option(response.nama_desa, response.id_desa, true, true)).trigger('change');
                }
                // Tampilkan foto yang ada
                if (response.foto) {
                    $('#foto-preview').attr('src', `<?= base_url('foto_sekolah/') ?>${response.foto}`);
                    $('#foto-preview-container').show();
                }
            })
            .fail(() => Swal.fire('Gagal', 'Tidak dapat menampilkan data.', 'error'));
    }

    function deleteData(id_sekolah) {
        Swal.fire({
            title: 'Yakin ingin menghapus?',
            text: "Data akan dihapus permanen!!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonText: 'Batal',
            customClass: {
                popup: 'swal-custom-popup'
            }
        }).then(result => {
            if (result.isConfirmed) {
                $.ajax({
                    url: `<?= site_url('sekolah/destroy/') ?>${id_sekolah}`,
                    method: "DELETE",
                    success: response => {
                        if (response.success) {
                            table.ajax.reload();
                            Swal.fire('Berhasil', response.message, 'success');
                        } else {
                            Swal.fire('Gagal', response.message, 'error');
                        }
                    },
                    error: () => Swal.fire('Error', 'Tidak dapat menghapus data.', 'error')
                });
            }
        });
    }
</script>
<?= $this->endSection() ?>