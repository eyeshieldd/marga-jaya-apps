<script>
   jQuery(document).ready(function() {
        // update cabang
        $('#tombol-simpan').click(function (){
            var form = '#form-edit';
            var url = '<?= base_url('user') ?>';

            $(form + ' #tombol-simpan').attr('disabled', true);            

            $.ajax({
                url: "<?php echo site_url('user/update_process') ?>",
                type: "POST",
                data: $(form).serialize(),
                timeout: 5000,
                dataType: "JSON",
                success: function (data)
                {
                    if (data.status)
                    {
                        notif.success(data.pesan, "Berhasil");
                        // window.location.href = url; // back to controller cabang
                        $(form).reload();                                    
                        // $(form)[0].reset();                        
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
        });
    })
</script>