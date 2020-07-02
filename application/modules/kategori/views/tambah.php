<div class="block">
    <!--    <div class="block-header block-header-default">
            <h3 class="block-title">Stock Marga Jaya Tajem </h3>
        </div>-->
        <div class="block-content block-content-full">
        	<div class="row ">
        		<div class="col-xs-12 col-md-12"><a class="btn btn-secondary btn-lg mb-10" href="<?= base_url('kategori') ?>">Back</a>
        			<button class="btn btn-primary btn-lg mb-10 pull-right" id="tombol-simpan"><i class="fa fa-save"></i> Simpan</button></div>
        		</div>

        		<div class="row">			
        			<div class="col-lg-12 col-xs-12 col-md-12">		        
        				<div class="block">
        					<div class="block-header block-header-default">
        						<h3 class="block-title">Input Kategori</h3>		                
        					</div>
        					<div class="block-content">
        						<form method="post" id="form-tambah" onsubmit="return false" enctype="multipart/form-data">
        							<div class="form-group row">
        								<label class="col-lg-2 col-xs-12 col-md-12" for="nama_kategori">Nama Kategori</label>
        								<div class="col-lg-10 col-xs-12 col-md-12">
        									<input type="text" class="form-control form-control-lg" id="nama_kategori" name="nama_kategori" placeholder="Input data nama kategori..">
        								</div>
        							</div>

        							<div class="form-group row">
        								<label class="col-lg-2 col-xs-12 col-md-12" for="satuan">Satuan</label>
        								<div class="col-lg-10 col-xs-12 col-md-12">
        									<select class="form-control form-control-lg" name="satuan" id="satuan">
        										<option value="">Pilih</option>
        										<option value="m2">m2</option>
        										<option value="pcs">pcs</option>
        									</select>
        								</div>
        							</div>

        							<div class="form-group row">
        								<label class="col-lg-2 col-xs-12 col-md-12" for="konversi">Konversi</label>
        								<div class="col-lg-10 col-xs-12 col-md-12">
        									<input type="text" class="form-control form-control-lg jumlah" id="konversi" name="konversi" >
        								</div>
        							</div>

        							<div class="form-group row">
        								<label class="col-lg-2 col-xs-12 col-md-12" for="chart">Show Chart</label>
        								<div class="col-lg-10 col-xs-12 col-md-12">
        									<label><input type="checkbox" name="chart" value="1">  </label>
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