<?php
class dao extends CI_Model {

    public function __construct(){
        parent::__construct();
        $this->load->database();
    }
    
    public function days($from, $to) {
        $this->db->select('count(is_boron = 1) as `count`, tweet');
        $this->db->where('date >', $from);
        $this->db->where('date <', $to);

        return $this->db->get('daily')->result_array();
    }
//         SELECT 
// DATE_FORMAT(date, "%Y/%m") as `date` , count(*) as tweets , count(is_boron = 1) as boron_count
// FROM `daily`
// GROUP BY DATE_FORMAT(date, "%Y/%m") 
    public function stat_boron_count($from, $to) {
        $sql = <<<EOD
select DATE_FORMAT(date, "%Y/%m") as `date`, count(*) as tweet_count ,count(is_boron = 1) as boron_count
from daily
where is_boron = 1 and
date > ? and date < ? 
group by DATE_FORMAT(date, "%Y/%m")
EOD;
        return $this->db->query($sql, array($from, $to) )->result_array();

        // $this->db->select('DATE_FORMAT(date, "%Y/%m") as `date`, count(*) as boron_count');
        // $this->db->where('is_boron', 1);
        // $this->db->where('date >', $from);
        // $this->db->where('date <', $to);
        
        // return $this->db->get('daily')->result_array();
    }

}
?>