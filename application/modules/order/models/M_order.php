<?php

/*
 * By : Praditya Kurniawan
 * website : http://masiyak.com
 * email : aku@masiyak.com
 *
 */

require_once APPPATH . 'models/M_model_base.php';

class M_order extends M_model_base
{
    // global var
    var $superadmin_group = 'gr5dd5550a780d7';

    public function __construct()
    {
        parent::__construct();
    }

    public function get_list_cabang()
    {
        $sql = $this->db->select('cabang_id, nama_cabang')
        ->from('cabang')
        ->where('is_deleted', 0)
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
        $sql = $this->db->select('sp.stok_produksi_id, CAST(sp.stok AS INT) AS stok')
        ->from('stok_produksi sp')
        ->where('stok_produksi_id', $stok_produksi_id)
        ->get();


        if ($sql->num_rows() > 0) {
            $result = $sql->row_array();
            $sql->free_result();
            return $result;
        } else {
            return array();
        }
    }

    public function get_list_order($com_user)
    {
        $st_pengiriman_status = array(
            'belum dikirim' => '<span class="badge badge-danger">belum dikirim</span>',
            'proses'        => '<span class="badge badge-warning">diproses</span>',
            'selesai'       => '<span class="badge badge-success">selesai</span>',
        );

        $this->db->select('o.order_id, o.no_order, o.nama_pembeli, o.tanggal_order, o.alamat, o.status_pengiriman, o.status_pembayaran')
        ->from('order o')
        // ->order_by('tanggal_order', 'asc')
        ->join('cabang c', 'c.cabang_id = o.cabang_id', 'left')
        ->where('o.cabang_id', $this->input->post('cabang_id'));

        if ($this->input->post('tanggal') != '') {
            $this->db->where('DATE_FORMAT(o.tanggal_order, "%m-%Y") = "' . $this->input->post('tanggal') . '"');
        }

        $result['recordsTotal'] = $this->db->count_all_results('', false);

        if ($this->input->post('no_nama') != '') {
            $this->db->group_start();
            $this->db->like('no_order', $this->input->post('no_nama'), 'both');
            $this->db->or_like('nama_pembeli', $this->input->post('no_nama'), 'both');
            $this->db->group_end();
        }

        // cari data post order yang diorder
        if ($this->input->post('order') !== NULL) {
            // deteksi nama kolom yang di urutkan
            foreach ($this->input->post('order') as $vorder) {                    
                // 1. tanggal & 2. status
                if ($vorder['column'] == 1) {
                    $this->db->order_by('o.tanggal_order', $vorder['dir']);
                } elseif ($vorder['column'] == 2) {
                    $this->db->order_by('o.status_pembayaran', $vorder['dir']);
                }                
            }
        }

        $result['recordsFiltered'] = $this->db->count_all_results('', false);

        $this->db->limit($this->input->post('length', true), $this->input->post('start', true));

        $result['draw'] = $this->input->post('draw');
        $result['data'] = [];
        $rs_order       = $this->db->get();
        $no             = $this->input->post('start') + 1;
        foreach ($rs_order->result_array() as $key => $vorder) {
            $tombol = '-';
            // validasi tombol
            if(($com_user['group_id'] == $this->superadmin_group) || $com_user['cabang_id'] == $this->input->post('cabang_id'))
                $tombol = '<div class="btn-group" role="group" aria-label="Third group">
            <button type="button" class="btn btn-secondary dropdown-toggle" id="toolbarDrop" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Opsi</button>
            <div class="dropdown-menu" aria-labelledby="toolbarDrop">
            <a class="dropdown-item" href="' . base_url('order/pembayaran/' . $vorder['order_id']) . '">
            <i class="fa fa-credit-card"></i> Pembayaran
            </a>
            <a class="dropdown-item" href="' . base_url('order/pengambilan/' . $vorder['order_id']) . '">
            <i class="fa fa-archive"></i> Pengambilan
            </a>
            <a class="dropdown-item" href="' . base_url('order/pengiriman/' . $vorder['order_id']) . '">
            <i class="fa fa-truck"></i> Riwayat Dist
            </a>
            <div class="dropdown-divider"></div>
            <a class="dropdown-item" href="' . base_url('order/ubah_order/' . $vorder['order_id']) . '">
            <i class="fa fa-fw fa-pencil mr-5"></i> Ubah Order
            </a>
            </div>
            </div>';

            // status pembayaran
            switch ($vorder['status_pembayaran']) {
                case 'lunas':
                $result['data'][$key]['status_pembayaran'] = '<span class="badge badge-success">Lunas</span>';
                break;
                case 'dp':
                case 'termin':
                $result['data'][$key]['status_pembayaran'] = '<span class="badge badge-warning">' . $vorder['status_pembayaran'] . '</span>';
                break;

                default:
                $result['data'][$key]['status_pembayaran'] = '<span class="badge badge-danger">' . $vorder['status_pembayaran'] . '</span>';
                break;
            }

            // data order
            $teksorder = '';
            $teksorder .= '#' . $vorder['no_order'];
            $teksorder .= '<br>' . $vorder['nama_pembeli'];
            $teksorder .= '<br>' . date('Y-m-d', strtotime($vorder['tanggal_order']));
            $teksorder .= '<br>' . $vorder['alamat'];

            $teksorder .= '<br> Pengambilan/Pengiriman : ';
            // $teksorder .= '<br>' . $d['status_pengiriman'];
            $teksorder .= isset($st_pengiriman_status[$vorder['status_pengiriman']]) ? $st_pengiriman_status[$vorder['status_pengiriman']] : '<span class="badge badge-danger">belum diproses</span>';

            $result['data'][$key]['no']           = $no++;
            $result['data'][$key]['order_id']     = $vorder['order_id'];
            $result['data'][$key]['no_order']     = $vorder['no_order'];
            $result['data'][$key]['nama_pembeli'] = $teksorder;
            $result['data'][$key]['tombol']       = $tombol;
        }

        return json_encode($result);
    }

