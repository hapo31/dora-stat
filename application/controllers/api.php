<?php 

class api extends CI_Controller {

    public function weekly() {
        $timestamp = $this->input->get("timestamp");
        
        if(is_null($timestamp) && !is_int($timestamp)){
            $this->output->set_status_header(400);
            $this->output
                ->set_content_type('application/json')
                ->set_output(json_encode(array('error' => 'date format is invalid.')));
            return ;
        }

        //Javascriptのnow()はミリ秒を返すので秒数に変換
        $timestamp /= 1000;
        
        try {
            $from = date('c', $timestamp);
            $to   = date('c', $timestamp + 604800);    
        } catch (Exception $e) {
            $this->output->set_status_header(400);
            $this->output
                ->set_content_type('application/json')
                ->set_output(json_encode(array('error' => 'date format is invalid.')));
            return;
        }
        $result = $this->dao->days($from, $to);

        $this->output
             ->set_content_type('application/json')
             ->set_output(json_encode($result));
    }
}

?>