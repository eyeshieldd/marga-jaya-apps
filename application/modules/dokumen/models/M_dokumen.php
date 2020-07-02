<?php

require_once APPPATH . 'models/M_model_base.php';

class M_dokumen extends M_model_base{

    public function __construct() {
        parent::__construct();
    }

    public function get_list_dokumen()
    {
        // select data
        $rs_data = $this->db->select('d.dokumen_id, d.nama_dokumen, c.nama_cabang')
            ->from('dokumen d')
            ->join('cabang c', 'd.cabang_id = c.cabang_id', 'left');

        /*echo "<pre/>";
        print_r($rs_data->get()->result_array());
        exit();*/

        // get total records data
        $option['recordsTotal'] = $rs_data->count_all_results('', false);

        // searching function should be here
        if (!empty($this->input->post('dokumen'))) {
            $rs_data->like('d.nama_dokumen', $this->input->post('dokumen'), 'both');
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
            $tombol = '<div class="text-center">
                    <a class="btn btn-sm btn-alt-secondary" data-toggle="tooltip" title="Download Data" href="' . base_url() . 'dokumen/download/' . $vdata['dokumen_id'] . '"><i class="fa fa-download"></i></a>
                    <button type="button" class="btn btn-sm btn-alt-danger hapus-data" data-toggle="tooltip" title="Hapus Data" data-id="'. $vdata['dokumen_id'] .'"><i class="fa fa-trash"></i> </button></div>';                   

            $vdata                      = xss_clean($vdata);
            $vdata['tombol']            = $tombol;
            $vdata['no']                = $no;

            $rs_data_[] = $vdata;
            $no++;
        }
        $option['data'] = $rs_data_;
        return $option;
    }

    // ambil data cabang
    public function get_list_cabang()
    {
        $sql = $this->db->select('cabang_id, nama_cabang')
                ->from('cabang')
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

    public function get_detail_dokumen($params) {
        $sql = 'SELECT dokumen_id, nama_dokumen, file_url FROM dokumen WHERE dokumen_id = ?';

        $query = $this->db->query($sql, $params);
        if ($query->num_rows() > 0) {
            $result = $query->row_array();
            $query->free_result();
            return $result;
        } else {
            return array();
        }
    }

    public function hapus($id)
    {
        if (empty($id)) {
            return false;
        }

        // get id 
        $q = $this->db->select('file_url')
                ->from('dokumen')
                ->where('dokumen_id', $id)
                ->get();

        $result = $q->row_array();

        /*echo "<pre/>";
        print_r($result);
        exit();*/

        if (empty($result['file_url'])) {
            return false;
        }
        if (!empty($result['file_url'] && is_file($result['file_url']))) {
            unlink($result['file_url']);
        }

        $this->hapus_data('dokumen', array('dokumen_id' => $id));

        return true;
    }
}
