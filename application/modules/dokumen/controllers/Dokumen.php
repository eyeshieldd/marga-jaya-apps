<?php

class Dokumen extends Portal_admin{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('m_dokumen');
    }
    
    public function index()
    {        
        $this->_set_page_role('r');

        /* ambil data cabang dari session user */
        $data['nama_cabang'] = $this->com_user['nama_cabang'];
        $data['rs_cabang']   = $this->m_dokumen->get_pencarian_cabang($this->com_user['nama_cabang']);

        // echo "<pre/>";
        // print_r($data['rs_cabang']);
        // exit();
        
        parent::display('index', $data, 'footer_index');        
    }

    /* datatable lama - dipakai */    
    function get_list_dokumen_test()
    {
        $this->_set_page_role('r');

        if (!$this->input->is_ajax_request()) {
            show_404();
        }

        $rs_dokumen = $this->m_dokumen->get_list_dokumen();

        return $this->output->set_output(json_encode($rs_dokumen));
    }

    public function get_list_dokumen()
    {
        $this->_set_page_role('r');
        
        if (!$this->input->is_ajax_request()) {
            show_404();
        }

        // tombol
        $tombol = '<div class="text-center">
                        <a class="btn btn-sm btn-alt-secondary download-data" href="' . base_url() . 'dokumen/download/{{dokumen_id}}" data-toggle="tooltip" title="Download Data"><i class="fa fa-download"></i></a>
                        <button type="button" class="btn btn-sm btn-alt-danger hapus-data" data-toggle="tooltip" title="Hapus Data" data-id="{{dokumen_id}}"><i class="fa fa-trash"></i> </button>
                    </div>';

        $this->load->library('cldatatable');

        return $this->output->set_output($this->cldatatable->set_kolom('d.dokumen_id, d.nama_dokumen, c.nama_cabang, c.cabang_id')
                ->set_tabel('dokumen d')
                ->join_tabel('cabang c', 'd.cabang_id = c.cabang_id', 'left')
                ->cari_perkolom_like('nama_dokumen', $this->input->post('dokumen'),'both')
                ->saring_data('c.cabang_id', $this->input->post('cabang_id'))
                ->tambah_kolom('tombol', $tombol)
                ->get_datatable());
    }
    
    public function tambah()
    {
        // load select2
        $this->load_css('assets/operator/js/plugins/select2/css/select2.min.css');
        $this->load_js('assets/operator/js/plugins/select2/js/select2.min.js');

        $data['rs_cabang'] = $this->m_dokumen->get_list_cabang();

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
        $this->form_validation->set_rules('nama_dokumen', 'Nama Dokumen', 'required|trim');

        // run validation
        if ($this->form_validation->run() == false) {
            $data['pesan']  = validation_errors();
            $data['status'] = false;
            return $this->output->set_output(json_encode($data));
        }

        // validasi file upload
        // if ($_FILES['file_dokumen']['name'] == ''){
        //     $this->form_validation->set_error_message('File Dokumen','File dokumen belum diupload');
        // }


        // echo "<pre/>";
        // print_r($_FILES['upload_data']);
        // exit();

        // direktori config dokumen
        // $dir_dokumen  = 'uploads/dokumen/';


        // config upload file dokumen - format jpeg (image)
        $config = array(
            'upload_path'    => 'uploads/dokumen/',            
            'allowed_types'  => 'pdf|jpg|jpeg|png|doc|xlsx',
            // 'overwrite'      => true
        );

        // if (!file_exists($dir_dokumen)) {
        //     if(!mkdir($dir_dokumen, 0777, true)){
        //         die('Failed to create folders...');
        //     }
        // }

        // lakukan upload
        $this->load->library('upload', $config);
        // $this->upload->initialize($config);

        if (!$this->upload->do_upload('file_dokumen')) {
            $data['pesan']  = $this->upload->display_errors();
            $data['status'] = false;
            return $this->output->set_output(json_encode($data));
        }

        $data['upload_data'] = $this->upload->data();
        $file_dokumen        = $config['upload_path'].$data['upload_data']['file_name'];
        
        // library uuid
        $this->load->library('uuid');
        $data_simpan['dokumen_id']   = $this->uuid->v4(true);
        $data_simpan['nama_dokumen'] = $this->input->post('nama_dokumen', true);
        $data_simpan['cabang_id']    = $this->input->post('cabang_id', true);
        $data_simpan['file_url']     = $file_dokumen;
        $data_simpan['ctb']          = $this->com_user['user_id'];
        $data_simpan['created_at']   = date('Y-m-d H:i:s');
        $data_simpan['mdb']          = $this->com_user['user_id'];
        $data_simpan['updated_at']   = date('Y-m-d H:i:s');

        // echo "<pre/>";
        // print_r($data_simpan);
        // exit();

        if ($this->m_dokumen->tambah_data('dokumen', $data_simpan)) {
            $result['status'] = true;
            $result['pesan']  = 'Data berhasil disimpan.';
        } else {
            $eror             = $this->m_dokumen->get_db_error();
            $result['status'] = false;
            $result['pesan']  = 'Data gagal disimpan. Eror kode : ' . $eror['code'];
        }
        return $this->output->set_output(json_encode($result));
    }

    // download file
    public function download($id = null)
    {
        $this->load->helper('download');

        $result = $this->m_dokumen->get_detail_dokumen($id);

        $file = $result['file_url'];        

        force_download($file, null);
    }

    public function hapus_dokumen() {
        
        $this->_set_page_role('d');

        if (!$this->input->is_ajax_request()) {
            show_404();
        }

        if ($this->input->post() == '') {
            $respon['status'] = false;
            $respon['pesan']  = 'Data ID tidak tersedia';
        }     

        if ($this->m_dokumen->hapus($this->input->post('data_id'))) {
            $data['status'] = true;
            $data['pesan']  = 'Data berhasil dihapus.';
        } else {
            $error          = $this->m_dokumen->get_db_error();
            $data['status'] = false;
            $data['pesan']  = 'Data gagal dihapus. Error kode : ' . $error['code'];
        }
        return $this->output->set_output(json_encode($data));
    }    
}