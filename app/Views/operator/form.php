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
                    <label for="id_sekolah" class="col-sm-3 col-form-label">Sekolah</label>
                    <div class="col-sm-9">
                        <select name="id_sekolah" id="id_sekolah" class="form-control" style="width: 100%;"></select>
                    </div>
                </div>

                <div class="form-group row">
                    <label for="username" class="col-sm-3 col-form-label">Nama Operator</label>
                    <div class="col-sm-9">
                        <input type="text" name="username" id="username" class="form-control">
                    </div>
                </div>

                <div class="form-group row">
                    <label for="email" class="col-sm-3 col-form-label">Email</label>
                    <div class="col-sm-9">
                        <input type="email" name="email" id="email" class="form-control">
                    </div>
                </div>

                <div class="form-group row" id="change-password-button-container" style="display: none;">
                    <label class="col-sm-3 col-form-label"></label>
                    <div class="col-sm-9">
                        <button type="button" class="btn btn-sm btn-outline-secondary" id="btn-change-password">
                            <i class="fe fe-lock"></i> Ubah Password
                        </button>
                    </div>
                </div>

                <div id="password-input-container" style="display: none;">
                    <div class="form-group row">
                        <label for="password" class="col-sm-3 col-form-label">Password</label>
                        <div class="col-sm-9">
                            <input type="password" name="password" id="password" class="form-control">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="password_confirm" class="col-sm-3 col-form-label">Konfirmasi Password</label>
                        <div class="col-sm-9">
                            <input type="password" name="password_confirm" id="password_confirm" class="form-control">
                        </div>
                    </div>
                </div>
            </div>

            <div class="modal-footer">
                <button type="submit" class="btn btn-sm btn-primary"><i class="fe fe-save"></i> Simpan</button>
                <button type="button" class="btn btn-sm btn-dark" data-dismiss="modal"><i class="fe fe-x-circle"></i> Batal</button>
            </div>
        </form>
    </div>
</div>