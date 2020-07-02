<script type="text/javascript">
	jQuery(document).ready(function() {
		/* Set DataTable */
		dtpengiriman = $("#tpengiriman").DataTable({
			"ajax": {
				"url": "<?= base_url('kiriman/get_list_kirim'); ?>",
				"type": "POST",
				"data": function(d){
					d.cabang_id = $('#form-cari [name="cabang_id"]').val()
					d.nama_sopir = $('#form-cari [name="nama_sopir"]').val()

				}
			},
			"sDom": dom_none,
			"serverSide": true,
			"bFilter": true,
			"paging": true,
			"autoWidth": true,
			"ordering": true,
			"order": [],
			"columns": [
			{"data": "tanggal", "orderable": true},
			{"data": "nama_sopir", "orderable": true},
			{"data": "nama_pembeli", "orderable": true},
			{"data": "nama_barang", "orderable": true},
			{"data": "jumlah", "orderable": true},                
			],
			"oLanguage": {
				"sSearch": ""
			}
		});

        /*$('#form-cari [name="dokumen"]').on('keyup', function(){
            dtdokumen.ajax.reload(null, false);
        });*/

        $('#form-cari').on("change", function(){
        	dtpengiriman.ajax.reload(null, false);
        	console.log('asdg')
        });


    })
</script>