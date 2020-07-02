<div class="block">
    <!--    <div class="block-header block-header-default">
            <h3 class="block-title">Stock Marga Jaya Tajem </h3>
        </div>-->
    <div class="block-content block-content-full">
        <div class="row ">
            <div class="col-xs-12 col-md-12">
            	<a class="btn btn-secondary btn-lg mb-10" href="<?= base_url('order') ?>">
            		Back
            	</a>
            	<button class="btn btn-primary btn-lg mb-10 pull-right" id="tombol-simpan"><i class="fa fa-save"></i> Simpan</button>
            </div>
        </div>

		<div class="row">
		    <div class="col-xs-12 col-md-12">		        
		        <div class="block">
		            <div class="block-header block-header-default">
		                <h3 class="block-title">Input Order Cabang "<?=$result_cabang['nama_cabang']?>"</h3>
		            </div>		            
		            <div class="block-content">
		                <form action="" method="" enctype="multipart/form-data">
		                	<input type="hidden" name="cabang_id" value="<?=$result_cabang['cabang_id']?>" id="cabang_id">
	    					<div class="row">
			                    <div class="col-lg-4 col-xs-12 col-md-12">
				                    <div class="form-group">
				                        <label for="nama_order">Nama Pembeli</label>
				                        <div>
				                            <input type="text" class="form-control form-control-lg" id="nama_pembeli" name="nama_pembeli" placeholder="Nama Pembeli">
				                        </div>
				                    </div>
			                    </div>

	    						<div class="col-lg-4 col-xs-12 col-md-12">
				                    <div class="form-group">
				                        <label for="tangal">Tanggal</label>
				                        <div>
				                            <input placeholder="dd / mm / yy" type="text" class="form-control form-control-lg datepicker" name="tanggal" id="tanggal" value="<?=date('d-m-Y')?>">
				                        </div>
				                    </div>
			                    </div>

								<div class="col-lg-4 col-xs-12 col-md-12">
				                    <div class="form-group">
				                        <label for="alamat">Alamat</label>
				                        <div>
				                            <input type="text" class="form-control form-control-lg" id="alamat" name="alamat" placeholder="Alamat pembeli">
				                        </div>
				                    </div>
			                    </div>								
	    					</div>
	    				</form>
    					<!-- ./row -->
    					<hr>
						<form id="form-tambah-barang" onsubmit="return false">
	    					<div class="row">
	    						<div class="col-lg-4 col-xs-12 col-md-12">
				                    <div class="form-group">
				                        <label for="lokasi">Barang</label>
				                        <div>
											<select class="form-control form-control-lg js-select2 " name="nama_barang">
			                                    <option></option>
			                                    <?php
			                                    if(isset($rs_barang) && !empty($rs_barang)){
			                                    	foreach ($rs_barang as $key => $vbarang) {
					                                    echo '<option value="'.$vbarang['barang_id'].'">'.$vbarang['nama_barang'].'</option>';
			                                    	}
			                                    }
			                                    ?>
			                                </select>
				                        </div>
				                    </div>
				                </div>
			                    <div class="col-lg-1 col-xs-12 col-md-6">
				                    <div class="form-group">
				                        <label for="jumlah">Jumlah</label>
				                        <div>
				                            <input type="text" class="form-control text-right number" name="jumlah" value="0">
				                        </div>
				                    </div>
			                    </div>
			                    <div class="col-lg-2 col-xs-12 col-md-6">
				                    <div class="form-group">
				                        <label for="harga">Harga</label>
				                        <div>
				                            <input type="text" class="form-control text-right number" name="harga" value="0">
				                        </div>
				                    </div>
			                    </div>
			                    <div class="col-lg-2 col-xs-12 col-md-6">
				                    <div class="form-group">
				                        <label for="jumlah">Pengambilan</label>
				                        <div>
				                            <select class="form-control" name="status_pengambilan">
				                            	<option value="diambil">Diambil</option>
				                            	<option value="diantar">Diantar</option>
				                            </select>
				                        </div>
				                    </div>
			                    </div>
								<div class="col-lg-3 col-xs-12 col-md-12">
				                    <br>
			                    	<button class="btn btn-primary mb-10" id="tombol-tambah-barang" onclick="return false"><i class="fa fa-plus"></i> Tambah Barang</button>
			                    </div>
	    					</div>
		                </form>
    					<!-- ./row -->
						
	                    <div class="table-responsive">
	                    	<form id="form-detail-barang" onsubmit="return false">
					            <table id="tabel-barang" class="table table-bordered table-striped table-vcenter js-dataTable-full-pagination">
					                <thead>
					                    <tr>
					                        <th class="text-center" style="width: 10%;">#</th>
					                        <th>Nama Barang</th>
					                        <th class="text-right">Jumlah</th>
					                        <th class="text-right">Sub Total</th>
					                        <th class="text-center" style="width: 8%;">Aksi</th>
					                    </tr>
					                </thead>
					                <tbody>
					                    <tr><td colspan="5">Belum ada data.</td></tr>
					                </tbody>
					            </table>
					        </form>
				        </div>

						<div class="row">
							<div class="col-lg-12 col-xs-12 col-md-12">		
                                <div class="form-group pull-right row">
                                    <label class="col-lg-4 col-form-label" for="total_biaya">Total Barang</label>
                                    <div class="col-lg-8">
                                        <input type="text" readonly="readonly" class="form-control form-control-lg text-right number" id="total_biaya" name="total_biaya" value="0">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
							<div class="col-lg-12 col-xs-12 col-md-12">	
                                <div class="form-group row pull-right">
                                    <label class="col-lg-4 col-form-label" for="total_bayar">Transport</label>
                                    <div class="col-lg-8">
                                        <input type="text" class="form-control form-control-lg text-right number" id="transport" name="transport" value="0">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
							<div class="col-lg-12 col-xs-12 col-md-12">	
                                <div class="form-group row pull-right">
                                    <label class="col-lg-4 col-form-label" for="total_bayar">Diskon</label>
                                    <div class="col-lg-8">
                                        <input type="text" class="form-control form-control-lg text-right number" id="diskon" name="total_bayar" value="0">
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row">
							<div class="col-lg-12 col-xs-12 col-md-12">	
                                <div class="form-group row pull-right">
                                    <label class="col-lg-4 col-form-label" for="total_bayar">Total Bayar</label>
                                    <div class="col-lg-8">
                                        <input type="text" readonly="readonly" class="form-control form-control-lg text-right number" id="total_bayar" name="total_bayar" value="0">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- ./row -->
                        <div class="row">
							<div class="col-lg-12 col-xs-12 col-md-12">
                                <div class="form-group row pull-right">
                                    <label class="col-lg-4 col-form-label" for="status">Status</label>
                                    <div class="col-lg-8">
                                        <select class="form-control form-control-lg" id="status_pembayaran" name="status_pembayaran">
		                                    <option></option>
		                                    <option value="dp">Uang DP</option>
		                                    <option value="lunas">Lunas</option>
		                                    <option value="belum bayar">Belum Dibayar</option>      
		                                </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row" id="div-uang-muka" style="display: none">
							<div class="col-lg-12 col-xs-12 col-md-12">	
                                <div class="form-group row pull-right">
                                    <label class="col-lg-4 col-form-label" for="total_bayar">Uang Muka</label>
                                    <div class="col-lg-8">
                                        <input type="text" class="form-control form-control-lg text-right number" id="uang_muka" name="uang_muka" value="0">
                                    </div>
                                </div>
                            </div>
                        </div>
		            </div>
		        </div>
		    </div>
			<!-- ./col-md-12 -->
		</div>
		<!-- ./row -->
	</div>
</div>