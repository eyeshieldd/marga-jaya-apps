<div class="block">
    <!--    <div class="block-header block-header-default">
            <h3 class="block-title">Stock Marga Jaya Tajem </h3>
        </div>-->
    <div class="block-content block-content-full">
        <div class="row ">
            <div class="col-xs-12 col-md-12"><a class="btn btn-secondary btn-lg mb-10" href="<?= base_url('stock/produksi/'.$barang_id.'/'.$cabang_id) ?>">Back</a>
            <button class="btn btn-primary btn-lg mb-10 pull-right" id="tombol-simpan"><i class="fa fa-save"></i> Simpan</button></div>
        </div>

		<div class="row">
		    <div class="col-lg-12 col-xs-12 col-md-12">		        
		        <div class="block">
		            <div class="block-header block-header-default">
		                <h3 class="block-title">Input Nama</h3>
		            </div>		    	
		            <div class="block-content">
		                <form method="post" id="form-tambah" enctype="multipart/form-data">
		                    <div class="form-group row">
		                        <input type="hidden" name="stok_id" value="<?= $stok['stok_id']; ?>">	                    			                    	
		                        <label class="col-lg-2 col-xs-12 col-md-12" for="nama_pegawai">Nama Anda</label>
		                        <div class="col-lg-10 col-xs-12 col-md-12">
		                            <input type="text" class="form-control form-control-lg" id="nama_pegawai" name="nama_pegawai" placeholder="Input data nama anda..">
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