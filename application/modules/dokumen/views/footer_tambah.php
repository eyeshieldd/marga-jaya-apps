<script>
	$(document).ready(function() {
		var breakpointDefinition = {
            tablet: 1024,
            phone: 480
        };

        // tombol simpan
        $('#tombol-simpan').click(function (){
            var modal = '#modal-add';
            var form = '#form-tambah';
            var formData = new FormData($("#form-tambah")[0]);

            $(form + ' #tombol-simpan').attr('disabled', true);

            $.ajax({
                url: "<?php echo site_url('dokumen/simpan') ?>",
                type: "POST",
                data: formData,
                processData:false,
                contentType:false,
                // data: $(form).serialize(),
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