<?php

class User extends Portal_admin
{

    public $form_conf = array(
        array('field' => 'username', 'label' => 'Username', 'rules' => 'required|max_length[45]|strip_tags|trim'),
        array('field' => 'nama_lengkap', 'label' => 'Nama Lengkap', 'rules' => 'required|max_length[100]|strip_tags|trim'),
        array('field' => 'status', 'label' => 'Status', 'rules' => 'required|max_length[11]|strip_tags|trim'),
    );

    public function __construct()
    {
        parent::__construct();
        $this->load->model('m_user');
    }

    public function index()
    {

        $this->_set_page_role('r');

        // load select2
        // $this->load_css('assets/js/plugins/select2/css/select2.min.css');
        // $this->load_js('assets/js/plugins/select2/js/select2.min.js');

        $data['rs_cabang'] = $this->m_user->get_list_cabang();
        $data['rs_group']  = $this->m_user->get_list_group();

        parent::display('index', $data, 'footer_index');
    }

    public function get_list_user()
    {
        $this->_set_page_role('r');

        if (!$this->input->is_ajax_request()) {
            show_404();
        }

        $rs_user = $this->m_user->get_list_user($this->com_user['user_id']);
        return $this->output->set_output(json_encode($rs_user));
    }

    public function tambah()
    {
        $this->_set_page_role('c');

        $data['rs_cabang'] = $this->m_user->get_list_cabang();
        $data['rs_group']  = $this->m_user->get_list_group();

        parent::display('tambah', $data, 'footer_tambah');
    }

    public function simpan()
    {
        $this->_set_page_role('c');

        if (!$this->input->is_ajax_request()) {
            show_404();
        }

        // load form validation
        $this->load->library('form_validation');

        // cek username sudah digunakan atau belum
        if ($this->m_user->user_is_exist('username', $this->input->post('username', true))) {
            $this->form_validation->set_error_message('username', 'Username sudah digunakan.  Silakan masukkan username lain.');
        }

        // load form validation
        // $this->load->library('form_validation');
        $this->form_validation->set_error_delimiters('', '<br/>');
        $this->form_validation->set_rules($this->form_conf);
        $this->form_validation->set_rules('password', 'Password', 'required');
        $this->form_validation->set_rules('repassword', 'Retype Password', 'required|matches[password]');

        // run validation
        if ($this->form_validation->run($this) == false) {
            $data['pesan']  = validation_errors();
            $data['status'] = false;
            return $this->output->set_output(json_encode($data));
        }

        $this->load->library('uuid');
        $userid               = str_replace(',', '.', microtime(true));
        $userid               = explode('.', $userid);
        $save['user_id']      = $userid[0];
        $save['cabang_id']    = $this->input->post('cabang_id');
        $save['username']     = $this->input->post('username', true);
        $save['kata_sandi']   = password_hash($this->config->item('encryption_key') . $this->input->post('password', true), PASSWORD_BCRYPT);
        $save['nama_lengkap'] = $this->input->post('nama_lengkap', true);
        // $save['email']         = $this->input->post('email', true);
        $save['status']        = $this->input->post('status', true);
        $save['registered_by'] = $this->com_user['user_id'];
        $save['mdd']           = date('Y-m-d H:i:s');

        $user_group['user_id']  = $save['user_id'];
        $user_group['group_id'] = $this->input->post('group_id');
        $user_group['default']  = 1;

        if ($this->m_user->tambah_user($save, $user_group) === false) {
            $eror          = $this->User->get_db_error();
            $out['status'] = false;
            $out['pesan']  = 'Data gagal disimpan. Eror kode : ' . $eror['code'];
        } else {
            $out['status'] = true;
            $out['pesan']  = 'Data berhasil disimpan.';
        }
        $this->output->set_content_type('application/json')->set_output(json_encode($out));
    }

    public function edit($user_id = null)
    {
        if (empty($user_id)) {
            redirect('user');
        }

        // set permission
        $this->_set_page_role('u');

        $data['user']   = $this->m_user->get_detail_data($user_id);
        $data['rs_cabang'] = $this->m_user->get_list_cabang();
        $data['rs_group']  = $this->m_user->get_list_group();

        parent::display('edit', $data, 'footer_edit');
    }

    public function update_process()
    {
        $this->_set_page_role('u');

        if (!$this->input->is_ajax_request()) {
            show_404();
        }

        // load form validation
        $this->load->library(array('form_validation'));

        if ($this->m_user->user_is_exist('username', $this->input->post('username', true), $this->input->post('user_id'))) {
            $this->form_validation->set_error_message('username', 'Username sudah digunakan.  Silakan masukkan username lain.');
        }

        $this->form_validation->set_rules('group_id', 'Group name', 'required');
        if ($this->input->post('password') != '') {
            $this->form_validation->set_rules('password', 'Password', 'required');
            $this->form_validation->set_rules('repassword', 'Retype Password', 'required|matches[password]');
        }

        // run validation
        if ($this->form_validation->run($this) == false) {
            $data['pesan']  = validation_errors();
            $data['status'] = false;
            return $this->output->set_output(json_encode($data));
        }

        // jika password diisi
        if ($this->input->post('password') != '') {
            $save['kata_sandi'] = password_hash($this->config->item('encryption_key') . $this->input->post('password'), PASSWORD_BCRYPT);
        }

        //ubah data group
        $save_g = $this->input->post('group_id');

        $save['nama_lengkap'] = $this->input->post('nama_lengkap');
        $save['username'] = $this->input->post('username');
        $save['cabang_id'] = $this->input->post('cabang_id');
        // ubah status
        $save['status'] = $this->input->post('status');
        $save['mdd']    = date('Y-m-d H:i:s');

        if ($this->m_user->ubah_user($save, $save_g, $this->input->post('user_id')) == false) {
            $eror             = $this->m_user->get_db_error();
            $result['status'] = false;
            $result['pesan']  = 'Data gagal diubah. Eror kode : ' . $eror['code'];
        } else {
            $result['status'] = true;
            $result['pesan']  = 'Data berhasil diubah.';
        }

        $this->output->set_content_type('application/json')->set_output(json_encode($result));
    }

    public function hapus_user()
    {
        // set permission
        $this->_set_page_role('d');

        // validasi hanya request lewat ajax
        if (!$this->input->is_ajax_request()) {
            show_404();
        }

        // parameter
        $hapus['user_id'] = $this->input->post('data_id');
        if ($this->m_user->hapus_data('sys_user', $hapus)) {
            $result['status'] = true;
            $result['pesan']  = 'Data berhasil dihapus.';
        } else {
            // update is_deleted to 1
            if ($this->m_user->ubah_data('sys_user', 'user_id', $this->input->post('data_id'), array('is_deleted' => 1))) {
                $result['status'] = true;
                $result['pesan']  = 'Data berhasil dihapus.';
            } else {
                $result['status'] = false;
                $result['pesan']  = 'Data gagal dihapus. Eror kode : ' . $eror['code'];
            }
        }
        return $this->output->set_output(json_encode($result));
    }
}