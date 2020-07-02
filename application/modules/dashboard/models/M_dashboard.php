<?php

require_once APPPATH . 'models/M_model_base.php';

class M_dashboard extends M_model_base
{

    public function __construct()
    {
        parent::__construct();
    }

    // get list menu
    public function get_list_menu($group_id, $parent_menu, $portal_number)
    {
        $query = $this->db->select('DISTINCT(a.menu_id), a.portal_id, a.menu_name, a.menu_desc, a.menu_position, a.menu_order, a.menu_parent,
                a.menu_link, a.menu_icon, a.menu_fonticon , b.permission')
            ->from('sys_menu a')
            ->join('sys_permission b', 'b.menu_id=a.menu_id', 'inner')
            ->join('sys_portal c', 'c.portal_id=a.portal_id', 'inner')
            ->where_in('b.group_id', $group_id)
            ->where('a.menu_position', 'lfm')
            ->where('a.menu_parent', $parent_menu)
            ->where('SUBSTRING(b.permission,2,1)', 1)
            ->where('c.portal_number', $portal_number)
            ->where('a.menu_show', 1)
            ->order_by('a.menu_order', 'ASC')
            ->get();
        if ($query->num_rows() > 0) {
            $result = $query->result_array();
            $query->free_result();
            return $result;
        } else {
            return array();
        }
    }

    public function get_chart_pcs()
    {
        // keseluruhan stok & prmintaan
        $sql = 'SELECT b.nama_barang, IFNULL(j.stok,0) AS stok, IFNULL(n.jumlah, 0) AS permintaan
                FROM barang b
                LEFT JOIN(
                    SELECT SUM(sp.stok) AS stok, b.nama_barang, b.barang_id
                    FROM stok_produksi sp
                    LEFT JOIN stok s ON s.stok_id = sp.stok_id
                    LEFT JOIN barang b ON b.barang_id = s.barang_id
                    WHERE b.is_deleted = 0
                    GROUP BY s.barang_id
                ) j ON j.barang_id = b.barang_id
                LEFT JOIN(
                    SELECT b.nama_barang, SUM((od.jumlah - IFNULL(od.jumlah_terkirim, 0))) AS jumlah, b.barang_id
                    FROM order_detail od
                    LEFT JOIN barang b ON b.barang_id = od.barang_id
                    LEFT JOIN `order` o ON o.order_id = od.order_id
                    WHERE b.is_deleted = 0
                    GROUP BY od.barang_id   
                ) n ON n.barang_id = b.barang_id
                LEFT JOIN kategori_barang kb 
                ON kb.kategori_id = b.kategori_id
                WHERE kb.satuan = "pcs" AND kb.is_show_chart = 1 AND b.is_deleted = 0';

        $query = $this->db->query($sql);

        if ($query->num_rows() > 0) {
            $result = $query->result_array();
            $query->free_result();
            return $result;
        } else {
            return array(array('nama_barang' => '', 'permintaan' => 0, 'stok' => 0));
        }
    }

    public function get_chart_m2()
    {
        $sql = 'SELECT b.nama_barang, IFNULL(j.stok,0) AS stok, IF(j.stok != 0, j.stok / kb.konversi, 0) AS nilai_konversi, IFNULL(n.jumlah, 0) AS permintaan
                FROM barang b
                LEFT JOIN(
                    SELECT IFNULL(SUM(sp.stok),0) AS stok, b.nama_barang, b.barang_id
                    FROM stok_produksi sp
                    LEFT JOIN stok s
                    ON s.stok_id = sp.stok_id
                    LEFT JOIN barang b ON b.barang_id = s.barang_id
                    LEFT JOIN kategori_barang kb ON kb.kategori_id = b.kategori_id
                    WHERE b.is_deleted = 0
                    GROUP BY s.barang_id
                ) j ON j.barang_id = b.barang_id
                LEFT JOIN(
                    SELECT b.nama_barang, SUM((od.jumlah - IFNULL(od.jumlah_terkirim, 0))) AS jumlah, b.barang_id
                    FROM order_detail od
                    LEFT JOIN barang b ON b.barang_id = od.barang_id
                    LEFT JOIN `order` o ON o.order_id = od.order_id
                    WHERE b.is_deleted = 0
                    GROUP BY od.barang_id   
                ) n ON n.barang_id = b.barang_id
                LEFT JOIN kategori_barang kb
                ON kb.kategori_id = b.kategori_id
                WHERE kb.satuan = "m2" AND kb.is_show_chart = 1 AND b.is_deleted = 0';

        $query = $this->db->query($sql);

        if ($query->num_rows() > 0) {
            $result = $query->result_array();
            $query->free_result();
            return $result;
        } else {
            return array(array('nama_barang' => '', 'nilai_konversi' => 0, 'permintaan' => 0, 'stok' => 0));
        }
    }
}
