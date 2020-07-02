<script>
	jQuery(document).ready(function() {
        only_number('.jumlah', 10);

        // tombol ubah - update data
        $('#tombol-ubah').click(function (){
            var modal = '#modal-add';
            var form = '#form-edit';

            $(form + ' #tombol-ubah').attr('disabled', true);            

            $.ajax({
                url: "<?php echo site_url('kategori/ubah') ?>",
                type: "POST",
                data: $(form).serialize(),
                timeout: 5000,
                dataType: "JSON",
                success: function (data)
                {
                    if (data.status)
                    {
                        notif.success(data.pesan, "Berhasil");
                        // $(form)[0].reset();
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
        })

        $(".dataTables_filter input").addClass('form-control form-control-lg');
        $(".dataTables_filter input").attr('placeholder', 'Search');
        $(".dataTables_filter").attr('float', 'left !important');
    })
</script>