    public function get_list_order_pengiriman($order_id)
    {

        $sql = $this->db->select('odd.tanggal, odd.jenis_pengiriman, odd.keterangan, b.nama_barang')
        ->from('order_detail_delivery odd')
        ->join('order_detail od', 'odd.detail_id = od.detail_id', 'left')
        ->join('barang b', 'od.barang_id = b.barang_id')
        ->where('od.order_id', $order_id)
        ->get();

        // $sql = $this->db->select('p.tanggal, b.nama_barang ,p.nama_sopir, p.jumlah')
        //     ->from('pengiriman p')
        //     ->join('order_detail od', 'p.order_detail_id = od.detail_id', 'left')
        //     ->join('barang b', 'od.barang_id = b.barang_id')
        //     ->where('od.order_id', $order_id)
        //     ->get();

        if ($sql->num_rows() > 0) {
            $result = $sql->result_array();
            $sql->free_result();
            return $result;
        } else {
            return null;
        }
    }

    public function get_detail_cabang($cabang_id)
    {
        $sql = $this->db->select('cabang_id, nama_cabang')
        ->from('cabang')
        ->where('is_deleted', 0)
        ->where('cabang_id', $cabang_id)
        ->get();

        if ($sql->num_rows() > 0) {
            $result = $sql->row_array();
            $sql->free_result();
            return $result;
        } else {
            return array();
        }
    }

