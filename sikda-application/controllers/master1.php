<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
require_once 'include/xmlelement.php';
class Master1 extends CI_Controller {
	public function index()
	{
		$this->load->view('master1');
	}
	
	public function master1popup()
	{
		$data['id_caller'] = $this->input->get('id_caller')?$this->input->get('id_caller',TRUE):null;
		$this->load->view('master1popup',$data);
	}
	
	public function master1popup2()
	{
		$data['id_caller'] = $this->input->get('id_caller')?$this->input->get('id_caller',TRUE):null;
		$this->load->view('master1popup2',$data);
	}
	
	public function master1xml()
	{
		$this->load->model('master1_model');
		
		$limit = $this->input->post('rows')?$this->input->post('rows'):10;
		
		$paramstotal=array(
					'dari'=>$this->input->post('dari'),
					'sampai'=>$this->input->post('sampai')
					);
					
		$total = $this->master1_model->totalMaster1($paramstotal);
		
		$total_pages = ($total >0)?ceil($total/$limit):1;
		$page = $this->input->post('page')?$this->input->post('page'):1;
		if ($page > $total_pages) $page=$total_pages;
		$start = $limit*$page - $limit;
		
		$params=array(
					'start'=>$start,
					'limit'=>$limit,
					'sort'=>$this->input->post('asc'),
					'dari'=>$this->input->post('dari'),
					'sampai'=>$this->input->post('sampai')
					);
					
		$result = $this->master1_model->getMaster1($params);		
		
		header("Content-type: text/xml");
		echo writeXmlElement::writeXml3('rows', $result['data'], $total,$page,$total_pages);
	}
	
	public function add()
	{
		$this->load->view('master1add');
	}
	
	public function addprocess()
	{
		$this->load->library('form_validation');

		$val = $this->form_validation;
		$val->set_rules('column1', 'Column Satu', 'trim|required|xss_clean');
		$val->set_rules('column2', 'Column Dua', 'trim|required|xss_clean');
		$val->set_rules('column3', 'Column Tiga', 'trim|required|xss_clean');
		
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
				'ncolumn1' => $val->set_value('column1'),
				'ncolumn2' => $val->set_value('column2'),
				'ncolumn3' => $val->set_value('column3'),
				'ntgl_master1' => date("Y-m-d", strtotime($this->input->post('tglmaster1',TRUE))),
				'ninput_oleh' => $this->session->userdata('nusername'),
				'ninput_tgl' => date('Y-m-d H:i:s')
			);
			
			$db->insert('tbl_master1', $dataexc);
			
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
		$val->set_rules('column1', 'Column Satu', 'trim|required|xss_clean');
		$val->set_rules('column2', 'Column Dua', 'trim|required|xss_clean');
		$val->set_rules('column3', 'Column Tiga', 'trim|required|xss_clean');

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
				'ncolumn1' => $val->set_value('column1'),
				'ncolumn2' => $val->set_value('column2'),
				'ncolumn3' => $val->set_value('column3'),
				'ntgl_master1' => date("Y-m-d", strtotime($this->input->post('tglmaster1',TRUE))),
				'nupdate_oleh' => $this->session->userdata('nusername'),
				'nupdate_tgl' => date('Y-m-d H:i:s')
			);			
			
			$db->where('nid_master1',$id);
			$db->update('tbl_master1', $dataexc);
			
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
		$val = $db->query("select * from tbl_master1 where nid_master1 = '".$id."'")->row();
		$data['data']=$val;		
		$this->load->view('master1edit',$data);
	}
	
	public function delete()
	{
		$id=$this->input->post('id')?$this->input->post('id',TRUE):null;
		$db = $this->load->database('sikda', TRUE);
		if($db->query("delete from tbl_master1 where nid_master1 = '".$id."'")){
			die(json_encode('OK'));
		}else{
			die(json_encode('FAIL'));
		}
	}
	
	public function detail()
	{
		$id=$this->input->get('id')?$this->input->get('id',TRUE):null;
		$db = $this->load->database('sikda', TRUE);
		$val = $db->query("select * from tbl_master1 where nid_master1 = '".$id."'")->row();
		$data['data']=$val;
		$this->load->view('master1detail',$data);
	}
	
	public function getBarChart()
	{			
		require_once ('include/jpgraph/src/jpgraph.php');
		require_once ('include/jpgraph/src/jpgraph_bar.php');
		
		$data1y=array(34,55,67,89,78,34,23,45,76,87,23,12);
		$data2y=array(20,35,35,55,53,23,23,40,70,80,20,7);
		$data3y=array(14,20,22,25,15,11,0,5,6,7,3,5);

		$graph = new Graph(985,165,'auto');	
		$graph->SetScale("textlin");

		$year=array('January','Februari','Maret','April','Mei','Juni','Juli','Agustus','September','Oktober','November','Desember');
		$graph->xaxis->SetTickLabels($year);

		$graph->SetShadow();
		$graph->img->SetMargin(30,30,25,40);

		$b1plot = new BarPlot($data1y);
		$b1plot->SetFillColor("orange");
		$b1plot->SetLegend('Data 1');
		$b2plot = new BarPlot($data2y);
		$b2plot->SetFillColor("blue");
		$b2plot->SetLegend('Data 2');
		$b3plot = new BarPlot($data3y);
		$b3plot->SetFillColor("yellow");
		$b3plot->SetLegend('Data 3');

		$graph->legend->Pos(0.03,0.05,"top","center");

		$gbplot = new GroupBarPlot(array($b1plot,$b2plot,$b3plot));

		$graph->Add($gbplot);
		$graph->Stroke();
	}
	
	public function getPieChart()
	{			
		require_once ('include/jpgraph/src/jpgraph.php');
		require_once ('include/jpgraph/src/jpgraph_pie.php');
		require_once ('include/jpgraph/src/jpgraph_pie3d.php');
		
		$data = array(11,38,3,15,9,5);

		$graph = new PieGraph(300,115);
		$graph->SetShadow();

		$p1 = new PiePlot3D($data);
		$p1->SetSize(0.5);
		$p1->SetCenter(0.35,0.5);
		$p1->SetLegends(array("2007","2008","2009","2010","2011","2012"));

		$graph->legend->Pos(0.1,0.5,"midle","center");
		$graph->legend->SetLayout(LEGEND_VERT);

		$graph->Add($p1);
		$graph->Stroke();
	}
	
	public function getPieChart2()
	{			
		require_once ('include/jpgraph/src/jpgraph.php');
		require_once ('include/jpgraph/src/jpgraph_pie.php');
		require_once ('include/jpgraph/src/jpgraph_pie3d.php');
		
		$data = array(11,38,3);

		$graph = new PieGraph(300,115);
		$graph->SetShadow();

		$p1 = new PiePlot3D($data);
		$p1->SetSize(0.5);
		$p1->SetCenter(0.35,0.5);
		$p1->SetLegends(array("Data 1","Data 2","Data 3"));

		$graph->legend->Pos(0.1,0.5,"midle","center");
		$graph->legend->SetLayout(LEGEND_VERT);

		$graph->Add($p1);
		$graph->Stroke();
	}
	
}

/* End of file master1.php */
/* Location: ./application/controllers/master1.php */