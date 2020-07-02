 <!-- Icon Navigation -->
             <div class="row gutters-tiny push">
                        <div class="col-6 col-md-4 col-xl-2">
                            <a class="block block-rounded block-bordered block-link-shadow text-center"
                            href="<?= base_url('produksi')?>">
                                <div class="block-content">
                                    <p class="mt-5">
                                        <i class="fa fa-pencil-square-o fa-3x text-muted"></i>
                                    </p>
                                    <p class="font-w600">Produksi</p>
                                </div>
                            </a>
                        </div>
                        <div class="col-6 col-md-4 col-xl-2">
                            <a class="block block-rounded block-bordered block-link-shadow ribbon ribbon-primary text-center"
                            href="<?= base_url('stock')?>">
                                <div class="block-content">
                                    <p class="mt-5">
                                        <i class="si si-bar-chart fa-3x text-muted"></i>
                                    </p>
                                    <p class="font-w600">Stock</p>
                                </div>
                            </a>
                        </div>
                        <div class="col-6 col-md-4 col-xl-2">
                            <a class="block block-rounded block-bordered block-link-shadow text-center"
                                href="<?= base_url('kiriman')?>">
                                <div class="block-content">
                                    <p class="mt-5">
                                        <i class="fa fa-truck fa-3x text-muted"></i>
                                    </p>
                                    <p class="font-w600">Pengiriman</p>
                                </div>
                            </a>
                        </div>
                    </div>
                    <!-- END Icon Navigation -->

                    <!-- Charts -->
                    <div class="row d-none d-md-block">
                        <div class="row">
                        <div class="col-xl-6">
                            <!-- Bars Chart -->
                            <div class="block">
                                <div class="block-header block-header-default">
                                    <h3 class="block-title">Paving Block<small> (m2)</small></h3>
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
                                    <h3 class="block-title">Lainnya</h3>
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
                    <script src="assets/js/plugins/chartjs/Chart.bundle.min.js"></script>
    <script src="assets/js/plugins/flot/jquery.flot.min.js"></script>
    <script src="assets/js/plugins/flot/jquery.flot.pie.min.js"></script>
    <script src="assets/js/plugins/flot/jquery.flot.stack.min.js"></script>
    <script src="assets/js/plugins/flot/jquery.flot.resize.min.js"></script>

                    <script>
        var ctx = document.getElementById("barPaving");
        var cty = document.getElementById("barLainnya");
        var myChart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: [" 4-6 K175", "4-6 K200", "4-6 K200 isi 45", "4-8 K200", "4-8 K300", "6-6 K175", "6-6 K200", "6-8 K200", "6-6 25*25", "20*20*6", "20*20*8", "Grass Block" ],
                datasets: [{
                    label: 'Stock',
                    data: [5025, 5108, 1230, 250, 1000, 115, 500, 220, 100, 400, 456, 500, 1208, 1000, 5000, 2000],
                    fill: !0, backgroundColor: "rgba(66,165,245,.75)", borderColor: "rgba(66,165,245,1)", pointBackgroundColor: "rgba(66,165,245,1)", pointBorderColor: "#fff", pointHoverBackgroundColor: "#fff", pointHoverBorderColor: "rgba(66,165,245,1)",
                    borderWidth: 1

                }, {
                    label: "Permintaan", fill: !0, backgroundColor: "rgba(66,165,245,.25)", borderColor: "rgba(66,165,245,1)", pointBackgroundColor: "rgba(66,165,245,1)", pointBorderColor: "#fff", pointHoverBackgroundColor: "#fff", pointHoverBorderColor: "rgba(66,165,245,1)", 
                    data: [2350, 4590, 142, 130, 170, 188, 196, 1200, 120, 2000, 500, 230, 1000, 300, 6000, 3200]
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
            data: {
                labels: [ "Kanstin Kecil", "Kanstin Besar", "Batako Kecil", "Batako Besar", "G. Gelombang", "G. Flat", "Kerpus Flat", "Kerpus Segitiga", "Kerpus n", "Risplang", "Buis 100", "Buis 80", "Buis 70", "Buis 60", "Buis 50", "Buis 50 Belah","Buis 40 utuh", "Buis 40 belah" ],
                datasets: [{
                    label: 'Stock',
                    data: [5025, 5108, 1230, 250, 1000, 115, 500, 220, 100, 400, 456, 500, 1208, 1000, 5000, 2000],
                    fill: !0, backgroundColor: "rgba(66,165,245,.75)", borderColor: "rgba(66,165,245,1)", pointBackgroundColor: "rgba(66,165,245,1)", pointBorderColor: "#fff", pointHoverBackgroundColor: "#fff", pointHoverBorderColor: "rgba(66,165,245,1)",
                    borderWidth: 1

                }, {
                    label: "Permintaan", fill: !0, backgroundColor: "rgba(66,165,245,.25)", borderColor: "rgba(66,165,245,1)", pointBackgroundColor: "rgba(66,165,245,1)", pointBorderColor: "#fff", pointHoverBackgroundColor: "#fff", pointHoverBorderColor: "rgba(66,165,245,1)", 
                    data: [2350, 4590, 142, 130, 170, 188, 196, 1200, 120, 2000, 500, 230, 1000, 300, 6000, 3200]
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