    public function get_detail_order($order_id)
    {
        $sql = $this->db->select('o.order_id, o.no_order, o.nama_pembeli, o.tanggal_order, c.nama_cabang, o.alamat')
        ->from('order o')
        ->join('cabang c', 'c.cabang_id = o.cabang_id', 'left')
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

    public function get_detail($order_id)
    {
        // print_r($order_id);
        // exit();
        $sql = $this->db->select('orb.tanggal_pembayaran, orb.status_pembayaran, orb.nominal, orb.keterangan, o.total_biaya, o.diskon, o.order_id')
        ->from('order_riwayat_bayar orb')
        ->join('order o', 'o.order_id = orb.order_id', 'left')
        ->where('o.order_id', $order_id)
        // ->where('is_deleted', '0')
        ->get();

        if ($sql->num_rows() > 0) {
            $result = $sql->result_array();
            $sql->free_result();
            return $result;
        } else {
            return array();
        }
    }

    public function get_total_tagihan($order_id)
    {
        $sql = $this->db->select('o.total_biaya, o.status_pembayaran, o.diskon, o.transport')
        ->from('order o')
        ->where('o.order_id', $order_id)
        // ->where('is_deleted', '0')
        ->get();

        if ($sql->num_rows() > 0) {
            $result = $sql->row_array();
            $sql->free_result();
            return $result;
        } else {
            return 0;
        }
    }

    public function get_kode_cabang($cabang_id)
    {
        $sql = $this->db->select('kode_cabang')
        ->from('cabang')
        ->where('cabang_id', $cabang_id)
        // ->where('is_deleted', '0')
        ->get();

        if ($sql->num_rows() > 0) {
            $result = $sql->row_array();
            $sql->free_result();
            return $result['kode_cabang'];
        } else {
            return false;
        }
    }

    public function get_last_number($cabang_id)
    {
        $sql = $this->db->select('CAST(SUBSTR(o.no_order, 7, 4) AS INT) AS no')
        ->from('order o')
        ->where('cabang_id', $cabang_id)
        ->order_by('no_order', 'desc')
        ->limit(1)
        ->get();

        if ($sql->num_rows() > 0) {
            $result = $sql->row_array();
            $sql->free_result();
            // build zero prefix if needed
            $i     = $result['no'] + 1;
            $nomor = '000' . $i;
            return substr($nomor, -4);
        } else {
            return '0001';
        }
    }

    public function get_list_item_pengambilan($order_id)
    {
        $sql = $this->db->select('d.detail_id, d.order_id, d.barang_id, b.nama_barang, CAST(d.jumlah as INT) as jumlah, IFNULL(CAST(d.jumlah_terkirim as INT),0) as jumlah_terkirim, d.jenis_pengiriman')
        ->from('order_detail d')
        ->join('barang b', 'b.barang_id = d.barang_id', 'inner')
        ->where('d.order_id', $order_id)
        ->where('d.jenis_pengiriman', 'diambil')
        ->group_start()
        ->where('d.status_pengiriman', 'proses')
        ->or_where('d.status_pengiriman', 'belum dikirim')
        ->group_end()
        ->get();

        if ($sql->num_rows() > 0) {
            $result = $sql->result_array();
            $sql->free_result();
            return $result;
        } else {
            return array();
        }
    }
    public function get_list_item_jumlahtotal($order_id)
    {
        $sql = $this->db->select('b.barang_id, (CAST(d.jumlah as INT) - CAST(IFNULL(d.jumlah_terkirim, 0) as INT)) as jumlah')
        ->from('order_detail d')
        ->join('barang b', 'b.barang_id = d.barang_id', 'inner')
        ->where('d.order_id', $order_id)
        ->get();

        if ($sql->num_rows() > 0) {
            $result = $sql->result_array();
            $sql->free_result();
            return $result;
        } else {
            return array();
        }
    }
    public function get_terkirim($detail_id)
    {
        $sql = $this->db->select(' CAST(d.jumlah_terkirim as INT) as jumlah')
        ->from('order_detail d')
        ->where('d.detail_id', $detail_id)
        ->get();

        if ($sql->num_rows() > 0) {
            $result = $sql->row_array();
            $sql->free_result();
            return $result;
        } else {
            return array();
        }
    }


    public function get_list_barang()
    {
        $sql = $this->db->select('b.barang_id, b.nama_barang, k.nama_kategori')
        ->from('barang b')
        ->join('kategori_barang k', 'k.kategori_id = b.kategori_id', ' left')
        ->where('b.is_deleted', '0')
        ->get();

        if ($sql->num_rows() > 0) {
            $result = $sql->result_array();
            $sql->free_result();
            return $result;
        } else {
            return array();
        }
    }

    public function get_list_stok($order_id)
    {
        $sql = $this->db->select('sp.stok_produksi_id, sp.nama_pegawai, CAST(sp.stok AS INT) AS stok, od.barang_id')
        ->from('stok_produksi sp')
        ->join('stok s', 's.stok_id = sp.stok_id', ' left')
        ->join('order_detail od', 'od.barang_id = s.barang_id', ' left')
        ->where('od.order_id', $order_id)
        ->where('od.jenis_pengiriman', 'diambil')
        ->get();

        if ($sql->num_rows() > 0) {
            $result = $sql->result_array();
            $sql->free_result();
            return $result;
        } else {
            return array();
        }
    }

    public function get_stok_available_by_id($id)
    {
        $sql = $this->db->select('sp.stok_produksi_id, sp.nama_pegawai, CAST(sp.stok AS INT) AS stok, c.nama_cabang')
        ->from('stok_produksi sp')
        ->join('stok s', 's.stok_id = sp.stok_id', 'left')
        ->join('cabang c', 'c.cabang_id = s.cabang_id', 'left')
        ->where_in('sp.stok_produksi_id', $id)
        ->get();

        if ($sql->num_rows() > 0) {
            $result = $sql->result_array();
            $sql->free_result();
            return $result;
        } else {
            return array();
        }
    }

    public function simpan_order($order = null, $pembayaran = null, $detail = null)
    {
        $this->db->trans_begin();

        $this->tambah_data('order', $order);
        $this->tambah_data_batch('order_detail', $detail);

        if (!empty($pembayaran)) {
            $this->tambah_data('order_riwayat_bayar', $pembayaran);
        }

        if ($this->db->trans_status() === false) {
            $this->db->trans_rollback();
            return false;
        } else {
            $this->db->trans_commit();
            return true;
        }
    }

    public function proses_simpan_pengambilan($stok_update_data, $stok_delivery, $stok_produksi_update, $stok_history, $order_id = null)
    {
        $this->db->trans_begin();

        $this->db->update_batch('order_detail', $stok_update_data, 'detail_id');
        $this->db->insert_batch('order_detail_delivery', $stok_delivery);
        $this->db->update_batch('stok_produksi', $stok_produksi_update, 'stok_produksi_id');
        $this->db->insert_batch('stok_produksi_detail', $stok_history);

        if ($this->db->trans_status() === false) {
            $this->db->trans_rollback();
            return false;
        } else {
            $this->db->trans_commit();
            // cek apakah semua item sudah diambil atau belum
            $q = $this->db->select('status_pengiriman')->from('order_detail')->where('order_id', $order_id)->get();

            // get total item
            $total_pesanan = $q->num_rows();
            /// get total selesai
            $total_selesai = 0;
            $total_proses  = 0;
            foreach ($q->result_array() as $vstatus) {
                if ($vstatus['status_pengiriman'] == 'selesai') {
                    $total_selesai += 1;
                } elseif ($vstatus['status_pengiriman'] == 'proses') {
                    $total_proses += 1;
                }
            }
            // kalau semua item sudah selesai maka update data order menjadi terkirim
            if ($total_pesanan == $total_selesai) {
                $this->db->where('order_id', $order_id)->update('order', ['status_pengiriman' => 'selesai']);
            } elseif ($total_pesanan > 0 && $total_proses > 0) {
                $this->db->where('order_id', $order_id)->update('order', ['status_pengiriman' => 'proses']);
            }

            return true;
        }
    }
    public function proses_simpan_pengiriman($data_simpan, $data_update, $order_id)
    {
        $this->db->trans_begin();

        $this->db->insert('order_riwayat_bayar', $data_simpan);
        $this->db->update('order', $data_update, array('order_id' => $order_id));

        if ($this->db->trans_status() === false) {
            $this->db->trans_rollback();
            return false;
        } else {
            $this->db->trans_commit();
            return true;
        }
    }

    public function get_order_data_by_id($order_id)
    {
        $sql = $this->db->select('o.order_id, o.cabang_id, o.no_order, o.nama_pembeli, o.tanggal_order, o.alamat, o.status_pengiriman, o.status_pembayaran, o.total_biaya, o.status_pembayaran, o.diskon, o.transport')
        ->from('order o')
        ->where('o.order_id', $order_id)
        ->get();

        if ($sql->num_rows() > 0) {
            $result = $sql->row_array();
            $sql->free_result();
            return $result;
        } else {
            return array();
        }
    }

    public function get_order_detail_by_id($order_id)
    {
        $sql = $this->db->select('od.detail_id, CAST(od.jumlah AS INT) AS jumlah, CAST(od.harga AS INT) AS harga, CAST(od.jumlah_terkirim AS INT) AS jumlah_terkirim, b.nama_barang, od.jenis_pengiriman, od.status_pengiriman')
        ->from('order_detail od')
        ->join('barang b', 'b.barang_id = od.barang_id', 'left')
        ->where('od.order_id', $order_id)
        ->get();

        if ($sql->num_rows() > 0) {
            $result = $sql->result_array();
            $sql->free_result();
            return $result;
        } else {
            return array();
        }
    }

    public function get_total_pembayaran($order_id)
    {
        $sql = $this->db->select('SUM(CAST(orb.nominal AS INT)) AS pembayaran')
        ->from('order_riwayat_bayar orb')
        ->where('orb.order_id', $order_id)
        ->get();

        if ($sql->num_rows() > 0) {
            $result = $sql->row_array();
            $sql->free_result();
            return $result['pembayaran'];
        } else {
            return 0;
        }
    }

    public function simpan_ubah_order($order = null, $order_detail = null, $order_id)
    {
        $this->db->trans_begin();

        $this->ubah_data('order', 'order_id', $order_id, $order);
        $this->db->update_batch('order_detail', $order_detail, 'detail_id');

        // if (!empty($pembayaran)) {
        //     $this->tambah_data('order_riwayat_bayar', $pembayaran);
        // }

        if ($this->db->trans_status() === false) {
            $this->db->trans_rollback();
            return false;
        } else {
            $this->db->trans_commit();
            return true;
        }
    }
}
