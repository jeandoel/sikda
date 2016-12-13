<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
require_once 'include/xmlelement.php';
class c_modul_library extends MX_Controller {

	public $urldownload = 'http://teknokayo.co.id/sikda/listmodul';
	
	public function index(){
		$this->load->view('modul_library/c_modul_library');
	}
	
	public function modul_libraryxml()
	{
		$this->load->helper('file');
		$path = FCPATH.APPPATH."logs";
		$dir = get_dir_file_info($path, TRUE);
		
		$data['data'] = array();
		$listmodul = array();
		foreach($dir as $row){		
			if($row['name'] == 'index.html') continue;			
			
			$fileabout 		= FCPATH.APPPATH."logs/".$row['name']."/".$row['name']."_about.xml";
			if(!file_exists($fileabout)){
				continue;
			}
			$contentabout 	= file_get_contents($fileabout);
			$xmlcontent 	= new XmlToArray($contentabout);
			$array 			= $xmlcontent->my_xml2array();			
			$arraycell 		= $xmlcontent->arraygetvalue($array);			
			$about		= end($arraycell);
			
			
			$row['date'] = date('Y-m-d H:i:s', filemtime($row['server_path']));
			$listmodul[] = array('nid_modul'=>'1','app'=>$row['name'], 'size'=>$row['size'], 'date'=>$row['date'],'nid'=>$row['name'], 'version'=>$about['version']);
		}
		
		$content = file_get_contents($this->urldownload);  //$content = file_get_contents('http://localhost/sikda-forum/sikda-modul.xml');
		$xmlcontent = new XmlToArray($content);
		$array = $xmlcontent->my_xml2array();	
		$serverlistmodul = $xmlcontent->arraygetvalue($array);
		$newList = array();
		foreach($serverlistmodul as $row){
			$exist = FALSE;
			$doupdate = FALSE;
			foreach($listmodul as $row2){
				if( ($row['app'] == $row2['app']) && ($row['version'] > $row2['version']) ){
					$exist = TRUE;
					$doupdate = TRUE;
				}elseif( ($row['app'] == $row2['app']) && ($row['version'] <= $row2['version']) ){
					$exist = TRUE;
					$doupdate = FALSE;
				}
			}
			
			if(!$exist){
				$newList['install'][] = $row;
			}
			
			if($exist && $doupdate){
				$newList['doupdate'][] = $row;
			}
			
			if($exist && !$doupdate){
				$newList['hasupdate'][] = $row;
			}
		}
		
		
		$data['data'] = array();
		$action = $_GET['action'];
		switch($action){
			case 'doupdate':
				$data['data'] = $newList['doupdate'];
			break;
			case 'hasupdate':
				$data['data'] = $newList['hasupdate'];
			break;
			case 'install':
				$data['data'] = $newList['install'];
			break;
		}
		
		header("Content-type: text/xml");
		echo writeXmlElement::writeXml3('rows', $data['data']);
	}
	
	//preview
	public function prepare(){
		$linkfolder = $_GET['folder'];		
		$namefolder = explode('/',$linkfolder);
		$data['namefolder'] = end($namefolder);	
		$data['linkfolder'] = $linkfolder;	
		
		$this->load->view("modul_library/v_prepare",$data);
	}
	
	//step 1
	public function downloadzip(){		
		$this->load->helper('file');
		
		$linkfolder = $_GET['folder'];		
		$namefolder = explode('/', $linkfolder);

		$data['namefolder'] = end($namefolder);	
		$data['linkfolder'] = $linkfolder;			
		
		$data['log'] = "Read file Content " . end($namefolder) . "<br/>";
		$modulzip = file_get_contents($linkfolder);
		
		if ( ! write_file('./logs/'.end($namefolder), $modulzip)){
			 $data['log'] .= 'Unable to write the ' . end($namefolder) . "<br/>";
		}else{
			 $data['log'] .= 'File ' . end($namefolder) . ' Download Succes!' . '<br/>';
		}
		$this->load->view("modul_library/v_downloadzip",$data);
	}
	
