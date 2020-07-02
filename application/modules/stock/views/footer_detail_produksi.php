<script>
	$(document).ready(function() {
        /* Set Datepicker */        
		$("#tanggal").datepicker({
		    format: 'mm-yyyy',
		    changeYear: true,
		    changeMonth: true,
		    startView: "months",
            minViewMode: "months",
            autoclose: true
		});

        var d = 0;
        var ds = 0;
        var dt = [];

		/* Set DataTable */
        dtdetailproduksi = $("#tdetailproduksi").DataTable({
            "ajax": {                
                "url": "<?= base_url('stock/get_list_detail_produksi/').$stok_produksi_id; ?>",
                "type": "POST",
                "data": function(d){
                    d.tanggal = $('#form-cari [name="tanggal"]').val()
                }
            },
            "sDom": dom_none,
            "serverSide": true,
            "bFilter": true,
            "paging": true,
            "autoWidth": true,
            "ordering": false,
            // "order": [['0', 'ASC']],
            "columns": [
                {"data": "no", "class" : "text-center", "orderable": false},
                {"data": "created_at", "orderable": false, "class" : "text-center"},
                {"data": "deskripsi", "orderable": false},
                {"data": "stok_awal", "orderable": false, "class" : "text-center"},
                {"data": "jumlah", "orderable": false, "class" : "text-center"},
                {"data": "stok_akhir", "orderable": false, "class" : "text-center"},
                {"data": "tombol", "orderable": false}
            ],
            "oLanguage": {
                "sSearch": ""
            },

            // "createdRow": function ( row, data, index ) {
                
            //     dt[d] = parseInt(data['jumlah']);
            //     console.log(ds);

            //     if (d > 0) {

            //         $('td', row).eq(3).text(ds);
            //         $('td', row).eq(5).text(dt[d] + ds);
            //         ds = ds + dt[d];


            //     } else {
            //         $('td', row).eq(3).text(0);
            //         $('td', row).eq(5).text(dt[d]);
            //         ds = dt[d];
            //     }
            //     d++;
            // },
        });

        $('#form-cari').on("change", function(){
            dtdetailproduksi.ajax.reload(null, false);
            console.log('asdg');
        });

        // hapus data detail produksi
        $('#tdetailproduksi').on('click', '.hapus-data', function() {
            /* var data_id = produksi_detail_id */
            var data_id = $(this).attr('data-id');
            $.confirm({
                title: 'Hapus data?',
                content: 'Apakah Anda yakin akan menghapus data ini?',
                type:'red',
                buttons: {
                    ya: {
                        btnClass: 'btn-red',
                        action:function () {
                            $.ajax({
                                type: 'post',
                                url: '<?php echo site_url('stock/hapus_detail_produksi'); ?>',
                                data: 'data_id=' + data_id,
                                dataType: 'JSON',
                                timeout: 5000,
                                success: function (data) {
                                    if (data.status) {
                                        notif.success(data.pesan, "Berhasil");
                                        dtdetailproduksi.ajax.reload(null, false);
                                        d = 0;
                                        dt = [];
                                    } else {
                                        notif.error(data.pesan, "Gagal");
                                        dtdetailproduksi.ajax.reload(null, false);
                                    }
                                },
                                error: function (jqXHR, textStatus, errorThrown) {
                                    dtdetailproduksi.ajax.reload(null, false);
                                    alertajax.error(textStatus, jqXHR.status);
                                }
                            });
                        }
                    },
                    batal:function(){}
                }
            });            
        });
	});
</script>