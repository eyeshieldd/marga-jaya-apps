<div class="block">
    <!--    <div class="block-header block-header-default">
            <h3 class="block-title">Stock Marga Jaya Tajem </h3>
        </div>-->
    <div class="block-content block-content-full">
        <div class="row ">            
            <div class="col-xs-12 col-md-12">
                <a class="btn btn-secondary btn-lg mb-10" href="<?= base_url('stock') ?>">Back</a>
                <a class="btn btn-primary btn-lg mb-10 pull-right" href="<?= base_url('stock/tambah_produksi/'.$barang_id.'/'.$cabang_id) ?>"><i class="fa fa-plus"></i> Tambah</a>
            </div>
        </div>
        <!-- DataTables functionality is initialized with .js-dataTable-full-pagination class in js/pages/be_tables_datatables.min.js which was auto compiled from _es6/pages/be_tables_datatables.js -->
        <div class="row m-b-20">      
            <div class="col-lg-4 col-xs-12 col-md-12"><br/>
                <!-- <h4>Barang Produksi</h4> -->
                <h4><?= $produksi['nama_barang'] ?></h4>
                <form id="form-cari">
                    <div class="form-group">
                        <label>Nama Pegawai</label>
                        <input type="text" name="nama_pegawai" class="form-control form-control-lg">
                    </div>
                </form>
            </div>        
        </div>
        <div class="table-responsive">
            <table class="display nowrap table table-hover table-striped table-bordered dataTable" width="100%" id="tproduksi">
                <thead>
                    <tr>
                        <th class="text-center" style="width: 10%;">#</th>
                        <th>Nama Pegawai</th>
                        <th class="text-center" style="width: 25%;">Total Stock</th>
                        <th class="text-center" style="width: 15%;">Detail</th>
                    </tr>
                </thead>
                <tbody>                   
                </tbody>
            </table>
        </div>
    </div>
</div>