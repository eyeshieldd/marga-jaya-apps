<div class="block">
    <!--    <div class="block-header block-header-default">
            <h3 class="block-title">Stock Marga Jaya Tajem </h3>
        </div>-->
    <div class="block-content block-content-full">
        <div class="row ">
            <div class="col-xs-12 col-md-12">
            	<a class="btn btn-secondary btn-lg mb-10" href="<?= base_url('barang') ?>">Back</a>            	
            	<button class="btn btn-primary btn-lg mb-10 pull-right" id="tombol-ubah"><i class="fa fa-pencil-square-o"></i> Ubah Data</button>
        	</div>        
        </div>

		<div class="row">
		    <div class="col-lg-12 col-xs-12 col-md-12">		        
		        <div class="block">
		            <div class="block-header block-header-default">
		                <h3 class="block-title">Edit Barang</h3>
		            </div>
		            <div class="block-content">
		                <form method="post" id="form-edit" enctype="multipart/form-data">
		                    <input type="hidden" name="barang_id" value="<?= $barang['barang_id']; ?>">

		                    <div class="form-group row">
		                        <label class="col-lg-2 col-xs-12 col-md-12" for="nama_barang">Nama Barang</label>
		                        <div class="col-lg-10 col-xs-12 col-md-12">
		                            <input type="text" class="form-control form-control-lg" id="nama_barang" name="nama_barang" value="<?= $barang['nama_barang']; ?>">
		                        </div>		            
		                    </div>
		                    <div class="form-group row">
		                        <label class="col-lg-2 col-xs-12 col-md-12">Kategori</label>
		                        <div class="col-lg-10 col-xs-12 col-md-12">                           
	                                <select class="form-control form-control-lg" name="kategori_id">
		                                <?php
		                                    if(isset($rs_kategori) && !empty($rs_kategori)){
		                                        foreach ($rs_kategori as $vkategori) {
		                                            // echo'<option value="'.$vkategori['kategori_id'].'">'.$vkategori['nama_kategori'].'</option>';

		                                            echo'<option value="'.$vkategori['kategori_id'].'" ';
                                            		echo ($barang['kategori_id'] == $vkategori['kategori_id']) ? "selected" : "";
                                            		echo '>'.$vkategori['nama_kategori'].'</option>';
		                                        }
		                                    }
		                                ?>
		                            </select>                            
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