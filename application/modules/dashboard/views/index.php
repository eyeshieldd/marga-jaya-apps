<!-- Icon Navigation -->
<div class="row gutters-tiny push">
    <?php
    if(isset($rs_menu) && !empty($rs_menu)):
        foreach ($rs_menu as $vmenu) :
            ?>
                <div class="col-6 col-md-4 col-xl-2">
                    <a class="block block-rounded block-bordered block-link-shadow text-center" href="<?= base_url($vmenu['menu_link'])?>">
                        <div class="block-content">
                            <p class="mt-5">
                                <i class="<?=$vmenu['menu_fonticon']?>"></i>
                            </p>
                            <p class="font-w600"><?=$vmenu['menu_name']?></p>
                        </div>
                    </a>
                </div>
            <?php
        endforeach;
    endif;
    ?>
</div>
<!-- END Icon Navigation -->

<!-- Charts -->
<div class="row d-none d-md-block">
    <div class="row">
        <div class="col-xl-6">
            <!-- Bars Chart -->
            <div class="block">
                <div class="block-header block-header-default">
                    <h3 class="block-title">Stock Produksi<small> (m2)</small></h3>
                    <div class="block-options">
                        <button type="button" class="btn-block-option" data-toggle="block-option"
                            data-action="state_toggle" data-action-mode="demo">
                            <i class="si si-refresh"></i>
                        </button>
                    </div>
                </div>
                <div class="block-content block-content-full text-center">
                    <!-- Bars Chart Container -->
                    <canvas class="js-chartjs-bars" id="barPaving"></canvas>
                </div>
            </div>
            <!-- END Bars Chart -->
        </div>

        <div class="col-xl-6">
            <!-- Bars Chart -->
            <div class="block">
                <div class="block-header block-header-default">
                    <h3 class="block-title">Stock Produksi <small> (pcs)</small></h3>
                    <div class="block-options">
                        <button type="button" class="btn-block-option" data-toggle="block-option"
                            data-action="state_toggle" data-action-mode="demo">
                            <i class="si si-refresh"></i>
                        </button>
                    </div>
                </div>
                <div class="block-content block-content-full text-center">
                    <!-- Bars Chart Container -->
                    <canvas class="js-chartjs-bars" id="barLainnya"></canvas>
                </div>
            </div>
            <!-- END Bars Chart -->
        </div>
    </div>
    <center><small>update terakhir tanggal 19 Oktober 2019</small></center>
    <br/>
</div>
<!-- END Charts -->

<script src="assets/operator/js/plugins/chartjs/Chart.bundle.min.js"></script>
<script src="assets/operator/js/plugins/flot/jquery.flot.min.js"></script>
<script src="assets/operator/js/plugins/flot/jquery.flot.pie.min.js"></script>
<script src="assets/operator/js/plugins/flot/jquery.flot.stack.min.js"></script>
<script src="assets/operator/js/plugins/flot/jquery.flot.resize.min.js"></script>

