<?php

class Kategori extends Portal_admin
{

    public $form_conf = array(
        array('field' => 'nama_kategori', 'label' => 'Nama Kategori', 'rules' => 'required|max_length[255]|strip_tags|trim'),
        array('field' => 'satuan', 'label' => 'Satuan', 'rules' => 'required|max_length[255]|strip_tags|trim'),
        array('field' => 'konversi', 'label' => 'Konversi', 'rules' => 'required|max_length[255]|strip_tags|trim'),
    );

    public function __construct()
    {
        parent::__construct();
        $this->load->model('m_kategori');
    }

    public function index()
    {
        $this->_set_page_role('r');

        parent::display('index', null, 'footer_index');
    }

    /* datatable */
    public function get_list_kategori()
    {
        $this->_set_page_role('r');

        if (!$this->input->is_ajax_request()) {
            show_404();
        }

        // tombol
        $tombol = '<div class="text-center">
        <a class="btn btn-sm btn-alt-warning ubah-data" href="' . base_url() . 'kategori/edit/{{kategori_id}}" data-toggle="tooltip" title="Edit Data"><i class="fa fa-pencil"></i></a>
        <button type="button" class="btn btn-sm btn-alt-danger hapus-data" data-toggle="tooltip" title="Hapus Data" data-id="{{kategori_id}}"><i class="fa fa-trash"></i> </button>
        </div>';

        $this->load->library('cldatatable');

        return $this->output->set_output(
            $this->cldatatable->set_kolom('kategori_id, nama_kategori, satuan')
                ->saring_data('is_deleted', 0)
                ->cari_perkolom_like('nama_kategori', $this->input->post('cari'), 'both')
                ->set_tabel('kategori_barang')
                ->tambah_kolom('tombol', $tombol)
                ->get_datatable()
        );
    }

    public function tambah()
    {
        // load jquery validator
        $this->load_js('assets/operator/js/plugins/inputmask/dist/jquery.inputmask.bundle.js');
        $this->load_css('assets/global/jquery-form-validator-net/form-validator/theme-default.min.css');
        $this->load_js('assets/global/jquery-form-validator-net/form-validator/jquery.form-validator.min.js');

        parent::display('tambah', null, 'footer_tambah');
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

        #run validation
        if ($this->form_validation->run($this) == false) {
            $data['pesan']  = validation_errors();
            $data['status'] = false;
            return $this->output->set_output(json_encode($data));
        }
        #insert to tabel kategori
        $this->load->library('uuid');
        $data_simpan['kategori_id']   = $this->uuid->v4(true);
        $data_simpan['nama_kategori'] = $this->input->post('nama_kategori', true);
        $data_simpan['satuan']        = $this->input->post('satuan', true);
        $data_simpan['konversi']      = $this->input->post('konversi', true);
        $data_simpan['ctb']           = $this->com_user['user_id'];
        $data_simpan['created_at']    = date('Y-m-d H:i:s');
        $data_simpan['mdb']           = $this->com_user['user_id'];
        $data_simpan['updated_at']    = date('Y-m-d H:i:s');

        if ($this->input->post('chart') == true) {
            $data_simpan['is_show_chart'] = $this->input->post('chart');
        } else {
            $data_simpan['is_show_chart'] = 0;
        }
        if ($this->m_kategori->tambah_data('kategori_barang', $data_simpan)) {
            $result['status'] = true;
            $result['pesan']  = 'Data berhasil disimpan.';
        } else {
            $eror             = $this->m_kategori->get_db_error();
            $result['status'] = false;
            $result['pesan']  = 'Data gagal disimpan. Eror kode : ' . $eror['code'];
        }
        return $this->output->set_output(json_encode($result));
    }

    public function edit($id = null)
    {
        // ambil detail data kategori berdasar ID
        $data['kategori'] = $this->m_kategori->get_detail_kategori($id);
        $data['rs_satuan'] = $this->m_kategori->get_list_satuan();

        // echo "<pre/>";
        // print_r($data['kategori']);
        // exit();

        if (!empty($data['kategori'])) {
            $data['status'] = true;
            $data['data']   = $data['kategori'];
        } else {
            $data['status'] = false;
            $data['data']   = null;
            $data['pesan']  = $this->m_kategori->get_error_message();
        }
        $this->load_js('assets/operator/js/plugins/inputmask/dist/jquery.inputmask.bundle.js');

        parent::display('edit', $data, 'footer_index');
    }

    public function ubah()
    {

        if (!$this->input->is_ajax_request())
            return;

        $this->_set_page_role('u');

        $this->load->library('form_validation');
        $this->form_validation->set_rules($this->form_conf);

        if ($this->form_validation->run() == FALSE) {
            $data['pesan'] = validation_errors();
            $data['status'] = FALSE;
            return $this->output->set_output(json_encode($data));
        }

        // set data
        $data_simpan['nama_kategori'] = $this->input->post('nama_kategori', true);
        $data_simpan['satuan']        = $this->input->post('satuan', true);
        $data_simpan['konversi']      = $this->input->post('konversi', true);
        $data_simpan['is_show_chart'] = $this->input->post('chart', true) == '' ? 0 : 1;
        $data_simpan['mdb']           = $this->com_user['user_id'];
        $data_simpan['updated_at']    = date('Y-m-d H:i:s');

        if ($this->m_kategori->ubah_data('kategori_barang', 'kategori_id', $this->input->post('kategori_id', TRUE), $data_simpan)) {
            $result['status'] = TRUE;
            $result['pesan'] = 'Data kategori ' . $this->input->post('nama_kategori', TRUE) . ' berhasil diubah.';
        } else {
            $error = $this->m_kategori->get_db_error();
            $result['status'] = FALSE;
            $result['pesan'] = 'Data kategori ' . $this->input->post('nama_kategori', TRUE) . ' gagal diubah. Error kode : ' . $error['code'];
        }
        return $this->output->set_output(json_encode($result));
    }

    public function hapus_kategori()
    {
        $this->_set_page_role('d');

        if (!$this->input->is_ajax_request()) {
            show_404();
        }

        if ($this->input->post() == '') {
            $respon['status'] = false;
            $respon['pesan']  = 'Data ID tidak tersedia';
        }

        $hapus['kategori_id'] = $this->input->post('data_id');

        if ($this->m_kategori->hapus_data('kategori_barang', $hapus)) {
            $data['status'] = true;
            $data['pesan']  = 'Data berhasil dihapus.';
        } else {
            if ($this->m_kategori->ubah_data('kategori_barang', 'kategori_id', $this->input->post('data_id'), ['is_deleted' => '1'])) {
                $data['status'] = true;
                $data['pesan']  = 'Data berhasil dihapus.';
            } else {
                $error          = $this->m_kategori->get_db_error();
                $data['status'] = false;
                $data['pesan']  = 'Data gagal dihapus. Error kode : ' . $error['code'];
            }
        }
        return $this->output->set_output(json_encode($data));
    }
}
