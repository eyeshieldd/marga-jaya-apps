<div class="block">
    <!--    <div class="block-header block-header-default">
            <h3 class="block-title">Stock Marga Jaya Tajem </h3>
        </div>-->
    <div class="block-content block-content-full">
        <div class="row ">
            <div class="col-xs-12 col-md-12">
            	<a class="btn btn-secondary btn-lg mb-10" href="<?= base_url('kategori') ?>">Back</a>
            	<!-- <a class="btn btn-primary btn-lg mb-10 pull-right" id="tombol-ubah" href="<?= base_url('kategori/proses_ubah') ?>"><i class="fa fa-pencil-square-o"></i> Ubah Data</a> -->
            	<button class="btn btn-primary btn-lg mb-10 pull-right" id="tombol-ubah"><i class="fa fa-pencil-square-o"></i> Ubah Data</button>
        	</div>
        </div>

		<div class="row">
		    <div class="col-xs-12 col-md-12">		        
		        <div class="block">
		            <div class="block-header block-header-default">
		                <h3 class="block-title">Edit Kategori</h3>		                
		            </div>
		            <div class="block-content">
		                <form method="post" id="form-edit" enctype="multipart/form-data">
		                    <input type="hidden" name="kategori_id" value="<?= $kategori['kategori_id']; ?>">		                    	
		                    <div class="form-group row">
		                        <label class="col-lg-2 col-xs-12 col-md-12" for="nama_kategori">Nama Kategori</label>
		                        <div class="col-lg-10 col-xs-12 col-md-12">
		                            <input type="text" class="form-control form-control-lg" id="nama_kategori" name="nama_kategori" value="<?= $kategori['nama_kategori']; ?>">
		                        </div>
		                    </div>

	                        <div class="form-group row">
								<label class="col-lg-2 col-xs-12 col-md-12" for="satuan">Satuan</label>
								<div class="col-lg-10 col-xs-12 col-md-12">
									<select class="form-control form-control-lg" name="satuan" id="satuan">
	                                	<?php
	                                	if ($kategori['satuan'] == 'm2') {
    										echo '<option value="m2" selected="">'.$kategori['satuan'].'</option>';
    										echo '<option value="pcs">pcs</option>';
	                                	} else {
											echo '<option value="pcs" selected="">'.$kategori['satuan'].'</option>';
    										echo '<option value="m2">m2</option>';
	                                	} ?>
									</select>
								</div>
							</div>

							<div class="form-group row">
								<label class="col-lg-2 col-xs-12 col-md-12" for="konversi">Konversi</label>
								<div class="col-lg-10 col-xs-12 col-md-12">
									<input type="text" class="form-control form-control-lg jumlah" id="konversi" name="konversi" value="<?= $kategori['konversi']; ?>">
								</div>
							</div>

							<div class="form-group row">
								<label class="col-lg-2 col-xs-12 col-md-12" for="chart">Show Chart</label>
								<div class="col-lg-10 col-xs-12 col-md-12">
									<label>
                    					<input type="checkbox" value="1" name="chart" <?php if ($kategori['is_show_chart'] == '1') {echo 'checked';} ?> />
									</label>
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