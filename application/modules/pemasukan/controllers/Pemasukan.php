<?php

class Pemasukan extends Portal_admin{

    /* validate - |trim|xss_clean|strip_tags| */
    public $form_conf = array(
        array('field' => 'deskripsi', 'label' => 'Nama Pemasukan', 'rules' => 'required|max_length[255]|strip_tags'),
        array('field' => 'nominal', 'label' => 'Nominal', 'rules' => 'required|strip_tags'),
    );

    public function __construct(){
        parent::__construct();
        $this->load->model('m_pemasukan');
    }

    public function index()
    {
        $this->_set_page_role('r');

        // load datepicker
        $this->load_css('assets/operator/js/plugins/bootstrap-datepicker/css/bootstrap-datepicker3.min.css');
        $this->load_js('assets/operator/js/plugins/bootstrap-datepicker/js/bootstrap-datepicker.min.js');

        /* ambil data cabang dari session user */
        $data['nama_cabang'] = $this->com_user['nama_cabang'];
        $data['rs_cabang']   = $this->m_pemasukan->get_pencarian_cabang($this->com_user['nama_cabang']);

        // echo "<pre/>";
        // print_r($data);
        // exit();
        
        parent::display('index', $data, 'footer_index');
    }

    /* datatable lama */
    function get_list_data()
    {
        $this->_set_page_role('r');

        if (!$this->input->is_ajax_request()) {
            show_404();
        }

        $rs_pemasukan = $this->m_pemasukan->get_list_pemasukan();

        /*$vdata['pemasukan'] = $rs_pemasukan;*/
        echo "<pre/>";
        print_r($vdata['pemasukan']['data']);
        exit();

        return $this->output->set_output(json_encode($rs_pemasukan));
    }

    /* datatable baru - dipakai */
    public function get_list_pemasukan()
    {
        $this->_set_page_role('r');

        if (!$this->input->is_ajax_request()) {
            show_404();
        }

        // tombol
        $tombol = '<div class="text-center">
                        <button type="button" class="btn btn-sm btn-alt-danger hapus-data" data-toggle="tooltip" title="Hapus Data" data-id="{{arus_id}}"><i class="fa fa-trash"></i> </button>
                    </div>';

        $this->load->library('cldatatable');

        // ambil data dari input post tanggal
        // $firstDate = $this->input->post('tanggal');
        // // set data tanggal awal
        // if ($firstDate == null) {
        //     $firstDate = date('Y-m-d');
        // }
        // $result = '01-'.$firstDate.' 00:00:00';

        // test input post field pemasukan
        $pemasukan = $this->input->post('pemasukan');

        // converter
        // $tanggal_awal = Date('Y-m-01 00:00:00', strtotime($firstDate));
        // $tanggal_akhir = Date('Y-m-t 23:59:59', strtotime($firstDate));

        // echo "<pre/>";
        // // print_r($tanggal_awal);
        // print_r($this->input->post('tanggal'));
        // exit();

        $this->cldatatable->set_tabel('arus_kas a')
                ->set_kolom('a.arus_id, a.tanggal_transaksi, a.deskripsi, a.nominal, c.nama_cabang')
                ->join_tabel('cabang c', 'a.cabang_id = c.cabang_id', 'inner')
                ->saring_data('c.cabang_id', $this->input->post('cabang_id'))
                ->saring_data('jenis_pengeluaran', 'in');

        // $firstDate = $this->input->post('tanggal');
        // // set data tanggal awal
        // if ($firstDate == null) {
        //     $firstDate = date('Y-m-d');
        // }
        if (!empty($this->input->post('tanggal'))) {
        $result = '01-'.$this->input->post('tanggal');
            $tanggal_awal = Date('Y-m-01 00:00:00', strtotime($result));
            $tanggal_akhir = Date('Y-m-t 23:59:59', strtotime($result));
            $this->cldatatable
                ->saring_data('a.tanggal_transaksi >= "'.$tanggal_awal.'" AND a.tanggal_transaksi <= ',  $tanggal_akhir);
        }

        return $this->output->set_output(            
                $this->cldatatable
                ->cari_perkolom_like('deskripsi', $this->input->post('pemasukan'),'both')
                /* format tanggal */
                ->modif_data('tanggal_transaksi', function ($d) {
                    return Date('d-M-Y', strtotime($d['tanggal_transaksi']));
                })
                ->modif_data('nominal', function($d){
                    return format_rupiah($d['nominal']);
                })
                ->tambah_kolom('tombol', $tombol)
                ->get_datatable()
            );
    }

