<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Common Functions
 * @subpackage	Helpers
 * @category	Helpers
 * @author		Knowledge Matrix Dev Team
 */
/**
 * Print_r convenience function, which prints out <PRE> tags around
 * the output of given array. 
 * @param array $var Variable to print out
 */
function pr($var) {
	echo '<pre>';
	print_r($var);
	echo '</pre>';
}
/**
 * for including js files convenience function
 * the output of given string. 
 * @param array $var includes the file name and path of that files
 */
function KM_js($options=array()) {
   $scripts='';
	if(is_array($options)){
	   foreach($options as $file){
	      $scripts .= "<script type='text/javascript' src='/".trim(strrchr(trim(str_replace('\\','/',FCPATH), '/'), '/'),'/').'/'.$file.".js'></script>";
   
	   }
	   return $scripts;
	}
}
/**
 * for including css files convenience function
 * the output of given string. 
 * @param array $var includes the file name and path of that files
 */
function KM_css($options=array()) {
  $css='';
	if(is_array($options)){
	   foreach($options as $file){
	      $css .= "<link rel='stylesheet' type='text/css' href='/".trim(strrchr(trim(str_replace('\\','/',FCPATH), '/'), '/'),'/').'/'.$file.".css' />";
   
	   }
	   return $css;
	}
}
/**
 * date difference 
 * the output of given string. 
 * @param array $var includes the file name and path of that files
 */	
 function date_differnce($from,$to){
       $result=array();
       $diff = abs(strtotime($to) - strtotime($from));
	   $result['years'] = floor($diff / (365*60*60*24));
       $result['months'] = floor(($diff) / (30*60*60*24));
       $result['days'] = floor(($diff)/(60*60*24));
	   return $result;
 }
/**
 * To display Duration in weeks or months.
 * @param $days number of days.
 */ 
 function display_duration($days){
	if($days<=28){
		if($days==7){
			return round($days/7).' Week';
		}
		else
		{
			return round($days/7).' Weeks';
		}
	}else{
		if($days==30)
		{
			return round($days/30).' Month';
		}else
		{
			return round($days/30).' Months';
		}
	}
}
function compareByName($a, $b) {
  return strcmp($a["tracker_title"], $b["tracker_title"]);
}
/**
 * Truncates text.
 *
 * Cuts a string to the length of $length and replaces the last characters
 * with the ending if the text is longer than length.
 *
 * ### Options:
 *
 * - `ending` Will be used as Ending and appended to the trimmed string
 * - `exact` If false, $text will not be cut mid-word
 * - `html` If true, HTML tags would be handled correctly
 *
 * @param string $text String to truncate.
 * @param integer $length Length of returned string, including ellipsis.
 * @param array $options An array of html attributes and options.
 * @return string Trimmed string.
 */
 function Texttruncate($text, $length = 100, $options = array()) {
		$default = array(
			'ending' => '...', 'exact' => true, 'html' => false
		);
		$options = array_merge($default, $options);
		extract($options);
		if (!function_exists('mb_strlen')) {
			class_exists('Multibyte');
		}
		if ($html) {
			if (mb_strlen(preg_replace('/<.*?>/', '', $text)) <= $length) {
				return $text;
			}
			$totalLength = mb_strlen(strip_tags($ending));
			$openTags = array();
			$truncate = '';
			preg_match_all('/(<\/?([\w+]+)[^>]*>)?([^<>]*)/', $text, $tags, PREG_SET_ORDER);
			foreach ($tags as $tag) {
				if (!preg_match('/img|br|input|hr|area|base|basefont|col|frame|isindex|link|meta|param/s', $tag[2])) {
					if (preg_match('/<[\w]+[^>]*>/s', $tag[0])) {
						array_unshift($openTags, $tag[2]);
					} elseif (preg_match('/<\/([\w]+)[^>]*>/s', $tag[0], $closeTag)) {
						$pos = array_search($closeTag[1], $openTags);
						if ($pos !== false) {
							array_splice($openTags, $pos, 1);
						}
					}
				}
				$truncate .= $tag[1];
				$contentLength = mb_strlen(preg_replace('/&[0-9a-z]{2,8};|&#[0-9]{1,7};|&#x[0-9a-f]{1,6};/i', ' ', $tag[3]));
				if ($contentLength + $totalLength > $length) {
					$left = $length - $totalLength;
					$entitiesLength = 0;
					if (preg_match_all('/&[0-9a-z]{2,8};|&#[0-9]{1,7};|&#x[0-9a-f]{1,6};/i', $tag[3], $entities, PREG_OFFSET_CAPTURE)) {
						foreach ($entities[0] as $entity) {
							if ($entity[1] + 1 - $entitiesLength <= $left) {
								$left--;
								$entitiesLength += mb_strlen($entity[0]);
							} else {
								break;
							}
						}
					}
					$truncate .= mb_substr($tag[3], 0 , $left + $entitiesLength);
					break;
				} else {
					$truncate .= $tag[3];
					$totalLength += $contentLength;
				}
				if ($totalLength >= $length) {
					break;
				}
			}
		} else {
			if (mb_strlen($text) <= $length) {
				return $text;
			} else {
				$truncate = mb_substr($text, 0, $length - mb_strlen($ending));
			}
		}
		if (!$exact) {
			$spacepos = mb_strrpos($truncate, ' ');
			if ($html) {
				$truncateCheck = mb_substr($truncate, 0, $spacepos);
				$lastOpenTag = mb_strrpos($truncateCheck, '<');
				$lastCloseTag = mb_strrpos($truncateCheck, '>');
				if ($lastOpenTag > $lastCloseTag) {
					preg_match_all('/<[\w]+[^>]*>/s', $truncate, $lastTagMatches);
					$lastTag = array_pop($lastTagMatches[0]);
					$spacepos = mb_strrpos($truncate, $lastTag) + mb_strlen($lastTag);
				}
				$bits = mb_substr($truncate, $spacepos);
				preg_match_all('/<\/([a-z]+)>/', $bits, $droppedTags, PREG_SET_ORDER);
				if (!empty($droppedTags)) {
					if (!empty($openTags)) {
						foreach ($droppedTags as $closingTag) {
							if (!in_array($closingTag[1], $openTags)) {
								array_unshift($openTags, $closingTag[1]);
							}
						}
					} else {
						foreach ($droppedTags as $closingTag) {
							array_push($openTags, $closingTag[1]);
						}
					}
				}
			}
			$truncate = mb_substr($truncate, 0, $spacepos);
		}
		$truncate .= $ending;
		if ($html) {
			foreach ($openTags as $tag) {
				$truncate .= '</' . $tag . '>';
			}
		}
		return $truncate;
	}
