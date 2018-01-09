<?php if( ! defined('BASEPATH')) exit('No direct script access allowed');
class Breadcrumb {
	private $breadcrumbs = array();
	private $_divider = '  &gt; ';
	private $_tag_open = '';
	private $_tag_close = '';
	public function __construct($params = array()){
		if (count($params) > 0){
			$this->initialize($params);
		}
		
		log_message('debug', "Breadcrumb Class Initialized");
	}
	/**
	 * 
	 *
	 * @access public
	 * @param array initialization parameters
	 * @return void
	 */
	private function initialize($params = array()){
		if (count($params) > 0){
			foreach ($params as $key => $val)
			{
				if (isset($this->{'_' . $key}))
				{
					$this->{'_' . $key} = $val;
				}
			}
		}
	}
	/**
	 *
	 *
	 * @access public
	 * @param string $title
	 * @param string $href
	 * @return void
	 */
	function append_crumb($title, $href,$js=0){
		// no title or href provided
		//if (!$title OR !$href) return;
		// add to end
		
		$this->breadcrumbs[] = array('title' => $title, 'href' => $href,"js"=>$js);
		
		
	}
	/**
	 * 
	 *
	 * @access public
	 * @param string $title
	 * @param string $href
	 * @return void
	 */
	function prepend_crumb($title, $href){
		// no title or href provided
		if (!$title OR !$href) return;
		// add to start
		array_unshift($this->breadcrumbs, array('title' => $title, 'href' => $href));
	}
	
	/**
	 * Generate breadcrumb
	 *
	 * @access public
	 * @return string
	 */
	function output(){
		
		if ($this->breadcrumbs) {
		
			$output = $this->_tag_open;
			
			foreach ($this->breadcrumbs as $key => $crumb) {
				// add divider
				//if ($key) $output .= $this->_divider;
				
				if (end(array_keys($this->breadcrumbs)) == $key) {
					$output .= '<div class="sub_nav" style="color:#000;text-decoration:none">&nbsp;&nbsp;&nbsp;&nbsp;'.$crumb['title'].'</div>';
				
				} else {
				
				 if($crumb['js']==1){$crumb['href']="javascript:void(0)";
				 $output .= ' &nbsp;<div class="sub_nav" ><a href="javascript:void(0)" style="color:#000;text-decoration:none">'.$crumb['title'].'</a></div>';
				 }else
				 {
				 $output .= ' &nbsp;<div class="sub_nav" >' .anchor($crumb['href'],$crumb['title']) .'</div>';
				 }
					
				}
			}
		
			return $output . $this->_tag_close . PHP_EOL;
		}
	
		return '';
	}
}
   