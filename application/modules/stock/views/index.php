<div class="block">
    <!--    <div class="block-header block-header-default">
            <h3 class="block-title">Stock Marga Jaya Tajem </h3>
        </div>-->
    <div class="block-content block-content-full">
    <div class="row ">
            <div class="col-xs-12 col-md-12">
                <a class="btn btn-alt-secondary btn-lg mb-10" href="<?= base_url('dashboard') ?>">Back</a>               
            </div>
        </div>
        <!-- DataTables functionality is initialized with .js-dataTable-full-pagination class in js/pages/be_tables_datatables.min.js which was auto compiled from _es6/pages/be_tables_datatables.js -->
        <div class="row m-b-20">
            <div class="col-xs-12 col-md-12">                
                    <form id="form-cari">
                        <div class="form-group">
                            <div class="row">
                                <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">                                
                                    <label>Nama Barang</label>
                                    <input type="text" name="barang" class="form-control form-control-lg">
                                </div>
                                <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
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
                                <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                                    <label>Cabang</label>
                                    <!-- <label>Cabang - <?= $nama_cabang ?></label> -->
                                    <!-- kalau data not empty / data cabang ada datanya maka tampil dengan select nama cabang dan didisabled -->
                                    <select class="form-control form-control-lg" name="cabang_id">
                                        <option value="">Pilih Cabang</option>
                                        <?php
                                            foreach ($rs_cabang as $vcabang) {
                                                $selected = $vcabang['cabang_id'] == $result_cabang ? 'selected="selected"':'';
                                                echo'<option value="'.$vcabang['cabang_id'].'" '.$selected.'>'.$vcabang['nama_cabang'].'</option>';
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
            <table class="display nowrap table table-hover table-striped table-bordered dataTable" width="100%" id="tstock">
                <thead>
                    <tr>
                        <th class="text-center" style="width: 10%;">#</th>
                        <th>Nama Barang</th>
                        <th style="width: 25%;">Kategori Barang</th>
                        <th class="text-center">Stock Total</th>
                        <th class="text-center">Permintaan</th>
                        <th class="text-center" style="width: 15%;">Detail</th>
                    </tr>
                </thead>
                <tbody>                    
                </tbody>
            </table>
        </div>
    </div>
</div>