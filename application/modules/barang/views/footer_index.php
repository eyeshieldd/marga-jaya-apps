<script>
   jQuery(document).ready(function() {
        /* Set DataTable */
        dtbarang = $("#tbarang").DataTable({
            "ajax": {
                "url": "<?= base_url('barang/get_list_barang'); ?>",
                "type": "POST",
                "data": function(d){
                    d.barang      = $('#form-cari [name="barang"]').val(),
                    d.kategori_id = $('#form-cari [name="kategori_id"]').val()
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
                {"data": "nama_barang", "orderable": true},
                {"data": "nama_kategori", "orderable": true},
                {"data": "tombol", "orderable": false}
            ],
            "oLanguage": {
                "sSearch": ""
            },            
        });

        $('#form-cari').on("change", function(){
            dtbarang.ajax.reload(null, false);
            console.log('asdg')
        });

        // update kategori
        $('#tombol-ubah').click(function (){
            var modal = '#modal-add';
            var form = '#form-edit';
            var url = '<?= base_url('kategori') ?>';

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
                        // window.location.href = url; // back to controller kategori
                        $(form).reload();                                    
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
        });

        // hapus data barang
        $('#tbarang').on('click', '.hapus-data', function() {
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
                                url: '<?php echo site_url('barang/hapus_barang'); ?>',
                                data: 'data_id=' + data_id,
                                dataType: 'JSON',
                                timeout: 5000,
                                success: function (data) {
                                    if (data.status) {
                                        notif.success(data.pesan, "Berhasil");
                                        dtbarang.ajax.reload(null, false);
                                    } else {
                                        notif.error(data.pesan, "Gagal");
                                        dtbarang.ajax.reload(null, false);
                                    }
                                },
                                error: function (jqXHR, textStatus, errorThrown) {
                                    dtbarang.ajax.reload(null, false);
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
        $(".dataTables_filter input").css('margin-left', "0");
        $(".dataTables_filter input").attr('placeholder', 'Search');
        // $(".dataTables_filter input").attr('float', 'left !important');

        // $(".dataTables_filter :input").focus().val(value).keyup();
    })
</script>