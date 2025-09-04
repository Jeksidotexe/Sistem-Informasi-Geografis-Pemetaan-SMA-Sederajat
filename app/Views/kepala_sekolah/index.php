<?= $this->extend('layouts/master') ?>

<?= $this->section('container') ?>
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-12">
            <h2 class="mb-2 page-title"><?= esc($title) ?></h2>
            <div class="row my-4">
                <div class="col-md-12">
                    <div class="card shadow">
                        <div class="card-header">
                            <?php if (session('user_role') === 'admin') : ?>
                                <button class="btn btn-primary btn-sm" onclick="addForm('<?= site_url('kepala_sekolah/store') ?>')">
                                    <i class="fe fe-plus"></i> Tambah
                                </button>
                            <?php endif; ?>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table datatables" style=" width:100%">
                                    <thead>
                                        <tr role="row">
                                            <th width="5%">No</th>
                                            <th>Nama Sekolah</th>
                                            <th>Nama Kepala Sekolah</th>
                                            <th width="10%"><i class="fe fe-settings"></i></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?= $this->include('kepala_sekolah/form') ?>
<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script>
    let table;

    $(document).ready(function() {
        // Inisialisasi Select2
        const selectSekolah = $('#id_sekolah');
        selectSekolah.select2({
            dropdownParent: $('#modal-form'),
            placeholder: 'Cari dan Pilih Sekolah',
            allowClear: true,
            ajax: {
                url: "<?= site_url('sekolah/select2') ?>",
                dataType: 'json',
                delay: 250,
                allowClear: true,
                data: function(params) {
                    return {
                        term: params.term || ''
                    };
                },
                processResults: function(data) {
                    return {
                        results: data
                    };
                },
                cache: true
            }
        });

        // Inisialisasi DataTable
        table = $('.table').DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                url: "<?= site_url('kepala_sekolah/data') ?>",
                type: 'GET'
            },
            columns: [{
                    data: 'DT_RowIndex',
                    orderable: false,
                    searchable: false
                },
                {
                    data: 'nama_sekolah'
                },
                {
                    data: 'nama_kepsek'
                },
                {
                    data: 'aksi',
                    orderable: false,
                    searchable: false
                }
            ]
        });

        // Event listener untuk submit form
        $('#modal-form form').on('submit', function(e) {
            e.preventDefault();
            let url = $(this).attr('action');
            let data = $(this).serialize();

            $.ajax({
                url: url,
                type: 'POST',
                data: data,
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
                        if (response.errors) {
                            let formattedErrorMessages = Object.values(response.errors).join('<br>');
                            Swal.fire({
                                title: 'Gagal!',
                                icon: 'error',
                                html: formattedErrorMessages,
                                showCloseButton: true,
                                confirmButtonText: 'Oke',
                                customClass: {
                                    popup: 'swal-custom-popup'
                                }
                            });
                        } else {
                            Swal.fire('Gagal!', response.message || 'Terjadi kesalahan.', 'error');
                        }
                    }
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    Swal.fire('Error', 'Terjadi kesalahan pada server: ' + textStatus, 'error');
                }
            });
        });
    });

    function addForm(url) {
        $('#modal-form').modal('show');
        $('#modal-form .modal-title').text('Tambah Kepala Sekolah');
        $('#modal-form form')[0].reset();
        $('#modal-form form').attr('action', url);
        $('#modal-form [name=_method]').val('post');

        // Reset Select2
        $('#id_sekolah').val(null).trigger('change');

        $('#modal-form [name=nama_kepsek]').focus();
    }

    function editForm(id_kepsek) {
        $('#modal-form').modal('show');
        $('#modal-form .modal-title').text('Edit Kepala Sekolah');
        $('#modal-form form')[0].reset();
        $('#modal-form [name=_method]').val('put');

        let getDataUrl = `<?= site_url('kepala_sekolah/') ?>${id_kepsek}`;
        let updateFormUrl = `<?= site_url('kepala_sekolah/update/') ?>${id_kepsek}`;
        $('#modal-form form').attr('action', updateFormUrl);

        // Reset Select2 sebelum diisi
        $('#id_kecamatan').val(null).trigger('change');

        $.get(getDataUrl)
            .done(response => {
                if (response.success === false) {
                    Swal.fire('Gagal', response.message, 'error');
                    $('#modal-form').modal('hide');
                } else {
                    // Isi form
                    $('#modal-form [name=nama_kepsek]').val(response.nama_kepsek);

                    // Untuk mengisi Select2 yang sudah ada nilainya
                    // Buat option baru jika belum ada, lalu pilih
                    if (response.id_sekolah && response.nama_sekolah) {
                        let option = new Option(response.nama_sekolah, response.id_sekolah, true, true);
                        $('#id_sekolah').append(option).trigger('change');
                    }
                }
            })
            .fail(() => {
                Swal.fire('Gagal', 'Tidak dapat menampilkan data.', 'error');
            });
    }

    function deleteData(url) {
        Swal.fire({
            title: 'Yakin ingin menghapus?',
            text: "Data akan dihapus permanen!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#6c757d',
            confirmButtonText: 'Ya, hapus!',
            cancelButtonText: 'Batal',
            customClass: {
                popup: 'swal-custom-popup'
            }
        }).then(result => {
            if (result.isConfirmed) {
                $.ajax({
                    url: url,
                    method: "DELETE",
                    success: function(response) {
                        if (response.success) {
                            table.ajax.reload();
                            Swal.fire({
                                icon: 'success',
                                title: 'Berhasil',
                                text: 'Data berhasil dihapus',
                                timer: 1500,
                                showConfirmButton: false,
                                customClass: {
                                    popup: 'swal-custom-popup'
                                }
                            });
                        } else {
                            Swal.fire('Gagal', response.message || 'Terjadi kesalahan.', 'error');
                        }
                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                        Swal.fire('Error', 'Tidak dapat menghapus data: ' + textStatus, 'error');
                    }
                });
            }
        });
    }
</script>
<?= $this->endSection() ?>