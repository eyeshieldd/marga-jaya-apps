<script>
	jQuery(function(){ Codebase.helpers(['select2']); });
	$(document).ready(function() {
		$(".select2").select2();
		$(".add_row").on("click", function(){
			// console.log('tes')
			var klo = $(this).parent().find("table tr.row_clone").last()
			// klo.find(".select2").select2();
			var tes = klo.clone().insertAfter(klo)
            tes.find("input.jumlah").val(0);

            // console.log(ths)
            var total = 0;
            $(this).parent().find("table tr.row_clone input.jumlah").each(function () {
                total = total + parseInt($(this).val());
            });

            $(this).parent().parent().find("td .txt-jumlah").text(total)
            
            console.log(total)
		})

		$("#tombol-simpan").on("click", function(){
			var form = '#form-detail-barang';

			$.ajax({
                url: "<?php echo site_url('order/proses_pengambilan') ?>",
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

	});

	function removeTerminDetail(ths) {
        var td = $(ths).parent(),
                tr = td.parent(), tb = tr.parent();
        if(tr.parent().find('tr.row_clone').length > 1){
	        $(tr).remove();
        }
        var total = 0;
        tb.find("tr.row_clone input.jumlah").each(function () {
            total = total + parseInt($(this).val());
            console.log(parseInt($(this).val()))
        });
        tb.parentsUntil("tbody#parent-tabel").find("td .txt-jumlah").text(total)
        // val_update_jumlah(tb)
	    
    }

    // function val_update(ths){
    //     // console.log(ths)
    //     table=document.getElementsByTagName('table');
    //     // console.log(table)

    //     // $(ths).parentsUntil("table").css({"color": "red", "border": "2px solid red"});

    //     for (var i = 1; i < table.length; i++) {
    //         // table=document.getElementsById('item'+table[i]);
    //         tableId = table[i].id;
    //         // console.log(tableId);

    //         var total = 0;
    //         // $(ths).parentsUntil("table").find("tr.row_clone input.jumlah").each(function () {
    //         //         total = total + parseInt($(this).val());
    //         // });

    //         tes=document.getElementById(tableId);

    //         $(tes).parentsUntil("table").css({"color": "red", "border": "2px solid red"});

    //         // $(tes).parentsUntil("table").find('tr.row_clone inpur.jumlah').each(function() {
    //         //     total = total + parseInt($(this).val());
    //         //     console.log(total);
    //         // });
            
    //         // $(ths).parentsUntil("tbody#parent-tabel").find(tableId+"td .txt-jumlah").text(total)
    //         // $(ths).parentsUntil("tbody#parent-tabel").css({"color": "red", "border": "2px solid red"});       
    //     }

    //     // var total = 0;
    //     // $(ths).parentsUntil("table").find("tr.row_clone input.jumlah").each(function () {
    //     //     total = total + parseInt($(this).val());
    //     //     // console.log(total);
    //     // });
    // }

    function val_update_jumlah(ths)
    {
        var total = 0;
        $(ths).parentsUntil("table").find("tr.row_clone input.jumlah").each(function () {
            total = total + parseInt($(this).val());
        });

        $(ths).parentsUntil("tbody#parent-tabel").find("td .txt-jumlah").text(total);
    }

    // function update_jumlah(ths){
    //     console.log(ths)
    //     var total = 0;
    //     $(ths).parent().find("table tr.row_clone input.jumlah").each(function () {
    //         total = total + parseInt($(this).val());
    //     });

    //     $(ths).parentsUntil("tbody").find("td .txt-jumlah").text(total)
    // }
</script>