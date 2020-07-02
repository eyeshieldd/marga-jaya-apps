<div class="block">
    <!--    <div class="block-header block-header-default">
            <h3 class="block-title">Stock Marga Jaya Tajem </h3>
        </div>-->
    <div class="block-content block-content-full">
        <div class="row ">
            <div class="col-xs-12 col-lg-12 col-md-12">
            	<a class="btn btn-secondary btn-lg mb-10" href="<?= base_url('pengeluaran') ?>">Back</a>
            	<button class="btn btn-primary btn-lg mb-10 pull-right" id="tombol-simpan"><i class="fa fa-save"></i> Simpan</button></div>
        	</div>
        </div>

		<div class="row">
		    <div class="col-xs-12 col-md-12">		        
		        <div class="block">
		            <div class="block-header block-header-default">
		                <h3 class="block-title">Input Pengeluaran</h3>
		            </div>		            
		            <div class="block-content">
		                <form method="post" id="form-tambah" enctype="multipart/form-data">
	    					<div class="row">
	    						<div class="col-xl-6 col-lg-3 col-sm-12 col-xs-12 col-md-12">
				                    <div class="form-group">
				                        <label for="tanggal">Tanggal</label>
				                        <div>
				                            <input placeholder="dd / mm / yy" type="text" class="datepicker form-control form-control-lg" name="tanggal" id="tanggal">
				                        </div>
				                    </div>
			                    </div>

			                    <div class="col-xl-6 col-lg-3 col-sm-12 col-xs-12 col-md-12">
				                    <div class="form-group">
				                        <label for="deskripsi">Nama Pengeluaran</label>
				                        <div>
				                            <input type="text" class="form-control form-control-lg" id="deskripsi" name="deskripsi" placeholder="Input data nama pengeluaran..">
				                        </div>
				                    </div>
			                    </div>

								<div class="col-xl-6 col-lg-3 col-sm-12col-xs-12 col-md-12">
				                    <div class="form-group">
				                        <label for="nominal">Nominal</label>
				                        <div>
				                            <input type="text" class="form-control form-control-lg number" id="nominal" name="nominal" value="0">
				                        </div>
				                    </div>
			                    </div>								

								<div class="col-xl-6 col-lg-3 col-sm-12 col-xs-12 col-md-12">
				                    <div class="form-group">
				                        <label for="cabang">Cabang</label>
				                        <div>
			                                <?php if (!empty($nama_cabang)) { ?>
			                                    <select class="form-control form-control-lg" name="cabang_id">
			                                        <?php
			                                            if(isset($rs_cabang) && !empty($rs_cabang)) {
			                                                foreach ($rs_cabang as $vcabang) {
			                                                    echo'<option value="'.$vcabang['cabang_id'].'">'.$vcabang['nama_cabang'].'</option>';
			                                                }
			                                            }
			                                        ?>
			                                    </select>
			                                <?php } else { ?>
			                                    <select class="form-control form-control-lg" name="cabang_id">
			                                    <option value="">Pilih</option>
			                                        <?php
			                                            foreach ($rs_cabang as $vcabang) {
			                                                echo'<option value="'.$vcabang['cabang_id'].'">'.$vcabang['nama_cabang'].'</option>';
			                                            }
			                                        ?>
			                                    </select>
			                                <?php } ?>
											

				                        </div>
				                    </div>
				                </div>
	    					</div>
	    					<!-- ./row -->
		                </form>
		            </div>
		        </div>
		    </div>
			<!-- ./col-md-12 -->
		</div>
		<!-- ./row -->
	</div>
</div>
