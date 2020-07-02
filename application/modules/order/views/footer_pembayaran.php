<script>
	$(document).ready(function(){		
		$(document).ready(function() {        
            $("#tanggal").datepicker({
                format: 'dd-mm-yyyy',
                defaultViewDate: 'today',
                todayHighlight:true,
                autoclose: true,
            });
        });

		
	});
    only_number('.number', 10);

    // get_list_table();
    // get_unfinished_order();
    
    $("#tombol-simpan").on("click", function(){
        var form = '#form-detail-pembayaran';


        $.ajax({
            url: "<?php echo site_url('order/proses_bayar') ?>",
            type: "POST",
            data: $(form).serialize(),
            timeout: 5000,
            dataType: "JSON",
            success: function (data)
            {
                    // console.log(data);
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
    })

</script>