<div class="block">
    <!--    <div class="block-header block-header-default">
            <h3 class="block-title">Stock Marga Jaya Tajem </h3>
        </div>-->
    <div class="block-content block-content-full">
        <div class="row ">
            <div class="col-xs-12 col-md-12">
            	<a class="btn btn-secondary btn-lg mb-10" href="<?= base_url('order') ?>">
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
		                	<input type="hidden" name="cabang_id" value="<?=$result_order['nama_cabang']?>">
	    					<div class="row">
			                    <div class="col-lg-4 col-xs-12 col-md-12">
				                    <div class="form-group">
				                        <label for="nama_order">Nama Pembeli</label>
				                        <div>
				                            <input type="text" class="form-control form-control-lg" readonly="readonly" disabled="disabled" name="nama_pembeli" value="<?=$result_order['nama_pembeli']?>" placeholder="Nama Pembeli">
				                        </div>
				                    </div>
			                    </div>
	    						<div class="col-lg-4 col-xs-12 col-md-12">
				                    <div class="form-group">
				                        <label for="tangal">Tanggal</label>
				                        <div>
				                            <input placeholder="dd / mm / yy" type="text" readonly="readonly" disabled="disabled" class="form-control form-control-lg datepicker" name="tanggal" value="<?=$result_order['nama_pembeli']?>">
				                        </div>
				                    </div>
			                    </div>

								<div class="col-lg-4 col-xs-12 col-md-12">
				                    <div class="form-group">
				                        <label for="alamat">Alamat</label>
				                        <div>
				                            <input type="text" class="form-control form-control-lg" readonly="readonly" disabled="disabled" name="alamat" placeholder="Alamat pembeli"  value="<?=$result_order['alamat']?>">
				                        </div>
				                    </div>
			                    </div>								
	    					</div>
	    				</form>
    					<!-- ./row -->
	                    <div class="table-responsive">
	                    	<form id="form-detail-barang" onsubmit="return false">
	                    		<input type="hidden" name="order_id" value="<?=$result_order['order_id']?>">
					            <table id="tabel-barang" class="table table-bordered table-striped">
					                <thead>
					                    <tr>
					                        <th class="text-center" style="width: 10%;">#</th>
					                        <th>Nama Barang</th>
					                        <th class="text-right">Jumlah</th>
					                    </tr>
					                </thead>
					                <tbody>
					                	<?php
					                	if(isset($rs_barang) && !empty($rs_barang)){
					                		$no = 1;
					                		foreach ($rs_barang as $vbarang) {
					                			echo '<tr>';
					                			echo '<td class="text-center">'.$no++.'</td>';
					                			echo '<td>'.$vbarang['nama_barang'].'<table id="item'.$vbarang['barang_id'].'" class="table table-condensed" width="100%">';
					                			echo '<tr class="row_clone"><td width=""><select class="form-control form-control-sm" name="nama_stok['.$vbarang['barang_id'].'][]"><option value=""></option>';
					                			// build data stok
					                			foreach ($rs_stok[$vbarang['barang_id']] as $vstok) {
					                				echo '<option value="'.$vstok['stok_produksi_id'].'">'.$vstok['nama_pegawai'].' ('.$vstok['stok'].')</option>';
					                			}
					                			echo '</select></td>';
					                			echo '<td width="15%"><input type="text" class="form-control form-control-sm jumlah" onchange="val_update_jumlah(this)" name="jumlah['.$vbarang['barang_id'].'][]"  value="0"></td>';
					                			echo '<td width="15%"><button class="btn btn-sm btn-danger tombol-hapus-stok" onclick="removeTerminDetail(this)"><i class="fa fa-trash"></i></button></tr>';
					                			echo '</table><a class="add_row" onclick="return false" href="javascript.void(0)">[Tambah]</a></td>';
					                			echo '<td class="text-right">total : '.$vbarang['jumlah'].'<br>sudah diambil : '.$vbarang['jumlah_terkirim'].'<br>belum diambil : '.($vbarang['jumlah'] - $vbarang['jumlah_terkirim']).'<br>Akan diambil : <span class="text-bold txt-jumlah">0</span> </td>';
					                			echo '</tr>';
					                		}
					                	} else {
					                		echo '<tr><td colspan="3">Tidak ada barang.</td></tr>';
					                	}
					                	?>
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