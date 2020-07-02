<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Number_generator
{
  protected $table_name;
  protected $field_name;
  protected $generate_number_format_id;
  protected $generate_number_format;
  protected $stored_format_table_name;
  protected $stored_format_table_id;
  protected $stored_format_table_id_field;
  protected $max_no;
  protected $condition = [];

  public function __construct($parameter = null)
  {
    // Assign the CodeIgniter super-object
    $this->CI = &get_instance();

    $this->CI->load->database('', true);
  }

  public function set_table_name($table_name)
  {
    $this->table_name = $table_name;
    return $this;
  }

  public function get_table_name(){
    return $this->table_name;
  }

  public function get_stored_format_table_name(){
    return $this->stored_format_table_name;
  }

  public function get_stored_format_table_id(){
    return $this->stored_format_table_id;
  }

  public function get_stored_format_table_id_field(){
    return $this->stored_format_table_id_field;
  }

  public function get_field_name()
  {
    return $this->field_name;
  }

  /**
   * Fungsi untuk pointing tabel yang digunakan untuk menyimpan
   * format number yang akan digenerate
   * 
   * @param [type] $table_target    [description]
   * @param [type] $target_id_field [description]
   * @param [type] $target_id       [description]
   */
  public function set_stored_format_table_name($table_target, $target_id_field, $target_id)
  {
    $this->stored_format_table_name     = $table_target;
    $this->stored_format_table_id       = $target_id;
    $this->stored_format_table_id_field = $target_id_field;
    return $this;
  }

  public function set_field_name($field_name)
  {
    $this->field_name = $field_name;
    return $this;
  }

  public function where($field, $val)
  {
    $condition['field'] = $field;
    $condition['val']   = $val;
    $this->condition[]  = $condition;
    return $this;
  }

  public function get_number()
  {
    // kalau input nomor ada isinya ambil nilai dari post
    if (!empty($this->CI->input->post($this->field_name, true))) {
      return $this->CI->input->post($this->field_name, true);
    }

    // get number format
    $number_format = $this->get_generate_number_format();

    return $number_format['fix_prefix'] . ($this->get_max_no() + 1) . $number_format['fix_suffix'];
  }

  public function get_default_format_id()
  {
    $sql    = 'SELECT generate_number_format_id  FROM generate_number WHERE table_name = ?';
    $params = [$this->table_name];
    if (!empty($this->stored_format_table_name)) {
      $sql    = 'SELECT generate_number_format_id  FROM ' . $this->stored_format_table_name . ' WHERE ' . $this->stored_format_table_id_field . ' = ?';
      $params = [$this->stored_format_table_id];
    }
    $query = $this->CI->db->query($sql, $params);
    if ($query->num_rows() > 0) {
      $result = $query->row_array();
      $query->free_result();
      return $result['generate_number_format_id'];
    } else {
      return '';
    }
  }

  protected function get_max_no()
  {
    if (empty($this->max_no) && $this->max_no !== 0) {
      // Cek perubahan format
      $this->check_format_number();
      $max_no = $this->query_max_no($this->generate_number_format['fix_prefix'], $this->generate_number_format['fix_suffix']);

      // Cek Nomor di bulan sebelumnya
      while ((empty($max_no) || $max_no == null) AND $this->generate_number_format['month_no'] > 1) {
        $this->generate_number_format['month_no']--;
        $prefix = $this->get_fix_format($this->generate_number_format['prefix'], $this->generate_number_format['month_no']);
        $suffix = $this->get_fix_format($this->generate_number_format['suffix'], $this->generate_number_format['month_no']);
        $max_no = $this->query_max_no($prefix, $suffix);
      }

      if (empty($max_no) || $max_no == null) {
        $max_no       = 0;
        $this->max_no = $max_no;
      }
    } else {
      // jika request nomor lebih dari sekali
      $max_no = ++$this->max_no;
    }

    return $max_no;
  }

  protected function check_format_number()
  {
    if ($this->CI->input->post('generate_number_format_id', true) !== $this->CI->input->post('generate_number_format_id_origin', true)) {
      // format diganti
      // Stored format table khusus untuk accounting
      if (!empty($this->stored_format_table_name)) {
        $this->CI->db->where('id', $this->stored_format_table_id);
        $data['generate_number_format_id'] = $this->CI->input->post('generate_number_format_id', true);
        $this->CI->db->update($this->stored_format_table_name, $data);
      } else {
        $data['table_name']                = $this->table_name;
        $data['generate_number_format_id'] = $this->CI->input->post('generate_number_format_id', true);
        $this->CI->db->where('table_name', $this->table_name);
        $this->CI->db->update('generate_number', $data);
        // echo $this->CI->db->affected_rows();
        if ($this->CI->db->affected_rows() < 1) {
          $this->CI->db->insert('generate_number', $data);
        }
      }
    }
  }

  protected function query_max_no($prefix, $suffix)
  {
    // $number_format = $this->generate_number_format;
    // $prefix        = $number_format['fix_prefix'];
    // $suffix        = $number_format['fix_suffix'];
    $prefix_length = strlen($prefix);

    // print_r($number_format);

    $sql = "SELECT MAX(CONVERT(REPLACE(SUBSTRING($this->field_name, $prefix_length + 1), '$suffix', ''), UNSIGNED INTEGER)) max_no
            FROM $this->table_name";

    // $generate_number_format_id = !empty($this->CI->input->post('generate_number_format_id', true)) ? " = " . $this->CI->input->post('generate_number_format_id', true) : ' IS NULL';

    // $sql .= " WHERE generate_number_format_id $generate_number_format_id";

    $sql .= " WHERE $this->field_name LIKE '$prefix%'";
    $sql .= "AND $this->field_name LIKE '%$suffix'";
    $sql .= "AND REPLACE(SUBSTRING($this->field_name, $prefix_length + 1), '$suffix', '') REGEXP '^[0-9]+$'";


    // khusus tabel transaksi akuntansi
    if ($this->stored_format_table_name == 'acc_transaction_type') {
      $sql .= ' AND acc_transaction_type_id=' . $this->stored_format_table_id;
    }

    if (!empty($this->condition)) {
      $condition = '';
      foreach ($this->condition as $key => $value) {
        $condition .= ' AND ' . $value['field'] . ' = "' . $value['val'] . '"';
      }
      $sql .= $condition;
    }

    $query = $this->CI->db->query($sql);

    if ($query->num_rows() > 0) {
      $result = $query->row_array();
      $query->free_result();
      $this->max_no = $result['max_no'];
      return $result['max_no'];
    } else {
      return array();
    }
  }

  protected function get_generate_number_format()
  {
    $generate_number_format_id = $this->CI->input->post('generate_number_format_id', true);

    $data = $this->CI->db
      ->get_where('generate_number_format', array('id' => $generate_number_format_id))
      ->row_array();


      if (!empty($data)) {
        // Reformat prefix
        $data['month_no']   = date('n');
        $data['fix_prefix'] = $this->get_fix_format($data['prefix'], $data['month_no']);
        $data['fix_suffix'] = $this->get_fix_format($data['suffix'], $data['month_no']);
      }


    $this->generate_number_format = $data;

    return $data;
  }

  protected function get_fix_format($string, $month_no = null){
    if (empty($string)) {
      return '';
    }
    if (empty($month_no)) {
      $month_no = date('n');
    }
    $string = str_replace('[M]', romanic_number($month_no), $string);
    $string = str_replace('[Y]', date('Y'), $string);

    return $string;
  }
}
