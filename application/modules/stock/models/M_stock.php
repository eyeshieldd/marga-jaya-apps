<?php
defined('BASEPATH') or exit('No direct script access allowed');

require_once APPPATH . 'models/M_model_base.php';

class M_stock extends M_model_base
{

    // global var
    var $superadmin_group = 'gr5dd5550a780d7';

    public function __construct()
    {
        parent::__construct();
    }

    public function get_list_stock($com_user)
    {
        $par = $this->input->post('cabang_id');

        $sql = 'SELECT b.barang_id, j.cabang_id, j.stok_id, kb.nama_kategori, kb.kategori_id, b.nama_barang, IFNULL(j.stok, 0) AS total_stok, IFNULL(n.jumlah, 0) AS permintaan
                    FROM barang b
                    LEFT JOIN (
                        SELECT SUM(sp.stok) AS stok, b.nama_barang, b.barang_id, s.stok_id, s.cabang_id
                        FROM stok_produksi sp
                        LEFT JOIN stok s ON s.stok_id = sp.stok_id
                        LEFT JOIN barang b ON b.barang_id = s.barang_id
                        WHERE b.is_deleted = 0 AND s.cabang_id = ?
                        GROUP BY s.barang_id
                    ) j ON j.barang_id = b.barang_id
                    LEFT JOIN (
                        SELECT b.nama_barang, SUM((od.jumlah - IFNULL(od.jumlah_terkirim, 0))) AS jumlah, b.barang_id
                        FROM order_detail od
                        LEFT JOIN barang b ON b.barang_id = od.barang_id
                        LEFT JOIN `order` o ON o.order_id = od.order_id
                        WHERE b.is_deleted = 0 AND o.cabang_id = ?
                        GROUP BY od.barang_id
                    ) n ON n.barang_id = b.barang_id
                    LEFT JOIN kategori_barang kb USING (kategori_id)
                    WHERE b.is_deleted = 0';

        // searching function should be here
        if (!empty($this->input->post('kategori_id'))) {
            $sql .= ' AND kb.kategori_id = "' . $this->input->post('kategori_id') . '"';
        }

        $query = $this->db->query($sql, array($par, $par));


        // get total records data
        $option['recordsTotal'] = $query->num_rows();

        // searching function should be here
        if (!empty($this->input->post('barang'))) {
            $sql .= ' AND b.nama_barang LIKE "%' . $this->input->post('barang') . '%"';
        }
        // hitung data setelah filter
        $option['recordsFiltered'] = $query->num_rows();

        $sql .= ' LIMIT ' . $this->input->post('start', true) . ',' . $this->input->post('length', true);
        $query = $this->db->query($sql, array($par, $par));

        // // limit data
        // if ($this->input->post('length') > -1) {
        //     $rs_data->limit($this->input->post('length', true), $this->input->post('start', true));
        // }

        // $option['draw'] = $this->input->post('draw');

        $no = $this->input->post('start') + 1;

        $rs_data_ = [];
        foreach ($query->result_array() as $vdata) {
            // add button
            $tombol = '<div class="text-center">-</div>';
            // jika yang login adalah super admin atau selain super admin tetapi sama cabang nya maka muncul tombol aksi
            if (($com_user['group_id'] == $this->superadmin_group) || ($com_user['group_id'] != $this->superadmin_group && $com_user['cabang_id'] == $this->input->post('cabang_id'))) {
                $tombol = '<div class="text-center"><a class="btn btn-sm btn-alt-secondary detail-data tombol-detail" data-link="' . base_url() . 'stock/produksi/' . $vdata['barang_id'] . '" href="javascript.void(0)" onclick="return false" data-toggle="tooltip" title="Detail Data"><i class="fa fa-list"></i></a></div>';

            }

            $vdata           = xss_clean($vdata);
            $vdata['tombol'] = $tombol;
            $vdata['no']     = $no;

            $rs_data_[] = $vdata;
            $no++;
        }
        $option['data'] = $rs_data_;

        return $option;
    }

    // barang_id, cabang_id
    public function get_list_produksi($barang_id)
    {
        // $rs_data = $this->db->select('sp.stok_produksi_id, sp.stok_id, sp.nama_pegawai, sp.stok')
        //     ->from('stok_produksi sp')
        //     ->join('stok s', 'sp.stok_id = s.stok_id', 'left')
        //     ->where('s.stok_id', $stok_id);

        /* select data */
        $rs_data = $this->db->select('sp.stok_produksi_id, sp.nama_pegawai, sp.stok')
            ->from('stok s')
            ->join('stok_produksi sp', 'sp.stok_id = s.stok_id', 'left')
            ->where('s.stok_id', $stok_id);

        // get total records data
        $option['recordsTotal'] = $rs_data->count_all_results('', false);

        // searching function should be here
        if (!empty($this->input->post('nama_pegawai'))) {
            $rs_data->like('sp.nama_pegawai', $this->input->post('sp.nama_pegawai'), 'both');
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
            $tombol = '<div class="text-center"><a class="btn btn-sm btn-alt-secondary detail-data" href="' . base_url() . 'stock/detail_produksi/' . $vdata['barang_id'] . '" data-toggle="tooltip" title="Detail Data"><i class="fa fa-list"></i></a></div>';

            $vdata = xss_clean($vdata);
            // $vdata['tanggal_transaksi'] = Date('d-M-Y', strtotime($vdata['tanggal_transaksi']));
            $vdata['tombol'] = $tombol;
            $vdata['no']     = $no;

            $rs_data_[] = $vdata;
            $no++;
        }
        $option['data'] = $rs_data_;
        return $option;
    }

