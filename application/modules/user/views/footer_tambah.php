<script>
   jQuery(document).ready(function() {

    // tombol simpan
        $('#tombol-simpan').click(function (){
            var form = '#form-tambah';

            $(form + ' #tombol-simpan').attr('disabled', true);

            $.ajax({
                url: "<?php echo base_url('user/simpan') ?>",
                type: "POST",
                data: $(form).serialize(),
                timeout: 10000,
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
                    $(form + ' #tombol-simpan').attr('disabled', false);
                },
                error: function (jqXHR, textStatus, errorThrown)
                {
                  alertajax.error(textStatus, jqXHR.status);
                  $(form + ' #tombol-simpan').attr('disabled', false);
                }
            });
        })


    })
</script>