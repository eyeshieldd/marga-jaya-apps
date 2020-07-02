        <div class="block">
        <div class="block-content block-content-full">
            <div class="row ">
                <div class="col-xs-12 col-md-12"><a class="btn btn-secondary btn-lg mb-10" href="<?= base_url('dashboard') ?>">Back</a>
                    <a class="btn btn-primary btn-lg mb-10 pull-right" href="<?= base_url('kategori/tambah') ?>">  <i class="fa fa-plus"></i> Tambah</a></div>
                </div>

                <div class="row m-b-20">
                    <div class="col-lg-4 col-xs-12 col-md-12">
                        <form id="form-cari">
                            <div class="form-group">
                                <label>Kategori Barang</label>
                                <input type="text" name="cari" class="form-control form-control-lg">
                            </div>
                        </form>
                    </div>
                </div>
                <div class="table-responsive">
                    <table class="display nowrap table table-hover table-striped table-bordered dataTable" width="100%" id="tkategori">
                        <thead>
                            <tr>
                                <th class="text-center">#</th>
                                <th>Kategori Barang</th>
                                <th>Satuan</th>

                                <th class="text-center" style="width: 15%;">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>