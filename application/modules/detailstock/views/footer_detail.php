<script>
	$(document).ready(function() {
		// $("#tanggal").datepicker({
		//     format: 'dd-mm-yyyy',
		// });

		$("#tanggal").datepicker({
		    format: 'mm-yyyy',
		    changeYear: true,
		    changeMonth: true,
		    startView: "months",
            minViewMode: "months",
            autoclose: true
		});
	});
</script>