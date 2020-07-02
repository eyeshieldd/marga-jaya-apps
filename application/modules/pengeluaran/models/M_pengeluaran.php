<?php

require_once APPPATH . 'models/M_model_base.php';

class M_pengeluaran extends M_model_base {

    public function __construct() {
        parent::__construct();
    }

    public function get_list_pengeluaran()
    {
        // select data
        $rs_data = $this->db->select('a.arus_id, a.tanggal_transaksi, a.deskripsi, a.nominal, c.nama_cabang')
            ->from('arus_kas a')
            ->join('cabang c', 'a.cabang_id = c.cabang_id', 'inner')
            ->where('jenis_pengeluaran', 'out');

        // get total records data
        $option['recordsTotal'] = $rs_data->count_all_results('', false);

        // searching function should be here
        if (!empty($this->input->post('pengeluaran'))) {
            $rs_data->like('a.deskripsi', $this->input->post('pengeluaran'), 'both');
        }
        // searching function should be here
        if (!empty($this->input->post('cabang_id'))) {
            $rs_data->like('c.cabang_id', $this->input->post('cabang_id'), 'both');
        }

        // hitung data setelah filter
        $option['recordsFiltered'] = $rs_data->count_all_results('', false);

        // limit data
        if ($this->input->post('length') > -1) {
            $rs_data->limit($this->input->post('length', true), $this->input->post('start', true));
        }

        $option['draw'] = $this->input->post('draw');

        $no = $this->input->post('start') + 1;

        $rs_data_ = [];
        foreach ($rs_data->get()->result_array() as $vdata) {
            // add button
            $tombol = '<div class="text-center"><button type="button" class="btn btn-sm btn-alt-danger hapus-data" data-toggle="tooltip" title="Hapus Data" data-id="'. $vdata['arus_id'] .'"><i class="fa fa-trash"></i> </button></div>';

            $vdata                      = xss_clean($vdata);
            $vdata['tanggal_transaksi'] = Date('d-M-Y', strtotime($vdata['tanggal_transaksi']));
            $vdata['nominal']           = abs($vdata['nominal']);
            $vdata['tombol']            = $tombol;
            $vdata['no']                = $no;

            $rs_data_[] = $vdata;
            $no++;
        }
        $option['data'] = $rs_data_;
        return $option;
    }

    public function get_list_data()
    {
        $query = $this->db->select('pemasukan_id, nama_pemasukan')
            ->from('arus_kas')
            ->where('jenis_pengeluaran', 'in')
            ->get();

        if ($query->num_rows() > 0) {
            $result = $query->result_array();
            $query->free_result();
            return $result;
        } else {
            return array();
        }
    }

    // detail data kategori
    public function get_detail_kategori($params)
    {
        $sql = 'SELECT kategori_id, nama_kategori, ctb, created_at, mdb, updated_at FROM kategori_barang WHERE kategori_id = ?';

        $query = $this->db->query($sql, $params);
        if ($query->num_rows() > 0) {
            $result = $query->row_array();
            $query->free_result();
            return $result;
        } else {
            return array();
        }
    }

    // ambil data cabang
    public function get_list_cabang($params)
    {
        $sql = $this->db->select('cabang_id, nama_cabang')
                ->from('cabang')
                ->where('cabang_id', $params)
                ->get();

        if ($sql->num_rows() > 0) {
            $result = $sql->row_array();
            $sql->free_result();
            return $result;
        } else {
            return null;
        }
    }

    // ambil data - pencarian dropdown cabang
    public function get_pencarian_cabang($params)
    {
        $sql = $this->db->select('cabang_id, nama_cabang')
                ->from('cabang');

        if (!empty($params)) {
            $sql = $this->db->where('nama_cabang', $params);
        }
        
        $sql = $this->db->get();

        if ($sql->num_rows() > 0) {
            $result = $sql->result_array();
            $sql->free_result();
            return $result;
        } else {
            return null;
        }
    }
}
