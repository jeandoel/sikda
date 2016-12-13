<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
include_once("class/fpdf/fpdf.php");
include_once("class/PHPJasperXML.inc.php");
include_once ("setting.php");

$resepno  = $_GET['hdnNoResep'];
$pid    = $_GET['pid']; 

$PHPJasperXML = new PHPJasperXML();
//$PHPJasperXML->debugsql=true;
set_time_limit (0);

$xml =  simplexml_load_file("resep.jrxml");
$PHPJasperXML->arrayParameter=array("ResepNo"=>"'" . $resepno . "'", "parameter1"=>"'". $pid . "'");
  
$PHPJasperXML->xml_dismantle($xml);
$PHPJasperXML->transferDBtoArray($server,$user,$pass,$db);
$PHPJasperXML->outpage("I"); //page output method I:standard output  D:Download file    F:Save to Local File
?>
