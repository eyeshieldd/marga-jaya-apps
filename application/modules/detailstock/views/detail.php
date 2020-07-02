<div class="block">
    <!--    <div class="block-header block-header-default">
            <h3 class="block-title">Stock Marga Jaya Tajem </h3>
        </div>-->
    <div class="block-content block-content-full">
    <div class="row ">
            
            <div class="col-xs-12 col-md-12"><a class="btn btn-secondary btn-lg mb-10" href="<?= base_url('detailstock') ?>">Back</a>
            <a class="btn btn-primary btn-lg mb-10 pull-right" href="<?= base_url('detailstock/tambah_stock') ?>">  <i class="fa fa-plus"></i> Tambah</a></div>
        </div>
        <!-- DataTables functionality is initialized with .js-dataTable-full-pagination class in js/pages/be_tables_datatables.min.js which was auto compiled from _es6/pages/be_tables_datatables.js -->
        <div class="row m-b-20">
            <div class="col-lg-4 col-xs-12 col-md-12"><br/>
            <h4>Paijo</h4>                
                <form>
                    <div class="form-group">
                        <label>Tanggal</label>
                        <input placeholder="dd / mm / yy" type="text" class="form-control form-control-lg datepicker" name="tanggal" id="tanggal">
                    </div>
                </form>                
            </div>
        </div>
        <div class="table-responsive">
            <table class="table table-bordered table-striped table-vcenter js-dataTable-full-pagination">
                <thead>
                    <tr>
                        <th class="text-center">#</th>
                        <th>Tanggal</th>
                        <th>Keterangan</th>
                        <th class="text-center">Jumlah</th>
                        <th class="text-center">Stock</th>
                        <th class="text-center" style="width: 15%;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td class="text-center">1</td>
                        <td class="font-w600">11/11/2019</td>
                        <td class="font-w600">Stock Bertambah</td>
                        <td class="text-center">10</td>
                        <td class="text-center">10</td>
                        <td class="text-center">
                            <!-- <a class="btn btn-sm btn-alt-warning" href="<?= base_url('detailstock/edit') ?>" title="Edit Data"> <i class="fa fa-pencil"></i></a> -->
                            <button type="button" class="btn btn-sm btn-alt-danger" data-toggle="tooltip" title="Hapus Data">
                                <i class="fa fa-trash"></i>
                            </button>
                        </td>
                    </tr>
                    <tr>
                        <td class="text-center">2</td>
                        <td class="font-w600">12/11/2019</td>
                        <td class="font-w600">Tampil Stock</td>
                        <td class="text-center">25</td>
                        <td class="text-center">35</td>
                        <td class="text-center">                            
                            <button type="button" class="btn btn-sm btn-alt-danger" data-toggle="tooltip" title="Hapus Data">
                                <i class="fa fa-trash"></i>
                            </button>
                        </td>
                    </tr>
                    <tr>
                        <td class="text-center">3</td>
                        <td class="font-w600">13/11/2019</td>
                        <td class="font-w600">Data Stock Pesanan</td>
                        <td class="text-center">5</td>
                        <td class="text-center">40</td>
                        <td class="text-center">                            
                            <button type="button" class="btn btn-sm btn-alt-danger" data-toggle="tooltip" title="Hapus Data">
                                <i class="fa fa-trash"></i>
                            </button>
                        </td>
                    </tr>                    
                    <tr>
                        <td class="text-center">5</td>
                        <td class="font-w600">14/11/2019</td>
                        <td class="font-w600">Stock yang dikirim</td>
                        <td class="text-center">27</td>
                        <td class="text-center">67</td>
                        <td class="text-center">                            
                            <button type="button" class="btn btn-sm btn-alt-danger" data-toggle="tooltip" title="Hapus Data">
                                <i class="fa fa-trash"></i>
                            </button>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>