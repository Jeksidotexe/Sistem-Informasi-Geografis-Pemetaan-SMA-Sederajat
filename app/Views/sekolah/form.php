<div class="modal fade" id="modal-form" tabindex="-1" role="dialog" aria-labelledby="modal-form-label" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <form action="" method="post" class="modal-content" enctype="multipart/form-data">
            <?= csrf_field() ?>
            <input type="hidden" name="_method" value="post">
            <input type="hidden" name="id_sekolah" id="id_sekolah">

            <div class="modal-header">
                <h5 class="modal-title" id="modal-form-label">Form Sekolah</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <div class="modal-body">
                <div class="form-group row">
                    <label for="nama_sekolah" class="col-sm-3 col-form-label">Nama Sekolah</label>
                    <div class="col-sm-9">
                        <input type="text" name="nama_sekolah" id="nama_sekolah" class="form-control">
                    </div>
                </div>
                <div class="form-group row">
                    <label for="npsn" class="col-sm-3 col-form-label">NPSN</label>
                    <div class="col-sm-9">
                        <input type="text" name="npsn" id="npsn" class="form-control">
                    </div>
                </div>
                <div class="form-group row">
                    <label for="id_jenjang" class="col-sm-3 col-form-label">Jenjang Pendidikan</label>
                    <div class="col-sm-9">
                        <select name="id_jenjang" id="id_jenjang" class="form-control select2" style="width: 100%;"></select>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="akreditasi" class="col-sm-3 col-form-label">Akreditasi</label>
                    <div class="col-sm-9">
                        <select name="akreditasi" id="akreditasi" class="form-control">
                            <option value="">Pilih Akreditasi</option>
                            <option value="A">A</option>
                            <option value="B">B</option>
                            <option value="C">C</option>
                            <option value="Belum Terakreditasi">Belum Terakreditasi</option>
                        </select>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="status" class="col-sm-3 col-form-label">Status</label>
                    <div class="col-sm-9">
                        <select name="status" id="status" class="form-control">
                            <option value="">Pilih Status</option>
                            <option value="Negeri">Negeri</option>
                            <option value="Swasta">Swasta</option>
                        </select>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="id_kecamatan" class="col-sm-3 col-form-label">Kecamatan</label>
                    <div class="col-sm-9">
                        <select name="id_kecamatan" id="id_kecamatan" class="form-control select2" style="width: 100%;"></select>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="id_desa" class="col-sm-3 col-form-label">Desa</label>
                    <div class="col-sm-9">
                        <select name="id_desa" id="id_desa" class="form-control select2" style="width: 100%;" disabled></select>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="alamat" class="col-sm-3 col-form-label">Alamat</label>
                    <div class="col-sm-9">
                        <textarea name="alamat" id="alamat" class="form-control"></textarea>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="latitude" class="col-sm-3 col-form-label">Latitude</label>
                    <div class="col-sm-9">
                        <input type="text" name="latitude" id="latitude" class="form-control">
                    </div>
                </div>
                <div class="form-group row">
                    <label for="longitude" class="col-sm-3 col-form-label">Longitude</label>
                    <div class="col-sm-9">
                        <input type="text" name="longitude" id="longitude" class="form-control">
                    </div>
                </div>
                <div class="form-group row">
                    <label for="foto" class="col-sm-3 col-form-label">Foto Sekolah</label>
                    <div class="col-sm-9">
                        <input type="file" name="foto" id="foto" class="form-control-file">
                        <div id="foto-preview-container" class="mt-2" style="display: none;">
                            <img id="foto-preview" src="#" alt="Preview Foto" style="max-width: 200px; max-height: 200px;">
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