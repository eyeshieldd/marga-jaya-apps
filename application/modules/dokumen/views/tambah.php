<div class="block">
    <!--    <div class="block-header block-header-default">
            <h3 class="block-title">Stock Marga Jaya Tajem </h3>
        </div>-->
    <div class="block-content block-content-full">
        <div class="row">
            <div class="col-xs-12 col-md-12">
            	<a class="btn btn-secondary btn-lg mb-10" href="<?= base_url('dokumen') ?>">Back</a>
            	<button class="btn btn-primary btn-lg mb-10 pull-right" id="tombol-simpan"><i class="fa fa-save"></i> Simpan</button></div>
        	</div>
        </div>

		<div class="row">
		    <div class="col-xs-12 col-md-12">
		        <div class="block">
		            <div class="block-header block-header-default">
		                <h3 class="block-title">Input Dokumen</h3>
		            </div>
		            <div class="block-content">
		                <form method="post" id="form-tambah" enctype="multipart/form-data">

	    					<div class="row">
	    						<div class="col-lg-4 col-xs-12 col-md-12">
				                    <div class="form-group">
				                        <label for="nama_dokumen">Nama Dokumen</label>
				                        <div>
				                            <input type="text" class="form-control form-control-lg" id="nama_dokumen" name="nama_dokumen" placeholder="Input data nama dokumen..">
				                        </div>
				                    </div>
			                    </div>

								<div class="col-lg-4 col-xs-12 col-md-12">
				                    <div class="form-group">
				                        <label for="lokasi">Cabang</label>
				                        <div>
											<select class="form-control form-control-lg" name="cabang_id">
				                                <option>Pilih</option>
				                                <?php
				                                    if(isset($rs_cabang) && !empty($rs_cabang)){
				                                        foreach ($rs_cabang as $vcabang) {
				                                            echo'<option value="'.$vcabang['cabang_id'].'">'.$vcabang['nama_cabang'].'</option>';
				                                        }
				                                    }
				                                ?>
				                            </select>
				                        </div>
				                    </div>
				                </div>

				                <!-- default upload -->
								<div class="col-lg-4 col-xs-12 col-md-12">
				                    <div class="form-group">
				                        <label>Upload</label>
				                        <div>
				                            <input type="file" id="file_dokumen" name="file_dokumen">
				                        </div>
				                    </div>
			                    </div>

				                <!-- upload custom file -->
			                    <!-- <div class="col-lg-4 col-xs-12 col-md-12">
									<div class="form-group">
			                            <label>Upload</label>
			                            <div>
			                                <div class="custom-file">
			                                    <input type="file" class="custom-file-input" id="upload_data" name="upload_data" data-toggle="custom-file-input">
			                                    <label class="custom-file-label form-control-lg">Pilih file</label>
			                                </div>
			                            </div>
			                        </div>
		                        </div> -->
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