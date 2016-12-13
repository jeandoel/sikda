<?php

/**
 * Migration model to fix database issue or migrate database version
 * @author Dickson <dickson@civira.com>
 * @version  1.0.0
 */
class M_Migration extends CI_Model {

	private $db;

	/**
	 * Load database library and initialize configuration
	 * Actually can be loaded in autoload but as the previous developer use this method
	 * Let's just go with the flow
	 */
	public function __construct()
	{
		parent::__construct();
		$this->db = $this->load->database('sikda', TRUE);
		$this->db_name = $this->db->database;
	}

	/**
	 * Fix database issue of incrorrect data type, wrong ID, incorrect view, lack of column, etc.
	 * @version  1.0
	 * @return String message on failure or success
	 */
	public function fixDB1(){
		$this->db->trans_begin();

		$this->kdFamilyToInt();
		$this->setAIFamily();
		$this->updateViewDetailRawatJalan();
		$this->updateViewDetailRawatInap();
		$this->addColumnToTable('pel_imunisasi','KD_PUSKESMAS','VARCHAR(20)','KD_PELAYANAN');
		$this->addColumnToTable('trans_imunisasi','KD_PUSKESMAS','VARCHAR(20)','KD_TRANS_IMUNISASI');
		$this->addColumnToTable('apt_obat_terima','KD_KABUPATEN','VARCHAR(20)','KD_PKM');
		$this->addColumnToTable('apt_obat_keluar','KD_KABUPATEN','VARCHAR(20)','KD_PKM');

		//consider using view to get KD_KABUPATEN from pel_ord_obat, for quick result just use this code bellow
		$this->addColumnToTable('pel_ord_obat','KD_KABUPATEN','VARCHAR(20)','KD_PUSKESMAS');

		$this->complete_transaction(
				function(){
					echo "patching database failed";
				},
				function(){
					echo "patching database complete. ";
					echo '<a href="..">back to login</a>';
				}
			);
	}

	/**
	 * Update view with prepared sql query file
	 * @param  String $file      relative path and name of the sql file
	 * @param  String $view_name name of the view in database
	 * @return void
	 */
	private function updateViewFromFile($file, $view_name){
		$view_query = readFileContents($file);

		$query = "CREATE OR REPLACE VIEW $view_name AS $view_query";
		$this->db->query($query);
	}

	/**
	 * Update detail rawat jalan view based on prepared sql query file
	 * @return void
	 */
	private function updateViewDetailRawatJalan(){
		$this->updateViewFromFile("query/vw_detail_rawat_jalan.sql","vw_detail_rawat_jalan");
	}

	/**
	 * Update detail rawat inap view based on prepared sql query file
	 * @return void
	 */
	private function updateViewDetailRawatInap(){
		$this->updateViewFromFile("query/vw_detail_rawat_inap.sql","vw_detail_rawat_inap");	
	}

	/**
	 * Add column to certain table
	 * @param String $table_name   name of the table for column
	 * @param String $column_name  name of the column
	 * @param String $data_type    data type of column
	 * @param String $after_column after what column does this column will be appended
	 */
	private function addColumnToTable($table_name, $column_name, $data_type, $after_column=null){
		if(!$this->columnExists($table_name, $column_name)){
			$alter_query = "ALTER TABLE $table_name ADD $column_name $data_type";
			if($after_column){
				$alter_query .= " after $after_column";
			}
			$this->db->query($alter_query);
		}
	}

	/**
	 * Check whether certain column exists or not in certain table
	 * @param  String $table_name  name of the table in database
	 * @param  String $column_name name of the column in table
	 * @return Boolean              true if exists, false otherwise
	 */
	private function columnExists($table_name, $column_name){
		$check_query = "SELECT *
							FROM information_schema.COLUMNS 
							WHERE TABLE_NAME = '$table_name' 
							AND COLUMN_NAME = '$column_name'
							AND TABLE_SCHEMA  = '$this->db_name'";
		$check_result = $this->db->query($check_query)->row();

		if(empty($check_result)) return false;
		else return true;
	}

	/**
	 * Set id of auto increment family folder 
	 * to the latest id family folder in pasien table
	 * @return  Void
	 */
	private function setAIFamily(){
		$query = "SELECT MAX(ID_FAMILY_FOLDER) AS MAX_ID_FAMILY FROM pasien";
		$result = $this->db->query($query)->row();

		$family_ai = $this->getAI('family_folder');

		if($result->MAX_ID_FAMILY>$family_ai){

			$alter_query = "ALTER TABLE  `family_folder` AUTO_INCREMENT = ".($result->MAX_ID_FAMILY+1);
			$this->db->query($alter_query);
		}
	}

	/**
	 * Convert KD_FAMILY_FOLDER data type to int
	 * @return Void
	 */
	private function kdFamilyToInt(){
		$query = "SELECT DATA_TYPE 
					FROM information_schema.COLUMNS 
					WHERE TABLE_NAME = 'family_folder' 
					AND COLUMN_NAME = 'KD_FAMILY_FOLDER'
					AND TABLE_SCHEMA  = '$this->db_name'";
		$result = $this->db->query($query)->row();
		if($result->DATA_TYPE!="int"){

			$alter_query = "ALTER TABLE `family_folder` CHANGE `KD_FAMILY_FOLDER` `KD_FAMILY_FOLDER` INT(20) NOT NULL";
			$this->db->query($alter_query);
		}
	}

	/**
	 * Shorthand for codeigniter transaction complete process
	 * @param  Function $error_callback   function to be called when succeed
	 * @param  Function $success_callback function to be called when failed
	 * @return Void                   
	 */
	private function complete_transaction($error_callback=null, $success_callback=null){
		if($this->db->trans_status()===FALSE){
			$this->db->trans_rollback();
			if(is_callable($error_callback)) $error_callback();
		}else{
			$this->db->trans_commit();
			if(is_callable($success_callback)) $success_callback();
		}
	}

	/**
	 * Get current auto increment value of a table with primary key and AI
	 * @param  String  $table_name  the table name
	 * @return Decimal              value of current auto increment
	 */
	public function getAI($table_name){
		$query = "SELECT `AUTO_INCREMENT`
					FROM  INFORMATION_SCHEMA.TABLES
					WHERE TABLE_NAME   = '$table_name'
					AND TABLE_SCHEMA  = '$this->db_name'";
		$result = $this->db->query($query)->row();
		if(!$result) return 1;
		else return $result->AUTO_INCREMENT;
	}
}