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
                            <button class="btn btn-primary btn-sm" onclick="addForm('<?= site_url('kecamatan/store') ?>')">
                                <i class="fe fe-plus"></i> Tambah
                            </button>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table datatables dataTable" style="width:100%">
                                    <thead>
                                        <tr role="row">
                                            <th width="5%">No</th>
                                            <th>Nama Kecamatan</th>
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

<?= $this->include('kecamatan/form') ?>
<?= $this->endSection() ?>

<?= $this->section('scripts') ?>

<script>
    let table; // Deklarasikan variabel table di scope global

    $(document).ready(function() {
        table = $('.table').DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                url: "<?= site_url('kecamatan/data') ?>",
                type: 'GET'
            },
            columns: [{
                    data: 'DT_RowIndex',
                    orderable: false,
                    searchable: false
                },
                {
                    data: 'nama_kecamatan'
                },
                {
                    data: 'aksi',
                    orderable: false,
                    searchable: false
                }
            ]
        });

        // Event listener untuk submit form modal (untuk Tambah/Edit)
        $('#modal-form form').on('submit', function(e) {
            e.preventDefault(); // Mencegah form submit default

            let url = $(this).attr('action');
            let method = $(this).find('input[name="_method"]').val(); // Ambil method (post/put)
            let data = $(this).serialize(); // Ambil semua data form

            // Reset pesan error sebelumnya
            $('.invalid-feedback').remove();
            $('.is-invalid').removeClass('is-invalid');

            $.ajax({
                url: url,
                type: 'POST', // Selalu POST untuk method POST/PUT/DELETE di CodeIgniter lewat form
                data: data,
                success: function(response) {
                    if (response.success) {
                        $('#modal-form').modal('hide');
                        table.ajax.reload(); // Muat ulang DataTables
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
                        // Menampilkan error validasi
                        if (response.errors) {
                            let errorMessages = []; // Gunakan array untuk mengumpulkan pesan
                            for (const [key, value] of Object.entries(response.errors)) {
                                errorMessages.push(value); // Tambahkan pesan ke array
                            }
                            // Gabungkan pesan dengan <br> untuk break baris
                            let formattedErrorMessages = errorMessages.join('<br>');

                            Swal.fire({
                                title: 'Gagal!',
                                icon: 'error',
                                html: formattedErrorMessages, // Tampilkan pesan dengan break baris
                                showCloseButton: true,
                                confirmButtonText: 'Oke',
                                customClass: {
                                    popup: 'swal-custom-popup'
                                }
                            });
                        } else {
                            // Ini untuk error non-validasi dari controller
                            Swal.fire('Gagal!', response.message || 'Terjadi kesalahan.', 'error');
                        }
                    }
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    // Ini untuk error HTTP seperti 500, 404, dll.
                    Swal.fire('Error', 'Terjadi kesalahan pada server: ' + textStatus, 'error');
                }
            });
        });
    });

    function addForm(url) {
        $('#modal-form').modal('show');
        $('#modal-form .modal-title').text('Tambah Kecamatan');
        $('#modal-form form')[0].reset();
        $('#modal-form form').attr('action', url);
        $('#modal-form [name=_method]').val('post');
        $('#modal-form [name=nama_kecamatan]').focus();
        $('.invalid-feedback').remove();
        $('.is-invalid').removeClass('is-invalid');
    }

    function editForm(id_kecamatan) { // Terima ID, bukan URL lengkap untuk update
        $('#modal-form').modal('show');
        $('#modal-form .modal-title').text('Edit Kecamatan');
        $('#modal-form form')[0].reset();
        $('#modal-form [name=_method]').val('put');
        $('.invalid-feedback').remove();
        $('.is-invalid').removeClass('is-invalid');

        // URL untuk mengambil data (GET)
        let getDataUrl = `<?= site_url('kecamatan/') ?>${id_kecamatan}`;
        // URL untuk mengirim update (PUT)
        let updateFormUrl = `<?= site_url('kecamatan/update/') ?>${id_kecamatan}`;

        // Set action form untuk proses update
        $('#modal-form form').attr('action', updateFormUrl);

        $.get(getDataUrl) // Lakukan GET request ke endpoint show()
            .done(response => {
                if (response.success === false) {
                    Swal.fire('Gagal', response.message, 'error');
                    $('#modal-form').modal('hide');
                } else {
                    $('#modal-form [name=nama_kecamatan]').val(response.nama_kecamatan);
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