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
		                <h3 class="block-title">Ubah Order #<?=$result_order['no_order']?></h3>
		            </div>		            
		            <div class="block-content">
		                <form action="" method="" enctype="multipart/form-data" id="form-order">
		                	<input type="hidden" name="order_id" value="<?=$result_order['order_id']?>">
	    					<div class="row">
			                    <div class="col-lg-4 col-xs-12 col-md-12">
				                    <div class="form-group">
				                        <label for="nama_order">Nama Pembeli</label>
				                        <div>
				                            <input type="text" class="form-control form-control-lg" id="nama_pembeli" name="nama_pembeli" placeholder="Nama Pembeli" value="<?=$result_order['nama_pembeli']?>">
				                        </div>
				                    </div>
			                    </div>

	    						<div class="col-lg-4 col-xs-12 col-md-12">
				                    <div class="form-group">
				                        <label for="tangal">Tanggal</label>
				                        <div>
				                            <input placeholder="dd / mm / yy" type="text" class="form-control form-control-lg datepicker" name="tanggal" id="tanggal" value="<?=date('d-m-Y')?>">
				                        </div>
				                    </div>
			                    </div>

								<div class="col-lg-4 col-xs-12 col-md-12">
				                    <div class="form-group">
				                        <label for="alamat">Alamat</label>
				                        <div>
				                            <input type="text" class="form-control form-control-lg" id="alamat" name="alamat" placeholder="Alamat pembeli" value="<?=$result_order['alamat']?>">
				                        </div>
				                    </div>
			                    </div>								
	    					</div>
	    				</form>
    					<!-- ./row -->
    					<hr>
						
	                    <div class="table-responsive">
	                    	<form id="form-detail-order" onsubmit="return false">
					            <table id="tabel-barang" class="table table-bordered table-striped table-vcenter js-dataTable-full-pagination">
					                <thead>
					                    <tr>
					                        <th class="text-center" style="width: 10%;">#</th>
					                        <th>Nama Barang</th>
					                        <th class="" style="width: 8%;">Diambil</th>
					                        <th class="text-right" style="width: 15%;">Harga</th>
					                        <th class="text-right" style="width: 15%;">Jumlah</th>
					                        <th class="text-right" style="width: 20%;">Sub Total</th>
					                    </tr>
					                </thead>
					                <tbody>
					                	<?php
					                	if(isset($rs_item) && !empty($rs_item)){
					                		$no = 1;
					                		$total_biaya = 0;
					                		foreach ($rs_item as $vitem) {
					                			// selected diambil / tidak
					                			$selected = $vitem['jenis_pengiriman'] == 'diambil'? 'checked="checked"' : '';
					                			echo '<tr class="row_item">';
					                			echo '<input type="hidden" name="item[]" value="'.$vitem['detail_id'].'">';
					                			echo '<td class="text-center">'.$no++.'</td>';
					                			echo '<td>'.$vitem['nama_barang'].'</td>';
					                			echo '<td><input name="diambil['.$vitem['detail_id'].']" type="checkbox" '.$selected.' class="form-control" value="1"></td>';
					                			echo '<td><input name="harga[]" onchange="hitung_subtotal(this)" type="text" class="form-control text-right number" value="'.$vitem['harga'].'"></td>';
					                			echo '<td><input name="jumlah[]" onchange="hitung_subtotal(this)" type="text" class="form-control text-right number" value="'.$vitem['jumlah'].'"</td>';
					                			echo '<td class="text-right"><span class="subt">'.number_format($vitem['jumlah'] * $vitem['harga']).'</span></td>';
					                			echo '</tr>';
					                			$total_biaya += $vitem['jumlah'] * $vitem['harga'];
					                		}
					                	} else {
					                		echo '<tr><td colspan="5">Belum ada data.</td></tr>';
					                	}
					                	?>
					                </tbody>
					            </table>
					        </form>
				        </div>
				        <form>
						<div class="row">
							<div class="col-lg-12 col-xs-12 col-md-12">		
                                <div class="form-group pull-right row">
                                    <label class="col-lg-4 col-form-label" for="total_biaya">Total Biaya</label>
                                    <div class="col-lg-8">
                                        <input type="text" readonly="readonly" class="form-control form-control-lg text-right number" id="total_biaya" name="total_biaya" value="<?=number_format($total_biaya)?>">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
							<div class="col-lg-12 col-xs-12 col-md-12">		
                                <div class="form-group pull-right row">
                                    <label class="col-lg-4 col-form-label" for="total_biaya">Transport</label>
                                    <div class="col-lg-8">
                                        <input type="text" class="form-control form-control-lg text-right number" id="transport" name="transport" value="<?=number_format($result_order['transport'])?>">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
							<div class="col-lg-12 col-xs-12 col-md-12">	
                                <div class="form-group row pull-right">
                                    <label class="col-lg-4 col-form-label" for="total_bayar">Diskon</label>
                                    <div class="col-lg-8">
                                        <input type="text" class="form-control form-control-lg text-right number" id="diskon" name="total_bayar" value="<?=number_format($result_order['diskon'])?>">
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row">
							<div class="col-lg-12 col-xs-12 col-md-12">	
                                <div class="form-group row pull-right">
                                    <label class="col-lg-4 col-form-label" for="total_bayar">Total Bayar</label>
                                    <div class="col-lg-8">
                                        <input type="text" readonly="readonly" class="form-control form-control-lg text-right number" id="total_bayar" name="total_bayar" value="<?=number_format($total_biaya - $result_order['diskon'])?>">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
							<div class="col-lg-12 col-xs-12 col-md-12">	
                                <div class="form-group row pull-right">
                                    <label class="col-lg-4 col-form-label" for="sudah_bayar">Sudah bayar</label>
                                    <div class="col-lg-8">
                                        <input type="text" readonly="readonly" class="form-control form-control-lg text-right number" id="sudah_bayar" name="sudah_bayar" value="<?=number_format($result_pembayaran)?>">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
							<div class="col-lg-12 col-xs-12 col-md-12">	
                                <div class="form-group row pull-right">
                                    <label class="col-lg-4 col-form-label" for="sudah_bayar">Kurang bayar</label>
                                    <div class="col-lg-8">
                                        <input type="text" readonly="readonly" class="form-control form-control-lg text-right number" id="kurang_bayar" name="kurang_bayar" value="<?=number_format($result_order['total_biaya'] - $result_pembayaran)?>">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- ./row -->
                        <!-- <div class="row">
							<div class="col-lg-12 col-xs-12 col-md-12">
                                <div class="form-group row pull-right">
                                    <label class="col-lg-4 col-form-label" for="status">Status</label>
                                    <div class="col-lg-8">
                                        <select class="form-control form-control-lg" id="status_pembayaran" name="status_pembayaran">
		                                    <option></option>
		                                    <option value="termin">Termin</option>
		                                    <option value="dp">Uang DP</option>
		                                    <option value="lunas">Lunas</option>
		                                    <option value="belum bayar">Belum Dibayar</option>      
		                                </select>
                                    </div>
                                </div>
                            </div>
                        </div> -->
                        <div class="row" id="div-uang-muka" style="display: none">
							<div class="col-lg-12 col-xs-12 col-md-12">	
                                <div class="form-group row pull-right">
                                    <label class="col-lg-4 col-form-label" for="total_bayar">Uang Muka</label>
                                    <div class="col-lg-8">
                                        <input type="text" class="form-control form-control-lg text-right number" id="uang_muka" name="uang_muka" value="0">
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