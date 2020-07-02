<script>
	jQuery(function(){ Codebase.helpers(['select2']); });

	$(document).ready(function() {
		only_number('.number', 10);

		$("#tanggal").datepicker({
		    format: 'dd-mm-yyyy',
		    // defaultViewDate: 'today',
		    todayHighlight:true,
		    autoclose: true,
		});

		$("#diskon").on("change", function(){
			update_total_bayar();
		})

		$("#transport").on("change", function(){
			update_total_bayar();
		})

		$("#tombol-simpan").on("click", function(){
			var form1 = '#form-order';
			var form2 = '#form-detail-order';

			$.ajax({
                url: "<?php echo site_url('order/proses_ubah_order') ?>",
                type: "POST",
                data: $(form1).serialize() + '&' + $(form2).serialize() + '&diskon=' +$("#diskon").val() + '&transport=' +$("#transport").val(),
                timeout: 5000,
                dataType: "JSON",
                success: function (data)
                {
                    if (data.status)
                    {
                        notif.success(data.pesan, "Berhasil");
                        // location.reload();
                        window.setTimeout(function(){location.reload()}, 2000);
                    } else {
                        notif.error(data.pesan,'Gagal');
                    }
                },
                error: function (jqXHR, textStatus, errorThrown)
                {
                  alertajax.error(textStatus, jqXHR.status);
                }
            });
		})
	})

	function hitung_subtotal(ths){
		console.log($(ths).parent())
		var total = 0;
        $(ths).parentsUntil("table").find("tr.row_item").each(function () {
            total = total + (parseInt($(this).find('input[name="harga[]"]').val()) * parseInt($(this).find('input[name="jumlah[]"]').val()));
            
            $(this).find('span.subt').text(accounting.formatNumber((parseInt($(this).find('input[name="harga[]"]').val()) * parseInt($(this).find('input[name="jumlah[]"]').val()))))
	        // console.log($(this).find('input[name="harga[]"]').val())
        });
        $("#total_biaya").val(total)
        update_total_bayar();
        // console.log(total)
	}

	function update_total_bayar(){
		var total_biaya = diskon = total_bayar = transport = 0;
		if($("#total_biaya").val() == 0){
			total_biaya = 0;
		} else {
			total_biaya = $("#total_biaya").val();
		}

		if($("#diskon").val() == 0){
			diskon = 0;
		} else {
			diskon = parseInt($("#diskon").val());
		}

		if($("#transport").val() == 0){
			transport = 0;
		} else {
			transport = parseInt($("#transport").val());
		}

		total_bayar = total_biaya - diskon;
		$("#total_bayar").val(total_bayar);

		var kurang_bayar = total_biaya - diskon + transport - parseInt($("#sudah_bayar").val());
		$("#kurang_bayar").val(kurang_bayar);
	}
</script>
