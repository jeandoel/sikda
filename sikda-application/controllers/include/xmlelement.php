<?php

class SimpleXMLExtended extends SimpleXMLElement // http://coffeerings.posterous.com/php-simplexml-and-cdata
{
  public function addCData($cdata_text)
  {
    $node= dom_import_simplexml($this); 
    $no = $node->ownerDocument; 
    $node->appendChild($no->createCDATASection($cdata_text)); 
  } 
}

class writeXmlElement
{
	public static function writeXml($title = 'Default', $results = array(), $results_count = 0)
	{
		$str = $title;//strtolower($this->uri->segment(3));
		$xmlheader = "<?xml version=\"1.0\" encoding=\"UTF-8\"?>\n<$str></$str>";
		$xmlobj = simplexml_load_string($xmlheader);
		
		if($results)
		{
			$xmlobj->addChild('COUNT', $results_count);
			foreach($results as $values => $value)
			{
				$element = $xmlobj->addChild('DATA');
				$element->addAttribute('ID', $value['ALCON']);
				foreach($value as $value_name => $value_of)
				{
					if(!is_numeric($value_name)): $element->addChild($value_name, $value_of ? self::strRplcToChar($value_of) : '-'); endif;
				}
			}
		}else{
			$xmlobj->addChild('COUNT', '0');
		}
		return $xmlobj->asXML();
	}
	
	private static function strRplcToChar($str)
	{
		return str_replace('&', '&amp;', $str);
	}
	
	public static function writeXml2($title = 'Default', $results = array(), $results_count = 0)
	{
		$str = $title;//strtolower($this->uri->segment(3));
		$xmlheader = "<?xml version=\"1.0\" encoding=\"UTF-8\"?>\n<$str></$str>";
		$xmlobj = simplexml_load_string($xmlheader);

		if($results)
		{
			$xmlobj->addChild('COUNT', $results_count);
			foreach($results as $values => $value)
			{
				$element = $xmlobj->addChild('DATA');
				foreach($value as $value_name => $value_of)
				{
					if(!is_numeric($value_name)): $element->addChild($value_name, $value_of ? self::strRplcToChar($value_of) : '-'); endif;
				}
			}
		}else{
			$xmlobj->addChild('COUNT', '0');
		}
		return $xmlobj->asXML();
	}
	
	public static function writeXml3($title = 'Default', $results = array(), $results_count = 0,$page=1,$total=1)
	{
		/*$str = $title;//strtolower($this->uri->segment(3));
		$xmlheader = "<?xml version=\"1.0\" encoding=\"UTF-8\"?>\n<$str></$str>";
		$xmlobj = simplexml_load_string($xmlheader);

		if($results)
		{
			$xmlobj->addChild('PAGE', $results_count);
			$xmlobj->addChild('TOTAL', $results_count);
			$xmlobj->addChild('RECORDS', $results_count);
			foreach($results as $values => $value)
			{
				$element = $xmlobj->addChild('ROW');
				foreach($value as $value_name => $value_of)
				{
					if(!is_numeric($value_name)): $element->addChild($value_name, $value_of ? self::strRplcToChar($value_of) : '-'); endif;
				}
			}
		}else{
			$xmlobj->addChild('COUNT', '0');
		}*/
		//$xmlFile    = 'config.xml';
		$xml        = new SimpleXMLExtended('<'.$title.'/>');
		if($results)
		{
			$xml->addChild('page', $page);
			$xml->addChild('total', $total);
			$xml->addChild('records', $results_count);
			foreach($results as $values => $value)
			{
				$element = $xml->addChild('row');
				foreach($value as $value_name => $value_of)
				{
					if(!is_numeric($value_name)): $element->addChild('cell')->addCData($value_of); endif;
				}
			}
		}else{
			$xml->addChild('RECORDS', '0');
		}
		//$xml->saveXML($xmlFile);
		
		return $xml->asXML();
	}
	
}

//======================================================================================================================================================
//======================================================================================================================================================
//======================================================================================================================================================

/*
 * Parsing XML to Array
 */
class XmlToArray
{
	var $xml='';

	/**
	 * Default Constructor
	 * @param $xml = xml data
	 * @return none
	 */

	function XmlToArray($xml)
	{
		$this->xml = $xml;
	}

