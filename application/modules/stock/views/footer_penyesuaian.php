<script>
	$(document).ready(function() {
		$("#tanggal").datepicker({
		    format: 'dd-mm-yyyy',		   
		}).datepicker("setDate", new Date());

        //$stok_awal = alert($('input[name=stok_awal]').val());
        only_number('.number', 10);

		// tombol simpan
        $('#tombol-simpan').click(function (){            
            var form = '#form-tambah';
            var stok_awal = $('input[name=stok_awal]').val();

            $(form + ' #tombol-simpan').attr('disabled', true);

            // if (!$(form).isValid()) {
            //     $(form + ' #tombol-simpan').attr('disabled', false);
            //     return;
            // }

            $.ajax({
                url: "<?php echo site_url('stock/simpan_penyesuaian') ?>",
                type: "POST",
                data: $(form).serialize(),
                timeout: 5000,
                dataType: "JSON",
                success: function (data)
                {
                    if (data.status)
                    {
                        notif.success(data.pesan, "Berhasil");
                        $(form)[0].reset();
                    } else {
                        notif.error(data.pesan,'Gagal');
                    }
                },
                error: function (jqXHR, textStatus, errorThrown)
                {
                  alertajax.error(textStatus, jqXHR.status);
                }
            });
            $(form + ' #tombol-simpan').attr('disabled', false);
        });	
	});
</script>