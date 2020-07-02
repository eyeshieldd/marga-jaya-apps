<div class="block">    
    <div class="block-content block-content-full">
        <div class="row ">
            <div class="col-xs-12 col-md-12"><a class="btn btn-secondary btn-lg mb-10" href="<?= base_url('dashboard') ?>">Back</a>
            <a class="btn btn-primary btn-lg mb-10 pull-right" href="<?= base_url('cabang/tambah') ?>">  <i class="fa fa-plus"></i> Tambah</a></div>
        </div>        
        <div class="row m-b-20">
            <div class="col-xs-12 col-md-12">
                <form id="form-cari">                    
                    <div class="form-group">
                        <div class="row">
                            <div class="col-lg-4 col-md-6 col-sm-6 col-xs-12">
                                <label>Cabang</label>
                                <input type="text" name="cari" class="form-control form-control-lg">
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <div class="table-responsive">
            <table class="display nowrap table table-hover table-striped table-bordered dataTable" width="100%" id="tcabang">
                <thead>
                    <tr>
                        <th style="width: 10%;">#</th>
                        <th style="width: 17%;">Kode Cabang</th>
                        <th>Cabang</th>
                        <th>Alamat</th>
                        <th>Telepon</th>
                        <th class="text-center" style="width: 15%;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                </tbody>
            </table>
        </div>
    </div>
</div>