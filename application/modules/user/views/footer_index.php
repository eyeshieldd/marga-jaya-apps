<script>
   jQuery(document).ready(function() {
        /* Set DataTable */
        dtuser = $("#tuser").DataTable({
            "ajax": {
                "url": "<?= base_url('user/get_list_user'); ?>",
                "type": "POST",
                "data": function(d){
                    d.username = $('#form-cari [name="username"]').val(),
                    d.group_id = $('#form-cari [name="group_id"]').val(),
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
                // {"data": "no", "class" : "text-center", "orderable": false},
                {"data": "username", "orderable": true},
                {"data": "group_name", "orderable": true},
                {"data": "nama_cabang", "orderable": false},
                {"data": "aksi", "orderable": false}
            ],
            "oLanguage": {
                "sSearch": ""
            }
        });

        $("#form-cari").on("change", function(){
            dtuser.ajax.reload(null, false);
            console.log('asdg')
        })

        // hapus data kategori
        $('#tuser').on('click', '.hapus-data', function() {
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
                                url: '<?php echo site_url('user/hapus_user'); ?>',
                                data: 'data_id=' + data_id,
                                dataType: 'JSON',
                                timeout: 5000,
                                success: function (data) {
                                    if (data.status) {
                                        notif.success(data.pesan, "Berhasil");
                                        dtuser.ajax.reload(null, false);
                                    } else {
                                        notif.error(data.pesan, "Gagal");
                                        dtuser.ajax.reload(null, false);
                                    }
                                },
                                error: function (jqXHR, textStatus, errorThrown) {
                                    dtuser.ajax.reload(null, false);
                                    alertajax.error(textStatus, jqXHR.status);
                                }
                            });
                        }
                    },
                    batal:function(){}
                }
            });            
        });

        // $(".dataTables_filter input").addClass('form-control form-control-lg');
        // $(".dataTables_filter input").attr('placeholder', 'Search');
        // $(".dataTables_filter").attr('float', 'left !important');
    })
</script>