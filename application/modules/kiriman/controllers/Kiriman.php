<?php

class Kiriman extends Portal_admin
{

    public function __construct()
    {
        parent::__construct();
        #  load model pengiriman
        $this->load->model('m_kiriman');

    }

    public $form_conf = array(
        array(' field' => 'tanggal', 'label' => 'Tanggal', 'rules' => 'required|max_length[255]|strip_tags|trim'),
        array('field' => 'nama_sopir', 'label' => 'Nama Supir', 'rules' => 'required|max_length[255]|strip_tags|trim'),
        array('field' => 'order_id', 'label' => 'Pesanan A.N', 'rules' => 'required|max_length[255]|strip_tags|trim'),
        array('field' => 'stok_produksi_id', 'label' => 'Stok', 'rules' => 'required|max_length[255]|strip_tags|trim'),
        array('field' => 'jumlah', 'label' => 'Jumlah', 'rules' => 'required|max_length[255]|strip_tags|trim'),

    );

    public function index()
    {

        $this->_set_page_role('r');

        # Mengambil data cabang
        $data['nama_cabang'] = $this->com_user['nama_cabang'];
        $data['rs_cabang']   = $this->m_kiriman->get_pencarian_cabang($this->com_user['nama_cabang']);
        // print_r($data);
        // exit();
        parent::display('index', $data, 'footer_index');
    }

    public function get_list_kirim()
    {

        # query memnampilkan data
        // SELECT p.pengiriman_id, od.barang_id, b.`nama_barang`, o.`nama_pembeli`, p.`jumlah`, p.`nama_sopir`, p.`tanggal`
        // FROM pengiriman p
        // LEFT JOIN order_detail od
        // ON p.`order_detail_id` = od.`detail_id`
        // LEFT JOIN barang b
        // ON b.`barang_id` = od.`barang_id`
        // LEFT JOIN `order` o
        // ON o.`order_id` = od.`order_id`

        $this->_set_page_role('r');

        if (!$this->input->is_ajax_request()) {
            show_404();
        }

        # load libary CI datatable
        $this->load->library('cldatatable');

        # mengambil dan menampilkan data untuk riwayat pengiriman
        $this->cldatatable->set_kolom('p.tanggal, p.jumlah, p.nama_sopir , o.nama_pembeli, b.nama_barang')
            ->set_tabel('pengiriman p')
            ->join_tabel('order_detail od', 'p.order_detail_id = od.detail_id', 'left')
            ->join_tabel('barang b', 'b.barang_id = od.barang_id', 'left')
            ->join_tabel('order o', 'o.order_id = od.order_id', 'left')

        # mencari berdasarkan nama sopir
            ->cari_perkolom_like('nama_sopir', $this->input->post('nama_sopir'), 'both')
            ->saring_data('p.cabang_id', $this->input->post('cabang_id'))
            ->get_datatable();

        return $this->output->set_output(
            $this->cldatatable
                ->modif_data('tanggal', function ($d) {
                    return Date('d-M-Y', strtotime($d['tanggal']));
                })
                ->get_datatable()
        );
    }
    public function tambah()
    {

        $this->_set_page_role('c');

        # load file js & css
        $this->load_js('assets/operator/js/plugins/inputmask/dist/jquery.inputmask.bundle.js');
        $this->load_css('assets/operator/js/plugins/bootstrap-datepicker/css/bootstrap-datepicker3.min.css');
        $this->load_js('assets/operator/js/plugins/bootstrap-datepicker/js/bootstrap-datepicker.min.js');
        $this->load_js('assets/operator/js/plugins/select2/js/select2.min.js');

        # mengambil data pembeli dan simpan di variabel
        $data['nama_cabang'] = $this->com_user['nama_cabang'];
        $data['rs_pembeli']  = $this->m_kiriman->get_list_pembeli($this->com_user['nama_cabang']);

        // print_r($data['rs_pembeli']);
        // exit();
        parent::display('tambah', $data, 'footer_tambah');
    }

