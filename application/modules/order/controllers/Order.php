<?php
class Order extends Portal_admin
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('m_order');
    }

    public $form_conf = array(
        array('field' => 'tanggal', 'label' => 'Tanggal Pembayaran', 'rules' => 'required|max_length[255]|strip_tags|trim'),
        array('field' => 'nominal', 'label' => 'Nominal', 'rules' => 'required|max_length[255]|strip_tags|trim'),
        array('field' => 'status', 'label' => 'Status Pembayaran', 'rules' => 'required|max_length[255]|strip_tags|trim'),

    );

    public $form_con = array(
        array('field' => 'jumlah', 'label' => 'Jumlah', 'rules' => 'max_length[255]|strip_tags|trim'),

    );

    public function index()
    {

        // load datepicker
        $this->load_css('assets/operator/js/plugins/bootstrap-datepicker/css/bootstrap-datepicker3.min.css');
        $this->load_js('assets/operator/js/plugins/bootstrap-datepicker/js/bootstrap-datepicker.min.js');

        $data['rs_cabang'] = $this->m_order->get_list_cabang();
        $data['cabang_id'] = $this->com_user['cabang_id'];

        parent::display('index', $data, 'footer_index');
    }

    public function pembayaran($order_id = null)
    {
        $this->_set_page_role('c');

        if (empty($order_id)) {
            redirect('order');
        }

        $this->load_js('assets/operator/js/plugins/select2/js/select2.full.min.js');
        $data['order_id'] = $order_id;
        // $this->m_order->get_detail($order_id);
        $data['result_detail'] = $this->m_order->get_detail($order_id);
        $data['result_total']  = $this->m_order->get_total_tagihan($order_id);

        // echo "<pre>";
        // print_r($data['result_detail']);
        // print_r($data['result_total']);
        // exit();
        parent::display('pembayaran', $data, 'footer_index');
    }
    public function tambah_pembayaran($order_id = null)
    {

        $this->_set_page_role('c');

        if (empty($order_id)) {
            redirect('order');
        }
        $this->load_js('assets/operator/js/plugins/inputmask/dist/jquery.inputmask.bundle.js');
        $this->load_css('assets/operator/js/plugins/bootstrap-datepicker/css/bootstrap-datepicker3.min.css');
        $this->load_js('assets/operator/js/plugins/bootstrap-datepicker/js/bootstrap-datepicker.min.js');
        $data['order_id'] = $order_id;
        parent::display('tambah_pembayaran', $data, 'footer_pembayaran');
    }
    public function proses_bayar()
    {

        $this->_set_page_role('c');

        if (!$this->input->is_ajax_request()) {
            return;
        }

        $this->load->library('form_validation');
        $this->form_validation->set_rules($this->form_conf);
        $result_order = $this->m_order->get_order_data_by_id($this->input->post('order_id'));

        $result_pembayaran = $this->m_order->get_total_pembayaran($this->input->post('order_id'));

        // print_r($result_pembayaran);
        // exit();

        $data_u['total'] = ($result_order['total_biaya'] + $result_order['diskon'] - $result_order['transport']);

        $data['kurang'] = ($result_pembayaran + $this->input->post('nominal', true) + $result_order['diskon'] - $result_order['transport']);

        if ($data['kurang'] > $data_u['total']) {
            $this->form_validation->set_error_message('nominal', 'melebihi jumlah pembayaran');
        }

        #run validation
        if ($this->form_validation->run($this) == false) {
            $data['pesan']  = validation_errors();
            $data['status'] = false;
            return $this->output->set_output(json_encode($data));
        }

        #insert to tabel order_riwayat_bayar
        $this->load->library('uuid');
        $data_simpan['bayar_id']           = $this->uuid->v4(true);
        $data_simpan['order_id']           = $this->input->post('order_id', true);
        $data_simpan['tanggal_pembayaran'] = date_format(date_create_from_format('d-m-Y', $this->input->post('tanggal')), 'Y-m-d');
        $data_simpan['status_pembayaran']  = $this->input->post('status', true);
        $data_simpan['keterangan']         = $this->input->post('status', true);
        $data_simpan['nominal']            = $this->input->post('nominal', true);
        $data_simpan['created_at']         = date('Y-m-d H:i:s');
        $data_simpan['mdb']                = $this->com_user['user_id'];
        $data_simpan['updated_at']         = date('Y-m-d H:i:s');

        #update to tabel order
        $order_id                         = $this->input->post('order_id', true);
        $data_update['tanggal_order']     = date_format(date_create_from_format('d-m-Y', $this->input->post('tanggal')), 'Y-m-d');
        $data_update['status_pembayaran'] = ($result_order['total_biaya'] + $result_order['diskon'] - $result_order['transport']) == ($result_pembayaran - $result_order['transport'] + $result_order['diskon'] + $this->input->post('nominal', true)) ? 'lunas' : $this->input->post('status', true);

        $data_update['updated_at'] = date('Y-m-d H:i:s');

        if ($this->m_order->proses_simpan_pengiriman($data_simpan, $data_update, $order_id)) {
            $result['status'] = true;
            $result['pesan']  = 'Data berhasil disimpan.';
        } else {
            $eror             = $this->m_kiriman->get_db_error();
            $result['status'] = false;
            $result['pesan']  = 'Data gagal disimpan. Eror kode : ' . $eror['code'];
        }
        return $this->output->set_output(json_encode($result));
    }

    public function tambah($cabang_id = null)
    {
        // permission
        $this->_set_page_role('c');

        if (empty($cabang_id)) {
            redirect('order');
        }

        // get cabang
        $data['result_cabang'] = $this->m_order->get_detail_cabang($cabang_id);
        // list barang
        $data['rs_barang'] = $this->m_order->get_list_barang();

        if (empty($data['result_cabang'])) {
            redirect('order');
        }

        // load datepicker
        $this->load_css('assets/operator/js/plugins/bootstrap-datepicker/css/bootstrap-datepicker3.min.css');
        $this->load_js('assets/operator/js/plugins/bootstrap-datepicker/js/bootstrap-datepicker.min.js');
        // select2
        // $this->load_css('assets/operator/js/plugins/select2/css/select2.min.css');
        $this->load_js('assets/operator/js/plugins/select2/js/select2.full.min.js');

        $this->load_js('assets/operator/js/plugins/inputmask/dist/jquery.inputmask.bundle.js');

        $this->load_js('assets/operator/js/plugins/accounting.min.js');

        parent::display('tambah', $data, 'footer_tambah');
    }

    public function get_list_order()
    {
        $this->_set_page_role('r');

        if (!$this->input->is_ajax_request()) {
            return;
        }

        return $this->output->set_output($this->m_order->get_list_order($this->com_user));
    }

    public function pengiriman($order_id)
    {

        $this->_set_page_role('c');

        # mengambil data riwayat pengiriman
        $data['order_kirim'] = $this->m_order->get_list_order_pengiriman($order_id);
        parent::display('pengiriman', $data, 'footer_tambah');
    }

    public function proses_tambah()
    {
        $this->_set_page_role('c');

        if (!$this->input->is_ajax_request()) {
            return;
        }

        // get data
        $dt_penjualan        = (array) json_decode($this->input->post('penjualan'));
        $dt_detail_penjualan = (array) json_decode($this->input->post('detail_penjualan'));

        // create no order
        // 01-19120001
        $cabang_kode = $this->m_order->get_kode_cabang($dt_penjualan['cabang_id']);

        // tanggal order
        $tanggal_kode = date_format(date_create_from_format('d-m-Y', $dt_penjualan['tanggal']), 'ym');

        // get last number
        $urutan = $this->m_order->get_last_number($dt_penjualan['cabang_id']);

        $no_order = $cabang_kode . $tanggal_kode . $urutan;

        $this->load->library('uuid');
        // data penjualan

        $order['order_id']          = $this->uuid->v4(true);
        $order['cabang_id']         = $dt_penjualan['cabang_id'];
        $order['no_order']          = $no_order;
        $order['nama_pembeli']      = $dt_penjualan['nama_pembeli'];
        $order['tanggal_order']     = date_format(date_create_from_format('d-m-Y', $dt_penjualan['tanggal']), 'Y-m-d');
        $order['alamat']            = $dt_penjualan['alamat'];
        $order['status_pengiriman'] = 'belum dikirim';
        $order['status_pembayaran'] = $dt_penjualan['status_pembayaran'];
        $order['total_biaya']       = $dt_penjualan['total_bayar'];
        $order['diskon']            = $dt_penjualan['diskon'];
        $order['transport']         = $dt_penjualan['transport'];
        $uang_muka                  = $dt_penjualan['status_pembayaran'] == 'lunas' ? $dt_penjualan['total_bayar'] : $dt_penjualan['uang_muka'];
        $order['ctb']               = $this->com_user['user_id'];
        $order['created_at']        = date('Y-m-d H:i:s');
        $order['mdb']               = $this->com_user['user_id'];
        $order['updated_at']        = date('Y-m-d H:i:s');

        // echo "<pre>";
        // print_r($uang_muka);
        // exit();

        // riwayat pembayaran
        // jika status pembayaran selain "belum dibayar"
        $pembayaran = null;
        if ($order['status_pembayaran'] != 'belum bayar') {
            $pembayaran['bayar_id']           = $this->uuid->v4(true);
            $pembayaran['order_id']           = $order['order_id'];
            $pembayaran['tanggal_pembayaran'] = $order['tanggal_order'];
            $pembayaran['status_pembayaran']  = $order['status_pembayaran'];
            $pembayaran['nominal']            = $uang_muka;
            $pembayaran['keterangan']         = $order['status_pembayaran'];
            $pembayaran['ctb']                = $this->com_user['user_id'];
            $pembayaran['created_at']         = date('Y-m-d H:i:s');
            $pembayaran['mdb']                = $this->com_user['user_id'];
            $pembayaran['updated_at']         = date('Y-m-d H:i:s');
        }
        // barang
        $status_barang_diambil = false;
        // detail barang
        foreach ($dt_detail_penjualan as $k => $vbarang) {
            $detail[$k]['detail_id']         = $this->uuid->v4(true);
            $detail[$k]['order_id']          = $order['order_id'];
            $detail[$k]['barang_id']         = $vbarang->id;
            $detail[$k]['jumlah']            = $vbarang->jumlah;
            $detail[$k]['harga']             = $vbarang->harga;
            $detail[$k]['jenis_pengiriman']  = $vbarang->pengambilan;
            $detail[$k]['status_pengiriman'] = 'belum dikirim';
            $detail[$k]['ctb']               = $this->com_user['user_id'];
            $detail[$k]['created_at']        = date('Y-m-d H:i:s');
            $detail[$k]['mdb']               = $this->com_user['user_id'];
            $detail[$k]['updated_at']        = date('Y-m-d H:i:s');

            if ($detail[$k]['jenis_pengiriman'] == 'diambil') {
                $status_barang_diambil = true;
            }
        }

        // echo "<pre>";
        // print_r($pembayaran);
        // exit();

        // proses simpan
        if ($this->m_order->simpan_order($order, $pembayaran, $detail)) {
            $result['status']   = true;
            $result['order_id'] = $order['order_id'];
            $result['pesan']    = 'Data berhasil disimpan.';
            if ($status_barang_diambil) {
                $result['url'] = base_url('order/pengambilan/' . $order['order_id']);
            } else {
                $result['url'] = base_url('order');
            }
        } else {
            $eror             = $this->m_order->get_db_error();
            $result['status'] = false;
            $result['pesan']  = 'Data gagal disimpan. Eror kode : ' . $eror['code'];
        }
        return $this->output->set_output(json_encode($result));
    }

    public function pengambilan($order_id = null)
    {
        $this->_set_page_role('c');

        if (empty($order_id)) {
            redirect('order');
        }

        $this->load_js('assets/operator/js/plugins/select2/js/select2.full.min.js');

        // get detail order
        $data['result_order'] = $this->m_order->get_detail_order($order_id);

        // get list barang yang diambil sendiri
        $data['rs_barang'] = $this->m_order->get_list_item_pengambilan($order_id);
        // echo "<pre>";
        // print_r($data['rs_barang']);
        // exit();

        // get stok data
        $rs_stok = $this->m_order->get_list_stok($order_id);

        foreach ($rs_stok as $vstok) {
            $data['rs_stok'][$vstok['barang_id']][] = $vstok;
        }

        // get stok by rs barang
        // foreach ($data['rs_barang'] as $vbarang) {
        //     $this->m_order->get_data_stok_by_id($vbarang)
        // }

        // echo "<pre>";
        // print_r($data['result_order']);
        // exit();

        parent::display('pengambilan', $data, 'footer_pengambilan');
    }

    public function proses_pengambilan()
    {
        $this->_set_page_role('c');

        if (!$this->input->is_ajax_request()) {
            return;
        }

        // cek data
        $this->load->library('form_validation');
        $this->form_validation->set_rules($this->form_con);

        $result_item = $this->m_order->get_list_item_pengambilan($this->input->post('order_id'));
        // echo "<pre>";
        // print_r($result_item);
        // exit();
        if (empty($result_item)) {
            $data['pesan']  = 'Tidak ada data.';
            $data['status'] = false;
            return $this->output->set_output(json_encode($data));
        }

        $order_id      = $this->input->post('order_id');
        $dataku['jum'] = $this->m_order->get_list_item_jumlahtotal($order_id);
        // echo "<pre>";
        // print_r($dataku['jum']);
        // exit();
        foreach ($dataku['jum'] as $key => $vjumlah) {
            $dtjumlah[$vjumlah['barang_id']]['jumlah'] = $vjumlah['jumlah'];
        }
        // echo "<pre>";
        // print_r($this->input->post('jumlah'));
        // print_r($dtjumlah);
        // exit();

        foreach ($result_item as $kro => $vorder) {
            // print_r($this->input->post('nama_stok')[$vorder['barang_id']]) ;

            if ($this->input->post('nama_stok')[$vorder['barang_id']] != '' || empty($this->input->post('nama_stok')[$vorder['barang_id']])) {

                $jumlah = 0;

                foreach ($this->input->post('nama_stok')[$vorder['barang_id']] as $i => $vnamastok) {
                    $stok_tukang = $this->m_order->get_stok_available($vnamastok);
                    if (!isset($stok_tukang['stok'])) {
                        continue;
                    }
                    $jumlah_barang = $this->input->post('jumlah')[$vorder['barang_id']][$i];

                    if ($jumlah_barang > $stok_tukang['stok']) {
                        $this->form_validation->set_error_message('jumlah', 'melebihi jumlah stok');
                        $data['pesan']  = validation_errors();
                        $data['status'] = false;
                        return $this->output->set_output(json_encode($data));
                        break;
                    }

                    $jumlah                              = $jumlah + $jumlah_barang;
                    $jum[$vorder['barang_id']]['jumlah'] = $jumlah;
                    $jum['detail_id']                    = $vorder['detail_id'];
                }
            }
        }
        // echo "<pre>";
        // print_r($jumlah);
        // // print_r($stok_tukang['stok']);
        // exit();

        foreach ($dtjumlah as $key => $vjumlah) {
            if (!isset($jum[$key]['jumlah'])) {
                continue;
            }

            if (($jum[$key]['jumlah'] > $vjumlah['jumlah']) && ($jumlah > $vjumlah['jumlah'])) {
                $this->form_validation->set_error_message('jumlah', 'melebihi jumlah order');
                $data['pesan']  = validation_errors();
                $data['status'] = false;
                return $this->output->set_output(json_encode($data));
                break;
            }
        }

        // echo "<pre>";
        // print_r($dtjumlah);
        // // print_r($stok_tukang['stok']);
        // exit();

        // $datamu['terkirim'] = $this->m_order->get_stok_available($stok_produksi_id);

        // $detail_id = $jum['detail_id'];
        // $dataterkirim['terkirim'] = $this->m_order->get_terkirim($detail_id);

        // $total = $dataterkirim['terkirim']['jumlah'] + $jum['jumlah'];

        // if ($total > $dataku['jum']['jumlah']){
        //     $this->form_validation->set_error_message('jumlah', 'melebihi jumlah order');

        // } elseif ($jum['jumlah'] > $datamu['terkirim']['stok']) {

        //     $this->form_validation->set_error_message('jumlah', 'melebihi jumlah stok');
        // }

        // $this->form_validation->set_error_delimiters('', '<br>');

        // if ($this->form_validation->run($this) == false) {
        //     $data['pesan']  = validation_errors();
        //     $data['status'] = false;
        //     return $this->output->set_output(json_encode($data));
        // }

        // load library
        $this->load->library('uuid');

        $stok_update_data = [];
        $stok_produksi_id = [];
        foreach ($result_item as $kro => $vorder) {

            // get data input
            $total_terkirim = 0;
            if ($this->input->post('nama_stok')[$vorder['barang_id']] != '') {
                // exit();
                foreach ($this->input->post('nama_stok')[$vorder['barang_id']] as $i => $vnamastok) {
                    // set produksi ID
                    $stok_produksi_id[] = $vnamastok;
                    $stok[$vnamastok]   = $this->input->post('jumlah')[$vorder['barang_id']][$i];
                    $total_terkirim += $this->input->post('jumlah')[$vorder['barang_id']][$i];

                    // insert data for detail delivery
                    $od['delivery_id']      = $this->uuid->v4(true);
                    $od['detail_id']        = $vorder['detail_id'];
                    $od['tanggal']          = date('Y-m-d H:i:s');
                    $od['jenis_pengiriman'] = 'diambil';
                    $od['jumlah']           = $this->input->post('jumlah')[$vorder['barang_id']][$i];
                    $od['keterangan']       = $vnamastok;
                    $od['created_at']       = date('Y-m-d H:i:s');
                    $od['ctb']              = $this->com_user['user_id'];
                    $stok_delivery[]        = $od;
                }
            }

            // set data for update
            $stok_update_data[$kro]['detail_id']       = $vorder['detail_id'];
            $stok_update_data[$kro]['jumlah_terkirim'] = $vorder['jumlah_terkirim'] + $total_terkirim;

            // status pengiriman
            // $stok_update_data[$kro]['status_pengiriman'] = 'selesai';
            if ($stok_update_data[$kro]['jumlah_terkirim'] >= $vorder['jumlah']) {
                $stok_update_data[$kro]['status_pengiriman'] = 'selesai';
            } elseif ($stok_update_data[$kro]['jumlah_terkirim'] < $vorder['jumlah']) {
                $stok_update_data[$kro]['status_pengiriman'] = 'proses';
            } else {
                $stok_update_data[$kro]['status_pengiriman'] = 'belum dikirim';
            }
        }

        // get last stok
        $rs_stok_available = $this->m_order->get_stok_available_by_id($stok_produksi_id);

        // get nama pegawai stok by index
        $nama_stok = [];
        foreach ($rs_stok_available as $vstok_nama) {
            $nama_stok[$vstok_nama['stok_produksi_id']] = $vstok_nama['nama_pegawai'] . ' ' . $vstok_nama['nama_cabang'];
        }

        // buat keterangan
        foreach ($stok_delivery as $key => $vstok_delivery) {
            if (isset($nama_stok[$vstok_delivery['keterangan']])) {
                $stok_delivery[$key]['keterangan'] = 'Diambil dari ' . $nama_stok[$vstok_delivery['keterangan']] . ' jumlah ' . $vstok_delivery['jumlah'];
            }
        }

        // set data for update stok produksi
        foreach ($rs_stok_available as $is => $vstokavail) {
            // update stok
            $stok_produksi_update[$is]['stok_produksi_id'] = $vstokavail['stok_produksi_id'];
            $stok_produksi_update[$is]['stok']             = $vstokavail['stok'] - $stok[$vstokavail['stok_produksi_id']];
            $stok_produksi_update[$is]['mdb']              = $this->com_user['user_id'];
            $stok_produksi_update[$is]['updated_at']       = date('Y-m-d H:i:s');

            // add to history
            $stok_history[$is]['produksi_detail_id'] = $this->uuid->v4(true);
            $stok_history[$is]['stok_produksi_id']   = $vstokavail['stok_produksi_id'];
            $stok_history[$is]['stok_awal']          = $vstokavail['stok'];
            $stok_history[$is]['jumlah']             = '-' . $stok[$vstokavail['stok_produksi_id']];
            $stok_history[$is]['stok_akhir']         = $stok_produksi_update[$is]['stok'];
            $stok_history[$is]['deskripsi']          = 'Pengambilan barang (penjualan)';
            $stok_history[$is]['ctb']                = $this->com_user['user_id'];
            $stok_history[$is]['created_at']         = date('Y-m-d H:i:s');
        }

        // proses simpan
        if ($this->m_order->proses_simpan_pengambilan($stok_update_data, $stok_delivery, $stok_produksi_update, $stok_history, $this->input->post('order_id'))) {
            $result['status'] = true;
            $result['pesan']  = 'Data berhasil disimpan.';
        } else {
            $eror             = $this->m_order->get_db_error();
            $result['status'] = false;
            $result['pesan']  = 'Data gagal disimpan. Eror kode : ' . $eror['code'];
        }
        return $this->output->set_output(json_encode($result));
    }

    public function ubah_order($order_id = null)
    {
        $this->_set_page_role('u');

        if (empty($order_id)) {
            redirect('order');
        }

        // get detail
        $data['result_order'] = $this->m_order->get_order_data_by_id($order_id);

        // jika tidak ada data
        if (empty($data)) {
            redirect('order');
        }

        // load js
        $this->load_js('assets/operator/js/plugins/inputmask/dist/jquery.inputmask.bundle.js');

        $this->load_js('assets/operator/js/plugins/accounting.min.js');

        // load datepicker
        $this->load_css('assets/operator/js/plugins/bootstrap-datepicker/css/bootstrap-datepicker3.min.css');
        $this->load_js('assets/operator/js/plugins/bootstrap-datepicker/js/bootstrap-datepicker.min.js');

        // get list item
        $data['rs_item'] = $this->m_order->get_order_detail_by_id($order_id);
        // get total sudah dibayar
        $data['result_pembayaran'] = $this->m_order->get_total_pembayaran($order_id);

        parent::display('ubah_order', $data, 'footer_ubah_order');
    }

    public function proses_ubah_order()
    {
        $this->_set_page_role('u');

        if (!$this->input->is_ajax_request()) {
            return;
        }

        // load form validation
        $this->load->library('form_validation');
        $this->form_validation->set_error_delimiters('', '<br>');
        $this->form_validation->set_rules('nama_pembeli', 'Nama Pembeli', 'required');
        $this->form_validation->set_rules('tanggal', 'Tanggal', 'required');
        $this->form_validation->set_rules('alamat', 'Alamat', 'required');

        // run validation
        if ($this->form_validation->run($this) == false) {
            $data['pesan']  = validation_errors();
            $data['status'] = false;
            return $this->output->set_output(json_encode($data));
        }

        // get list item
        $rs_item = [];
        foreach ($this->m_order->get_order_detail_by_id($this->input->post('order_id')) as $vitem) {
            $rs_item[$vitem['detail_id']] = $vitem;
        }

        // get total sudah dibayar
        $result_order = $this->m_order->get_order_data_by_id($this->input->post('order_id'));

        // order data update
        $order_data['nama_pembeli']  = $this->input->post('nama_pembeli');
        $order_data['tanggal_order'] = date_format(date_create_from_format('d-m-Y', $this->input->post('tanggal')), 'Y-m-d');
        $order_data['alamat']        = $this->input->post('alamat');

        // detail order
        $total_biaya = 0;
        if ($this->input->post('item[]') != '') {
            // indikator jika terdapat barang yang belum dikirim namun sudah selesai, harus diupdate menjadi proses lagi
            $is_proses = false;
            foreach ($this->input->post('item') as $key => $vitem) {
                $order_detail_data[$key]['detail_id']        = $vitem;
                $order_detail_data[$key]['jenis_pengiriman'] = isset($this->input->post('diambil')[$vitem]) && $this->input->post('diambil')[$vitem] == 1 ? 'diambil' : 'diantar';
                $order_detail_data[$key]['jumlah']           = isset($this->input->post('jumlah')[$key]) && $this->input->post('jumlah')[$key] != '' ? $this->input->post('jumlah')[$key] : 0;
                $order_detail_data[$key]['harga']            = isset($this->input->post('harga')[$key]) && $this->input->post('jumlah')[$key] != '' ? $this->input->post('harga')[$key] : 0;

                // validasi jika barang sudah terkirim namun ada penambahan
                if ($rs_item[$vitem]['status_pengiriman'] == 'selesai' && $rs_item[$vitem]['jumlah_terkirim'] <= $order_detail_data[$key]['jumlah']) {
                    $order_detail_data[$key]['status_pengiriman'] = 'proses';
                    $is_proses                                    = true;
                }

                $total_biaya += $order_detail_data[$key]['jumlah'] * $order_detail_data[$key]['harga'];
            }
        }

        // jika terdapat item yang belum dikirim status pengiriman diupdate ke proses lagi
        if ($is_proses) {
            $order_data['status_pengiriman'] = 'proses';
        }

        $order_data['diskon']      = $this->input->post('diskon') == '' ? 0 : (float) $this->input->post('diskon');
        $order_data['transport']   = $this->input->post('transport') == '' ? 0 : (float) $this->input->post('transport');
        $order_data['total_biaya'] = $total_biaya - $order_data['diskon'] + $order_data['transport'];

        // validasi data jika terjadi kurang bayar karena item bertambah maka update status jika lunas jadi termin
        if (
            $result_order['status_pembayaran'] == 'lunas'
            && (($result_order['total_biaya']) < ($order_data['total_biaya']))
        ) {
            $order_data['status_pembayaran'] = 'termin';
        }

        // echo '<pre>';
        // print_r($order_detail_data);
        // print_r($order_data);
        // exit();
        // proses simpan
        if ($this->m_order->simpan_ubah_order($order_data, $order_detail_data, $this->input->post('order_id'))) {
            $result['status'] = true;
            $result['pesan']  = 'Data berhasil disimpan.';
        } else {
            $eror             = $this->m_order->get_db_error();
            $result['status'] = false;
            $result['pesan']  = 'Data gagal disimpan. Eror kode : ' . $eror['code'];
        }
        return $this->output->set_output(json_encode($result));
    }

    public function detail()
    {
        parent::display('detail');
    }
}
