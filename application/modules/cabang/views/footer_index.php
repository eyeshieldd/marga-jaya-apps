<script>
   jQuery(document).ready(function() {
        /* Set DataTable */
        dtcabang = $("#tcabang").DataTable({
            "ajax": {
                "url": "<?= base_url('cabang/get_list_cabang'); ?>",
                "type": "POST",
                "data": function(d){
                    d.cari = $('#form-cari [name="cari"]').val()
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
                {"data": "kode_cabang", "class" : "text-center", "orderable": true},
                {"data": "nama_cabang", "orderable": true},
                {"data": "alamat", "orderable": true},
                {"data": "telepon", "orderable": false},
                {"data": "aksi", "orderable": false}
            ],
            "oLanguage": {
                "sSearch": ""
            }
        });

        $('#form-cari [name="cari"]').on('keyup', function(){
            dtcabang.ajax.reload(null, false);
        })

        /* hapus kategori */
        $('#tcabang').on('click', '.hapus-data', function() {
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
                                url: '<?php echo site_url('cabang/hapus_cabang'); ?>',
                                data: 'data_id=' + data_id,
                                dataType: 'JSON',
                                timeout: 5000,
                                success: function (data) {
                                    if (data.status) {
                                        notif.success(data.pesan, "Berhasil");
                                        dtcabang.ajax.reload(null, false);
                                    } else {
                                        notif.error(data.pesan, "Gagal");
                                        dtcabang.ajax.reload(null, false);
                                    }
                                },
                                error: function (jqXHR, textStatus, errorThrown) {
                                    dtcabang.ajax.reload(null, false);
                                    alertajax.error(textStatus, jqXHR.status);
                                }
                            });
                        }
                    },
                    batal:function(){}
                }
            });            
        });
    })
</script>