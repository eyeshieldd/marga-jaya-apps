<script>
   jQuery(document).ready(function() {

        $("#tanggal").datepicker({
            format: 'mm-yyyy',
            changeYear: true,
            changeMonth: true,
            startView: "months",
            minViewMode: "months",
            autoclose: true
        });

        /* Set DataTable */
        dtpengeluaran = $("#tpengeluaran").DataTable({
            "ajax": {
                "url": "<?= base_url('pengeluaran/get_list_pengeluaran'); ?>",
                "type": "POST",
                "data": function(d){
                    d.pengeluaran = $('#form-cari [name="pengeluaran"]').val(),
                    d.tanggal = $('#form-cari [name="tanggal"]').val(),
                    d.cabang_id   = $('#form-cari [name="cabang_id"]').val()
                }
            },
            "sDom": dom_none,
            "serverSide": true,
            "bFilter": true,
            "paging": true,
            "autoWidth": true,
            "ordering": true,            
            "order": [['0', 'ASC']],
            "columns": [                
                {"data": "tanggal_transaksi", "orderable": false, "class" : "text-center"},
                {"data": "deskripsi", "orderable": false},
                {"data": "nominal", "orderable": false, "className": "text-right"},
                {"data": "nama_cabang", "orderable": false},
                {"data": "tombol", "orderable": false}
            ],
            "oLanguage": {
                "sSearch": ""
            },            
        });

        // $('#form-cari [name="cari"]').on('keyup', function(){
        //     dtpengeluaran.ajax.reload(null, false);
        // });

        $('#form-cari').on("change", function(){
            dtpengeluaran.ajax.reload(null, false);
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

        // hapus data kategori
        $('#tpengeluaran').on('click', '.hapus-data', function() {
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
                                url: '<?php echo site_url('pengeluaran/hapus_pengeluaran'); ?>',
                                data: 'data_id=' + data_id,
                                dataType: 'JSON',
                                timeout: 5000,
                                success: function (data) {
                                    if (data.status) {
                                        notif.success(data.pesan, "Berhasil");
                                        dtpengeluaran.ajax.reload(null, false);
                                    } else {
                                        notif.error(data.pesan, "Gagal");
                                        dtpengeluaran.ajax.reload(null, false);
                                    }
                                },
                                error: function (jqXHR, textStatus, errorThrown) {
                                    dtpengeluaran.ajax.reload(null, false);
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