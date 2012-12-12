<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

if(! function_exists('datePart'))
{
	function datePart($strValue) {
		$pattern = "/\d{4}-\d{2}-\d{2}/";
		
		$dateValue = preg_match($pattern, $strValue, $matches);
		
		if(empty($matches[0]))
			$dateValue = '1980-01-01';
		
		return $matches[0];
	}
}

if(! function_exists('dateSplit'))
{
	function dateSplit($strValue) {
		$pattern = "/-/";
		
		if(empty($strValue))
			$strValue = "1980-01-01";
			
		$arrVal = preg_split($pattern, $strValue);
		
		return $arrVal;
	}
}

if(!function_exists('longDate')){
	function longDate($param) {
		$dateSep = dateSplit($param);
		
		if(!$param){
			return 'Not a valid date';
		}
		
		return date("l, F j, Y ", mktime(0,0,0, $dateSep[1], $dateSep[2], $dateSep[0])); 
	}
}


function daysBetweenDate($from, $till) {
/*
 *This function will calculate the difference between two given dates.
 *
 *Please input time by ISO 8601 standards (yyyy-mm-dd).
 *i.e: daysBetweenDate('2009-01-01', '2010-01-01');
 *This will return 365.
 *
 *Author: brian [at] slaapkop [dot] net
 *May 5th 2010
*/
	
	/*
	 * =====================================================================
	 *
	 * This part has been revised
	 *
	 */
	// References to codeigniter super global object.
	$CI =& get_instance();
	
	// Sets the timezone
	date_default_timezone_set($CI->config->item('timezonee'));
	
	/* ==================================================================== */
	
	
    if($till < $from) {
        trigger_error("The date till is before the date from", E_USER_NOTICE);
        }
       
    //Explode date since gregoriantojd() requires mm, dd, yyyy input;
        $from = explode('-', $from);
        $till = explode('-', $till);

    //Calculate date to Julian Day Count with freshly created array $from.
        $from = gregoriantojd($from[1], $from[2], $from[0])."<br />";
       
    //Calculate date to Julian Day Count with freshly created array $till.
        $till = gregoriantojd($till[1], $till[2], $till[0])."<br />";

    //Substract the days $till (largest number) from $from (smallest number) to get the amount of days
        $days = ($till - $from);
   
    //Return the number of days.
        return $days;

    //Isn't it sad how my comments use more lines than the actual code?
}
/* End of file url_helper.php */
/* Location: ./application/helpers/MY_date_helper.php */