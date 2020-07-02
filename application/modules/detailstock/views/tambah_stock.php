<div class="block">
    <!--    <div class="block-header block-header-default">
            <h3 class="block-title">Stock Marga Jaya Tajem </h3>
        </div>-->
    <div class="block-content block-content-full">
        <div class="row ">
            <div class="col-xs-12 col-md-12"><a class="btn btn-secondary btn-lg mb-10" href="<?= base_url('detailstock/detail') ?>">Back</a>
            <a class="btn btn-primary btn-lg mb-10 pull-right" href="<?= base_url('detailstock/proses_tambah') ?>"><i class="fa fa-save"></i> Simpan</a></div>
        </div>

		<div class="row">
		    <div class="col-xs-12 col-md-12">		        
		        <div class="block">
		            <div class="block-header block-header-default">
		                <h3 class="block-title">Input Stock</h3>
		            </div>		    	
		            <div class="block-content">
		                <form action="" method="" enctype="multipart/form-data">
	    					<div class="row">
	    						<div class="col-lg-6 col-xs-12 col-md-12">
				                    <div class="form-group">
				                        <label for="nama_detailstock">Tanggal</label>
				                        <div>
				                            <input placeholder="dd / mm / yy" type="text" class="datepicker form-control form-control-lg" name="tanggal" id="tanggal">
				                        </div>
				                    </div>
			                    </div>

								<div class="col-lg-6 col-xs-12 col-md-12">
				                    <div class="form-group">
				                        <label for="alamat">Jumlah</label>
				                        <div>
				                            <input type="text" class="form-control form-control-lg" id="alamat" name="alamat" placeholder="Input jumlah stock..">
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