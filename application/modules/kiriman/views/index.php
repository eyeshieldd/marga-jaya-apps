<div class="block">
    <!--    <div class="block-header block-header-default">
            <h3 class="block-title">Stock Marga Jaya Tajem </h3>
        </div>-->
        <div class="block-content block-content-full">
            <div class="row ">
                <div class="col-xs-12 col-md-12"><a class="btn btn-secondary btn-lg mb-10" href="<?= base_url('dashboard') ?>">Back</a>
                    <a class="btn btn-primary btn-lg mb-10 pull-right" href="<?= base_url('kiriman/tambah') ?>">  <i class="fa fa-plus"></i> Tambah</a></div>
                </div>
                <!-- DataTables functionality is initialized with .js-dataTable-full-pagination class in js/pages/be_tables_datatables.min.js which was auto compiled from _es6/pages/be_tables_datatables.js -->
                <div class="row m-b-20">
                    <div class="col-xs-12 col-md-12">
                        <form id="form-cari">
                            <div class="form-group">
                                <div class="row">
                                    <div class="col-sm-6 col-xs-12">
                                        <label>Nama Sopir</label>
                                        <input type="text" name="nama_sopir" class="form-control form-control-lg">
                                    </div>
                            <!-- <div class="col-sm-6 col-xs-12">
                                <label>Cabang</label>
                                <select class="form-control form-control-lg" name="cabang_id">
                                    <option value="">All Cabang</option>
                                    <?php
                                        if(isset($rs_cabang) && !empty($rs_cabang)){
                                            foreach ($rs_cabang as $vcabang) {
                                                echo'<option value="'.$vcabang['cabang_id'].'">'.$vcabang['nama_cabang'].'</option>';
                                            }
                                        }
                                    ?>
                                </select>
                            </div> -->
                            <div class="col-lg-6 col-md-4 col-sm-4 col-xs-12">
                                <label>Cabang</label>
                                <!-- kalau data not empty / data cabang ada datanya maka tampil dengan select nama cabang dan didisabled -->
                                <?php if (!empty($nama_cabang)) { ?>
                                    <select class="form-control form-control-lg" name="cabang_id" disabled>
                                        <?php
                                        if(isset($rs_cabang) && !empty($rs_cabang)) {
                                            foreach ($rs_cabang as $vcabang) {
                                                echo'<option value="'.$vcabang['cabang_id'].'">'.$vcabang['nama_cabang'].'</option>';
                                            }
                                        }
                                        ?>
                                    </select>
                                <?php } else { ?>
                                    <select class="form-control form-control-lg" name="cabang_id">
                                        <option value="">Pilih</option>
                                        <?php
                                        foreach ($rs_cabang as $vcabang) {
                                            echo'<option value="'.$vcabang['cabang_id'].'">'.$vcabang['nama_cabang'].'</option>';
                                        }
                                        ?>
                                    </select>
                                <?php } ?>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <div class="table-responsive">
            <table class="display nowrap table table-hover table-striped table-bordered dataTable" width="100%" id="tpengiriman">
                <thead>
                    <tr>
                        <th class="">tanggal</th>
                        <th class="text-left">nama sopir</th>
                        <th>nama pemesan</th>
                        <th>barang</th>
                        <th>jumlah</th>


                    </tr>
                </thead>
                <tbody>                    
                </tbody>
            </table>
        </div>
    </div>
</div>