/*
*    Multi Languages function  
*/
	
 function __($str=null){
    	return $str;
	}
	
	
# recursively remove a directory
  function rrmdir($dir) {
    foreach(glob($dir . '/*') as $file) {
        if(is_dir($file))
            rrmdir($file);
        else
            unlink($file);
    }
    rmdir($dir);
  }
  
 //referer function 
 function KM_referer($type=''){
      if(isset($_SERVER['HTTP_REFERER'])){
	     redirect($_SERVER['HTTP_REFERER']);
	  }
	  else{
	     if($type=='admin'){
		   redirect(admin_url());
		 }
	     redirect(base_url());
	  }
  }
 //seo title generation function 
 function seo_title($realname=null){
		
			$seoname = preg_replace('/\%/',' percentage',$realname); 
			$seoname = preg_replace('/\@/',' at ',$seoname); 
			$seoname = preg_replace('/\&/',' and ',$seoname); 
			$seoname = preg_replace('/\s[\s]+/','-',$seoname);    // Strip off multiple spaces 
			$seoname = preg_replace('/[\s\W]+/','-',$seoname);    // Strip off spaces and non-alpha-numeric
			$seoname = preg_replace('/^[\-]+/','',$seoname); // Strip off the starting hyphens 
			$seoname = preg_replace('/[\-]+$/','',$seoname); // // Strip off the ending hyphens 
			$seoname = strtolower($seoname); 
			
	     return $seoname;
	}       
	
		   //Random code generation
 function generate_random_code($length=8) {
         $key = '';
		list($usec, $sec) = explode(' ', microtime());
		mt_srand((float) $sec + ((float) $usec * 100000));
		
		$inputs = array_merge(range('z','a'),range(0,9),range('A','Z'));
	
		for($i=0; $i<$length; $i++)
		{
			$key .= $inputs{mt_rand(0,61)};
		}
		return $key;
    }
function closetags ( $html )
        {
        #put all opened tags into an array
        preg_match_all ( "#<([a-z]+)( .*)?(?!/)>#iU", $html, $result );
        $openedtags = $result[1];
        #put all closed tags into an array
        preg_match_all ( "#</([a-z]+)>#iU", $html, $result );
        $closedtags = $result[1];
        $len_opened = count ( $openedtags );
        # all tags are closed
        if( count ( $closedtags ) == $len_opened )
        {
        return $html;
        }
        $openedtags = array_reverse ( $openedtags );
        # close tags
        for( $i = 0; $i < $len_opened; $i++ )
        {
            if ( !in_array ( $openedtags[$i], $closedtags ) )
            {
            $html .= "</" . $openedtags[$i] . ">";
            }
            else
            {
            unset ( $closedtags[array_search ( $openedtags[$i], $closedtags)] );
            }
        }
        return $html;
    }
function time_zone_set($zone){
	if($zone=='P'){
		date_default_timezone_set('America/Los_Angeles');
	}else if($zone=='C'){
		date_default_timezone_set("America/Chicago");
	}else if($zone=='K'){
		date_default_timezone_set("America/Anchorage");
	}else if($zone=='E'){
		date_default_timezone_set("America/New_York");
	}else if($zone=='A'){
		date_default_timezone_set("America/Virgin");
	}else if($zone=='M'){
		date_default_timezone_set("America/Denver");
	}
}	