	//step 2
	public function install(){
		$name = $_GET['namefile']; //$newlocation = $_POST['pathfolderdestination'];
		$data['namefolder'] = $_GET['namefile'];	
		
		$target_dir = "logs/";
		
		$data['log'] = '';
		if (!file_exists($target_dir)) {
			mkdir($target_dir, 0777, true);
			$data['log'] = "Created Directory " . $target_dir . "<br/>";
		}
		
		$error = FALSE;
		
		$data['log'] .= "Memulai Extract<br/>";
		if(!$error){
			$zip = new ZipArchive;
			if ($zip->open($target_dir.$name) === TRUE) {
				$zip->extractTo($target_dir);
				$zip->close();				
				$data['log'] .= "Extract Selesai<br/>";
				$error = false;
			} else {
				$data['log'] .= "Extract Gagal<br/>";
				$error = true;
			}
		}
		
		if(!$error){
			$data['log'] .= "Mempersiapkan Memindahkan file ke folder '".$name."'<br/>";	
			
			//prepare list file;
			$this->cpy($target_dir."sikda-puskesmas", FCPATH);
						
			//write list file			
			$namemodul = substr($name,0,-4);
			$namelistfile 	= FCPATH.APPPATH."/logs/".$namemodul."/".$namemodul."_listfile.xml";
			//kosongkan isi file
			write_file($namelistfile, ' ');
			
			//isi file
			writeXmlElement::writeXml5('rows', $this->list_file, $namelistfile);
			
			$data['log'] .= "Memindahkan file ke folder '".$name."' Sudah selesai<br/>";							
			delete_files(FCPATH."logs/sikda-puskesmas", TRUE);
			$data['log'] .= "Delete File temporary successfully <br/>";				
		}
		
		$data['log'] .= "<pre>".$this->logs."</pre>";				
		$this->load->view("modul_library/v_install",$data);
	}
	
	//step 3
	public function insert_menu(){
		$this->load->database();		
		$data['log'] = '';
		$data['namefolder'] = $_GET['namefile'];	
		$namamodul = substr($data['namefolder'], 0, strlen($data['namefolder'])-4);				
		$this->load->view("modul_library/v_insert_menu",$data);
	}
		
	
	//step 4
	function update_database(){
		$this->load->database();
		$data['log'] = '';
		
		if(isset($_GET['id_menu']) && strlen($_GET['id_menu']) > 0){			
			$this->load->helper('inflector');
			
			$id_menu  = $_GET['id_menu'];
			$namefile = $_GET['namefile'];
			$namamodul = substr($_GET['namefile'], 0, strlen($_GET['namefile'])-4);		
			
			$menufile 	= FCPATH.APPPATH."logs/".$namamodul."/menu.txt";	
		
			$error = FALSE;
			if(!file_exists($menufile)){
				$error = TRUE;
				$data['log'] = 'File Not Exist';
			}
			
			if(!$error){
				eval(file_get_contents($menufile));
			}
			
			if(!$error){
				$maxquerymenu = $this->db->query(" SELECT MAX(id_menu) as id_menu FROM `config_menu`");
				$maxmenu = $maxquerymenu->row_array();
				
				$querymenu = $this->db->query(" SELECT * FROM `config_menu` WHERE id_menu='".$id_menu."'");
				
				$getparent = $querymenu->row_array();
				
				/* $prenewmenu = array(
							"id_menu"=>$maxmenu['id_menu']+1
							,"title"=>humanize($namamodul)
							,"link"=>$namamodul
							,"level"=>$getparent['level']
							,"parent"=>$getparent['parent']
							,"isleaf"=>"true"
							,"loaded"=>"true"
							,"expanded"=>"true");		 */	
				//$this->db->insert('config_menu', $newmenu); 
				
				$parentmenu = array();
				$level = $getparent['level'];
				$idparent = $getparent['parent'];
				$newidmenu = $maxmenu['id_menu']+1;
				if(isset($newmenu) && is_array($newmenu)){
					foreach($newmenu as $rowmenu){
						$isleaf = 'true';
						$loaded = 'false';
						$expanded = 'false';
						if(isset($rowmenu['isparent']) && $rowmenu['isparent'] == 'true'){
							$isleaf = 'false';
							$loaded = 'false';
							$expanded = 'false';
						}
						$prenewmenu[] = array(
							"id_menu"=>$newidmenu
							,"title"=>humanize($rowmenu['title'])
							,"link"=>$rowmenu['link']
							,"level"=>$level
							,"parent"=>$idparent
							,"isleaf"=>$isleaf
							,"loaded"=>$loaded
							,"expanded"=>$expanded);			
						//increase id menu
						$newidmenu++;
						//jika parent, maka level dan id parent di 
						if(isset($rowmenu['isparent']) && $rowmenu['isparent'] == 'true'){
							$level = $level+1;
							$idparent = $maxmenu['id_menu']+1; 
						}
					}
					
							
					$querymenu = $this->db->query(" SELECT id_menu, title, link, level, parent, isleaf, loaded, expanded FROM `config_menu` ORDER BY id ASC");
					$last_menu = array();
					foreach ($querymenu->result_array() as $row){
						$last_menu[] = $row;
						if($row['id_menu'] == $id_menu){
							foreach($prenewmenu as $appendrow){
								$last_menu[] = $appendrow;
							}
						}
					}
					
					//truncate
					$data['log'] .= 'Re Sort List Menu <br/>';
					$this->db->query(" TRUNCATE TABLE`config_menu`");
					
					$data['log'] .= 'Input List Menu <br/>';
					$this->db->insert_batch('config_menu', $last_menu);			
				}
			}
			
			
			
		}
		
		
		$data['namefolder'] = $_GET['namefile'];	
		$namamodul = substr($data['namefolder'], 0, strlen($data['namefolder'])-4);	
		$sqlfile 	= FCPATH.APPPATH."logs/".$namamodul."/update.sql";
		
		
		$error = FALSE;
		if(!file_exists($sqlfile)){
			$error = TRUE;
			$data['log'] .= 'Not Found File To Execution';
		}
		
		if(!$error){
			$contentsql = file_get_contents($sqlfile);		
			$data['log'] .= 'Prepare Update Database<br/>';
						
			//$this->db->query($contentsql);
			
			$templine = '';
			$lines = file($sqlfile);
			foreach($lines as $line){
				if(substr($line,0,2) == '--' || $line == '')
					continue;
				
				//echo "<pre>";
				//print_r($line);
				//echo "</pre>";
				$templine .= $line;
				if(substr(trim($line),-1,1) == ';'){
					$this->db->query($templine);
					$templine = '';
				}
			}
			$data['log'] .= 'Update Database Successfully<br/>';
		}
		
		$this->load->view("modul_library/v_update",$data);
	}
	
