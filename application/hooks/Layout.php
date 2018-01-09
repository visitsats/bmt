<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');
/**
 *
 */
class Layout {
    function render() {
        global $OUT;
        $CI = & get_instance();
        $output = $CI->output->get_output();
	
        if (!isset($CI->layout)) {
            $CI->layout = "default";
        }
		
        if ($CI->layout != false) {
            if (!preg_match('/(.+).php$/', $CI->layout)) {
                $CI->layout .= '.php';
            }
			if(substr($CI->router->directory,0,-1)=='admin'){
			 
			  $requested = BASEPATH . '../application/views/layouts/' . $CI->layout;
              $default = BASEPATH . '../application/views/'.$CI->router->directory.'layouts/default.php';
            }
			else{
			   $requested = BASEPATH . '../application/views/layouts/' . $CI->layout;
              $default = BASEPATH . '../application/views/layouts/default.php';
			}
            if (file_exists($requested)) {
                $layout = $CI->load->file($requested, true);
            } else {
                $layout = $CI->load->file($default, true);
            }
            $view = str_replace("{content}", $output, $layout);
			if(isset($CI->title)){
             $view = str_replace("{title}", $CI->title, $view);
            } 
            $scripts = "";
            $styles = "";
            $metas = "";
            if (isset($CI->meta) && count($CI->meta) > 0) {    
                $metas = implode("\n", $CI->meta);
            }
            if (isset($CI->scripts) && count($CI->scripts) > 0) {  
                foreach ($CI->scripts as $script) {
                    $scripts .= "<script type='text/javascript' src='" . BASE_URL . "js/" . $script . ".js'></script>";
                }
            }
            if (isset($CI->styles) && count($CI->styles) > 0) {   
                foreach ($CI->styles as $style) {
                    $styles .= "<link rel='stylesheet' type='text/css' href='" . BASE_URL . "css/" . $style . ".css' />";
                }
            }
            if (isset($CI->parts) && count($CI->parts) > 0) {   
                foreach ($CI->parts as $name => $part) {
                    $view = str_replace("{" . $name . "}", $part, $view);
                }
            }
			
            $view = str_replace("{metas}", $metas, $view);
            $view = str_replace("{scripts}", $scripts, $view);
            $view = str_replace("{styles}", $styles, $view);
            //$view = preg_replace("/{.*?}/ims", "", $view); 
        } else {
            $view = $output;
        }
        $OUT->_display($view);
		
    }
}
?> 