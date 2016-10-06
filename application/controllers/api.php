<?php 

class api extends CI_Controller {

    public function index(){
        $this->output
                ->set_content_type('application/json')
                ->set_output(json_encode( array(
                    "/api/stat" => "get statics doraemon's exposure"
                ) ));
    }

    public function stat() {
        $fromDate = 0;
        $toDate = 0;

        if( !is_null($this->input->get('date')) ) {
            $day = new Datetime($this->input->get('date'));
            $fromDate = $day->format("Y-m")."-01 00:00:00";
            $toDate = $day->format("Y-m-t")." 23:59:59";
        } else if(
            !is_null($this->input->get('from')) && 
            !is_null($this->input->get('to'))
        ){
            $from = new Datetime($this->input->get('from'));
            $to   = new Datetime($this->input->get('to'));

            $fromDate = $from->format("Y-m")."-01 00:00:00";
            $toDate   = $to->format("Y-m-t")." 23:59:59";
        }
        else {
            $this->output->set_status_header(400);
            $this->output
                ->set_content_type('application/json')
                ->set_output(json_encode(array('error' => "require paramerter 'date' or ('from','to') ")));
            return ;
        }
        // $this->output
        //         ->set_content_type('application/json')
        //         ->set_output(json_encode( array($fromDate, $toDate) ));

        if(is_null($fromDate) || is_null($toDate)){
            $this->output->set_status_header(400);
            $this->output
                ->set_content_type('application/json')
                ->set_output(json_encode(array('error' => 'date format is null or invalid.')));
            return ;
        }
        $result = $this->dao->stat_boron_count($fromDate, $toDate);
        $this->output
                ->set_content_type('application/json')
                ->set_output(json_encode( $result ));
     
    }
}

?>