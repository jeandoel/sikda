<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
require_once 'include/xmlelement.php';
class c_master_user_group extends CI_Controller {
	public function index()
	{
		$this->load->view('masterUsergroup/v_master_user_group');
	}
	
	public function masterusergrouppopup()
	{
		$data['id_caller'] = $this->input->get('id_caller')?$this->input->get('id_caller',TRUE):null;
		$this->load->view('masterUsergroup/v_master_user_group_popup',$data);
	}
	
	public function masterusergroupxml()
	{
		$this->load->model('m_master_user_group');
		
		$limit = $this->input->post('rows')?$this->input->post('rows'):10;
		
		$paramstotal=array(
					'dari'=>$this->input->post('dari'),
					'sampai'=>$this->input->post('sampai'),
					'group'=>$this->input->post('group')
					);
					
		$total = $this->m_master_user_group->totalMasterusergroup($paramstotal);
		
		$total_pages = ($total >0)?ceil($total/$limit):1;
		$page = $this->input->post('page')?$this->input->post('page'):1;
		if ($page > $total_pages) $page=$total_pages;
		$start = $limit*$page - $limit;
		
		$params=array(
					'start'=>$start,
					'limit'=>$limit,
					'sort'=>$this->input->post('asc'),
					'dari'=>$this->input->post('dari'),
					'sampai'=>$this->input->post('sampai'),
					'group'=>$this->input->post('group')
					);
					
		$result = $this->m_master_user_group->getMasterusergroup($params);		
		
		header("Content-type: text/xml");
		echo writeXmlElement::writeXml3('rows', $result['data'], $total,$page,$total_pages);
	}
	
	public function add()
	{
		$this->load->view('masterUsergroup/v_master_user_group_add');
	}
	
	public function addprocess()
	{
		$this->load->library('form_validation');

		$val = $this->form_validation;
		$val->set_rules('idgroup', 'Id Group', 'trim|required|xss_clean');
		$val->set_rules('namagroup', 'Nama Group', 'trim|required|xss_clean');
		$val->set_rules('deskripsi', 'Deskripsi');
		
		$val->set_message('required', "Silahkan isi field \"%s\"");

		if ($val->run() == FALSE)
		{
			$val->set_error_delimiters('<div style="color:white">', '</div>');
			die(validation_errors());
		}
		else
		{						
			$db = $this->load->database('sikda', TRUE);
			$db->trans_begin();
			$dataexc = array(
				'group_id' => $val->set_value('idgroup'),
				'group_name' => $val->set_value('namagroup'),
				'description' => $val->set_value('deskripsi'),
				'ntgl_group' => $this->input->post('tglgroup',TRUE),
				'ninput_oleh' => $this->session->userdata('nusername'),
				'ninput_tgl' => date('Y-m-d H:i:s')
			);
			
			$db->insert('user_group', $dataexc);
			
			if ($db->trans_status() === FALSE)
			{
				$db->trans_rollback();
				die('Maaf Proses Insert Data Gagal');
			}
			else
			{
				$db->trans_commit();
				die('OK');
			}
		}
	}
	
	public function editprocess()
	{
		$id = $this->input->post('id',TRUE);		
		$this->load->library('form_validation');

		$val = $this->form_validation;
		$val->set_rules('idgroup', 'Id Group', 'trim|required|xss_clean');
		$val->set_rules('namagroup', 'Nama Group', 'trim|required|xss_clean');
		$val->set_rules('deskripsi', 'Deskripsi');

		if ($val->run() == FALSE)
		{
			$val->set_error_delimiters('<div style="color:white">', '</div>');
			die(validation_errors());
		}
		else
		{						
			$db = $this->load->database('sikda', TRUE);
			$db->trans_begin();
			$dataexc = array(
				'group_id' => $val->set_value('idgroup'),
				'group_name' => $val->set_value('namagroup'),
				'description' => $val->set_value('deskripsi'),
				'ntgl_group' => $this->input->post('tglgroup',TRUE),
				'nupdate_oleh' => $this->session->userdata('nusername'),
				'nupdate_tgl' => date('Y-m-d H:i:s')
			);			
			
			$db->where('group_id',$id);
			$db->update('user_group', $dataexc);
			
			if ($db->trans_status() === FALSE)
			{
				$db->trans_rollback();
				die('Maaf Proses Insert Data Gagal');
			}
			else
			{
				$db->trans_commit();
				die('OK');
			}
		}
	}
	
