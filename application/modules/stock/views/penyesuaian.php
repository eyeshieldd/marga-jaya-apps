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
		                <h3 class="block-title">Penyesuaian Stok</h3>
		            </div>		    	
		            <div class="block-content">
		                <form method="post" id="form-tambah" enctype="multipart/form-data">
	    					<div class="row">
	    						<div class="col-lg-4 col-xs-12 col-md-12">
	    							<input type="hidden" name="stok_produksi_id" value="<?= $stok_produksi_id ?>">
	    							<input type="hidden" name="stok_awal" id="stok_awal" value="<?= $stok_awal['stok'] ?>">
				                    <div class="form-group">
				                        <label for="nama_detailstock">Tanggal</label>
				                        <div>
				                            <input placeholder="dd / mm / yy" type="text" class="form-control form-control-lg" name="tanggal" readonly="readonly" value="<?= $tanggal_sekarang ?>">
				                        </div>
				                    </div>
			                    </div>
			                    <div class="col-lg-4 col-xs-12 col-md-12">
				                    <div class="form-group">
				                        <label for="jumlah">Jumlah</label>
				                        <div>
				                            <input type="text" class="form-control form-control-lg number" disabled="" id="jumlah" name="jumlah" value="<?= $stok_awal['stok'] ?>">
				                        </div>
				                    </div>
			                    </div>
								<div class="col-lg-4 col-xs-12 col-md-12">
				                    <div class="form-group">
				                        <label for="jumlah">Jumlah Realisasi</label>
				                        <div>
				                            <input type="text" class="form-control form-control-lg number" id="jumlah_realisasi" name="jumlah_realisasi" value="0">
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