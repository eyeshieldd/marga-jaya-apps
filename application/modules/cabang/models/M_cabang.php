<?php
defined('BASEPATH') or exit('No direct script access allowed');

require_once APPPATH . 'models/M_model_base.php';

class M_cabang extends M_model_base {

    public function __construct() {
        parent::__construct();
    }    

    // tdk dipakai
    public function get_detail_data($par)
    {
        $sql = 'SELECT id, nama_barang, kategori, harga, tanggal_beli, ct.status, ct.mdd, u.username
				FROM contoh_tabel ct
				LEFT JOIN sys_user u ON u.user_id = ct.mdb 
				WHERE id = ?';

        $query = $this->db->query($sql, $par);
        if ($query->num_rows() > 0) {
            $result = $query->row_array();
            $query->free_result();
            return $result;
        } else {
            return null;
        }

    }

    public function get_detail_cabang($params) {
        $sql = 'SELECT cabang_id, kode_cabang, nama_cabang, alamat, telepon, ctb, created_at, mdb, updated_at FROM cabang WHERE cabang_id = ?';

        $query = $this->db->query($sql, $params);
        if ($query->num_rows() > 0) {
            $result = $query->row_array();
            $query->free_result();
            return $result;
        } else {
            return array();
        }
    }

    public function check_cabang_dokumen($params)
    {
        /*SELECT d.nama_dokumen, a.deskripsi, c.nama_cabang
        FROM cabang c
        INNER JOIN dokumen d
            ON d.cabang_id = c.cabang_id
        INNER JOIN arus_kas a
            ON a.cabang_id = c.cabang_id
        WHERE c.cabang_id = 1*/

        $sql = 'SELECT c.cabang_id, c.nama_cabang, a.deskripsi, d.nama_dokumen
                FROM cabang c
                INNER JOIN dokumen d
                    ON d.cabang_id = c.cabang_id
                INNER JOIN arus_kas a
                    ON a.cabang_id = c.cabang_id
                WHERE a.cabang_id = ?';

        $this->db->select('c.cabang_id, c.nama_cabang, d.nama_dokumen');               
        $this->db->from('dokumen d');
        $this->db->join('cabang c', 'd.cabang_id = c.cabang_id', 'inner');
        // $this->db->join('arus_kas a', 'a.cabang_id = c.cabang_id', 'inner');
        $this->db->where('d.cabang_id', $params);

        // $query = $this->db->query($sql, $params);
        $query = $this->db->get();

        if ($query->num_rows() > 0) {
            $result = $query->row_array();
            $query->free_result();
            return $result;
        } else {
            return array();
        }
    }

    public function check_cabang_arus_kas($params)
    {       
        // $sql = 'SELECT c.cabang_id, c.nama_cabang, a.deskripsi, d.nama_dokumen
        //         FROM cabang c
        //         INNER JOIN dokumen d
        //             ON d.cabang_id = c.cabang_id
        //         INNER JOIN arus_kas a
        //             ON a.cabang_id = c.cabang_id
        //         WHERE a.cabang_id = ?';

        $this->db->select('c.cabang_id, c.nama_cabang, a.deskripsi');
        $this->db->from('arus_kas a');
        $this->db->join('cabang c', 'a.cabang_id = c.cabang_id', 'inner');
        // $this->db->join('arus_kas a', 'a.cabang_id = c.cabang_id', 'inner');
        $this->db->where('a.cabang_id', $params);

        // $query = $this->db->query($sql, $params);
        $query = $this->db->get();

        if ($query->num_rows() > 0) {
            $result = $query->row_array();
            $query->free_result();
            return $result;
        } else {
            return array();
        }
    }

    public function kode_cabang_is_exist($kode_cabang)
    {
        /*$this->db->select('cabang_id, kode_cabang')
            ->from('cabang')
            ->where('cabang_id !=', $cabang_id);*/

        $sql = 'SELECT kode_cabang
                FROM cabang
                WHERE kode_cabang = ?';

        $query = $this->db->query($sql, $kode_cabang);
        // $query = $this->db->get();

        if ($query->num_rows() > 0) {
            $result = $query->row_array();
            $query->free_result();
            return $result;
        } else {
            return null;
        }
    }
    
    public function check_kode_cabang($cabang_id)
    {
        /*$this->db->select('cabang_id, kode_cabang')
            ->from('cabang')
            ->where('cabang_id !=', $cabang_id);*/

        $sql = 'SELECT kode_cabang
                FROM cabang
                WHERE cabang_id = ?';

        $query = $this->db->query($sql, $cabang_id);
        // $query = $this->db->get();

        if ($query->num_rows() > 0) {
            $result = $query->row_array();
            $query->free_result();
            return $result;
        } else {
            return null;
        }
    }    
}
