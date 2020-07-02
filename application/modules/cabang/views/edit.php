<div class="block">
    <!--    <div class="block-header block-header-default">
            <h3 class="block-title">Stock Marga Jaya Tajem </h3>
        </div>-->
    <div class="block-content block-content-full">
        <div class="row ">
            <div class="col-xs-12 col-md-12">
            	<a class="btn btn-secondary btn-lg mb-10" href="<?= base_url('cabang') ?>">Back</a>
            	<button class="btn btn-primary btn-lg mb-10 pull-right" id="tombol-ubah"><i class="fa fa-pencil-square-o"></i> Ubah Data</button>
            </div>
        </div>

		<div class="row">
		    <div class="col-xs-12 col-md-12">		        
		        <div class="block">
		            <div class="block-header block-header-default">
		                <h3 class="block-title">Edit Cabang</h3>
		            </div>		            
		            <div class="block-content">
		                <form method="post" id="form-edit" enctype="multipart/form-data">
		                    <input type="hidden" name="cabang_id" value="<?= $cabang['cabang_id']; ?>">

	    					<div class="row">
	    						<div class="col-xl-6 col-lg-6 col-md-6 col-xs-12 col-sm-12">
				                    <div class="form-group">
				                        <label for="kode_cabang">Kode Cabang</label>
				                        <div>
				                            <input type="text" class="form-control form-control-lg" id="kode_cabang" name="kode_cabang" value="<?= $cabang['kode_cabang'] ?>">
		                    				<input type="hidden" name="kode_cabang_lama" value="<?= $cabang['kode_cabang']; ?>">
				                        </div>
				                    </div>
			                    </div>

	    						<div class="col-xl-6 col-lg-6 col-md-6 col-xs-12 col-sm-12">
				                    <div class="form-group">
				                        <label for="nama_cabang">Nama Cabang</label>
				                        <div>
				                            <input type="text" class="form-control form-control-lg" id="nama_cabang" name="nama_cabang" value="<?= $cabang['nama_cabang'] ?>">
				                        </div>
				                    </div>
			                    </div>

								<div class="col-xl-6 col-lg-6 col-md-6 col-xs-12 col-sm-12">
				                    <div class="form-group">
				                        <label for="alamat">Alamat</label>
				                        <div>
				                            <input type="text" class="form-control form-control-lg" id="alamat" name="alamat" value="<?= $cabang['alamat'] ?>">
				                        </div>
				                    </div>
			                    </div>

								<div class="col-xl-6 col-lg-6 col-md-6 col-xs-12 col-sm-12">
				                    <div class="form-group">
				                        <label for="telepon">Telepon</label>
				                        <div>
				                            <input type="text" class="form-control form-control-lg" id="telepon" name="telepon" value="<?= $cabang['telepon'] ?>">
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