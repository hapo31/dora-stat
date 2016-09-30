<?php
class dao extends CI_Model {

    public function __construct(){
        parent::__construct();
        $this->load->database();
    }
    
    public function days($from, $to) {
        $this->db->select('*');
        $this->db->where('date >', $from);
        $this->db->where('date <', $to);

        return $this->db->get('daily')->result_array();
    }
}
?>