<script>
    var ctx = document.getElementById("barPaving");
    var cty = document.getElementById("barLainnya");
    var myChart = new Chart(ctx, {
        type: 'bar',
        // data: {
        //     labels: ["Conblock Hexagonal", "Batako Press 38", "Genteng Beton Gelombang", "Buis Beton ukuran 11", "Batako Press Besar", "Paving / Conblock Kubus 20x20" ],
        //     datasets: [{
        //         label: 'Stock',
        //         data: [0, 44, 64, 250, 32, 0],
        //         fill: !0, backgroundColor: "rgba(66,165,245,.75)", borderColor: "rgba(66,165,245,1)", pointBackgroundColor: "rgba(66,165,245,1)", pointBorderColor: "#fff", pointHoverBackgroundColor: "#fff", pointHoverBorderColor: "rgba(66,165,245,1)",
        //         borderWidth: 1

        //     }, {
        //         label: "Permintaan", fill: !0, backgroundColor: "rgba(66,165,245,.25)", borderColor: "rgba(66,165,245,1)", pointBackgroundColor: "rgba(66,165,245,1)", pointBorderColor: "#fff", pointHoverBackgroundColor: "#fff", pointHoverBorderColor: "rgba(66,165,245,1)", 
        //         data: [0, 12, 0, 0, 0, 0]
        //     }]
        // },
        data: {
            labels: <?php echo json_encode($nama) ?>,
            datasets: [{
                label: 'Stock',
                data: <?php echo json_encode($stok_m2) ?>,
                fill: !0, backgroundColor: "rgba(66,165,245,.75)", borderColor: "rgba(66,165,245,1)", pointBackgroundColor: "rgba(66,165,245,1)", pointBorderColor: "#fff", pointHoverBackgroundColor: "#fff", pointHoverBorderColor: "rgba(66,165,245,1)",
                borderWidth: 1

            }, {
                label: "Permintaan", fill: !0, backgroundColor: "rgba(66,165,245,.25)", borderColor: "rgba(66,165,245,1)", pointBackgroundColor: "rgba(66,165,245,1)", pointBorderColor: "#fff", pointHoverBackgroundColor: "#fff", pointHoverBorderColor: "rgba(66,165,245,1)", 
                data: <?php echo json_encode($permintaan_m2) ?>
            }]
        },
        options: {
            responsive: true,
            scales: {
                xAxes: [{
                    ticks: {
                        maxRotation: 90,
                        minRotation: 80
                    }
                }],
                yAxes: [{
                    ticks: {
                        beginAtZero: true
                    }
                }]
            }
        }
    });

    var myChart2 = new Chart(cty, {
        type: 'bar',
        // data: {
        //     labels: [ "Conblock Hexagonal", "Batako Press 38", "Genteng Beton Gelombang", "Buis Beton ukuran 11", "Batako Press Besar", "Paving / Conblock Kubus 20x20" ],
        //     datasets: [{
        //         label: 'Stock',
        //         data: [0, 44, 64, 250, 32, 0],
        //         fill: !0, backgroundColor: "rgba(66,165,245,.75)", borderColor: "rgba(66,165,245,1)", pointBackgroundColor: "rgba(66,165,245,1)", pointBorderColor: "#fff", pointHoverBackgroundColor: "#fff", pointHoverBorderColor: "rgba(66,165,245,1)",
        //         borderWidth: 1

        //     }, {
        //         label: "Permintaan", fill: !0, backgroundColor: "rgba(66,165,245,.25)", borderColor: "rgba(66,165,245,1)", pointBackgroundColor: "rgba(66,165,245,1)", pointBorderColor: "#fff", pointHoverBackgroundColor: "#fff", pointHoverBorderColor: "rgba(66,165,245,1)", 
        //         data: [0, 12, 0, 0, 0, 0]
        //     }]
        // },
        data: {
            labels: <?php echo json_encode($nama_barang) ?>,
            datasets: [{
                label: 'Stock',
                data: <?php echo json_encode($stok) ?>,
                fill: !0, backgroundColor: "rgba(66,165,245,.75)", borderColor: "rgba(66,165,245,1)", pointBackgroundColor: "rgba(66,165,245,1)", pointBorderColor: "#fff", pointHoverBackgroundColor: "#fff", pointHoverBorderColor: "rgba(66,165,245,1)",
                borderWidth: 1

            }, {
                label: "Permintaan", fill: !0, backgroundColor: "rgba(66,165,245,.25)", borderColor: "rgba(66,165,245,1)", pointBackgroundColor: "rgba(66,165,245,1)", pointBorderColor: "#fff", pointHoverBackgroundColor: "#fff", pointHoverBorderColor: "rgba(66,165,245,1)", 
                data: <?php echo json_encode($permintaan) ?>
            }]
        },
        options: {
            responsive: true,
            scales: {
                xAxes: [{
                    ticks: {
                        maxRotation: 90,
                        minRotation: 80
                    }
                }],
                yAxes: [{
                    ticks: {
                        beginAtZero: true
                    }
                }]
            }
        }
    });
</script>
