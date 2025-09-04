<div class="modal fade" id="modal-form" tabindex="-1" role="dialog" aria-labelledby="modal-form-label" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <form action="" method="post" class="modal-content">
            <?= csrf_field() ?>
            <input type="hidden" name="_method" value="post">

            <div class="modal-header">
                <h5 class="modal-title" id="modal-form-label"></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <div class="modal-body">
                <div class="form-group row">
                    <label for="id_kecamatan" class="col-sm-3 col-form-label">Kecamatan</label>
                    <div class="col-sm-9">
                        <select name="id_kecamatan" id="id_kecamatan" class="form-control" style="width: 100%;"></select>
                    </div>
                </div>

                <div class="form-group row">
                    <label for="nama_desa" class="col-sm-3 col-form-label">Nama Desa</label>
                    <div class="col-sm-9">
                        <input type="text" name="nama_desa" id="nama_desa" class="form-control">
                    </div>
                </div>
            </div>

            <div class="modal-footer">
                <button type="submit" class="btn btn-sm btn-primary">
                    <i class="fe fe-save"></i> Simpan
                </button>
                <button type="button" class="btn btn-sm btn-dark" data-dismiss="modal">
                    <i class="fe fe-x-circle"></i> Batal
                </button>
            </div>
        </form>
    </div>
</div>