<div class="block">
    <!--    <div class="block-header block-header-default">
            <h3 class="block-title">Stock Marga Jaya Tajem </h3>
        </div>-->
    <div class="block-content block-content-full">
        <div class="row ">
            <div class="col-xs-12 col-md-12"><a class="btn btn-secondary btn-lg mb-10" href="<?= base_url('dashboard') ?>">Back</a>
            <a class="btn btn-primary btn-lg mb-10 pull-right" href="<?= base_url('barang/tambah') ?>">  <i class="fa fa-plus"></i> Tambah</a></div>
        </div>        
        <div class="row m-b-20">
            <div class="col-xs-12 col-md-12">
                <form id="form-cari">
                    <div class="form-group">
                        <div class="row">
                            <div class="col-lg-6 col-md-12 col-sm-12 col-xs-12">
                                <label>Barang</label>
                                <input type="text" name="barang" class="form-control form-control-lg">
                            </div>
                            <div class="col-lg-6 col-md-12 col-sm-12 col-xs-12">
                                <label>Kategori</label>
                                <select class="form-control form-control-lg" name="kategori_id">
                                    <option value="">All Kategori</option>
                                    <?php
                                        if(isset($rs_kategori) && !empty($rs_kategori)){
                                            foreach ($rs_kategori as $vkategori) {
                                                echo'<option value="'.$vkategori['kategori_id'].'">'.$vkategori['nama_kategori'].'</option>';
                                            }
                                        }
                                    ?>
                                </select>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <div class="table-responsive">
            <table class="display nowrap table table-hover table-striped table-bordered dataTable" width="100%" id="tbarang">
                <thead>
                    <tr>
                        <th class="text-center" style="width: 10%;">#</th>
                        <th>Barang</th>
                        <th>Kategori Barang</th>
                        <th class="text-center" style="width: 15%;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                </tbody>
            </table>
        </div>
    </div>
</div>