	function my_xml2array()
	{
		$xml_values = array();
		$contents = $this->xml;;
		$parser = xml_parser_create('');
		if(!$parser)
		return false;

		xml_parser_set_option($parser, XML_OPTION_TARGET_ENCODING, 'UTF-8');
		xml_parser_set_option($parser, XML_OPTION_CASE_FOLDING, 0);
		xml_parser_set_option($parser, XML_OPTION_SKIP_WHITE, 1);
		xml_parse_into_struct($parser, trim($contents), $xml_values);
		xml_parser_free($parser);
		if (!$xml_values)
		return array();
		 
		$xml_array = array();
		$last_tag_ar =& $xml_array;
		$parents = array();
		$last_counter_in_tag = array(1=>0);
		foreach ($xml_values as $data)
		{
			switch($data['type'])
			{
				case 'open':
					$last_counter_in_tag[$data['level']+1] = 0;
					$new_tag = array('name' => $data['tag']);
					if(isset($data['attributes']))
					$new_tag['attributes'] = $data['attributes'];
					if(isset($data['value']) && trim($data['value']))
					$new_tag['value'] = trim($data['value']);
					$last_tag_ar[$last_counter_in_tag[$data['level']]] = $new_tag;
					$parents[$data['level']] =& $last_tag_ar;
					$last_tag_ar =& $last_tag_ar[$last_counter_in_tag[$data['level']]++];
					break;
				case 'complete':
					$new_tag = array('name' => $data['tag']);
					if(isset($data['attributes']))
					$new_tag['attributes'] = $data['attributes'];
					if(isset($data['value']) && trim($data['value']))
					$new_tag['value'] = trim($data['value']);

					$last_count = count($last_tag_ar)-1;
					$last_tag_ar[$last_counter_in_tag[$data['level']]++] = $new_tag;
					break;
				case 'close':
					$last_tag_ar =& $parents[$data['level']];
					break;
				default:
					break;
			};
		}
		return $xml_array;
	}

	/**
	 * _struct_to_array($values, &$i)
	 *
	 * This is adds the contents of the return xml into the array for easier processing.
	 * Recursive, Static
	 *
	 * @access    private
	 * @param    array  $values this is the xml data in an array
	 * @param    int    $i  this is the current location in the array
	 * @return    Array
	 */

	function _struct_to_array($values, &$i)
	{
		$child = array();
		if (isset($values[$i]['value'])) array_push($child, $values[$i]['value']);

		while ($i++ < count($values)) {
			switch ($values[$i]['type']) {
				case 'cdata':
					array_push($child, $values[$i]['value']);
					break;

				case 'complete':
					$name = $values[$i]['tag'];
					if(!empty($name)){
						$child[$name]= ($values[$i]['value'])?($values[$i]['value']):'';
						if(isset($values[$i]['attributes'])) {
							$child[$name] = $values[$i]['attributes'];
						}
					}
					break;

				case 'open':
					$name = $values[$i]['tag'];
					$size = isset($child[$name]) ? sizeof($child[$name]) : 0;
					$child[$name][$size] = $this->_struct_to_array($values, $i);
					break;

				case 'close':
					return $child;
					break;
			}
		}
		return $child;
	}//_struct_to_array

	/**
	 * createArray($data)
	 *
	 * This is adds the contents of the return xml into the array for easier processing.
	 *
	 * @access    public
	 * @param    string    $data this is the string of the xml data
	 * @return    Array
	 */
	function createArray()
	{
		$xml    = $this->xml;
		$values = array();
		$index  = array();
		$array  = array();
		$parser = xml_parser_create();
		xml_parser_set_option($parser, XML_OPTION_SKIP_WHITE, 1);
		xml_parser_set_option($parser, XML_OPTION_CASE_FOLDING, 1);
		xml_parse_into_struct($parser, $xml, $values, $index);
		xml_parser_free($parser);
		$i = 0;
		$name = $values[$i]['tag'];
		$array[$name] = isset($values[$i]['attributes']) ? $values[$i]['attributes'] : '';
		$array[$name] = $this->_struct_to_array($values, $i);
		return $array;
	}//createArray
	
	public static function filter_by_value ($array, $index, $value){
		if(is_array($array) && count($array)>0)
		{
			foreach(array_keys($array) as $key){
				$temp[$key] = $array[$key][$index];

				if ($temp[$key] == $value){
					$newarray[$key] = $array[$key];
				}
			}
		}
		return $newarray;
	}

	public static function multiArrayValueSearch($haystack, $needle, &$result, &$aryPath=NULL, $currentKey='') {
		if (is_array($haystack)) {
			$count = count($haystack);
			$iterator = 0;
			foreach($haystack as $location => $straw) {
				$iterator++;
				$next = ($iterator == $count)?false:true;
				if (is_array($straw)) $aryPath[$location] = $location;
				self::multiArrayValueSearch($straw,$needle,$result,$aryPath,$location);
				if (!$next) {
					unset($aryPath[$currentKey]);
				}
			}
		} else {
			$straw = $haystack;
			if ($straw == $needle) {
				if (!isset($aryPath)) {
					$strPath = "\$result[$currentKey] = \$needle;";
				} else {
					$strPath = "\$result['".join("']['",$aryPath)."'][$currentKey] = \$needle;";
				}
				eval($strPath);
			}
		}
	}


}//XmlToArray