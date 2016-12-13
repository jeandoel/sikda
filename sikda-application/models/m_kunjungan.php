<?php
class M_Kunjungan extends CI_Model {

  private $db;
  public function __construct()
  {
	parent::__construct();
	$this->db = $this->load->database('sikda', TRUE);
  }
  public function getNextKodeKunjungan($string, $last_identifier){
  	$empty=false;
  	$loop_limit = 30;
  	$loop_count =0;
  	while(!$empty && $loop_count<$loop_limit){
  		$code = $string.$last_identifier;
  		$this->db->select()->from('kunjungan');
  		$this->db->where('KD_KUNJUNGAN',$code);
  		$result = $this->db->get()->row();
  		if(empty($result)){
  			$empty=true;
  			return $code;
  		}else{
  			$last_identifier++;
  			$loop_count++;
  		}
  	}
  	return null;
  }
}
