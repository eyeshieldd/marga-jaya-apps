<div class="block">
    <div class="block-content block-content-full">
        <div class="row mb-10">
            <div class="col-md-12 col-xs-12">
                <a class="btn btn-alt-secondary btn-lg" href="<?= base_url('dashboard') ?>">Back</a>
                <button class="btn btn-primary btn-lg pull-right" id="tombol-order-baru">Order Baru</button>
            </div>
        </div>
        <!-- DataTables functionality is initialized with .js-dataTable-full-pagination class in js/pages/be_tables_datatables.min.js which was auto compiled from _es6/pages/be_tables_datatables.js -->
        <div class="row m-b-20">
            <div class="col-xs-12 col-md-12">
                <form id="form-cari">
                    <div class="form-group">
                        <div class="row">
                            <div class="col-sm-3 col-xs-12">
                                <label>No / Nama</label>
                                <input type="text" name="no_nama" class="form-control form-control-lg">
                            </div>
                            <div class="col-sm-3 col-xs-12">
                                <label>Tanggal Transaksi</label>
                                <input placeholder="dd / mm / yy" value="<?=date('m-Y')?>" type="text" class="form-control form-control-lg datepicker" name="tanggal" id="tanggal">
                            </div>
                            <div class="col-sm-4 col-xs-12">
                                <label>Cabang</label>
                                <select class="form-control form-control-lg" name="cabang_id">
                                    <option value="">Pilih Cabang</option>
                                    <?php 
                                        if(isset($rs_cabang) && !empty($rs_cabang)){
                                            foreach ($rs_cabang as $vcabang) {
                                                $selected = $vcabang['cabang_id'] == $cabang_id ? 'selected="selected"' : '';
                                                echo '<option value="'.$vcabang['cabang_id'].'" '.$selected.'>'.$vcabang['nama_cabang'].'</option>';
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
            <table class="display nowrap table table-hover table-striped table-bordered dataTable" id="torder" width="100%">
                <thead>
                    <tr>
                        <th class="text-center" style="width: 10%;">#</th>
                        <th>Data Order</th>
                        <th style="width: 25%;">Status Pembayaran</th>
                        <th class="text-center" style="width: 15%;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <!-- <tr>
                        <td class="text-center">1</td>
                        <td class="font-w600">#20191010001
                        <br>Budi
                        <br>10/10/2019                        
                        <br> Maguwoharjo
                        <br> Pengiriman : <span class="badge badge-warning">belum dikirim</span>
                        </td>
                        <td><span class="badge badge-success">Lunas</span></td>
                        <td class="text-center">
                            <a class="btn btn-sm btn-alt-secondary" href="<?= base_url('order/detail') ?>" data-toggle="tooltip" title="Detail Order"> <i class="fa fa-list"></i></a>
                        </td>
                    </tr> -->
                </tbody>
            </table>
        </div>
    </div>
</div>