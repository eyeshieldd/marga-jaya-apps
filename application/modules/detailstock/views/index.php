<div class="block">
    <!--    <div class="block-header block-header-default">
            <h3 class="block-title">Stock Marga Jaya Tajem </h3>
        </div>-->
    <div class="block-content block-content-full">
        <div class="row ">            
            <div class="col-xs-12 col-md-12">
                <a class="btn btn-secondary btn-lg mb-10" href="<?= base_url('stock') ?>">Back</a>
                <a class="btn btn-primary btn-lg mb-10 pull-right" href="<?= base_url('detailstock/tambah_nama') ?>"><i class="fa fa-plus"></i> Tambah</a>
            </div>
        </div>
        <!-- DataTables functionality is initialized with .js-dataTable-full-pagination class in js/pages/be_tables_datatables.min.js which was auto compiled from _es6/pages/be_tables_datatables.js -->
        <div class="row m-b-20">
            <div class="col-lg-4 col-xs-12 col-md-12"><br/>
                <h4>Stock Batako Press Besar</h4>            
                <form>
                    <div class="form-group">
                        <label>Nama Anda</label>
                        <input type="text" class="form-control form-control-lg">
                    </div>
                </form>
            </div>
        </div>
        <div class="table-responsive">
            <table class="table table-bordered table-striped table-vcenter js-dataTable-full-pagination">
                <thead>
                    <tr>
                        <th class="text-center" style="width: 10%;">#</th>
                        <th>Nama</th>
                        <th class="text-center" style="width: 25%;">Total Stock</th>
                        <th class="text-center" style="width: 15%;">Detail</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td class="text-center">1</td>
                        <td class="font-w600">Paijo</td>
                        <td class="text-center">50</td>
                        <td class="text-center">                            
                            <a class="btn btn-sm btn-alt-secondary" href="<?= base_url('detailstock/detail') ?>" title="Detail Data"> <i class="fa fa-list"></i></a>
                        </td>
                    </tr>
                    <tr>
                        <td class="text-center">2</td>
                        <td class="font-w600">Woto</td>
                        <td class="text-center">50</td>
                        <td class="text-center">
                            <a class="btn btn-sm btn-alt-secondary" href="<?= base_url('detailstock/detail') ?>" title="Detail Data"> <i class="fa fa-list"></i></a>
                        </td>
                    </tr>
                    <tr>
                        <td class="text-center">3</td>
                        <td class="font-w600">Heri</td>
                        <td class="text-center">50</td>
                        <td class="text-center">
                            <a class="btn btn-sm btn-alt-secondary" href="<?= base_url('detailstock/detail') ?>" title="Detail Data"> <i class="fa fa-list"></i></a>
                        </td>
                    </tr>                    
                    <tr>
                        <td class="text-center">4</td>
                        <td >Iwan</td>
                        <td class="text-center">0</td>
                        <td class="text-center">
                            <a class="btn btn-sm btn-alt-secondary" href="<?= base_url('detailstock/detail') ?>" title="Detail Data"> <i class="fa fa-list"></i></a>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>