	public function edit()
	{
		$id=$this->input->get('id')?$this->input->get('id',TRUE):null;
		$db = $this->load->database('sikda', TRUE);
		$val = $db->query("select * from user_group where group_id = '".$id."'")->row();
		$data['data']=$val;		
		$this->load->view('masterUsergroup/v_master_user_group_edit',$data);
	}
	
	public function menu()
	{
		
		$this->load->database();
		header("Content-type: text/xml");
		echo '<rows>
				<page>1</page>
				<total>1</total>
				<records>1</records>';
		$id = $_GET['id'];
		/* $query = $this->db->query(" SELECT a.* FROM(
										SELECT h.group, m.* FROM `config_menu` AS m 
										LEFT JOIN config_hak_akses AS h ON h.id_menu = m.col1
									) a
									WHERE a.group = '".$id."'
									OR a.group IS NULL"); */
		$account = $this->db->query(" SELECT * FROM `config_hak_akses` WHERE `group` = '".$id."'");
		
		$arraymenuaccount = array();
		foreach ($account->result_array() as $row)
		{
		   //echo $row['group'];
		   //echo $row['id_menu'];
		   $arraymenuaccount[$row['id_menu']] = $row['group'];
		}
		
		$query = $this->db->query(" SELECT * FROM `config_menu`");
									
		foreach ($query->result_array() as $row){
			//$row['MyCheckBox'] = (strlen($row['group']) > 0)?'True':'False';
			
			$row['MyCheckBox'] = strlen($arraymenuaccount[$row['id_menu']]) ?'True':'False';
			echo '<row>
					<cell>'.$row['id_menu'].'</cell>
					<cell>'.$row['title'].'</cell>
					<cell>'.$row['link'].'</cell>
					<cell>'.$row['MyCheckBox'].'</cell>
					<cell>'.$row['level'].'</cell>
					<cell>'.$row['parent'].'</cell>
					<cell>0</cell>
					<cell>true</cell>
					<cell>true</cell>
					<cell>'.$row['col9'].'</cell>
					</row>';
		}
		echo '</rows>';
	}
	
	function add_hak_akses_user(){
		//print_r($_GET);
		$id = $_GET['id'];
		$idmenu = $_GET['idmenu'];
		$state = $_GET['state'];
		
		$db = $this->load->database('sikda', TRUE);
		
		$data = array(
				   'group' => $id,
				   'id_menu' => $idmenu
				);
				
		if($state == 'false'){
			echo "DELETE";
			$db->delete('config_hak_akses', $data); 
		}
		if($state == 'true'){
			$row = $db->query("SELECT * FROM  `config_hak_akses` WHERE `group` = '".$id."' AND `id_menu` = '".$idmenu."'")->row();
			
			if(isset($row->id)){
				echo "Update";
				$db->where('group', $id);
				$db->where('id_menu', $idmenu);
				$db->update('config_hak_akses', $data); 
			}else{
				echo "Input";
				$db->insert('config_hak_akses', $data); 
			}
		}
	}
	
	public function delete()
	{
		$id=$this->input->post('id')?$this->input->post('id',TRUE):null;
		$db = $this->load->database('sikda', TRUE);
		if($db->query("delete from user_group where group_id = '".$id."'")){
			die(json_encode('OK'));
		}else{
			die(json_encode('FAIL'));
		}
	}
	
	public function detail()
	{
		$id=$this->input->get('id')?$this->input->get('id',TRUE):null;
		$db = $this->load->database('sikda', TRUE);
		$val = $db->query("select * from user_group where group_id = '".$id."'")->row();
		$data['data']=$val;
		$this->load->view('masterUsergroup/v_master_user_group_detail',$data);
	}
	
}

/* End of file masteruser.php */
/* Location: ./application/controllers/masteruser.php */