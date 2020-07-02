<?php

require_once APPPATH . 'models/M_model_base.php';

class M_kategori extends M_model_base {

    public function __construct() {
        parent::__construct();
    }

    public function get_list_kategori() {
        $query = $this->db->select('kategori_id, nama_kategori')
        ->from('kategori_barang')
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
    public function get_detail_kategori($params) {
        $sql = 'SELECT kategori_id, nama_kategori, satuan, konversi, is_show_chart, ctb, created_at, mdb, updated_at FROM kategori_barang WHERE kategori_id = ?';

        $query = $this->db->query($sql, $params);
        if ($query->num_rows() > 0) {
            $result = $query->row_array();
            $query->free_result();
            return $result;
        } else {
            return array();
        }
    }

    // ambil list satuan
    public function get_list_satuan()
    {
        $sql = $this->db->select('kategori_id, satuan')
        ->from('kategori_barang')
        // ->group_by('satuan')
        ->get();

        if ($sql->num_rows() > 0) {
            $result = $sql->result_array();
            $sql->free_result();
            return $result;
        } else {
            return null;
        }      
    }

    public function check_kategori($params)
    {
        $sql = 'SELECT k.kategori_id, k.nama_kategori, b.nama_barang
        FROM barang b
        JOIN kategori_barang k
        ON b.kategori_id = k.kategori_id
        WHERE b.kategori_id = ?';

        $query = $this->db->query($sql, $params);
        if ($query->num_rows() > 0) {
            $result = $query->row_array();
            $query->free_result();
            return $result;
        } else {
            return array();
        }
    }    
}
