<?php

class Cabang extends Portal_admin{

    public $form_conf = array(
        array('field' => 'kode_cabang', 'label' => 'Kode Cabang', 'rules' => 'required|trim'),
        array('field' => 'nama_cabang', 'label' => 'Nama Cabang', 'rules' => 'required|max_length[255]|strip_tags|trim'),
        array('field' => 'alamat', 'label' => 'Kategori', 'rules' => 'required|max_length[255]|strip_tags|trim'), 
        array('field' => 'telepon', 'label' => 'Telepon', 'rules' => 'required|max_length[255]|strip_tags|trim'),
    );
    
    public function __construct(){
        parent::__construct();
        $this->load->model('m_cabang');
    }
    
    public function index()
    {
        $this->_set_page_role('r');

        parent::display('index', null, 'footer_index');
    }
    
    public function get_list_cabang()
    {
        $this->_set_page_role('r');
        
        if (!$this->input->is_ajax_request()) {
            show_404();
        }

        // tombol
        $tombol = '<div class="text-center">
                        <a class="btn btn-sm btn-alt-warning ubah-data" href="' . base_url() . 'cabang/edit/{{cabang_id}}" data-toggle="tooltip" title="Edit Data"><i class="fa fa-pencil"></i></a>
                        <button type="button" class="btn btn-sm btn-alt-danger hapus-data" data-toggle="tooltip" title="Hapus Data" data-id="{{cabang_id}}"><i class="fa fa-trash"></i> </button>
                    </div>';

        $this->load->library('cldatatable');

        return $this->output->set_output($this->cldatatable->set_kolom('cabang_id, kode_cabang, nama_cabang, alamat, telepon')
                ->saring_data('is_deleted', 0)
                ->cari_perkolom_like('nama_cabang', $this->input->post('cari'),'both')
                ->set_tabel('cabang')
                ->tambah_kolom('aksi', $tombol)
                ->get_datatable());
    }

    public function tambah()
    {
        // load jquery validator
        $this->load_css('assets/global/jquery-form-validator-net/form-validator/theme-default.min.css');
        $this->load_js('assets/global/jquery-form-validator-net/form-validator/jquery.form-validator.min.js');

        parent::display('tambah', null, 'footer_tambah');
    }

    public function simpan()
    {
        // set permission
        $this->_set_page_role('c');

        // validasi hanya request lewat ajax
        if (!$this->input->is_ajax_request()) {
            show_404();
        }

        // load form validation
        $this->load->library('form_validation');
       
        $this->form_validation->set_rules('kode_cabang', 'Kode Cabang', 'required|trim');
        $this->form_validation->set_rules('nama_cabang', 'Nama Cabang', 'required|max_length[255]|strip_tags|trim');
        $this->form_validation->set_rules('alamat', 'Kategori', 'required|max_length[255]|strip_tags|trim'); 
        $this->form_validation->set_rules('telepon', 'Telepon', 'required|max_length[255]|strip_tags|trim');

        $kode_cabang = $this->input->post('kode_cabang', true);
        $data['kode_cabang'] = $this->m_cabang->kode_cabang_is_exist($kode_cabang);

        if (!empty($data['kode_cabang'])) {
            $data['pesan'] = 'Kode cabang sudah digunakan. Silakan masukkan kode cabang lain.';
            $data['status'] = FALSE;
            return $this->output->set_output(json_encode($data));
        }

        // run validation
        if ($this->form_validation->run($this) == false) {
            $data['pesan']  = validation_errors();
            $data['status'] = false;
            return $this->output->set_output(json_encode($data));
        }

        // library uuid
        $this->load->library('uuid');
        $data_simpan['kode_cabang'] = $this->input->post('kode_cabang', true);
        $data_simpan['nama_cabang'] = $this->input->post('nama_cabang', true);
        $data_simpan['alamat']      = $this->input->post('alamat', true);
        $data_simpan['telepon']     = $this->input->post('telepon', true);
        $data_simpan['ctb']         = $this->com_user['user_id'];
        $data_simpan['created_at']  = date('Y-m-d H:i:s');
        $data_simpan['mdb']         = $this->com_user['user_id'];
        $data_simpan['updated_at']  = date('Y-m-d H:i:s');

        if ($this->m_cabang->tambah_data('cabang', $data_simpan)) {
            $result['status'] = true;
            $result['pesan']  = 'Data berhasil disimpan.';
        } else {
            $eror             = $this->m_pl_kejuruan->get_db_error();
            $result['status'] = false;
            $result['pesan']  = 'Data gagal disimpan. Eror kode : ' . $eror['code'];
        }
        return $this->output->set_output(json_encode($result));
    }

