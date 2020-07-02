<?php


class Detailstock extends Portal_admin{
    
    public function __construct()
    {
        parent::__construct();
    }
    
    public function index(){
        parent::display('index');
    }
    
    # menambah data nama dengan stock 0
    public function tambah_nama(){
        parent::display('tambah_nama');
    }

    # menambah data detail stock
    public function tambah_stock(){

        // load datepicker
        $this->load_css('assets/operator/js/plugins/bootstrap-datepicker/css/bootstrap-datepicker3.min.css');
        $this->load_js('assets/operator/js/plugins/bootstrap-datepicker/js/bootstrap-datepicker.min.js');
        
        parent::display('tambah_stock', null, 'footer_tambah_stock');
    }

    public function detail(){

        // load datepicker
        $this->load_css('assets/operator/js/plugins/bootstrap-datepicker/css/bootstrap-datepicker3.min.css');
        $this->load_js('assets/operator/js/plugins/bootstrap-datepicker/js/bootstrap-datepicker.min.js');
        
        parent::display('detail', null, 'footer_detail');
    }

    public function edit(){

        // load datepicker
        $this->load_css('assets/operator/js/plugins/bootstrap-datepicker/css/bootstrap-datepicker3.min.css');
        $this->load_js('assets/operator/js/plugins/bootstrap-datepicker/js/bootstrap-datepicker.min.js');
        
        parent::display('edit', null, 'footer_edit');
    }
}