    public function tambah()
    {
        // load datepicker
        $this->load_css('assets/operator/js/plugins/bootstrap-datepicker/css/bootstrap-datepicker3.min.css');
        $this->load_js('assets/operator/js/plugins/bootstrap-datepicker/js/bootstrap-datepicker.min.js');

        // load select2
        $this->load_css('assets/operator/js/plugins/select2/css/select2.min.css');
        $this->load_js('assets/operator/js/plugins/select2/js/select2.min.js');

        // load jquery validator
        $this->load_css('assets/global/jquery-form-validator-net/form-validator/theme-default.min.css');
        $this->load_js('assets/global/jquery-form-validator-net/form-validator/jquery.form-validator.min.js');

        $this->load_js('assets/operator/js/plugins/inputmask/dist/jquery.inputmask.bundle.js');

        $data['nama_cabang'] = $this->com_user['nama_cabang'];
        // $data['rs_cabang'] = $this->m_pemasukan->get_list_cabang($this->com_user['cabang_id']);
        $data['rs_cabang']   = $this->m_pemasukan->get_pencarian_cabang($this->com_user['nama_cabang']);

        // echo "<pre/>";
        // print_r($data);
        // exit();
        
        parent::display('tambah', $data, 'footer_tambah');
    }

    public function simpan()
    {
        $this->_set_page_role('c');

        if (!$this->input->is_ajax_request()) {
            show_404();
        }

        // load form validation
        $this->load->library('form_validation');
        $this->form_validation->set_rules($this->form_conf);

        // run validation
        if ($this->form_validation->run($this) == false) {
            $data['pesan']  = validation_errors();
            $data['status'] = false;
            return $this->output->set_output(json_encode($data));
        }

        // save database
        $this->load->library('uuid'); // load uuid
        $data_simpan['arus_id']           = $this->uuid->v4(true);
        $data_simpan['cabang_id']         = $this->input->post('cabang_id', true);
        $data_simpan['tanggal_transaksi'] = date_format(date_create_from_format('d-m-Y', $this->input->post('tanggal')), 'Y-m-d');
        $data_simpan['jenis_pengeluaran'] = 'in';
        $data_simpan['deskripsi']         = $this->input->post('deskripsi');
        $data_simpan['nominal']           = $this->input->post('nominal');
        $data_simpan['ctb']               = $this->com_user['user_id'];
        $data_simpan['created_at']        = date('Y-m-d H:i:s');
        $data_simpan['mdb']               = $this->com_user['user_id'];
        $data_simpan['updated_at']        = date('Y-m-d H:i:s');

        if ($this->m_pemasukan->tambah_data('arus_kas', $data_simpan)) {
            $result['status'] = true;
            $result['pesan']  = 'Data berhasil disimpan.';
        } else {
            $eror             = $this->m_pemasukan->get_db_error();
            $result['status'] = false;
            $result['pesan']  = 'Data gagal disimpan. Eror kode : ' . $eror['code'];
        }
        return $this->output->set_output(json_encode($result));
    }

    public function hapus_pemasukan() 
    {
        $this->_set_page_role('d');

        if (!$this->input->is_ajax_request()) {
            show_404();
        }

        if ($this->input->post() == '') {
            $respon['status'] = false;
            $respon['pesan']  = 'Data ID tidak tersedia';
        }

        $hapus['arus_id'] = $this->input->post('data_id');
        if ($this->m_pemasukan->hapus_data('arus_kas', $hapus)) {
            $data['status'] = true;
            $data['pesan']  = 'Data berhasil dihapus.';
        } else {
            $error          = $this->m_pemasukan->get_db_error();
            $data['status'] = false;
            $data['pesan']  = 'Data gagal dihapus. Error kode : ' . $error['code'];
        }
        return $this->output->set_output(json_encode($data));
    }
}