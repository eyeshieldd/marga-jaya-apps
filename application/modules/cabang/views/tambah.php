<div class="block">
    <div class="block-content block-content-full">
        <div class="row">
            <div class="col-xs-12 col-md-12"><a class="btn btn-secondary btn-lg mb-10" href="<?= base_url('cabang') ?>">Back</a>
            <button class="btn btn-primary btn-lg mb-10 pull-right" id="tombol-simpan"><i class="fa fa-save"></i> Simpan</button></div>
        </div>
		<div class="row">
		    <div class="col-xs-12 col-md-12">		        
		        <div class="block">
		            <div class="block-header block-header-default">
		                <h3 class="block-title">Input Cabang</h3>
		            </div>		    	
		            <div class="block-content">
		                <form id="form-tambah" enctype="multipart/form-data" onsubmit="return false">
	    					<div class="row">
	    						<div class="col-xl-6 col-lg-6 col-md-6 col-xs-12 col-sm-12">
				                    <div class="form-group">
				                        <label for="date">Kode Cabang</label>
				                        <div>
				                            <input type="text" class="form-control form-control-lg" name="kode_cabang" placeholder="Input kode cabang..">
				                        </div>
				                    </div>
			                    </div>

	    						<div class="col-xl-6 col-lg-6 col-md-6 col-xs-12 col-sm-12">
				                    <div class="form-group">
				                        <label for="nama_cabang">Nama Cabang</label>
				                        <div>
				                            <input type="text" class="form-control form-control-lg" name="nama_cabang" placeholder="Input nama cabang..">
				                        </div>
				                    </div>
			                    </div>

								<div class="col-xl-6 col-lg-6 col-md-6 col-xs-12 col-sm-12">
				                    <div class="form-group">
				                        <label for="alamat">Alamat</label>
				                        <div>
				                            <input type="text" class="form-control form-control-lg" name="alamat" placeholder="Input alamat cabang..">
				                        </div>
				                    </div>
			                    </div>

								<div class="col-xl-6 col-lg-6 col-md-6 col-xs-12 col-sm-12">
				                    <div class="form-group">
				                        <label for="telepon">Telepon</label>
				                        <div>
				                            <input type="text" class="form-control form-control-lg" name="telepon" placeholder="Input nomor telepon..">
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