<div class="block">
    <!--    <div class="block-header block-header-default">
            <h3 class="block-title">Stock Marga Jaya Tajem </h3>
        </div>-->
    <div class="block-content block-content-full">
        <div class="row ">
            <div class="col-xs-12 col-md-12">
            	<a class="btn btn-secondary btn-lg mb-10" href="<?= base_url('order/tambah') ?>">
            		Back
            	</a>
            	<button class="btn btn-primary btn-lg mb-10 pull-right" id="tombol-simpan"><i class="fa fa-save"></i> Simpan</button>
            </div>
        </div>

		<div class="row">
		    <div class="col-xs-12 col-md-12">		        
		        <div class="block">
		            <div class="block-header block-header-default">
		                <h3 class="block-title">Pengambilan Barang</h3>
		            </div>		            
		            <div class="block-content">
		                <form action="" method="" enctype="multipart/form-data">
		                	<input type="hidden" name="cabang_id" value="<?=$result_cabang['nama_cabang']?>">
	    					<div class="row">
			                    <div class="col-lg-4 col-xs-12 col-md-12">
				                    <div class="form-group">
				                        <label for="nama_order">Nama Pembeli</label>
				                        <div>
				                            <input type="text" class="form-control form-control-lg" id="nama_pembeli" name="nama_pembeli" placeholder="Nama Pembeli">
				                        </div>
				                    </div>
			                    </div>

	    						<div class="col-lg-4 col-xs-12 col-md-12">
				                    <div class="form-group">
				                        <label for="tangal">Tanggal</label>
				                        <div>
				                            <input placeholder="dd / mm / yy" type="text" class="form-control form-control-lg datepicker" name="tanggal" id="tanggal">
				                        </div>
				                    </div>
			                    </div>

								<div class="col-lg-4 col-xs-12 col-md-12">
				                    <div class="form-group">
				                        <label for="alamat">Alamat</label>
				                        <div>
				                            <input type="text" class="form-control form-control-lg" id="alamat" name="alamat" placeholder="Alamat pembeli">
				                        </div>
				                    </div>
			                    </div>								
	    					</div>
	    				</form>
    					<!-- ./row -->
	                    <div class="table-responsive">
	                    	<form id="form-detail-barang" onsubmit="return false">
					            <table id="tabel-barang" class="table table-bordered table-striped table-vcenter js-dataTable-full-pagination">
					                <thead>
					                    <tr>
					                        <th class="text-center" style="width: 10%;">#</th>
					                        <th>Nama Barang</th>
					                        <th class="text-right">Jumlah</th>
					                    </tr>
					                </thead>
					                <tbody>
					                </tbody>
					            </table>
					        </form>
				        </div>

		            </div>
		        </div>
		    </div>
			<!-- ./col-md-12 -->
		</div>
		<!-- ./row -->
	</div>
</div>