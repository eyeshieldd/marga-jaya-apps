<script>
   jQuery(document).ready(function() {
        /* Set DataTable */
        dtproduksi = $("#tproduksi").DataTable({
            "ajax": {
                "url": "<?= base_url('stock/get_list_produksi/').$barang_id.'/'.$cabang_id; ?>",
                "type": "POST",
                "data": function(d){
                    d.nama_pegawai = $('#form-cari [name="nama_pegawai"]').val()
                }
            },
            "sDom": dom_none,
            "serverSide": true,
            "bFilter": true,
            "paging": true,
            "autoWidth": true,
            "ordering": false,
            "columns": [
                {"data": "no", "class" : "text-center", "orderable": false},
                {"data": "nama_pegawai", "orderable": false},
                {"data": "stok", "orderable": false, "class" : "text-center"},
                {"data": "tombol", "orderable": false}
            ],
            "oLanguage": {
                "sSearch": ""
            },
        });

        $('#form-cari').on("change", function(){
            dtproduksi.ajax.reload(null, false);
            console.log('asdg');
        });

        // $('#form-cari [name="nama_pegawai"]').on('keyup', function(){
        //     dtproduksi.ajax.reload(null, false);
        //     console.log('asdg');
        // })      
    })
</script>