    public function get_barangjs()
    {

        #get order_id
        $id = $this->input->post('id');

        #send parameter id to model
        $this->m_kiriman->get_list_barang($id);
        $this->m_kiriman->get_cabang($id);

        #get value barang from model kiriman
        $data['rs_barang'] = $this->m_kiriman->get_list_barang($id);

        if (!empty($data['rs_barang'])) {
            $result['status'] = true;
            $result['data']   = $data['rs_barang'];
        } else {
            $result['pesan'] = 'Data barang tidak ada';
        }

        return $this->output->set_output(json_encode($result));

    }

    public function get_stokjs()
    {

        #get id stok
        $id_stok = $this->input->post('id_stok');

        #send parameter $id_stok to model
        $this->m_kiriman->get_stok($id_stok);

        #get value stok from model kiriman
        $data['rs_stok'] = $this->m_kiriman->get_stok($id_stok);

        if (!empty($data['rs_stok'])) {
            $result['status'] = true;
            $result['data']   = $data['rs_stok'];
        } else {
            $result['pesan'] = 'Data barang tidak ada';
        }

        return $this->output->set_output(json_encode($result));

    }

    public function proses_simpan()
    {
        $this->_set_page_role('c');

        if (!$this->input->is_ajax_request()) {
            return;
        }
        #get order id and send to model
        $order_id = $this->input->post('order_id', true);
        $this->m_kiriman->get_jumlah($order_id);

        #get jumlah yang diorder dari tabel order
        $jumlah_order                     = $this->m_kiriman->get_jumlah($order_id);
        $jumlah_dikirim['jumlah_dikirim'] = $this->input->post('jumlah');

        $result_item_stok = $this->m_kiriman->get_stok_available($this->input->post('stok_produksi_id'));
        foreach ($result_item_stok as $key => $vstok) {
            $stok['stok'] = $vstok['stok'];
        }

        $this->load->library('form_validation');
        $this->form_validation->set_rules($this->form_conf);

        # validasi jika jumlah yang dikirim melebihi jumlah order
        if ($jumlah_dikirim['jumlah_dikirim'] > $jumlah_order['jumlah']) {
            $this->form_validation->set_error_message('jumlah', 'Jumlah pengiriman melebihi order');

            # validasi jika jumlah yang dikirim melebihi stok
        } elseif ($jumlah_dikirim['jumlah_dikirim'] > $stok['stok']) {
            $this->form_validation->set_error_message('stok', 'Jumlah pengiriman melebihi stok');

        }

        $jumlah_terkirim_sa         = $this->m_kiriman->get_jumlahterkirim($this->input->post('detail_id'));
        $data_jumlah['data_jumlah'] = $this->input->post('jumlah', true);
        $validasi_kirim             = $jumlah_terkirim_sa['jumlah_terkirim'] + $data_jumlah['data_jumlah'];

        $total['total'] = $validasi_kirim;

        if ($total['total'] > $jumlah_terkirim_sa['jumlah']) {
            $this->form_validation->set_error_message('jumlah', 'Jumlah pengiriman melebihi order');
        }

        $this->form_validation->set_error_delimiters('', '<br>');

        if ($this->form_validation->run($this) == false) {
            $data['pesan']  = validation_errors();
            $data['status'] = false;
            return $this->output->set_output(json_encode($data));
        }

        $result_cabang     = $this->m_kiriman->get_cabang($this->input->post('order_id'));
        $result_keterangan = $this->m_kiriman->get_keterangan($this->input->post('stok_produksi_id'));

        $keterangan = 'Dikirim oleh ' . $this->input->post('nama_sopir') . ' dari ' . $result_keterangan['nama_pegawai'] . ' ' . $result_cabang['nama_cabang'] . ' jumlah ' . $this->input->post('jumlah');
        // print_r($keterangan);
        // exit();

        $this->m_kiriman->get_list_item_pengiriman($this->input->post('order_id'));

        # insert to tabel pengiriman
        $this->load->library('uuid');
        $data_simpan['pengiriman_id']    = $this->uuid->v4(true);
        $data_simpan['cabang_id']        = $result_cabang['cabang_id'];
        $data_simpan['tanggal']          = date_format(date_create_from_format('d-m-Y', $this->input->post('tanggal')), 'Y-m-d');
        $data_simpan['nama_sopir']       = $this->input->post('nama_sopir', true);
        $data_simpan['order_detail_id']  = $this->input->post('detail_id', true);
        $data_simpan['stok_produksi_id'] = $this->input->post('stok_produksi_id', true);
        $data_simpan['jumlah']           = $this->input->post('jumlah', true);
        $data_simpan['ctb']              = $this->com_user['user_id'];
        $data_simpan['created_at']       = date('Y-m-d H:i:s');
        $data_simpan['mdb']              = $this->com_user['user_id'];
        $data_simpan['updated_at']       = date('Y-m-d H:i:s');

        #insert to tabel order_delivery_detail
        $this->load->library('uuid');
        $insert_odd['delivery_id']      = $this->uuid->v4(true);
        $insert_odd['detail_id']        = $this->input->post('detail_id');
        $insert_odd['tanggal']          = $data_simpan['tanggal'];
        $insert_odd['keterangan']       = $keterangan;
        $insert_odd['jenis_pengiriman'] = 'diantar';
        $insert_odd['jumlah']           = $data_simpan['jumlah'];
        $insert_odd['ctb']              = $this->com_user['user_id'];
        $insert_odd['created_at']       = date('Y-m-d H:i:s');

        $result_item_stok = $this->m_kiriman->get_stok_available($this->input->post('stok_produksi_id'));
        foreach ($result_item_stok as $key => $vstok) {
            $id = $this->input->post('stok_produksi_id', true);

            #update to tabel stok_produksi
            $update_sp['stok']       = $vstok['stok'] - $data_simpan['jumlah'];
            $update_sp['ctb']        = $this->com_user['user_id'];
            $update_sp['created_at'] = date('Y-m-d H:i:s');
            $update_sp['mdb']        = $this->com_user['user_id'];
            $update_sp['updated_at'] = date('Y-m-d H:i:s');

            #insert to tabel stok_produksi_detail
            $insert_spd['produksi_detail_id'] = $this->uuid->v4(true);
            $insert_spd['stok_produksi_id']   = $this->input->post('stok_produksi_id', true);
            $insert_spd['deskripsi']          = 'Pengiriman Barang';
            $insert_spd['stok_awal']          = $vstok['stok'];
            $insert_spd['jumlah']             = '-' . $data_simpan['jumlah'];
            $insert_spd['stok_akhir']         = $update_sp['stok'];
            $insert_spd['ctb']                = $this->com_user['user_id'];
            $insert_spd['created_at']         = date('Y-m-d H:i:s');
        }

        # mengambil order_id dan detail_id
        $order_id  = $this->input->post('order_id', true);
        $detail_id = $this->input->post('detail_id', true);

        # mengirim variabel ke dalam model
        $this->m_kiriman->get_jumlahterkirim($detail_id);
        $this->m_kiriman->get_total($order_id);

        # mengambil data dan menampung dalam variabel
        $jumlah_terkirim_sb = $this->m_kiriman->get_jumlahterkirim($detail_id);
        $total              = $this->m_kiriman->get_total($order_id);
        $hasil              = $total['jumlah_terkirim'] + $data_simpan['jumlah'];

        # menjumlahkan jumlah yang terkirim terakhir di database dengan inputan baru
        $terkirim = $jumlah_terkirim_sb['jumlah_terkirim'] + $data_simpan['jumlah'];

        # update to tabel order_detail
        $update_od['jumlah_terkirim'] = $terkirim;

        # validasi apabila jumlah terkirim = jumlah order maka update selsai
        if ($update_od['jumlah_terkirim'] == $jumlah_terkirim_sb['jumlah']) {
            $update_od['status_pengiriman'] = 'selesai';
        }

        if ($total['jumlah'] == $hasil) {

            $update_order['status_pengiriman'] = 'selesai';
        } else {

            $update_order['status_pengiriman'] = 'proses';

        }

        if ($this->m_kiriman->proses_simpan_pengiriman($data_simpan, $insert_odd, $update_sp, $insert_spd, $update_od, $id, $detail_id, $update_order, $order_id)) {
            $result['status'] = true;
            $result['pesan']  = 'Data berhasil disimpan.';
        } else {
            $eror             = $this->m_kiriman->get_db_error();
            $result['status'] = false;
            $result['pesan']  = 'Data gagal disimpan. Eror kode : ' . $eror['code'];
        }
        return $this->output->set_output(json_encode($result));
    }

}
