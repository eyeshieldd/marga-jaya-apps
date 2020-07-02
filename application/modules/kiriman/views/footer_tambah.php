<script>
	$(document).ready(function() {		
		$("#tanggal").datepicker({
            format: 'dd-mm-yyyy',
            defaultViewDate: 'today',
            todayHighlight:true,
            autoclose: true,
         

        });
    // only_number('.number', 10);
});

    only_number('.jumlah', 10);

    jQuery(document).ready(function() {        
        // tombol simpan
        $('#tombol-simpan').click(function (){            
        	var form = '#form-tambah'	;
           var $select = $('#my_select');
           var $selecto = $('#selecto');
           var $select = $('#select');


           $(form + ' #tombol-simpan').attr('disabled', true);

           $.ajax({
               url: "<?php echo site_url('kiriman/proses_simpan') ?>",
               type: "POST",
               data: $(form).serialize(),
               timeout: 5000,
               dataType: "JSON",
               success: function (data)
               {	
                  if (data.status)
                  {
               // $("#my_select").val('').trigger('change');
               // $("#select").val('').trigger('change');
               // $("#selecto").val('').trigger('change');
               // $(form)[0].reset();
               // window.location.reload(2000)
               notif.success(data.pesan, "Berhasil");
               window.setTimeout(function(){location.reload()},1000)
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
    })

    $("#my_select").select2();
    $("#my_select").change(function() {
        var id = $(this).val();
        // console.log(id);

        $.ajax({
            url: "<?php echo site_url('kiriman/get_barangjs') ?>",
            type: "POST",
            data: {id : id},
            timeout: 5000,
            dataType: "JSON",
            success: function (data)
            {  

                console.log(data) 
                
                if (data.status)
                {

                    var $select = $('#select');
                    $("#select").empty();

                    $select.append('<option value="">Pilih</option>'); 
                    $.each(data.data,function(value, text)
                    {


                        $select.append('<option value=  ' + text.detail_id + '>'  + text.nama_barang + ' ('+ text.jumlah +')('+ text.jumlah_terkirim +') </option>'); 
                    });
                } 
            },
            error: function (jqXHR, textStatus, errorThrown)
            {
                alertajax.error(textStatus, jqXHR.status);
            }

        });
    });
    $("#selecto").select2();
    $("#select").select2();
    $("#select").change(function() {
        console.log()
        var id_stok = $(this).val()
        console.log(id_stok);

        $.ajax({
            url: "<?php echo site_url('kiriman/get_stokjs') ?>",
            type: "POST",
            data: {id_stok : id_stok},
            timeout: 5000,
            dataType: "JSON",
            success: function (data)
            {   
                if (data.status)
                {
                    var $selecto = $('#selecto');
                // var $select = $('#select');

                // $("#select").empty();
                $("#selecto").empty();




                $selecto.append('<option value="">Pilih</option>'); 
                $.each(data.data,function(index, value)
                {

                    $selecto.append('<option value=' + value.stok_produksi_id+ '>' + value.nama_pegawai + ' ('+ value.stok +')  </option>'); 

                });
            } 
        // console.log(data);
    },
    error: function (jqXHR, textStatus, errorThrown)
    {
        alertajax.error(textStatus, jqXHR.status);
    }

});


    });


</script>