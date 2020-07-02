<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta content="IE=edge" http-equiv="X-UA-Compatible">
    <meta content="width=device-width, initial-scale=1" name="viewport">
    <meta content="" name="description">
    <meta content="" name="author">
    <link href="<?=base_url('assets/operator/plugins/images/favicon.png')?>" rel="icon" sizes="16x16" type="image/png">
    <title>
        <?php echo isset($SYS_TITLE) && !empty($SYS_TITLE) ? $SYS_TITLE : 'Circle Labs Core with Ample Admin Template' ?>
    </title>
    <!-- Bootstrap Core CSS -->
    <link href="<?=base_url('assets/operator/bootstrap/dist/css/bootstrap.min.css')?>" rel="stylesheet">
    <link href="<?=base_url('assets/operator/plugins/bower_components/datatables/jquery.dataTables.min.css')?>" rel="stylesheet">
    <!-- jquery confirm master -->
    <link href="<?=base_url('assets/operator/plugins/bower_components/jquery-confirm-master/dist/jquery-confirm.min.css')?>" rel="stylesheet">

    <!-- animation CSS -->
    <link href="<?=base_url('assets/operator/css/animate.css')?>" rel="stylesheet">
    <!-- Custom CSS -->
    <link href="<?=base_url('assets/operator/css/style.css')?>" rel="stylesheet">
    <link rel="stylesheet" type="text/css" media="screen" href="<?php echo base_url('assets/operator/plugins/bower_components/toast-master/css/jquery.toast.css'); ?>"/>
    <!-- color CSS -->
    <link href="<?=base_url('assets/operator/css/colors/default.css')?>" id="theme" rel="stylesheet">
    <?php echo isset($FILE_CSS) ? $FILE_CSS : ''; ?>
    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
<![endif]-->
</head>

