<div class="block">
    <!--    <div class="block-header block-header-default">
            <h3 class="block-title">Stock Marga Jaya Tajem </h3>
        </div>-->
    <div class="block-content block-content-full">
        <div class="row ">
            <div class="col-xs-12 col-md-12"><a class="btn btn-secondary btn-lg mb-10" href="<?= base_url('barang') ?>">Back</a>
            <button class="btn btn-primary btn-lg mb-10 pull-right" id="tombol-simpan"><i class="fa fa-save"></i> Simpan</button></div>
        </div>

		<div class="row">
		    <div class="col-lg-12 col-xs-12 col-md-12">
		        <div class="block">
		            <div class="block-header block-header-default">
		                <h3 class="block-title">Input Barang</h3>
		            </div>
		            <div class="block-content">
		                <form id="form-tambah" enctype="multipart/form-data" onsubmit="return false">
		                	<div class="row">
		                		<div class="col-xl-6 col-lg-6 col-md-6 col-xs-12 col-sm-12">
				                    <div class="form-group">
				                        <label for="nama_barang">Nama Barang</label>
				                        <div>
				                            <input type="text" class="form-control form-control-lg" id="nama_barang" name="nama_barang" placeholder="Input data nama barang..">
				                        </div>
				                    </div>
			                	</div>
								
		                		<div class="col-xl-6 col-lg-6 col-md-6 col-xs-12 col-sm-12">			
				                    <div class="form-group">
				                        <label for="kategori_id">Kategori</label>
				                        <div>
			                                <select class="form-control form-control-lg" name="kategori_id">
				                                <option>Pilih</option>
				                                <?php
				                                    if(isset($rs_kategori) && !empty($rs_kategori)){
				                                        foreach ($rs_kategori as $vkategori) {
				                                            echo'<option value="'.$vkategori['kategori_id'].'">'.$vkategori['nama_kategori'].'</option>';
				                                        }
				                                    }
				                                ?>
				                            </select>
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