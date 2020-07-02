<script>
   jQuery(document).ready(function() {
        /* Set DataTable */
        dtdokumen = $("#tdokumen").DataTable({
            "ajax": {
                "url": "<?= base_url('dokumen/get_list_dokumen'); ?>",
                "type": "POST",
                "data": function(d){
                    d.dokumen = $('#form-cari [name="dokumen"]').val(),
                    d.cabang_id = $('#form-cari [name="cabang_id"]').val()
                }
            },
            "sDom": dom_none,
            "serverSide": true,
            "bFilter": true,
            "paging": true,
            "autoWidth": true,
            "ordering": true,
            "order": [],
            "columns": [
                {"data": "no", "class" : "text-center", "orderable": false},
                {"data": "nama_dokumen", "orderable": true},
                {"data": "nama_cabang", "orderable": true},                
                {"data": "tombol", "orderable": false}
            ],
            "oLanguage": {
                "sSearch": ""
            }
        });

        /*$('#form-cari [name="dokumen"]').on('keyup', function(){
            dtdokumen.ajax.reload(null, false);
        });*/

        $('#form-cari').on("change", function(){
            dtdokumen.ajax.reload(null, false);
            console.log('asdg')
        });

        // hapus data kategori
        $('#tdokumen').on('click', '.hapus-data', function() {
            /* var modal dan form */
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
                                url: '<?php echo site_url('dokumen/hapus_dokumen'); ?>',
                                data: 'data_id=' + data_id,
                                dataType: 'JSON',
                                timeout: 5000,
                                success: function (data) {
                                    if (data.status) {
                                        notif.success(data.pesan, "Berhasil");
                                        dtdokumen.ajax.reload(null, false);
                                    } else {
                                        notif.error(data.pesan, "Gagal");
                                        dtdokumen.ajax.reload(null, false);
                                    }
                                },
                                error: function (jqXHR, textStatus, errorThrown) {
                                    dtdokumen.ajax.reload(null, false);
                                    alertajax.error(textStatus, jqXHR.status);
                                }
                            });
                        }
                    },
                    batal:function(){}
                }
            });            
        });

        $(".dataTables_filter input").addClass('form-control form-control-lg');
        $(".dataTables_filter input").attr('placeholder', 'Search');
        $(".dataTables_filter").attr('float', 'left !important');
    })
</script>