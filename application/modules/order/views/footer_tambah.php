<script>
	jQuery(function() {
		Codebase.helpers(['select2']);
	});
	$(document).ready(function() {
		$("#tanggal").datepicker({
			format: 'dd-mm-yyyy',
			defaultViewDate: 'today',
			todayHighlight: true,
			autoclose: true,
		});

		only_number('.number', 10);

		get_list_table();
		get_unfinished_order();

		// $('.select2').select2();
		$("#tombol-tambah-barang").on("click", function() {
			var barang = sessionStorage.getItem('daftar_barang')
			var cart = [];
			if (barang != null && barang != '')
				cart = JSON.parse(barang)
			var id = $('form select[name="nama_barang"]').select2('data')[0].id;
			var item = {};
			// console.log(cart)
			item['id'] = id;
			item['nama_barang'] = $('form select[name="nama_barang"]').select2('data')[0].text;
			item['jumlah'] = $('form input[name="jumlah"]').val();
			item['pengambilan'] = $('form select[name="status_pengambilan"]').val();
			item['harga'] = $('form input[name="harga"]').val();
			item['sub_total'] = parseInt(item['jumlah']) * parseInt(item['harga']);

			/* validasi */
			if (item['id'] == '') {
				$.alert({
					title: 'Perhatian!',
					content: 'Barang belum dipilih.',
					type: 'red',
				});
				return;
			}

			if (item['jumlah'] == 0 || item['jumlah'] == '') {
				$.alert({
					title: 'Perhatian!',
					content: 'Jumlah barang belum ditentukan.',
					type: 'red',
				});
				return;
			}

			cart.push(item)
			// console.log(JSON.stringify(cart))
			sessionStorage.setItem('daftar_barang', JSON.stringify(cart))
			get_list_table();
			$("#form-tambah-barang")[0].reset();
			$('form select[name="nama_barang"]').val('').trigger('change');
		})

		$("#total_biaya").on("change", function() {
			update_total_bayar();
		})

		$("#diskon").on("change", function() {
			update_total_bayar();
		})

		$("#transport").on("change", function() {
			update_total_bayar();
		})

		$("#tabel-barang").on("click", ".tombol-hapus", function() {
			var data_id = $(this).attr('data-id');
			// console.log(data_id);
			delete_item(data_id);
		})

		$('#status_pembayaran').on("change", function() {
			switch ($('#status_pembayaran').val()) {
				case "dp":
				case "termin":
					update_status_pembayaran(true);
					break;
				default:
					update_status_pembayaran(false);
			}
		})

		$("#tombol-simpan").on("click", function() {
			var penjualan = {};
			penjualan['cabang_id'] = $("#cabang_id").val();
			penjualan['nama_pembeli'] = $("#nama_pembeli").val();
			penjualan['tanggal'] = $("#tanggal").val();
			penjualan['alamat'] = $("#alamat").val();
			penjualan['total_biaya'] = $("#total_biaya").val();
			penjualan['transport'] = $("#transport").val();
			penjualan['diskon'] = $("#diskon").val();
			penjualan['total_bayar'] = $("#total_bayar").val();
			penjualan['status_pembayaran'] = $("#status_pembayaran").val();
			penjualan['uang_muka'] = $("#uang_muka").val();

			/* validasi */
			if (penjualan['nama_pembeli'] == '') {
				$.alert({
					title: 'Perhatian!',
					content: 'Nama pembeli belum diisi.',
					type: 'red',
				});
				return;
			}

			if (penjualan['tanggal'] == '') {
				$.alert({
					title: 'Perhatian!',
					content: 'Tanggal belum diisi.',
					type: 'red',
				});
				return;
			}

			if (penjualan['status_pembayaran'] == '') {
				$.alert({
					title: 'Perhatian!',
					content: 'Status pembayaran belum diisi.',
					type: 'red',
				});
				return;
			}

			if (penjualan['total_bayar'] == '') {
				$.alert({
					title: 'Perhatian!',
					content: 'Total pembayaran masih kosong. Silakan isi total biaya dan diskon jika ada.',
					type: 'red',
				});
				return;
			}

			var detail_penjualan = sessionStorage.getItem('daftar_barang');

			$.ajax({
				url: "<?php echo site_url('order/proses_tambah') ?>",
				type: "POST",
				data: 'penjualan=' + JSON.stringify(penjualan) + '&detail_penjualan=' + detail_penjualan,
				timeout: 15000,
				dataType: "JSON",
				success: function(data) {
					if (data.status) {
						notif.success(data.pesan, "Berhasil");
						sessionStorage.setItem('daftar_barang', '')
						sessionStorage.setItem('data_penjualan', '')
						window.setTimeout(function() {
							location.href = data.href
						}, 2000);
						// window.location.href = data.url;
					} else {
						notif.error(data.pesan, 'Gagal');
					}
				},
				error: function(jqXHR, textStatus, errorThrown) {
					alertajax.error(textStatus, jqXHR.status);
				}
			});

		})
	});

	function update_status_pembayaran(st) {
		if (st)
			$("#div-uang-muka").show();
		else
			$("#div-uang-muka").hide();
	}

	function update_total_bayar() {
		var total_biaya = diskon = total_bayar = transport = 0;
		if ($("#total_biaya").val() == 0) {
			total_biaya = 0;
		} else {
			total_biaya = $("#total_biaya").val();
		}

		if ($("#diskon").val() == 0) {
			diskon = 0;
		} else {
			diskon = parseInt($("#diskon").val());
		}

		if ($("#transport").val() == 0) {
			transport = 0;
		} else {
			transport = parseInt($("#transport").val());
		}

		total_bayar = total_biaya - diskon + transport;
		$("#total_bayar").val(total_bayar);
	}

	function get_list_table() {
		var barang = sessionStorage.getItem('daftar_barang')
		$('#tabel-barang tbody').empty();
		var baris = '';
		if (barang == null || barang == '' || JSON.parse(barang).length == 0) {
			baris = '<tr><td colspan="5">Belum ada data.</td></tr>';
			$('#tabel-barang tbody').append(baris);
			return;
		}

		var total_biaya = 0;
		var listbarang = JSON.parse(barang);
		listbarang.forEach(function(item, index, array) {
			baris += '<tr>';
			baris += '<td class="text-center">' + (index + 1) + '. </td>';
			baris += '<td>' + item.nama_barang + ' <br/> Rp ' + accounting.formatNumber(item.harga);
			if (item.pengambilan == "diambil") {
				baris += ' <br/> <label class="badge badge-success">diambil</label>';
			}
			baris += '</td>';
			baris += '<td class="text-right">' + accounting.formatNumber(item.jumlah) + '</td>';
			baris += '<td class="text-right">' + accounting.formatNumber(item.sub_total) + '</td>';
			baris += '<td class="text-center"><button type="button" class="btn btn-sm btn-alt-danger tombol-hapus" data-toggle="tooltip" title="Hapus Data" data-id="' + index + '"><i class="fa fa-trash"></i></button></td>';
			baris += '</tr>';

			total_biaya = total_biaya + item.sub_total;
		})

		$('#tabel-barang tbody').append(baris);

		// hitung total
		$("#total_biaya").val(total_biaya);

		update_total_bayar();
	}

	function delete_item(i) {
		var barang = sessionStorage.getItem('daftar_barang');
		var baris = '';
		if (barang == null) {
			return;
		}
		var listbarang = JSON.parse(barang);
		listbarang.splice(i, 1);

		sessionStorage.setItem('daftar_barang', JSON.stringify(listbarang))
		get_list_table();
	}

	function get_unfinished_order() {
		var penjualan = sessionStorage.getItem('data_penjualan');
		if (penjualan == '' || penjualan == null) {
			return;
		}

		var data_penjualan = JSON.parse(penjualan);
		$("#nama_pembeli").val(data_penjualan['nama_pembeli']);
		$("#tanggal").val(data_penjualan['tanggal']);
		$("#alamat").val(data_penjualan['alamat']);
		$("#transport").val(data_penjualan['transport']);
		$("#diskon").val(data_penjualan['diskon']);
		$("#total_biaya").val(data_penjualan['total_biaya']);
		$("#total_bayar").val(data_penjualan['total_bayar']);
		$("#status_pembayaran").val(data_penjualan['status_pembayaran']);
		$("#uang_muka").val(data_penjualan['uang_muka']);

		$('#tanggal').datepicker('update');

		switch ($('#status_pembayaran').val()) {
			case "dp":
			case "termin":
				update_status_pembayaran(true);
				break;
			default:
				update_status_pembayaran(false);
		}

	}
</script>