<body class="fix-header">
    <!-- ============================================================== -->
    <!-- Preloader -->
    <!-- ============================================================== -->
    <div class="preloader">
        <svg class="circular" viewBox="25 25 50 50">
            <circle class="path" cx="50" cy="50" r="20" fill="none" stroke-width="2" stroke-miterlimit="10" />
        </svg>
    </div>
    <!-- ============================================================== -->
    <!-- Wrapper -->
    <!-- ============================================================== -->
    <div id="wrapper">
        <!-- ============================================================== -->
        <!-- Topbar header - style you can find in pages.scss -->
        <!-- ============================================================== -->
        <nav class="navbar navbar-default navbar-static-top m-b-0">
            <div class="navbar-header">
                <div class="top-left-part">
                    <!-- Logo -->
                    <a class="logo" href="<?=base_url()?>">
                        <!-- Logo icon image, you can use font-icon also --><b>
                            <!--This is dark logo icon--><img src="<?=base_url('assets/operator')?>/plugins/images/admin-logo.png" alt="home" class="dark-logo" /><!--This is light logo icon--><img src="../plugins/images/admin-logo-dark.png" alt="home" class="light-logo" />
                        </b>
                        <!-- Logo text image you can use text also --><span class="hidden-xs">
                            <!--This is dark logo text--><img src="<?=base_url('assets/operator')?>/plugins/images/admin-text.png" alt="home" class="dark-logo" /><!--This is light logo text--><img src="../plugins/images/admin-text-dark.png" alt="home" class="light-logo" />
                        </span> </a>
                    </div>
                    <!-- /Logo -->
                    <ul class="nav navbar-top-links navbar-left">
                        <li><a href="javascript:void(0)" class="open-close waves-effect waves-light"><i class="ti-menu"></i></a></li>
                    </ul>
                    <!-- Search input and Toggle icon -->
                    <ul class="nav navbar-top-links navbar-right pull-right">
                        <li class="dropdown">
                            <a class="dropdown-toggle profile-pic" data-toggle="dropdown" href="#"> <img src="<?=base_url('assets/operator')?>/plugins/images/users/varun.jpg" alt="user-img" width="36" class="img-circle"><b class="hidden-xs"><?=$USER_LOGIN['username']?></b><span class="caret"></span> </a>
                            <ul class="dropdown-menu dropdown-user animated zoomin">
                                <li>
                                    <div class="dw-user-box">
                                        <div class="u-img"><img src="<?=base_url('assets/operator')?>/plugins/images/users/varun.jpg" alt="user" /></div>
                                        <div class="u-text">
                                            <h4><?=$USER_LOGIN['nama_lengkap']?></h4>
                                            <p class="text-muted">varun@gmail.com</p><a href="profile.html" class="btn btn-rounded btn-danger btn-sm">View Profile</a></div>
                                        </div>
                                    </li>
                                    <li role="separator" class="divider"></li>
                                    <li><a href="#"><i class="ti-user"></i> My Profile</a></li>
                                    <li><a href="#"><i class="ti-wallet"></i> My Balance</a></li>
                                    <li><a href="#"><i class="ti-email"></i> Inbox</a></li>
                                    <li role="separator" class="divider"></li>
                                    <li><a href="#"><i class="ti-settings"></i> Account Setting</a></li>
                                    <li role="separator" class="divider"></li>
                                    <li><a href="<?=base_url('auth/logout')?>"><i class="fa fa-power-off"></i> Logout</a></li>
                                </ul>
                                <!-- /.dropdown-user -->
                            </li>
                            <!-- /.dropdown -->
                        </ul>
                    </div>
                    <!-- /.navbar-header -->
                    <!-- /.navbar-top-links -->
                    <!-- /.navbar-static-side -->
                </nav>
                <!-- End Top Navigation -->
                <!-- ============================================================== -->
                <!-- Left Sidebar - style you can find in sidebar.scss  -->
                <!-- ============================================================== -->
                <div class="navbar-default sidebar" role="navigation">
                    <div class="sidebar-nav slimscrollsidebar">
                        <div class="sidebar-head">
                            <h3><span class="fa-fw open-close"><i class="ti-close ti-menu"></i></span> <span class="hide-menu">Navigation</span></h3> </div>
                            <ul class="nav" id="side-menu">
                                <li class="nav-devider">
                                </li>
                                <?php
                                echo isset($TPL_SIDEMENU) && !empty($TPL_SIDEMENU) ? $TPL_SIDEMENU : 'Side menu belum di-load';
                                ?>
                            </ul>
                        </div>
                    </div>
                    <!-- ============================================================== -->
                    <!-- End Left Sidebar -->
                    <!-- ============================================================== -->
                    <!-- ============================================================== -->
                    <!-- Page Content -->
                    <!-- ============================================================== -->
                    <div id="page-wrapper">
                        <div class="container-fluid">
                            <div class="row bg-title">
                                <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
                                    <h4 class="page-title">Starter Page</h4> </div>
                                    <div class="col-lg-9 col-sm-8 col-md-8 col-xs-12">
                                       <div class="col-md-7 align-self-center">
                                       </div>
                                       <?php
                                       if (!empty($BREADCRUMB))
                                        echo $BREADCRUMB;
                                    ?>
                                </div>
                                <!-- /.col-lg-12 -->
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <?php
                                    isset($TPL_ISI) && !empty($TPL_ISI) ? $this->load->view($TPL_ISI) : 'Index belum di-load';
                                    ?>
                                </div>
                            </div>
                        </div>
                        <!-- /.container-fluid -->
                        <footer class="footer text-center"> 2018 &copy; Circlelabs ID </footer>
                    </div>
                    <!-- ============================================================== -->
                    <!-- End Page Content -->
                    <!-- ============================================================== -->
                </div>
                <!-- /#wrapper -->
                <!-- jQuery -->
                <script src="<?=base_url('assets/operator/plugins/bower_components/jquery/dist/jquery.min.js')?>">
                </script>
                <!-- Bootstrap Core JavaScript -->
                <script src="<?=base_url('assets/operator/bootstrap/dist/js/bootstrap.min.js')?>">
                </script>
                <!-- Menu Plugin JavaScript -->
                <script src="<?=base_url('assets/operator/plugins/bower_components/sidebar-nav/dist/sidebar-nav.min.js')?>">
                </script>
                <!--slimscroll JavaScript -->
                <script src="<?=base_url('assets/operator/js/jquery.slimscroll.js')?>">
                </script>
                <!--Wave Effects -->
                <script src="<?=base_url('assets/operator/js/waves.js')?>">
                </script>
                <script type="text/javascript" src="<?php echo base_url('assets/global/jquery-form-validator-net/form-validator/jquery.form-validator.min.js') ?>"></script>
                <script type="text/javascript" src="<?php echo base_url('assets/operator/plugins/bower_components/toast-master/js/jquery.toast.js') ?>"></script>
                <script src="<?=base_url('assets/operator/plugins/bower_components/datatables/jquery.dataTables.min.js')?>"></script>
                <!-- jquery confirm master -->
                <script src="<?=base_url('assets/operator/plugins/bower_components/jquery-confirm-master/dist/jquery-confirm.min.js')?>"></script>
                <!-- Custom Theme JavaScript -->
                <script src="<?=base_url('assets/operator/js/custom.js')?>"></script>
                <script src="<?=base_url('assets/operator/js/circlelabs.js')?>"></script>
                <script type="text/javascript">

                    $(document).ajaxComplete(
                        function(event, request, options) {
                            if (request.responseText == "login_required") {
                                window.location.href = "<?=base_url('auth')?>";
                            }
                        }
                    );

                    $.ajaxSetup({
                        headers: {<?= '"' . $this->security->get_csrf_token_name() . '":"' . $this->security->get_csrf_hash() . '"' ?>}
                    });
                    $.fn.dataTable.ext.errMode = 'none';
                    $.extend(true, $.fn.dataTable.defaults, {
                        // "dom": dom_none,
                        "autoWidth": true,
                        "oLanguage": {
                            "sSearch": '<span class="input-group-addon"><i class="glyphicon glyphicon-search"></i></span>'
                        },
                        "language": {
                            "url": "<?= base_url('assets/operator/plugins/bower_components/datatables/indonesia.json') ?>"
                        },
                        // "dom": dom_footer,
                        "processing": true,
                        "searchDelay": 2000,
                        "serverSide": true,
                        "ordering": false,
                        "order": []
                    });

                    
    </script>
    <?php
    echo isset($FILE_JS) ? $FILE_JS : '';
    isset($TPL_FOOTER) && !empty($TPL_FOOTER) ? $this->load->view($TPL_FOOTER) : ''; ?>
</body>

</html>
