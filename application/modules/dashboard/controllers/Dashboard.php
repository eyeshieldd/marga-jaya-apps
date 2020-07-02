<?php


class Dashboard extends Portal_admin
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('m_dashboard');
    }

    public function index()
    {
        $this->_set_page_role('r');

        // get list menu
        $data['rs_menu'] = $this->m_dashboard->get_list_menu($this->com_user['group_id'], 0, $this->portal_id);

        // 1. chart pcs
        $chart_pcs['rs_chart'] = $this->m_dashboard->get_chart_pcs();

        foreach ($chart_pcs['rs_chart'] as $key => $value) {
            $data['nama_barang'][] = substr($value['nama_barang'], 0, 20);
            $data['permintaan'][] = $value['permintaan'];
            $data['stok'][] = $value['stok'];
        }

        // echo "<pre/>";
        // print_r($chart_pcs);
        // exit();

        // 2. chart m2
        $chart_m2['rs_chart'] = $this->m_dashboard->get_chart_m2();

        foreach ($chart_m2['rs_chart'] as $key => $value) {
            $data['nama'][] = substr($value['nama_barang'], 0, 20);
            $data['permintaan_m2'][] = $value['permintaan'];
            $data['stok_m2'][] = $value['nilai_konversi'];
        }

        /*echo "<pre/>";
        print_r($chart_m2);
        exit();*/

        parent::display('index', $data);
    }
}
