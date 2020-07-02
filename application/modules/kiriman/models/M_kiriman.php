<?php
defined('BASEPATH') or exit('No direct script access allowed');

require_once APPPATH . 'models/M_model_base.php';

class M_kiriman extends M_model_base {

    public function __construct() {
        parent::__construct();
    }

    public function get_list_pembeli($params)
    {
        $sql = $this->db->select('o.order_id, o.nama_pembeli , od.jenis_pengiriman , o.cabang_id , c.nama_cabang')
        ->from('order o')
        ->join('order_detail od', 'o.order_id = od.order_id' ,'left')
        ->join('cabang c', 'c.cabang_id = o.cabang_id')
        ->where('od.jenis_pengiriman','diantar')
        ->where('o.status_pengiriman !=','selesai')
        ->group_by ('o.order_id');

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
    
    public function get_cabang($order_id){

        $sql = $this->db->select('c.cabang_id, c.nama_cabang')
        ->from('order o')
        ->join('cabang c','c.cabang_id = o.cabang_id', 'left')
        ->where('order_id', $order_id)
            // ->where('is_deleted', '0')
        ->get();

        if ($sql->num_rows() > 0) {
            $result = $sql->row_array();
            $sql->free_result();
            return $result;
        } else {
            return array();
        }
    }

    public function get_keterangan($stok_produksi_id){

       $sql = $this->db->select('sp.nama_pegawai')
       ->from('stok_produksi sp')
       ->where('sp.stok_produksi_id', $stok_produksi_id )
       ->get();


       if ($sql->num_rows() > 0) {
        $result = $sql->row_array();
        $sql->free_result();
        return $result;
    } else {
        return array();
    }
}

    public function get_jumlah($order_id){
        $sql = $this->db->select('jumlah')
        ->from('order_detail')
        ->where('order_id', $order_id)
        ->get();


        if ($sql->num_rows() > 0) {
            $result = $sql->row_array();
            $sql->free_result();
            return $result;
        } else {
            return null;
        }      
    }
    
    public function get_list_barang($id){
        $sql = $this->db->select('o.order_id, o.nama_pembeli,od.jumlah, od.barang_id, b.nama_barang, IFNULL(od.jumlah_terkirim, 0) as jumlah_terkirim , od.detail_id')
        ->from('order_detail od')
        ->join('order o', 'od.order_id = o.order_id', 'left')
        ->join('barang b', 'od.barang_id = b.barang_id')
        ->where('od.status_pengiriman !=','selesai')
        // ->where('od.status_pengiriman','belum dikirim')

        ->where('od.jenis_pengiriman','diantar')
        ->where('o.order_id', $id)
        ->get();        

        if ($sql->num_rows() > 0) {
            $result = $sql->result_array();
            $sql->free_result();
            return $result;
        } else {
            return null;
        }      
    }

    public function get_stok($id_stok)
    {
        $sql = $this->db->select('sp.stok_produksi_id, sp.nama_pegawai, CAST(sp.stok AS INT) AS stok, od.barang_id')
        ->from('stok_produksi sp')
        ->join('stok s', 's.stok_id = sp.stok_id', ' left')
        ->join('order_detail od', 'od.barang_id = s.barang_id', ' left')
        ->where('od.jenis_pengiriman', 'diantar')
        ->where('od.detail_id', $id_stok )
        ->group_by('sp.nama_pegawai')
        ->get();

        if ($sql->num_rows() > 0) {
            $result = $sql->result_array();
            $sql->free_result();
            return $result;
        } else {
            return array();
        }
    }

    public function get_stok_available($stok_produksi_id)
    {
        $sql = $this->db->select('sp.stok_produksi_id, , CAST(sp.stok AS INT) AS stok')
        ->from('stok_produksi sp')
        ->where('stok_produksi_id', $stok_produksi_id)
        ->get();


        if ($sql->num_rows() > 0) {
            $result = $sql->result_array();
            $sql->free_result();
            return $result;
        } else {
            return array();
        }
    }
    public function get_list_item_pengiriman($order_id)
    {
        $sql = $this->db->select('d.detail_id, d.order_id, d.barang_id, b.nama_barang, d.jumlah, d.jenis_pengiriman ')
        ->from('order_detail d')
        ->join('barang b','b.barang_id = d.barang_id', 'inner')
        ->where('d.order_id', $order_id)
        ->where('d.jenis_pengiriman', 'diantar')
        ->where('d.status_pengiriman ', 'proses')
        ->get();

        if ($sql->num_rows() > 0) {
            $result = $sql->result_array();
            $sql->free_result();
            return $result;
        } else {
            return array();
        }
    }

    public function get_jumlahterkirim($detail_id){
        $sql = $this->db->select('order_detail.jumlah_terkirim, order_detail.jumlah')
        ->from('order_detail')
        ->where('order_detail.detail_id', $detail_id)
        ->get();

        if ($sql->num_rows() > 0) {
            $result = $sql->row_array();
            $sql->free_result();
            return $result;
        } else {
            return array();
        }
    }

//     SELECT  SUM(od.`jumlah`) AS jumlah, SUM(od.`jumlah_terkirim`) AS jt
// FROM order_detail od
// WHERE od.`order_id` = 'e28453a02d244a7196b3ac7a9d97f2b1'


    public function get_total($order_id){
        $sql = $this->db->select('SUM(od.jumlah) as jumlah, SUM(od.jumlah_terkirim) as jumlah_terkirim')
        ->from('order_detail od')
        ->where('od.order_id', $order_id)
        ->get();

        if ($sql->num_rows() > 0) {
            $result = $sql->row_array();
            $sql->free_result();
            return $result;
        } else {
            return array();
        }
    }


    public function proses_simpan_pengiriman($data_simpan , $insert_odd, $update_sp, $insert_spd, $update_od, $id, $detail_id , $update_order, $order_id)
    {
        $this->db->trans_begin();

        $this->db->insert('pengiriman', $data_simpan);
        $this->db->insert('order_detail_delivery', $insert_odd);
        $this->db->insert('stok_produksi_detail', $insert_spd);
        $this->db->update('stok_produksi', $update_sp, array('stok_produksi_id' => $id));
        $this->db->update('order_detail', $update_od, array('detail_id' => $detail_id));
        $this->db->update('order', $update_order, array('order_id' => $order_id));



        if ($this->db->trans_status() === false) {
            $this->db->trans_rollback();
            return false;
        } else {
            $this->db->trans_commit();
            return true;
        }
    }
}

