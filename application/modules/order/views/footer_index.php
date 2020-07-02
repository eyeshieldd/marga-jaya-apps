<script>
	$(document).ready(function(){		
		$(document).ready(function() {        
            $("#tanggal").datepicker({
                format: 'mm-yyyy',
                changeYear: true,
                changeMonth: true,
                startView: "months",
                minViewMode: "months",
                autoclose: true
            });
        });

		/* Set DataTable */
        dtorder = $("#torder").DataTable({
            "ajax": {
                "url": "<?= base_url('order/get_list_order'); ?>",
                "type": "POST",
                "data": function(d){
                    d.no_nama      = $('#form-cari [name="no_nama"]').val(),
                    d.tanggal      = $('#form-cari [name="tanggal"]').val(),
                    d.cabang_id = $('#form-cari [name="cabang_id"]').val()
                }
            },
            "sDom": dom_none,
            "serverSide": true,
            "bFilter": true,
            "paging": true,
            "autoWidth": true,
            "ordering": true,            
            "order": [['1', 'DESC']],
            "columns": [
            {"data": "no", "class" : "text-center", "orderable": false},
            {"data": "nama_pembeli", "orderable": true},
            {"data": "status_pembayaran", "orderable": true},
            {"data": "tombol", "orderable": false}
            ],
            "oLanguage": {
                "sSearch": ""
            },            
        });

        $('#form-cari').on("change", function(){
            dtorder.ajax.reload(null, false);
        });

        $("#tombol-order-baru").on("click",function(){
         if($("#form-cari [name='cabang_id']").val() != ''){
            window.location.href = "<?=base_url('order/tambah')?>/"+$("#form-cari [name='cabang_id']").val();
            return;
        }

        $.alert({
          title: 'Perhatian!',
          content: 'Pilih cabang terlebih dahulu.',
          type:'red',
      });
    })
    });
</script>