    public function get_detail_produksi($produksi_detail_id = null)
    {
        $sql = $this->db->select('pd.produksi_detail_id, sp.stok_produksi_id, sp.stok, pd.stok_awal, pd.jumlah, pd.stok_akhir')
            ->from('stok_produksi_detail pd')
            ->join('stok_produksi sp', 'pd.stok_produksi_id = sp.stok_produksi_id', 'left')
            ->where('pd.produksi_detail_id', $produksi_detail_id);

        $query = $this->db->get();

        if ($query->num_rows() > 0) {
            $result = $query->row_array();
            $query->free_result();
            return $result;
        } else {
            return null;
        }
    }

    // ambil lsit kategori
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

    // ambil data - pencarian dropdown cabang
    public function get_pencarian_cabang($params = null)
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

    public function get_nama_barang($params)
    {
        // $this->db->select('s.stok_id, p.nama_pegawai, p.stok, b.nama_barang');
        // $this->db->from('stok s');
        // $this->db->join('barang b', 's.barang_id = b.barang_id', 'left');
        // $this->db->join('stok_produksi p', 's.stok_id = p.stok_id', 'left');
        // $this->db->where('s.stok_id', $params);

        $query = $this->db->select('nama_barang')
            ->from('barang ')            
            ->where('barang_id', $params);

        $query = $this->db->get();

        if ($query->num_rows() > 0) {
            $result = $query->row_array();
            $query->free_result();
            return $result;
        } else {
            return array();
        }
    }

    public function get_nama_pegawai($params)
    {
        $this->db->select('stok_id, nama_pegawai');
        $this->db->from('stok_produksi')->where('stok_produksi_id', $params);
        // $this->db->join('barang b', 's.barang_id = b.barang_id', 'left');
        // $this->db->join('stok_produksi p', 's.stok_id = p.stok_id', 'left');
        // $this->db->where('s.stok_id', $params);

        // stok_id dari stok_produk, stok_produksi_id (detail data)

        // $query = $this->db->select('pd.produksi_detail_id, sp.stok_produksi_id, sp.stok_id, sp.nama_pegawai, pd.created_at, pd.stok_awal, pd.stok_akhir')
        //     ->from('stok_produksi_detail pd')
        //     ->join('stok_produksi sp', 'sp.stok_produksi_id = pd.stok_produksi_id', 'left')
        //     ->where('pd.stok_produksi_id', $params);

        // $query = $this->db->select('stok_produksi_id, stok_id, nama_pegawai')
        //     ->from('stok_produksi')
        //     ->where('stok_id', $params);

        $query = $this->db->get();

        if ($query->num_rows() > 0) {
            $result = $query->row_array();
            $query->free_result();
            return $result;
        } else {
            return array();
        }
    }

    public function get_stok_awal($params)
    {
        $this->db->select('stok_id, stok');
        $this->db->from('stok_produksi')->where('stok_produksi_id', $params);

        $query = $this->db->get();

        if ($query->num_rows() > 0) {
            $result = $query->row_array();
            $query->free_result();
            return $result;
        } else {
            return array();
        }
    }

    # transaction simpan - ubah data
    public function simpan($data_simpan = null)
    {
        // mulai transaction
        $this->db->trans_begin();

        $data['stok'] = $data_simpan['stok_akhir'];

        // ubah data stok - tabel stok_produksi
        $this->ubah_data('stok_produksi', 'stok_produksi_id', $this->input->post('stok_produksi_id', true), $data);

        // tambah data stok - tabel stok_produksi_detail
        $this->tambah_data('stok_produksi_detail', $data_simpan);

        $this->db->trans_complete();

        if ($this->db->trans_status() === false) {
            $this->db->trans_rollback();
            return false;
        } else {
            $this->db->trans_commit();
            return true;
        }
    }

    # transaction hapus - ubah data
    public function hapus($data_simpan = null)
    {
        // mulai transaction
        $this->db->trans_begin();

        $hapus['produksi_detail_id'] = $data_simpan['produksi_detail_id'];

        // hapus data stok - tabel stok_produksi_detail
        $this->hapus_data('stok_produksi_detail', $hapus);

        // update data stok tabel stok produksi
        $data['stok'] = $data_simpan['hasil'];

        // ubah data stok - tabel stok_produksi
        $this->ubah_data('stok_produksi', 'stok_produksi_id', $data_simpan['stok_produksi_id'], $data);

        $this->db->trans_complete();

        if ($this->db->trans_status() === false) {
            $this->db->trans_rollback();
            return false;
        } else {
            $this->db->trans_commit();
            return true;
        }
    }

    public function is_exist_data($barang_id, $cabang_id)
    {
        $query = $this->db->select('stok_id')
            ->from('stok')
            ->where('barang_id', $barang_id)
            ->where('cabang_id', $cabang_id);

        $query = $this->db->get();

        if ($query->num_rows() > 0) {
            $result = $query->row_array();
            $query->free_result();
            return $result;
        } else {
            return array();
        }
    }

    public function get_stok_id($barang_id, $cabang_id)
    {
        $query = $this->db->select('stok_id')
            ->from('stok')
            ->where('barang_id', $barang_id)
            ->where('cabang_id', $cabang_id);

        $query = $this->db->get();

        if ($query->num_rows() > 0) {
            $result = $query->row_array();
            $query->free_result();
            return $result;
        } else {
            return array();
        }
    }

    public function get_id_barang_cabang($stok_produksi_id)
    {
        $query = $this->db->select('barang_id, cabang_id')
            ->from('stok_produksi sp')
            ->join('stok s', 's.stok_id = sp.stok_id', 'left')
            ->where('sp.stok_produksi_id', $stok_produksi_id);

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
