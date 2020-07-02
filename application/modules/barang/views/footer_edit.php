<script>
   jQuery(document).ready(function() {
        // update barang
        $('#tombol-ubah').click(function (){            
            var form = '#form-edit';
            var url = '<?= base_url('barang') ?>';

            $(form + ' #tombol-ubah').attr('disabled', true);            

            $.ajax({
                url: "<?php echo site_url('barang/ubah') ?>",
                type: "POST",
                data: $(form).serialize(),
                timeout: 5000,
                dataType: "JSON",
                success: function (data)
                {
                    if (data.status)
                    {
                        notif.success(data.pesan, "Berhasil");
                        /* kembali ke home page
                        window.location.href = url; */
                        $(form).reload();
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
    })
</script>