	public $logs = '';
	public $list_file = array();
	public function cpy($source, $dest){
		$this->load->helper('file');
		
		if(is_dir($source)) {
			$dir_handle=opendir($source);
			while($file=readdir($dir_handle)){
				if($file!="." && $file!=".."){
					if(is_dir($source."/".$file)){
						if(!is_dir($dest."/".$file)){
							mkdir($dest."/".$file);							
							
							$this->logs .= "Create Folder ".$dest."/".$file;
							$this->list_file[] = get_file_info($dest."/".$file);
						}
						$this->cpy($source."/".$file, $dest."/".$file);
						
						$this->logs .= $source."/".$file." >>>>>>>>>>>>>>> ".$dest."/".$file."<br/>";						
						$this->list_file[] = get_file_info($dest."/".$file);
					} else {
						copy($source."/".$file, $dest."/".$file);						
						
						$this->logs .= $source."/".$file." >>>>>>>>>>>>>>> ".$dest."/".$file."<br/>";
						$this->list_file[] = get_file_info($dest."/".$file);
					}
				}
			}
			closedir($dir_handle);
		} else {
			copy($source, $dest);
			
			$this->logs .= $source." >>>>>>>>>>>>>>> ".$dest."<br/>";	
			$this->list_file[] = get_file_info($dest);			
		}
	}
	
	function prepare_uninstall(){
		$linkfolder = $_GET['link'];		
		$linkarray = explode('/', $linkfolder);
		$namemodul = substr(end($linkarray), 0, -4);
		
		$data['namemodul'] = $namemodul;	
		
		$this->load->view("modul_library/v_prepare_uninstall",$data);
	}
	
	public function delete_menu(){
		$findmenu 	= $_GET['findmenu'];
		$this->load->database();
		
		$data['log'] = '';
		
		$namamodul = $_GET['findmenu']; //$namamodul = substr($_GET['findmenu'], 0, strlen($_GET['findmenu'])-4);		
		$menufile  = FCPATH.APPPATH."logs/".$namamodul."/menu.txt";	
		
		$error = FALSE;
		if(!file_exists($menufile)){
			$error = TRUE;
			$data['log'] = 'File Not Exist';
		}
		
		if(!$error){
			$data['log'] .= 'Read List Menu<br/>';
			eval(file_get_contents($menufile));
		}
		
		if(!$error){
			foreach($newmenu as $rowmenu){
				$this->db->where('link', $rowmenu['link']);
				$this->db->where('title', $rowmenu['title']);
				$this->db->delete('config_menu'); 
				$data['log'] .= "Delete Menu ".$rowmenu['title']." Success<br/>";
			}
		}
		
		$data['namemodul'] = $findmenu;	
		$this->load->view("modul_library/v_delete_menu",$data);
	}
	
	public function list_file_uninstall(){
		$namemodul = $_GET['namemodul'];
		$contentlistfilezip = $this->read_xmlatzip($namemodul);
		
		$data['log'] = '';
		foreach($contentlistfilezip as $row){
			if(file_exists($row['server_path'])){
				$data['log'] .= "File ".$row['server_path']."<br/>";
			}
		}
		
		$data['countfile'] = COUNT($contentlistfilezip);
		$data['namemodul'] = $namemodul;	
		
		$this->load->view("modul_library/v_list_file_uninstall",$data);
	}
	
