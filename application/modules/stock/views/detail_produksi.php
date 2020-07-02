<div class="block">
    <!--    <div class="block-header block-header-default">
            <h3 class="block-title">Stock Marga Jaya Tajem </h3>
        </div>-->
    <div class="block-content block-content-full">
    <div class="row ">
        <div class="col-xs-12 col-md-12">
            <a class="btn btn-secondary btn-lg mb-10" href="<?= base_url('stock/produksi/'.$id['barang_id'].'/'.$id['cabang_id']) ?>">Back</a> 
            <a class="btn btn-primary btn-lg mb-10 pull-right" href="<?= base_url('stock/tambah_detail_produksi/'.$stok_produksi_id) ?>">  <i class="fa fa-plus"></i> Tambah</a> 
        </div>
        
        </div>
        <!-- DataTables functionality is initialized with .js-dataTable-full-pagination class in js/pages/be_tables_datatables.min.js which was auto compiled from _es6/pages/be_tables_datatables.js -->
        <div class="row m-b-20">
            <div class="col-lg-4 col-xs-12 col-md-12"><br/>            
                <h4><?= $detail_produksi['nama_pegawai']; ?></h4>
                <form id="form-cari">
                    <div class="form-group">
                        <label>Tanggal</label>
                        <input placeholder="dd / mm / yy" type="text" class="form-control form-control-lg datepicker" name="tanggal" id="tanggal">
                    </div>
                </form>                
            </div>
        </div>
        <div class="table-responsive">
            <table class="display nowrap table table-hover table-striped table-bordered dataTable" width="100%" id="tdetailproduksi">
                <thead>
                    <tr>
                        <th class="text-center" style="width: 10%;">#</th>
                        <th>Tanggal</th>
                        <th>Keterangan</th>
                        <th class="text-center">Stok Awal</th>
                        <th class="text-center">Jumlah</th>
                        <th class="text-center" style="width: 15%;">Total Stock</th>
                        <th class="text-center" style="width: 15%;">Aksi</th>
                    </tr>
                </thead>
                <tbody>                    
                </tbody>
            </table>
        </div>
    </div>
</div>