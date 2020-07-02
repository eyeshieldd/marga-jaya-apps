<?php

class Stock extends Portal_admin
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('m_stock');
    }

    public function index()
    {
        $this->_set_page_role('r');

        $data['rs_kategori'] = $this->m_stock->get_list_kategori();
        $data['result_cabang'] = $this->com_user['cabang_id'];
        $data['rs_cabang']   = $this->m_stock->get_pencarian_cabang();

        parent::display('index', $data, 'footer_index');
    }

    /* menampilkan list stok */
    public function get_list_stock()
    {
        $this->_set_page_role('r');

        if (!$this->input->is_ajax_request()) {
            show_404();
        }

        if ($this->input->post('cabang_id') != '') {
            $rs_stock = $this->m_stock->get_list_stock($this->com_user);
        } else {
            $rs_stock['recordsTotal'] = $rs_stock['recordsFiltered'] = 0;
            $rs_stock['data']         = [];
        }

        return $this->output->set_output(json_encode($rs_stock));
    }

    public function produksi($barang_id, $cabang_id)
    {
        $this->_set_page_role('r');

        // select stok_id dari data barang_id
        $data['stok_id'] = $this->m_stock->get_stok_id($barang_id, $cabang_id);

        // tampilkam nama barang dari tabel barang
        $data['produksi']  = $this->m_stock->get_nama_barang($barang_id);
        $data['barang_id'] = $barang_id;
        $data['cabang_id'] = $cabang_id;

        // echo "<pre/>";
        // print_r($data['produksi']);
        // exit();

        # cek data stok sudah ada belum - kalau belum (tambahkan)
        if (!$this->m_stock->is_exist_data($barang_id, $cabang_id)) {

            # load library uuid
            $this->load->library('uuid');

            $data_simpan['stok_id']    = $this->uuid->v4(true);
            $data_simpan['barang_id']  = $barang_id;
            $data_simpan['cabang_id']  = $cabang_id;
            $data_simpan['ctb']        = $this->com_user['user_id'];
            $data_simpan['created_at'] = date('Y-m-d H:i:s');
            $data_simpan['mdb']        = $this->com_user['user_id'];
            $data_simpan['updated_at'] = date('Y-m-d H:i:s');

            # simpan data
            $this->m_stock->tambah_data('stok', $data_simpan);
        }
        parent::display('produksi', $data, 'footer_produksi');
    }

    /* menampilkan list produksi */
    public function get_list_produksi($barang_id, $cabang_id)
    {
        $this->_set_page_role('r');

        if (!$this->input->is_ajax_request()) {
            show_404();
        }

        $this->load->library('cldatatable');

        // tombol
        $tombol = '<div class="text-center"><a class="btn btn-sm btn-alt-secondary detail-data tombol-detail" href="' . base_url() . 'stock/penyesuaian/{{stok_produksi_id}}" data-toggle="tooltip" title="Penyesuaian Stok"><i class="fa fa-history"></i></a>';
        $tombol .= '&nbsp; <a class="btn btn-sm btn-alt-secondary detail-data tombol-detail" href="' . base_url() . 'stock/detail_produksi/{{stok_produksi_id}}" data-toggle="tooltip" title="Detail Data"><i class="fa fa-list"></i></a></div>';

        return $this->output->set_output(
            $this->cldatatable->set_tabel('stok_produksi sp')
                ->set_kolom('sp.stok_produksi_id, sp.nama_pegawai, sp.stok')
                ->join_tabel('stok s', 's.stok_id = sp.stok_id', 'inner')
                ->cari_perkolom_like('sp.nama_pegawai', $this->input->post('nama_pegawai'), 'both')
                ->saring_data('s.cabang_id', $cabang_id)
                ->saring_data('s.barang_id', $barang_id)
                ->tambah_kolom('tombol', $tombol)
                ->get_datatable()
        );
    }

    /* tambah data produksi */
    public function tambah_produksi($barang_id, $cabang_id)
    {
        $this->_set_page_role('c');

        $data['stok'] = $this->m_stock->get_stok_id($barang_id, $cabang_id);

        $data['barang_id'] = $barang_id;
        $data['cabang_id'] = $cabang_id;

        parent::display('tambah_produksi', $data, 'footer_tambah_produksi');
    }

    # simpan produksi
    public function simpan_produksi()
    {
        $this->_set_page_role('c');

        if (!$this->input->is_ajax_request()) {
            show_404();
        }

        // load form validation
        $this->load->library('form_validation');
        $this->form_validation->set_rules('nama_pegawai', 'Input Nama', 'required|max_length[255]|strip_tags');
        // run validation
        if ($this->form_validation->run($this) == false) {
            $data['pesan']  = validation_errors();
            $data['status'] = false;
            return $this->output->set_output(json_encode($data));
        }

        // load uuid
        $this->load->library('uuid');

        $data_simpan['stok_produksi_id'] = $this->uuid->v4(true);
        $data_simpan['stok_id']          = $this->input->post('stok_id', true);
        $data_simpan['nama_pegawai']     = $this->input->post('nama_pegawai', true);
        $data_simpan['stok']             = 0;
        $data_simpan['ctb']              = $this->com_user['user_id'];
        $data_simpan['created_at']       = date('Y-m-d H:i:s');
        $data_simpan['mdb']              = $this->com_user['user_id'];
        $data_simpan['updated_at']       = date('Y-m-d H:i:s');

        if ($this->m_stock->tambah_data('stok_produksi', $data_simpan)) {
            $result['status'] = true;
            $result['pesan']  = 'Data berhasil disimpan.';
        } else {
            $eror             = $this->m_stock->get_db_error();
            $result['status'] = false;
            $result['pesan']  = 'Data gagal disimpan. Eror kode : ' . $eror['code'];
        }
        return $this->output->set_output(json_encode($result));
    }

    public function detail_produksi($stok_produksi_id = null)
    {
        /* tampilkam nama_pegawai di tag h4 stok - stok_produksi_detail */
        $data['detail_produksi']  = $this->m_stock->get_nama_pegawai($stok_produksi_id);
        $data['stok_produksi_id'] = $stok_produksi_id;

        $data['id'] = $this->m_stock->get_id_barang_cabang($stok_produksi_id);

        $this->_set_page_role('r');

        // load datepicker
        $this->load_css('assets/operator/js/plugins/bootstrap-datepicker/css/bootstrap-datepicker3.min.css');
        $this->load_js('assets/operator/js/plugins/bootstrap-datepicker/js/bootstrap-datepicker.min.js');

        parent::display('detail_produksi', $data, 'footer_detail_produksi');
    }

    # list detail produksi
    public function get_list_detail_produksi($stok_produksi_id = null)
    {
        $this->_set_page_role('r');

        if (!$this->input->is_ajax_request()) {
            show_404();
        }

        // tombol
        $tombol = '<div class="text-center">
                        <button type="button" class="btn btn-sm btn-alt-danger hapus-data" data-toggle="tooltip" title="Hapus Data" data-id="{{produksi_detail_id}}"><i class="fa fa-trash"></i> </button>
                    </div>';

        $this->load->library('cldatatable');

        $this->cldatatable->set_tabel('stok_produksi_detail pd')
            ->set_kolom('pd.produksi_detail_id, pd.created_at, pd.deskripsi, sp.stok, pd.stok_awal, pd.jumlah, pd.stok_akhir')
            ->urutkan('pd.created_at', 'DESC')
            ->join_tabel('stok_produksi sp', 'pd.stok_produksi_id = sp.stok_produksi_id', 'left')
            ->saring_data('pd.stok_produksi_id', $stok_produksi_id);

        if (!empty($this->input->post('tanggal'))) {
            $result        = '01-' . $this->input->post('tanggal') . ' 00:00:00';
            $tanggal_awal  = Date('Y-m-01 00:00:00', strtotime($result));
            $tanggal_akhir = Date('Y-m-t 23:59:59', strtotime($result));
            $this->cldatatable
                ->saring_data('pd.created_at >= "' . $tanggal_awal . '" AND pd.created_at <= ', $tanggal_akhir);
        }

        return $this->output->set_output(
            $this->cldatatable
                ->modif_data('created_at', function ($d) {
                    return Date('d-M-Y', strtotime($d['created_at']));
                })
                ->tambah_kolom('tombol', $tombol)
                ->get_datatable()
        );

        // return $this->output->set_output(
        //     $this->cldatatable->set_tabel('stok_produksi_detail pd')
        //         ->set_kolom('pd.produksi_detail_id, pd.created_at, pd.deskripsi, pd.stok_awal, pd.jumlah, pd.stok_akhir')
        //         ->join_tabel('stok_produksi sp', 'pd.stok_produksi_id = sp.stok_produksi_id', 'left')
        //         ->saring_data('pd.stok_produksi_id', $stok_produksi_id)
        //         ->modif_data('created_at', function ($d) {
        //             return Date('d-M-Y', strtotime($d['created_at']));
        //         })
        //         ->tambah_kolom('tombol', $tombol)
        //         ->get_datatable()
        //     );
    }

    public function tambah_detail_produksi($stok_produksi_id = null)
    {
        $this->_set_page_role('c');

        $data['stok_produksi_id'] = $stok_produksi_id;
        $data['stok_awal']        = $this->m_stock->get_stok_awal($stok_produksi_id);

        // load datepicker
        $this->load_css('assets/operator/js/plugins/bootstrap-datepicker/css/bootstrap-datepicker3.min.css');
        $this->load_js('assets/operator/js/plugins/bootstrap-datepicker/js/bootstrap-datepicker.min.js');

        $this->load_js('assets/operator/js/plugins/inputmask/dist/jquery.inputmask.bundle.js');

        parent::display('tambah_detail_produksi', $data, 'footer_tambah_detail_produksi');
    }

    public function simpan_detail_produksi()
    {
        $this->_set_page_role('c');

        if (!$this->input->is_ajax_request()) {
            show_404();
        }

        # load form validation
        $this->load->library('form_validation');
        $this->form_validation->set_rules('jumlah', 'Jumlah Stock', 'required|strip_tags');
        // $this->form_validation->set_rules('jumlah', 'Jumlah Stock', 'required|strip_tags|xss_clean|integer|max_length[5]');

        // run validation
        if ($this->form_validation->run($this) == false) {
            $data['pesan']  = validation_errors();
            $data['status'] = false;
            return $this->output->set_output(json_encode($data));
        }

        # load uuid
        $this->load->library('uuid');

        $data_simpan['produksi_detail_id'] = $this->uuid->v4(true);
        $data_simpan['stok_produksi_id']   = $this->input->post('stok_produksi_id');
        $data_simpan['deskripsi']          = 'Produksi Baru';
        $data_simpan['tanggal']            = date_format(date_create_from_format('d-m-Y', $this->input->post('tanggal')), 'Y-m-d');
        $data_simpan['jumlah']             = $this->input->post('jumlah', true);
        $data_simpan['stok_awal']          = $this->input->post('stok_awal');
        $stok_akhir                        = $data_simpan['stok_awal'] + $data_simpan['jumlah'];
        $data_simpan['stok_akhir']         = $stok_akhir;
        $data_simpan['ctb']                = $this->com_user['user_id'];
        $data_simpan['created_at']         = date('Y-m-d H:i:s');

        # set transaction
        if ($this->m_stock->simpan($data_simpan)) {
            $result['status'] = true;
            $result['pesan']  = 'Data berhasil disimpan.';
        } else {
            $eror             = $this->m_stock->get_db_error();
            $result['status'] = false;
            $result['pesan']  = 'Data gagal disimpan. Eror kode : ' . $eror['code'];
        }
        return $this->output->set_output(json_encode($result));
    }

    public function hapus_detail_produksi()
    {
        $this->_set_page_role('d');

        if (!$this->input->is_ajax_request()) {
            show_404();
        }

        if ($this->input->post() == '') {
            $respon['status'] = false;
            $respon['pesan']  = 'Data ID tidak tersedia';
        }

        $hapus['produksi_detail_id'] = $this->input->post('data_id');

        // ambil data stok_ahir, jumlah, stok_awal
        $data['produksi_detail'] = $this->m_stock->get_detail_produksi($this->input->post('data_id'));

        // echo "<pre/>";
        // print_r($data);
        // exit();
        /*
         * update & hapus data - transaction
         * stok_awal = stok_akhir - jumlah
         * update data stok di tabel stok_produksi
         * dengan id stok_produksi_id
         * hapus data
         */
        $data_simpan['produksi_detail_id'] = $data['produksi_detail']['produksi_detail_id'];
        $data_simpan['stok_produksi_id']   = $data['produksi_detail']['stok_produksi_id'];
        $data_simpan['stok_akhir']         = $data['produksi_detail']['stok_akhir'];
        $data_simpan['stok_awal']          = $data['produksi_detail']['stok_awal'];
        $data_simpan['stok']               = $data['produksi_detail']['stok'];
        $data_simpan['jumlah']             = $data['produksi_detail']['jumlah'];
        $hasil                             = $data['produksi_detail']['stok'] - $data_simpan['jumlah'];
        $data_simpan['hasil']              = $hasil;

        // echo "<pre/>";
        // print_r($data_simpan);
        // exit();

        // if ($this->m_stock->hapus_data('stok_produksi_detail', $hapus)) {
        if ($this->m_stock->hapus($data_simpan)) {
            $data['status'] = true;
            $data['pesan']  = 'Data berhasil dihapus.';
        } else {
            $error          = $this->m_stock->get_db_error();
            $data['status'] = false;
            $data['pesan']  = 'Data gagal dihapus. Error kode : ' . $error['code'];
        }
        return $this->output->set_output(json_encode($data));
    }

    // penyesuaian stok digunakan untuk menyesuaikan stok di aplikasi dengan kenyataan / realiasasi
    public function penyesuaian($stok_produksi_id = null)
    {
        $this->_set_page_role('u');

        if (empty($stok_produksi_id)) {
            redirect('stock');
        }

        $data['stok_produksi_id'] = $stok_produksi_id;
        $data['stok_awal']        = $this->m_stock->get_stok_awal($stok_produksi_id);
        $data['tanggal_sekarang'] = date('d-m-Y');

        // load datepicker
        $this->load_css('assets/operator/js/plugins/bootstrap-datepicker/css/bootstrap-datepicker3.min.css');
        $this->load_js('assets/operator/js/plugins/bootstrap-datepicker/js/bootstrap-datepicker.min.js');

        $this->load_js('assets/operator/js/plugins/inputmask/dist/jquery.inputmask.bundle.js');

        parent::display('penyesuaian', $data, 'footer_penyesuaian');

    }

    // proses simpan penyesuaian stok
    public function simpan_penyesuaian()
    {
        $this->_set_page_role('c');

        if (!$this->input->is_ajax_request()) {
            show_404();
        }

        # load form validation
        $this->load->library('form_validation');
        $this->form_validation->set_rules('jumlah_realisasi', 'Jumlah Stock', 'required|strip_tags');
        // $this->form_validation->set_rules('jumlah', 'Jumlah Stock', 'required|strip_tags|xss_clean|integer|max_length[5]');

        // run validation
        if ($this->form_validation->run($this) == false) {
            $data['pesan']  = validation_errors();
            $data['status'] = false;
            return $this->output->set_output(json_encode($data));
        }

        # load uuid
        $this->load->library('uuid');

        $data_simpan['produksi_detail_id'] = $this->uuid->v4(true);
        $data_simpan['stok_produksi_id']   = $this->input->post('stok_produksi_id');
        $data_simpan['deskripsi']          = 'Penyesuaian stok barang';
        $data_simpan['jumlah']             = (int)$this->input->post('jumlah_realisasi') - (int)$this->input->post('stok_awal');
        $data_simpan['stok_awal']          = (int)$this->input->post('stok_awal');
        $data_simpan['stok_akhir']         = (int)$this->input->post('jumlah_realisasi');
        $data_simpan['ctb']                = $this->com_user['user_id'];
        $data_simpan['created_at']         = date('Y-m-d H:i:s');

        # set transaction
        if ($this->m_stock->simpan($data_simpan)) {
            $result['status'] = true;
            $result['pesan']  = 'Data berhasil disimpan.';
        } else {
            $eror             = $this->m_stock->get_db_error();
            $result['status'] = false;
            $result['pesan']  = 'Data gagal disimpan. Eror kode : ' . $eror['code'];
        }
        return $this->output->set_output(json_encode($result));
    }
}