	public function uninstall(){
		$namemodul = $_GET['namemodul'];
		
		$data['namemodul'] = $namemodul;	
		$data['log'] = '';
		$data['log'] = 'Prepare List File<br/>';
		$contentlistfilezip = $this->read_xmlatzip($namemodul);
		
		foreach($contentlistfilezip as $row){
			if(is_file($row['server_path']) && file_exists($row['server_path'])){
				unlink($row['server_path']);
				$data['log'] .= "Remove File ".$row['server_path']."<br/>";
			}
		}
		
		$this->load->view("modul_library/v_uninstall",$data);
	}
	
	public function read_xmlatzip($modul)
	{
		$this->load->helper('file');
		$path = FCPATH.APPPATH."logs/"; //$path = FCPATH.APPPATH."modules";
		
		$dir = get_dir_file_info($path, TRUE);
		
		$data['data'] = array();
		$about = FCPATH.APPPATH."logs/".$modul."/".$modul."_listfile.xml";
		$arraycell = array();
		//membaca version lama
		if(is_file($about)){
			$contentabout = file_get_contents($about);
			$xmlcontent = new XmlToArray($contentabout);
			$array = $xmlcontent->my_xml2array();
			$arraycell = $xmlcontent->arraygetvalue($array);
			return $arraycell;
			exit();
		}
		return false;
	}
	
	public function delete_menu_last(){
		$findmenu 	= $_GET['findmenu'];
		
		$this->load->helper('file');
		$dashboard = FCPATH.APPPATH."controllers/dashboard.php";
		$contentfile = read_file($dashboard);
		
		$data['log'] = '';
		$data['log'] .= "Proccess Is Menu already exist ?<br/>";
		$do = FALSE;
		if(strpos($contentfile, $findmenu) > 0){			
			$do = TRUE;
			$data['log'] .= "Menu is already exist<br/>";
			$data['log'] .= "Not do anything<br/>";
		}else{			
			$do = FALSE;
			$data['log'] .= "Menu not exist<br/>";			
		}
		
		if($do){
			$lines = preg_split("/\\r\\n|\\r|\\n/", $contentfile);
			$data['log'] .= "Proccess List Menu<br/>";
			$newcontentfile = '';		
			foreach($lines as $line){
				$isfind = strpos($line, $findmenu);			
				if($isfind > 0){
				   $data['log'] .= "Find This Menu ".$line."<br/>";
				   $data['log'] .= "Delete This Menu ".$line."<br/>";
				}else{
					$newcontentfile .= $line."\n";
				}
			}
			
			if(!is_dir($controllerbackup = FCPATH.APPPATH."controllers/backup")){
				mkdir($controllerbackup);		
				$data['log'] .=	"Make Dir ".$controllerbackup;			
			}
			
			if(copy($dashboard, FCPATH.APPPATH."controllers/backup/dashboard.php")){
				$data['log'] .= "Backup Sukses ".$dashboard."<br/>";
			}
			
			if (! write_file($dashboard, $newcontentfile)){
				 $data['log'] .= 'Unable to write the file<br/>';
			}
			else{
				 $data['log'] .= 'File written!<br/>';
			} 
		}
		$data['namemodul'] = $findmenu;	
		$this->load->view("modul_library/v_delete_menu",$data);
	}
	
	public function read_xmlmenu()
	{
		$this->load->helper('file');
		$this->load->database();
		$path = FCPATH."menu.xml"; 
		echo $path;
		$arraycell = array();
		//membaca version lama
		if(is_file($path)){
			$contentabout = file_get_contents($path);
			
			$xmlcontent = new XmlToArray($contentabout);
			$array = $xmlcontent->my_xml2array();
			
			
			$newArray = array();
			foreach($array[0] as $key=>$row){
				if($row['name'] == 'row'){					
					$column = array();
					$inc = 1;
					foreach($row as $key2=>$row2){				
						if(is_numeric($key2)){
							$column['col'.$inc] = $row2['value'];
							$inc++;
						}
					}
					
					$newcolumn['id_menu'] = $column['col1'];
					$newcolumn['title'] = $column['col2'];
					$newcolumn['link'] = $column['col3'];
					$newcolumn['level'] = $column['col4'];
					$newcolumn['parent'] = $column['col5'];
					$newcolumn['isleaf'] = $column['col7'];
					$newcolumn['loaded'] = $column['col8'];
					$newcolumn['expanded'] = $column['col9'];
					//$newcolumn['id_menu'] = $column['col6'];
					$newArray[] = $newcolumn;
					$this->db->insert('config_menu', $newcolumn); 
					unset($newcolumn);
					unset($column);
				}
			}
			
			echo 'Sukses Input';
			echo "<pre>";
			print_r($newArray);
			echo "</pre>";
		}		
	}
}

/* End of file dashboard.php */
/* Location: ./sikdaapplication/controllers/login.php */