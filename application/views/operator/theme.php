<!doctype html>
<html lang="en" class="no-focus">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">

        <title>Marga Jaya App</title>

        <meta name="description" content="Codebase - Bootstrap 4 Admin Template &amp; UI Framework created by pixelcave and published on Themeforest">
        <meta name="author" content="pixelcave">
        <meta name="robots" content="noindex, nofollow">

        <!-- Open Graph Meta -->
        <meta property="og:title" content="Codebase - Bootstrap 4 Admin Template &amp; UI Framework">
        <meta property="og:site_name" content="Codebase">
        <meta property="og:description" content="Codebase - Bootstrap 4 Admin Template &amp; UI Framework created by pixelcave and published on Themeforest">
        <meta property="og:type" content="website">
        <meta property="og:url" content="">
        <meta property="og:image" content="">

        <!-- Icons -->
        <!-- The following icons can be replaced with your own, they are used by desktop and mobile browsers -->
        <link rel="shortcut icon" href="https://marga-jaya.com/images/cropped-favicon-192x192.png">
        <link rel="icon" type="image/png" sizes="192x192" href="https://marga-jaya.com/images/cropped-favicon-192x192.png">
        <link rel="apple-touch-icon" sizes="180x180" href="https://marga-jaya.com/images/cropped-favicon-180x180.png">
              <!-- END Icons -->
        <!-- Fonts and Codebase framework -->
        <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Muli:300,400,400i,600,700">
        <link rel="stylesheet" id="css-main" href="<?=base_url('assets/global/toastr/toastr.min.css')?>">
        <link rel="stylesheet" id="css-main" href="<?=base_url('assets/operator/js/plugins/datatables/buttons-bs4/buttons.bootstrap4.css')?>">
        <link rel="stylesheet" id="css-main" href="<?=base_url('assets/global/jquery-confirm-master/css/jquery-confirm.css')?>">

        <!-- You can include a specific file from css/themes/ folder to alter the default color theme of the template. eg: -->
        <!-- <link rel="stylesheet" id="css-theme" href="assets/css/themes/flat.min.css"> -->
        <link rel="stylesheet" id="css-main" href="<?= base_url('assets/operator/js/plugins/select2/css/select2.min.css') ?>">
        <link rel="stylesheet" id="css-main" href="<?= base_url('assets/operator/js/plugins/datatables/dataTables.bootstrap4.css')?>">
        <link rel="stylesheet" id="css-main" href="<?= base_url('assets/operator/css/codebase.min.css') ?>">
        <link rel="stylesheet" id="css-theme" href="<?= base_url('assets/operator/css/themes/corporate.min.css') ?>">
        <?php echo isset($FILE_CSS) ? $FILE_CSS : ''; ?>
        <!-- END Stylesheets -->
    </head>
    <body>
        <div id="page-container" class="sidebar-inverse side-scroll page-header-fixed page-header-glass page-header-inverse main-content-boxed">

            <!-- Sidebar -->
            <nav id="sidebar">
                <!-- Sidebar Content -->
                <div class="sidebar-content">
                    <!-- Side Header -->
                    <div class="content-header content-header-fullrow bg-black-op-10">
                        <div class="content-header-section text-center align-parent">
                            <!-- Close Sidebar, Visible only on mobile screens -->
                            <!-- Layout API, functionality initialized in Template._uiApiLayout() -->
                            <button type="button" class="btn btn-circle btn-dual-secondary d-lg-none align-v-r" data-toggle="layout" data-action="sidebar_close">
                                <i class="fa fa-times text-danger"></i>
                            </button>
                            <!-- END Close Sidebar -->
                            <!-- Logo -->
                            <div class="content-header-item">
                                <a class="link-effect font-w700" href="<?=base_url()?>">
                                <img style="  height: 35px; vertical-align:text-bottom; margin-right:10px;" src="https://marga-jaya.com/images/logo@2x.png" /> </a>
                              </a>                             
                            </div>
                            <!-- END Logo -->
                        </div>
                    </div>
                    <!-- END Side Header -->
                    <!-- Side Main Navigation -->
                    <div class="content-side content-side-full">
                        <!--
                        Mobile navigation, desktop navigation can be found in #page-header
                        If you would like to use the same navigation in both mobiles and desktops, you can use exactly the same markup inside sidebar and header navigation ul lists
                        -->
                        <ul class="nav-main">
                            <li>
                                <a class="active" href="<?=base_url('dashboard')?>"><i class="si si-rocket"></i>Dashboard</a>
                            </li>
                            <li>
                                <a class="nav-submenu" data-toggle="nav-submenu" href="#"><i class="si si-layers"></i>Laporan</a>
                                <ul>
                                    <li>
                                        <a href="">Laporan Produksi</a>
                                    </li>
                                    <li>
                                        <a href="">Laporan Stock</a>
                                    </li>
                                    <li>
                                        <a href="">Laporan Keuangan</a>
                                    </li>
                                    <li>
                                        <a href="">Laporan Kiriman</a>
                                    </li>
                                </ul>
                            </li>
                            <li>
                                <a href="<?=base_url('auth/logout')?>"><i class="si si-logout"></i>Logout</a>
                            </li>
                        </ul>
                    </div>
                    <!-- END Side Main Navigation -->
                </div>
                <!-- Sidebar Content -->
            </nav>
            <!-- END Sidebar -->

            <!-- Header -->
            <header id="page-header">
                <!-- Header Content -->
                <div class="content-header">
                    <!-- Left Section -->
                    <div class="content-header-section">
                        <!-- Logo -->
                        <div class="content-header-item mr-5">
                            <a class="link-effect font-w600" href="<?=base_url()?>">
                            <img style="  height: 35px; vertical-align:text-bottom; margin-right:10px;" src="https://marga-jaya.com/images/logo@2x.png" /> </a>
                        </div>
                        <!-- END Logo -->
                    </div>
                    <!-- END Left Section -->
                    <!-- Right Section -->
                    <div class="content-header-section">
                        <ul class="nav-main-header">
                            <li>
                                <a class="active" href="<?=base_url('dashboard')?>"><i class="si si-rocket"></i>Dashboard</a>
                            </li>
                            <li>
                                <a class="nav-submenu" data-toggle="nav-submenu" href="#"><i class="si si-layers"></i>Laporan</a>
                                <ul>
                                    <li>
                                        <a href="">Laporan Produksi</a>
                                    </li>
                                    <li>
                                        <a href="">Laporan Stock</a>
                                    </li>
                                    <li>
                                        <a href="">Laporan Keuangan</a>
                                    </li>
                                    <li>
                                        <a href="">Laporan Kiriman</a>
                                    </li>
                                </ul>
                            </li>
                            <li>
                                <a href="<?=base_url('auth/logout')?>"><i class="si si-logout"></i>Logout</a>
                            </li>
                        </ul>
                        <!-- END Header Navigation -->
                        <!-- Toggle Sidebar -->
                        <!-- Layout API, functionality initialized in Template._uiApiLayout() -->
                        <button type="button" class="btn btn-circle btn-dual-secondary d-lg-none" data-toggle="layout" data-action="sidebar_toggle">
                            <i class="fa fa-navicon"></i>
                        </button>
                        <!-- END Toggle Sidebar -->
                    </div>
                    <!-- END Right Section -->
                </div>
                <!-- END Header Content -->
                <!-- Header Loader -->
                <div id="page-header-loader" class="overlay-header bg-primary">
                    <div class="content-header content-header-fullrow text-center">
                        <div class="content-header-item">
                            <i class="fa fa-sun-o fa-spin text-white"></i>
                        </div>
                    </div>
                </div>
                <!-- END Header Loader -->
            </header>
            <!-- END Header -->
            <!-- Main Container -->
            <main id="main-container">
                <!-- Header -->
                <div class="bg-primary-dark">
                    <div class="content content-top">
                    </div>
                </div>
                <!-- END Header -->
                <!-- Page Content -->
                <div class="bg-white">
                    <!-- Breadcrumb -->
                    <!-- <div class="content d-none d-md-block">
                        <nav class="breadcrumb mb-0">
                            <a class="breadcrumb-item" href="javascript:void(0)">Home</a>
                            <span class="breadcrumb-item active">Dashboard</span>
                        </nav>
                    </div>-->
                    <!-- END Breadcrumb -->
                    <!-- Content -->
                    <div class="content">
                        <!-- Icon Navigation <?= base_url() ?>-->
                        <?php
                        isset($TPL_ISI) && !empty($TPL_ISI) ? $this->load->view($TPL_ISI) : 'Index belum di-load';
                        ?>
                        <!-- END Charts -->
                    </div>
                    <!-- END Content -->
                </div>
                <!-- END Page Content -->
            </main>
            <!-- END Main Container -->
       <!-- Footer -->
       <footer id="page-footer" class="bg-white opacity-0">
            <div class="content py-20 font-size-xs clearfix d-none d-md-block">
                <div class="float-right">
                    Made with <i class="fa fa-heart text-pulse"></i> marga-jaya.com</a>
                </div>
                <div class="float-left">
                    <a class="font-w600" href="http://marga-jaya.com" target="_blank">Marga Jaya App</a> &copy;
                    <span class="js-year-copy">2019</span>
                </div>
            </div>
        </footer>
        <!-- END Footer -->
        </div>
        <!-- END Page Container -->
        <script src="<?=base_url('assets/operator/js/core/jquery.min.js')?>"></script>
        <script src="<?=base_url('assets/operator/js/codebase.core.min.js')?>"></script>
        <script src="<?=base_url('assets/operator/js/codebase.app.min.js')?>"></script>
        <script src="<?=base_url('assets/operator/js/plugins/datatables/jquery.dataTables.min.js')?>"></script>
        <script src="<?=base_url('assets/operator/js/plugins/datatables/dataTables.bootstrap4.min.js')?>"></script>
        <script src="<?=base_url('assets/operator/js/plugins/datatables/buttons/dataTables.buttons.js')?>"></script>        
        <!-- <script src="<?=base_url('assets/operator/js/pages/be_tables_datatables.min.js')?>"></script> -->        
        <script src="<?=base_url('assets/global/jquery-confirm-master/js/jquery-confirm.js')?>"></script>
        <script src="<?=base_url('assets/global/toastr/toastr.min.js')?>"></script>
        <script src="<?=base_url('assets/operator/js/circlelabs-custom.js')?>"></script>
        <!-- <script src="<?=base_url('assets/js/plugins/sparkline/jquery.sparkline.min.js')?>"></script> -->
        <!-- Page JS Plugins -->
        <script>
            $.ajaxSetup({
                headers: {
                    <?= '"' . $this->security->get_csrf_token_name() . '":"' . $this->security->get_csrf_hash() . '"' ?>
                }
            });
        </script>

        <?php
        echo isset($FILE_JS) ? $FILE_JS : '';
        isset($TPL_FOOTER) && !empty($TPL_FOOTER) ? $this->load->view($TPL_FOOTER) : '';
        ?>
    </body>
</html>