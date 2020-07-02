<?php

class Barang extends Portal_admin{

    public $form_conf = array(
        array('field' => 'nama_barang', 'label' => 'Nama Barang', 'rules' => 'required|max_length[255]|strip_tags|trim'),       
    );
    
    public function __construct()
    {
        parent::__construct();
        $this->load->model('m_barang');
    }

    public function index()
    {
        $this->_set_page_role('r');
        $data['rs_kategori'] = $this->m_barang->get_list_kategori();


        parent::display('index', $data, 'footer_index');
    }

    
    function get_list_barang()
    {
        $this->_set_page_role('r');

        if (!$this->input->is_ajax_request()) {
            show_404();
        }

        $rs_barang = $this->m_barang->get_list_barang();

        return $this->output->set_output(json_encode($rs_barang));
    }

    // datatable - terfilter kategori
    /*public function get_list_barang()
    {
        $this->_set_page_role('r');

        if (!$this->input->is_ajax_request()) {
            show_404();
        }

        $this->load->library('cldatatable');

        // tombol
        $tombol = '<div class="text-center">
                        <a class="btn btn-sm btn-alt-warning ubah-data" href="' . base_url() . 'barang/edit/{{barang_id}}" data-toggle="tooltip" title="Edit Data"><i class="fa fa-pencil"></i></a>
                        <button type="button" class="btn btn-sm btn-alt-danger hapus-data" data-toggle="tooltip" title="Hapus Data" data-id="{{barang_id}}"><i class="fa fa-trash"></i> </button>
                    </div>';

        return $this->output->set_output(
            $this->cldatatable->set_tabel('barang b')
                ->set_kolom('b.barang_id, b.nama_barang, k.nama_kategori')
                ->join_tabel('kategori_barang k', 'k.kategori_id = b.kategori_id', 'inner')
                ->cari_perkolom_like('nama_barang', $this->input->post('barang'), 'both')
                ->saring_data('k.kategori_id', $this->input->post('kategori_id'))
                ->saring_data('b.is_deleted', 0)
                ->tambah_kolom('tombol', $tombol)
                ->get_datatable()
        );
    }*/

    public function tambah()
    {
        // load select2
        $this->load_css('assets/operator/js/plugins/select2/css/select2.min.css');
        $this->load_js('assets/operator/js/plugins/select2/js/select2.min.js');

        // load jquery validator
        $this->load_css('assets/global/jquery-form-validator-net/form-validator/theme-default.min.css');
        $this->load_js('assets/global/jquery-form-validator-net/form-validator/jquery.form-validator.min.js');

        $data['rs_kategori'] = $this->m_barang->get_list_kategori();

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

        // load uuid
        $this->load->library('uuid');

        $data_simpan['barang_id']   = $this->uuid->v4(true);
        $data_simpan['nama_barang'] = $this->input->post('nama_barang', true);
        $data_simpan['kategori_id'] = $this->input->post('kategori_id', true);
        $data_simpan['ctb']         = $this->com_user['user_id'];
        $data_simpan['created_at']  = date('Y-m-d H:i:s');
        $data_simpan['mdb']         = $this->com_user['user_id'];
        $data_simpan['updated_at']  = date('Y-m-d H:i:s');

        if ($this->m_barang->tambah_data('barang', $data_simpan)) {
            $result['status'] = true;
            $result['pesan']  = 'Data berhasil disimpan.';
        } else {
            $eror             = $this->m_barang->get_db_error();
            $result['status'] = false;
            $result['pesan']  = 'Data gagal disimpan. Eror kode : ' . $eror['code'];
        }
        return $this->output->set_output(json_encode($result));
    }

    public function edit($barang_id = null)
    {
        $data['barang'] = $this->m_barang->get_detail_barang($barang_id);
        $data['rs_kategori'] = $this->m_barang->get_list_kategori();

        /*echo "<pre/>";
        print_r($data['rs_kategori']);
        exit();*/

        if (empty($data['barang'])) {
            redirect('barang');
        }

        if (!empty($data['barang'])) {
            $data['status'] = true;
            $data['data']   = $data['barang'];
        } else {
            $data['status'] = false;
            $data['data']   = null;
            $data['pesan']  = $this->m_barang->get_error_message();
        }
        parent::display('edit', $data, 'footer_edit');
    }

    public function ubah()
    {
        $this->_set_page_role('u');

        if (!$this->input->is_ajax_request())
            return;

            $this->load->library('form_validation');
            $this->form_validation->set_rules($this->form_conf);

            if ($this->form_validation->run() == FALSE) {
                $data['pesan'] = validation_errors();
                $data['status'] = FALSE;
                return $this->output->set_output(json_encode($data));
            }

        // set data
            $data_simpan['nama_barang'] = $this->input->post('nama_barang');
            $data_simpan['kategori_id'] = $this->input->post('kategori_id');
            $data_simpan['mdb']         = $this->com_user['user_id'];
            $data_simpan['updated_at']  = date('Y-m-d H:i:s');

            if ($this->m_barang->ubah_data('barang', 'barang_id', $this->input->post('barang_id', TRUE), $data_simpan)) {
                $result['status'] = TRUE;
                $result['pesan'] = 'Data barang ' . $this->input->post('nama_barang', TRUE) . ' berhasil diubah.';
            } else {
                $error = $this->m_barang->get_db_error();
                $result['status'] = FALSE;
                $result['pesan'] = 'Data barang ' . $this->input->post('nama_barang', TRUE) . ' gagal diubah. Error kode : ' . $error['code'];
            }
            return $this->output->set_output(json_encode($result));
        }

        public function hapus_barang()
        {    
            $this->_set_page_role('d');

            if (!$this->input->is_ajax_request()) {
                show_404();
            }

            if ($this->input->post() == '') {
                $respon['status'] = false;
                $respon['pesan']  = 'Data ID tidak tersedia';
            }

            $hapus['barang_id'] = $this->input->post('data_id');

            if ($this->m_barang->hapus_data('barang', $hapus)) {
                $data['status'] = true;
                $data['pesan']  = 'Data berhasil dihapus.';
            } else {
                if ($this->m_barang->ubah_data('barang', 'barang_id', $this->input->post('data_id'), ['is_deleted' => '1'])) {
                    $data['status'] = true;
                    $data['pesan']  = 'Data berhasil dihapus.';
                } else {
                    $error          = $this->m_barang->get_db_error();
                    $data['status'] = false;
                    $data['pesan']  = 'Data gagal dihapus. Error kode : ' . $error['code'];
                }
            }
            return $this->output->set_output(json_encode($data));
        }    
    }