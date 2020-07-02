<div class="block">
	<div class="block-content block-content-full">
		<div class="row mb-10">
			<div class="col-md-12 col-xs-12">
				<a class="btn btn-alt-secondary btn-lg" href="<?= base_url('order/pembayaran') ?>">Back</a>
				<?php if($result_total['status_pembayaran'] != 'lunas'):?>
				<a class="btn btn-primary btn-lg mb-10 pull-right" href="<?= base_url('order/tambah_pembayaran/'.$order_id.'/') ?>">Pembayaran</a>
				<?php endif;?>
			</div>
		</div>
		<div class="table-responsive">
			<table class="table table-bordered table-striped table-vcenter js-dataTable-full-pagination">
				<thead>
					<tr>
						<th class="text-center" style="width: 10%;">#</th>
						<th class="text-left">Tanggal</th>
						<th>Status</th>
						<th class="text-left">keterangan</th>
						<th class="text-left">Pembayaran</th>
					</tr>
				</thead>
				<tbody>
					<?php 
					$no = 1;
					$total_bayar = 0 ;
					if(isset($result_detail) && !empty($result_detail)){
						foreach ($result_detail as $data  ) {
							$total_bayar += $data['nominal'];
							echo'<tr>';
							echo'<td class="text-center">'.$no++.'</td>';
							echo'<td>'.$data['tanggal_pembayaran'].'</td>';
							echo'<td>'.$data['status_pembayaran'].'</td>';
							echo'<td>'.$data['keterangan'].'</td>';
							echo'<td class="text-right">'.format_rupiah($data['nominal']).'</td>';
							echo'</tr>';
						} 
					} else {
						echo '<tr><td colspan="5">Tidak ada data.</td></tr>';
					}
					?>
					<tr>
						<td colspan="4" class="text-right"><b>Total Bayar</b></td>
						<td class="text-right"><?=format_rupiah($total_bayar)?></td>
					</tr>
					<tr>
						<td colspan="4" class="text-right"><b>Tagihan</b></td>
						<td class="text-right"><?=format_rupiah($result_total['total_biaya'] + $result_total['diskon'] - $result_total['transport'])?></td>
					</tr>
					<tr>
						<td colspan="4" class="text-right"><b>Transport</b></td>
						<td class="text-right"><?=format_rupiah($result_total['transport'])?></td>
					</tr>
					<tr>
						<td colspan="4" class="text-right"><b>Diskon</b></td>
						<td class="text-right"><?=format_rupiah($result_total['diskon'])?></td>
					</tr>
					<tr>
						<td colspan="4" class="text-right"><b>Total Tagihan</b></td>
						<td class="text-right"><?=format_rupiah($result_total['total_biaya'])?></td>
					</tr>
					<tr>
						<td colspan="4" class="text-right"><b>Kurang Bayar</b></td>
						<td class="text-right text-danger table-danger"><b><?=format_rupiah($result_total['total_biaya'] - $total_bayar)?></b></td>
					</tr>
				</tbody>
			</table>
		</div>
	</div>