    public function edit($cabang_id = null)
    {
        // ambil detail data cabang berdasar ID
        $data['cabang'] = $this->m_cabang->get_detail_cabang($cabang_id);
        $data['cabang_id'] = $cabang_id;

        /*$data['kode_cabang'] = $this->m_cabang->kode_cabang_is_exist($cabang_id);
        echo "<pre/>";
        print_r($data['kode_cabang']);
        exit();*/

        if (empty($data['cabang'])) {
            redirect('cabang');
        }

        if (!empty($data['cabang'])) {
            $data['status'] = true;
            $data['data']   = $data['cabang'];
        } else {
            $data['status'] = false;
            $data['data']   = null;
            $data['pesan']  = $this->m_cabang->get_error_message();
        }
        parent::display('edit', $data, 'footer_edit');
    }

    public function ubah($cabang_id = null)
    {
        $this->_set_page_role('u');
        
        if (!$this->input->is_ajax_request())
            return;

        $this->load->library('form_validation');

        // $this->form_validation->set_rules($this->form_conf);

        $this->form_validation->set_rules('kode_cabang', 'Kode Cabang', 'required|max_length[255]|strip_tags|trim');
        $this->form_validation->set_rules('nama_cabang', 'Nama Cabang', 'required|max_length[255]|strip_tags|trim');
        $this->form_validation->set_rules('alamat', 'Alamat', 'required|max_length[255]|strip_tags|trim');
        $this->form_validation->set_rules('telepon', 'Telepon', 'required|max_length[255]|strip_tags|trim');
        
        $kode_cabang = $this->input->post('kode_cabang', true);
        $check_kode_cabang = $this->m_cabang->check_kode_cabang($cabang_id);
        /*$cek = $check_kode_cabang['kode_cabang'] != $kode_cabang ? 'Betul' : 'Salah';*/

        if ($check_kode_cabang['kode_cabang'] != $kode_cabang) {
            $data['kode_cabang'] = $this->m_cabang->kode_cabang_is_exist($kode_cabang);

            if (!empty($data['kode_cabang'])) {
                $data['pesan'] = 'Kode cabang sudah digunakan. Silakan masukkan kode cabang lain.';
                $data['status'] = FALSE;
                return $this->output->set_output(json_encode($data));
            }
        }

        /*echo "<pre/>";
        print_r($check_kode_cabang['kode_cabang']);
        print_r($kode_cabang);
        print_r($cek);
        print_r($data['kode_cabang']);
        exit();*/
        
        if ($this->form_validation->run() == FALSE) {
            $data['pesan'] = validation_errors();
            $data['status'] = FALSE;
            return $this->output->set_output(json_encode($data));
        }

        // set data        
        $data_simpan['kode_cabang'] = $this->input->post('kode_cabang', true);
        $data_simpan['nama_cabang'] = $this->input->post('nama_cabang', true);
        $data_simpan['alamat']      = $this->input->post('alamat', true);
        $data_simpan['telepon']     = $this->input->post('telepon', true);
        $data_simpan['mdb']         = $this->com_user['user_id'];
        $data_simpan['updated_at']  = date('Y-m-d H:i:s');

        /*echo "<pre/>";
        var_dump($data_simpan);
        exit();*/

        if ($this->m_cabang->ubah_data('cabang', 'cabang_id', $this->input->post('cabang_id', TRUE), $data_simpan)) {
            $result['status'] = TRUE;
            $result['pesan'] = 'Data cabang ' . $this->input->post('nama_cabang', TRUE) . ' berhasil diubah.';
        } else {
            $error = $this->m_cabang->get_db_error();
            $result['status'] = FALSE;
            $result['pesan'] = 'Data cabang ' . $this->input->post('nama_cabang', TRUE) . ' gagal diubah. Error kode : ' . $error['code'];
        }
        return $this->output->set_output(json_encode($result));
    }

    public function hapus_cabang()
    {        
        $this->_set_page_role('d');

        if (!$this->input->is_ajax_request()) {
            show_404();
        }

        if ($this->input->post() == '') {
            $respon['status'] = false;
            $respon['pesan']  = 'Data ID tidak tersedia';
        }

        /*
         * Check kategori_id di tabel barang
         * kalau ada kategori_id di update
         * ngak ada di hapus
         */

        $hapus['cabang_id'] = $this->input->post('data_id');

        if ($this->m_cabang->hapus_data('cabang', $hapus)) {
            $data['status'] = true;
            $data['pesan']  = 'Data berhasil dihapus.';            
        } else {
            if ($this->m_cabang->ubah_data('cabang', 'cabang_id', $this->input->post('data_id'), ['is_deleted' => '1'])) {
                $data['status'] = true;
                $data['pesan']  = 'Data berhasil dihapus.';
            } else {
                $error          = $this->m_cabang->get_db_error();
                $data['status'] = false;
                $data['pesan']  = 'Data gagal dihapus. Error kode : ' . $error['code'];
            }
        }
        return $this->output->set_output(json_encode($data));
    }
}