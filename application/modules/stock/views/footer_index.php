<script>
 jQuery(document).ready(function() {


    /* Set DataTable */
    dtstock = $("#tstock").DataTable({
        "ajax": {
            "url": "<?= base_url('stock/get_list_stock'); ?>",
            "type": "POST",
            "data": function(d){
                d.com_cabang      = '<?=$result_cabang?>',
                d.barang      = $('#form-cari [name="barang"]').val(),
                d.kategori_id = $('#form-cari [name="kategori_id"]').val(),
                d.cabang_id   = $('#form-cari [name="cabang_id"]').val()
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
            {"data": "nama_barang", "orderable": false},
            {"data": "nama_kategori", "orderable": false},
            {"data": "total_stok", "orderable": false, "class" : "text-center"},
            {"data": "permintaan", "orderable": false, "class" : "text-center"},
            {"data": "tombol", "orderable": false}
            ],
            "oLanguage": {
                "sSearch": ""
            },                      
        });

    $('#tstock').on("click", '.tombol-detail', function(){
        console.log($(this).attr('data-link'));

        window.location.href = $(this).attr('data-link') + '/' + $('#form-cari [name="cabang_id"]').val();
    })

    $('#form-cari').on('change', function(){
        dtstock.ajax.reload(null, false);
        console.log($('#form-cari [name="cabang_id"]').val());
    });       
})
</script>