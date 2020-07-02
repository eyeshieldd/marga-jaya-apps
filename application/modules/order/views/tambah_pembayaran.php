<div class="block">

	<div class="block-content block-content-full">
		<div class="row ">
			<div class="col-xs-12 col-md-12"><a class="btn btn-secondary btn-lg mb-10" href="<?= base_url('order/Pembayaran/'.$order_id.'/') ?>">Back</a>
				<button class="btn btn-primary btn-lg mb-10 pull-right" id="tombol-simpan"><i class="fa fa-save"></i> Simpan</button></div>
			</div>



			<div class="row">
				<div class="col-lg-12 col-xs-12 col-md-12">		        
					<div class="block">
						<form id="form-detail-pembayaran" onsubmit="return false">
							<input type="hidden" name="order_id" value="<?=$order_id;?>" id="cabang_id">
							<div class="block-header block-header-default">
								<h3 class="block-title">Input Pembayaran</h3>
							</div>	
						</div>	
						<div class="block-content">
							<div class="form-group row">
								<label class="col-lg-2 col-xs-12 col-md-12" for="nama_pegawai">Tanggal Pembayaran</label>	
								<div class="col-lg-10 col-xs-12 col-md-12">
									<input placeholder="dd / mm / yy" type="text" class="datepicker form-control form-control-lg" name="tanggal" id="tanggal" value="<?=date('d-m-Y')?>">
								</div>
							</div>
							<div class="form-group row">
								<label class="col-lg-2 col-xs-12 col-md-12" for="nama_pegawai">Nominal</label>
								<div class="col-lg-10 col-xs-12 col-md-12">
									<input type="text" class="form-control form-control-lg number" id="nominal" name="nominal" >
								</div>
							</div>
							<input type="hidden" value="termin" name="status"> 
							<!-- <div class="form-group row">
								<label class="col-lg-2 col-xs-12 col-md-12" for="nama_pegawai">Status Pembayaran</label>
								<div class="col-lg-10 col-xs-12 col-md-12">
									<select class="form-control form-control-lg" name="status" id="status">
										<option value="termin">termin</option>
									</select>
								</div>

							</div> 	 -->
						</form>
					</div>
				</div>
			</form>
		</div>
		<!-- ./col-md-12 -->
	</div>
	<!-- ./row -->
</div>
</div>