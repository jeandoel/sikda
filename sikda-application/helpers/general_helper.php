<?php  
	if (!defined('BASEPATH')) exit('No direct script access allowed'); 

	/**
	 * General Helper
	 * Common used helper for database manipulation
	 * @author  Dickson <dk.dickson@yahoo.com>
	 */
	
	/**
	 * Read content of file
	 * @param  String $file name of file with include options 
	 * @return String 		content of the file
	 */
	if(!function_exists('readFileContents')){
		function readFileContents($file){
			$f = fopen($file,"r") or die("Unable to open file: ".$file);
			$content = fread($f, filesize($file));
			fclose($f);	

			return $content;
		}
	}

	/**
	 * Send header response, mainly used in error handling
	 * @param  String $msg    the message
	 * @param  String $header the header key
	 */
	if(!function_exists("sendHeader")){
		function sendHeader($msg, $header="warning"){
			header("$header: $msg");
		}
	}