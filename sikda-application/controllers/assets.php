<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/*
 * ASSETS Controller
 * This file allows you to  access assets from within your modules directory
 * 
 * @author Borda Juan Ignacio
 * 
 * @version  1.0 (2012-05-27)
 * 
 */

class assets extends CI_Controller {

    function __construct() {
        parent::__construct();
        //---get working directory and map it to your module
        //$file = getcwd() . '/application/modules/' . implode('/', $this->uri->segments);
		$file = getcwd() . '/sikda-application/modules/' . $this->uri->segment(2) . "/assets" . "/" . $this->uri->segment(3) . "/" . $this->uri->segment(4) ;
		
		//----get path parts form extension
        $path_parts = pathinfo( $file);//print_r($path_parts);
        //---set the type for the headers
        $file_type=  strtolower($path_parts['extension']);
        //echo mime_content_type($file);
        if (is_file($file)) {
            //----write propper headers
            switch ($file_type) {
                case 'css':
                    header('Content-type: text/css');
                    break;

                case 'js':
                    header('Content-type: text/javascript');
                    break;
                
                case 'json':
                    header('Content-type: application/json');
                    break;
                
                case 'xml':
                   header('Content-type: text/xml');
                    break;
                
                case 'pdf':
                  header('Content-type: application/pdf');
                    break;
                
                case 'jpg' || 'jpeg' || 'png' || 'gif':
                    header('Content-type: image/'.$file_type);
                    break;
				default:
					header('Content-type: '.mime_content_type($file));
            }
			
            include $file;
        } else {
            show_404();
        }
        exit;
    }

} 
