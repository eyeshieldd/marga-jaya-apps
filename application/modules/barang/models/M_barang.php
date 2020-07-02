<?php
defined('BASEPATH') or exit('No direct script access allowed');

require_once APPPATH . 'models/M_model_base.php';

class M_barang extends M_model_base {

    public function __construct() {
        parent::__construct();
    }

    // ambil list kategori
    public function get_list_kategori()
    {
        $sql = $this->db->select('kategori_id, nama_kategori')
                ->from('kategori_barang')
                ->get();

        if ($sql->num_rows() > 0) {
            $result = $sql->result_array();
            $sql->free_result();
            return $result;
        } else {
            return null;
        }      
    }

    // detail data barang
    public function get_detail_barang($params) {
        
        $this->db->select('b.barang_id, b.nama_barang, k.kategori_id, k.nama_kategori');
        $this->db->from('barang b');
        $this->db->join('kategori_barang k', 'b.kategori_id = k.kategori_id');
        $this->db->where('b.barang_id', $params);
        
        $query = $this->db->get();

        if ($query->num_rows() > 0) {
            $result = $query->row_array();
            $query->free_result();
            return $result;
        } else {
            return array();
        }
    }

    public function get_list_barang()
    {
        // select data
        $rs_data = $this->db->select('b.barang_id, b.nama_barang, k.nama_kategori')
            ->from('barang b')
            ->join('kategori_barang k', 'b.kategori_id = k.kategori_id', 'inner')
            ->where('b.is_deleted', 0);        

        // get total records data
        $option['recordsTotal'] = $rs_data->count_all_results('', false);

        // searching function should be here
        if (!empty($this->input->post('barang'))) {
            $rs_data->like('b.nama_barang', $this->input->post('barang'), 'both');
        }
        // searching function should be here
        if (!empty($this->input->post('kategori_id'))) {
            $rs_data->like('k.kategori_id', $this->input->post('kategori_id'), 'both');
        }

        // hitung data setelah filter
        $option['recordsFiltered'] = $rs_data->count_all_results('', false);

        // limit data
        if ($this->input->post('length') > -1) {
            $rs_data->limit($this->input->post('length', true), $this->input->post('start', true));
        }

        // order
        if ($this->input->post('order') !== NULL) {
            // deteksi nama kolom yang di urutkan
            foreach ($this->input->post('order') as $vorder) {                
                $this->db->order_by($this->input->post('columns')[$vorder['column']]['data'], $vorder['dir']);
            }
        }

        $option['draw'] = $this->input->post('draw');

        $no = $this->input->post('start') + 1;

        $rs_data_ = [];
        foreach ($rs_data->get()->result_array() as $vdata) {            
            // add button                
            $tombol = '<div class="text-center">
                    <a class="btn btn-sm btn-alt-warning ubah-data" href="' . base_url() . 'barang/edit/'. $vdata['barang_id'] .'" data-toggle="tooltip" title="Edit Data"><i class="fa fa-pencil"></i></a>
                    <button type="button" class="btn btn-sm btn-alt-danger hapus-data" data-toggle="tooltip" title="Hapus Data" data-id="'. $vdata['barang_id'] .'"><i class="fa fa-trash"></i> </button>
                </div>';

            $vdata           = xss_clean($vdata);
            $vdata['tombol'] = $tombol;
            $vdata['no']     = $no;

            $rs_data_[] = $vdata;
            $no++;
        }
        $option['data'] = $rs_data_;
        return $option;
    }

    // list datatable versi lama
    public function get_list_data()
    {
        $sql = "SELECT b.barang_id, b.nama_barang, k.nama_kategori
                FROM barang b
                JOIN kategori_barang k
                ON b.kategori_id = k.kategori_id
                WHERE b.is_deleted = 0";


        // hitung jumlah data awal
        $rowCount = $this->db->query($sql)->num_rows();

        // search
        // $where = 'is_deleted = 0';

        // nama lengkap
        if (isset($params['nama_barang']) && !empty($params['nama_barang'])) {
            if (!empty($where)) {
                $where .= ' AND ';
            }
            $where .= '(b.nama_barang LIKE "%' . $this->db->escape_like_str($params['nama_barang']) . '%")';
        }
        // where clause
        if (!empty($where)) {
            $sql = $sql . ' WHERE ' . $where;
        }

        $sql .= ' ORDER BY nama_barang ASC';
        // hitung filtered data
        $filteredRow = $this->db->query($sql)->num_rows();

        /*
         * Parameter yang wajib ada untuk datatabel : 
         * 1. recordsTotal => berisi jumlah total keseluruhan data
         * 2. draw => langsung ambil parameter post draw
         * 3. recordsFiltered => berisi jumlah total data dengan parameter pencarian (sejumlah data pencarian)
         * 4. data => data yang ditampilkan
         */
        
        $data['recordsTotal'] = $rowCount;
        $data['draw'] = $this->input->post('draw');
        $data['recordsFiltered'] = $filteredRow;

        // run query
        $rs_barang = $this->db->query($sql);        

        // membuat nomor data
        $no = $this->input->post('start') + 1;

        // jika ada data maka buat susunan data
        if ($rs_barang->num_rows() > 0) {
            foreach ($rs_barang->result_array() as $vbarang) {                

                $tombol = '<div class="text-center">
                        <a class="btn btn-sm btn-alt-warning ubah-data" href="' . base_url() . 'barang/edit/'. $vbarang['barang_id'] .'" data-toggle="tooltip" title="Edit Data"><i class="fa fa-pencil"></i></a>
                        <button type="button" class="btn btn-sm btn-alt-danger hapus-data" data-toggle="tooltip" title="Hapus Data" data-id="'. $vbarang['barang_id'] .'"><i class="fa fa-trash"></i> </button>
                    </div>';
                
                $d['no']            = $no;
                $d['barang_id']     = $vbarang['barang_id'];
                $d['nama_barang']   = $vbarang['nama_barang'];
                $d['nama_kategori'] = $vbarang['nama_kategori'];
                $d['tombol']        = $tombol;

                $data['data'][] = $d;
                $no ++;
            }
        } else {
            // jika kosong maka data diisi array kosong
            $data['data'] = array();
        }

        // return data
        return $data;
    }

    public function check_barang_stok($params)
    {
        $this->db->select('b.barang_id, b.nama_barang, s.stok_id');               
        $this->db->from('barang b');
        $this->db->join('stok s', 's.barang_id = b.barang_id', 'inner');
        $this->db->where('b.barang_id', $params);

        $query = $this->db->get();

        if ($query->num_rows() > 0) {
            $result = $query->row_array();
            $query->free_result();
            return $result;
        } else {
            return array();
        }
    }

    public function check_barang_order_detail($params)
    {       
        $this->db->select('b.barang_id, b.nama_barang, od.order_id');
        $this->db->from('barang b');
        $this->db->join('order_detail od', 'b.barang_id = od.barang_id', 'inner');
        $this->db->where('b.barang_id', $params);

        $query = $this->db->get();

        if ($query->num_rows() > 0) {
            $result = $query->row_array();
            $query->free_result();
            return $result;
        } else {
            return array();
        }
    }
}