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
                            <button class="btn btn-primary btn-sm" onclick="addForm('<?= site_url('operator/store') ?>')">
                                <i class="fe fe-plus"></i> Tambah
                            </button>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table datatables" id="table-users" style="width:100%">
                                    <thead>
                                        <tr role="row">
                                            <th width="5%">No</th>
                                            <th>Nama Sekolah</th>
                                            <th>Nama Operator</th>
                                            <th>Email</th>
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

<?= $this->include('operator/form') ?>
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
        table = $('#table-users').DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                url: "<?= site_url('operator/data') ?>",
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
                    data: 'username'
                },
                {
                    data: 'email'
                },
                {
                    data: 'aksi',
                    orderable: false,
                    searchable: false
                }
            ]
        });

        // Event listener untuk tombol "Ubah Password"
        $('#btn-change-password').on('click', function() {
            $('#change-password-button-container').hide();
            $('#password-input-container').slideDown();
            $('#password').prop('', true);
            $('#password_confirm').prop('', true);
            $('#password').focus();
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
        $('#modal-form .modal-title').text('Tambah Operator');
        $('#modal-form form')[0].reset();
        $('#modal-form form').attr('action', url);
        $('#modal-form [name=_method]').val('post');

        $('#password-input-container').show();
        $('#change-password-button-container').hide();
        $('#password').prop('', true);
        $('#password_confirm').prop('', true);

        $('#id_sekolah').val(null).trigger('change');
        $('#modal-form [name=username]').focus();
    }

    function editForm(id_users) {
        $('#modal-form').modal('show');
        $('#modal-form .modal-title').text('Edit Operator');
        $('#modal-form form')[0].reset();
        $('#modal-form [name=_method]').val('put');

        $('#password-input-container').hide();
        $('#change-password-button-container').show();
        $('#password').prop('', false);
        $('#password_confirm').prop('', false);

        let getDataUrl = `<?= site_url('operator/') ?>${id_users}`;
        let updateFormUrl = `<?= site_url('operator/update/') ?>${id_users}`;
        $('#modal-form form').attr('action', updateFormUrl);

        $('#id_sekolah').val(null).trigger('change');

        $.get(getDataUrl)
            .done(response => {
                if (response.id_users) {
                    $('#modal-form [name=username]').val(response.username);
                    $('#modal-form [name=email]').val(response.email);
                    if (response.id_sekolah && response.nama_sekolah) {
                        let option = new Option(response.nama_sekolah, response.id_sekolah, true, true);
                        $('#id_sekolah').append(option).trigger('change');
                    }
                } else {
                    Swal.fire('Gagal', response.message || 'Data tidak ditemukan.', 'error');
                    $('#modal-form').modal('hide');
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
                    headers: {
                        'X-CSRF-TOKEN': '<?= csrf_hash() ?>'
                    },
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