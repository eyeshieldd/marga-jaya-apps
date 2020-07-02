<div class="block">
	<div class="block-content block-content-full">
		<div class="row mb-10">
			<div class="col-md-12 col-xs-12">
				<a class="btn btn-alt-secondary btn-lg" href="<?= base_url('order/pembayaran') ?>">Back</a>
				<!-- <a class="btn btn-primary btn-lg mb-10 pull-right" href="<?= base_url('order/tambah_pembayaran/'.$order_id.'/') ?>">Pembayaran</a> -->
			</div>
		</div>
		<div class="table-responsive">
			<table class="table table-bordered table-striped table-vcenter js-dataTable-full-pagination">
				<thead>
					<tr>
						<th class="text-center" style="width: 10%;">#</th>
						<th class="text-left">Tanggal</th>
						<th>Nama Barang</th>
						<th>Jenis Distribusi</th>
						<th>Keterangan</th>
					</tr>
				</thead>
				<tbody>
					<?php 
					$no = 1;
					if(isset($order_kirim) && !empty($order_kirim)){
						foreach ($order_kirim as $data  ) {
							echo'<tr>';
							echo'<td class="text-center">'.$no++.'</td>';
							echo'<td>'.$data['tanggal'].'</td>';
							echo'<td>'.$data['nama_barang'].'</td>';
							echo'<td>'.$data['jenis_pengiriman'].'</td>';
							echo'<td>'.$data['keterangan'].'</td>';

							echo'</tr>';
						} 
					}else {
						echo '<tr><td colspan="5">Tidak ada data.</td></tr>';

					}
					?>
			</tbody>
		</table>
	</div>
</div>
