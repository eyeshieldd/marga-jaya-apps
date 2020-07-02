<div class="block">
    <!--    <div class="block-header block-header-default">
            <h3 class="block-title">Stock Marga Jaya Tajem </h3>
        </div>-->
    <div class="block-content block-content-full">
        <div class="row ">
            <div class="col-xs-12 col-md-12"><a class="btn btn-secondary btn-lg mb-10" href="<?= base_url('stock/detail_produksi/'.$stok_produksi_id) ?>">Back</a>
        	<button class="btn btn-primary btn-lg mb-10 pull-right" id="tombol-simpan"><i class="fa fa-save"></i> Simpan</button></div>
        </div>

		<div class="row">
		    <div class="col-xs-12 col-md-12">		        
		        <div class="block">
		            <div class="block-header block-header-default">
		                <h3 class="block-title">Input Stock</h3>
		            </div>		    	
		            <div class="block-content">
		                <form method="post" id="form-tambah" enctype="multipart/form-data">
	    					<div class="row">
	    						<div class="col-lg-6 col-xs-12 col-md-12">
	    							<input type="hidden" name="stok_produksi_id" value="<?= $stok_produksi_id ?>">
	    							<input type="hidden" name="stok_awal" id="stok_awal" value="<?= $stok_awal['stok'] ?>">

				                    <div class="form-group">
				                        <label for="nama_detailstock">Tanggal</label>
				                        <div>
				                            <input placeholder="dd / mm / yy" type="text" class="datepicker form-control form-control-lg" name="tgl" id="tgl" disabled="disabled">
				                            <!-- save database -->
				                            <input placeholder="dd / mm / yy" type="hidden" class="datepicker form-control form-control-lg" name="tanggal" id="tanggal">
				                        </div>
				                    </div>
			                    </div>

								<div class="col-lg-6 col-xs-12 col-md-12">
				                    <div class="form-group">
				                        <label for="jumlah">Jumlah</label>
				                        <div>
				                            <input type="text" class="form-control form-control-lg number" id="jumlah" name="jumlah" value="0">
				                        </div>
				                    </div>
			                    </div>
	    					</div>
		                </form>
		            </div>
		        </div>
		    </div>
			<!-- ./col-md-12 -->
		</div>
		<!-- ./row -->
	</div>
</div>