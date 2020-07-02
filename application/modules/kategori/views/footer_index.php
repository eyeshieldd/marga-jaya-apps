<script>
   jQuery(document).ready(function() {
    /* Set DataTable */


    dtkategori = $("#tkategori").DataTable({
        "ajax": {
            "url": "<?= base_url('kategori/get_list_kategori'); ?>",
            "type": "POST",
            "data": function(d){
                d.cari = $('#form-cari [name="cari"]').val()
            }
        },
        "sDom": dom_full,
        "serverSide": true,
        "bFilter": true,
        "paging": true,
        "autoWidth": true,
        "ordering": true,
        "order": [],
        "columns": [
        {"data": "no", "class" : "text-center", "orderable": false},
        {"data": "nama_kategori", "orderable": true},
        {"data": "satuan", "orderable": true},
        {"data": "tombol", "orderable": false}
        ],
        "oLanguage": {
            "sSearch": ""
        },            
    });

        // $(dtkategori).keyup(function(){
        //     oTable.search($(this).val()).draw() ;
        // });
        $('#form-cari [name="cari"]').on('keyup', function(){
            dtkategori.ajax.reload(null, false);
        })

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
        $('#tkategori').on('click', '.hapus-data', function() {
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
                                url: '<?php echo site_url('kategori/hapus_kategori'); ?>',
                                data: 'data_id=' + data_id,
                                dataType: 'JSON',
                                timeout: 5000,
                                success: function (data) {
                                    if (data.status) {
                                        notif.success(data.pesan, "Berhasil");
                                        dtkategori.ajax.reload(null, false);
                                    } else {
                                        notif.error(data.pesan, "Gagal");
                                        dtkategori.ajax.reload(null, false);
                                    }
                                },
                                error: function (jqXHR, textStatus, errorThrown) {
                                    dtkategori.ajax.reload(null, false);
                                    alertajax.error(textStatus, jqXHR.status);
                                }
                            });
                        }
                    },
                    batal:function(){}
                }
            });            
        });

        only_number('.jumlah', 10);


        // $(".dataTables_filter input").addClass('form-control form-control-lg');
        // $(".dataTables_filter input").css('margin-left', "0");
        // $(".dataTables_filter input").attr('placeholder', 'Search');
        // $(".dataTables_filter input").attr('float', 'left !important');

        // $(".dataTables_filter :input").focus().val(value).keyup();
    })
</script>