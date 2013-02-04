<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Order extends CI_Controller {
	

	public function __construct() {
		parent::__construct();

	}
	
	public function index() {
		
		echo "working..";
		
		$times = $this->create_time_range('8:00', '17:00', '15 mins');
		
		foreach ($times as $key => $time) {
			// $times[$key] = date('Y m, d, g:i:s', $time);  //date("w Y m, d, g:i s", $time)
			$times[$key] = date("Y-m-d H:i:s", $time);
		}
		
		print '<pre>'. print_r($times, true).'</pre>';
		
		echo date('l', $this->get_next_workday());
				
	}
	
	public function create_time_range($start, $end, $by='30 mins') {
	
	    $start_time = strtotime($start);
	    $end_time   = strtotime($end);
	
	    $current    = time();
	    $add_time   = strtotime('+'.$by, $current);
	    $diff       = $add_time-$current;
	
	    $times = array();
	    while ($start_time < $end_time) {
	        $times[] = $start_time;
	        $start_time += $diff;
	    }
	    $times[] = $start_time;
	    return $times;
	} 
	
	public function get_next_workday() {
		// Bank holidays
		$bankhols = array(
				// England & Wales Bank Holidays [2005 - 2008]
	
				/* 2005
				 ====
		// New Year's Day */
				'3-Jan-2005',
				// Good Friday
				'25-Mar-2005',
				// Easter Monday
				'28-Mar-2005',
				// Early May Bank Holiday
				'2-May-2005',
				// Spring Bank Holiday
				'30-May-2005',
				// Summer Bank Holiday
				'29-Aug-2005',
				// Christmas Day
				'25-Dec-2005',
				// Boxing Day
				'26-Dec-2005',
	
				/* 2006
				 ====
		// New Year's Day */
				'2-Jan-2006',
				// Good Friday
				'14-Apr-2006',
				// Easter Monday
				'17-Apr-2006',
				// Early May Bank Holiday
				'1-May-2006',
				// Spring Bank Holiday
				'29-May-2006',
				// Summer Bank Holiday
				'28-Aug-2006',
				// Christmas Day
				'25-Dec-2006',
				// Boxing Day
				'26-Dec-2006',
	
				/* 2007
				 ====
		// New Year's Day */
				'1-Jan-2007',
				// Good Friday
				'6-Apr-2007',
				// Easter Monday
				'9-Apr-2007',
				// Early May Bank Holiday
				'7-May-2007',
				// Spring Bank Holiday
				'28-May-2007',
				// Summer Bank Holiday
				'27-Aug-2007',
				// Christmas Day
				'25-Dec-2007',
				// Boxing Day
				'26-Dec-2007',
	
				/* 2008
				 ====
		// New Year's Day */
		'1-Jan-2008',
		// Good Friday
		'21-Mar-2008',
		// Easter Monday
		'24-Mar-2008',
		// Early May Bank Holiday
		'5-May-2008',
		// Spring Bank Holiday
		'26-May-2008',
		// Summer Bank Holiday
		'25-Aug-2008',
		// Christmas Day
		'25-Dec-2008',
		// Boxing Day
		'26-Dec-2008',
		);
		// Assuming that the longest someone can be off work is 4 days
		$nextdays = array(strtotime('+1 day'), strtotime('+2 days'), strtotime('+3 days'), strtotime('+4 days'), strtotime('+5 days'));
		for ($i = 0; $i < count($nextdays); $i++) {
			$daynum = (int) date('w', $nextdays[$i]);
			$daytext = date('d-M-Y', $nextdays[$i]);
			if (($daynum > 0) && ($daynum < 6) && (!in_array($daytext, $bankhols))) {
				return $nextdays[$i];
			}
		}
	}
	
	public function date_checker() {
		
		$timezone = "Asia/Manila";
		date_default_timezone_set($timezone);
		
		$params['querystring'] = "SELECT mboos_order_pick_schedule FROM mboos_orders ORDER BY mboos_order_date DESC LIMIT 1";
		
		$this->mdldata->select($params);
		
		$last_pick_scheduled = $this->mdldata->_mRecords;
		
		
		if($this->mdldata->_mRowCount == 0) {
			
			$start_date = date("Y-m-d h:i:s");
			
			call_debug($start_date, false);
			
			$splitComplateDate = preg_split('/ /', $start_date);
				
			//$start_time = $start_date . " 03:50 AM" ;
			
			
			$timestamp = strtotime(date("Y-m-d h:i A", strtotime($splitComplateDate[0])));
			$new_generate_datetime = date('Y-m-d h:i A', $timestamp);

			$currDate = date('Y-m-d');
				
			$start_currDate = $currDate . " 8:00:00 AM";
			$end_currDate = $currDate . " 5:00:00 PM";
			
			
			$format = $start_currDate . " to " . $end_currDate;
			
			if($this->check_date_is_within_range($start_currDate, $end_currDate, $new_generate_datetime)){
				
				call_debug($new_generate_datetime);
				
			} else {
				
 				$new_generate_datetime = date('Y-m-d h:i A' , strtotime('+ 1 day 8:00 AM', strtotime($splitComplateDate[0])));
				
 				call_debug($new_generate_datetime);
								
				
			}
		
		} else {
			
			$start_time = $last_pick_scheduled[0]->mboos_order_pick_schedule;
			
			call_debug($start_time ,false);
			$splitComplateDate = preg_split('/ /', $start_time);
			
			call_debug($splitComplateDate, false);
			
			$splitDate = preg_split('/-/', $splitComplateDate[0]);
			
			list($year, $month, $day)= $splitDate;
			
			$plitTime = preg_split('/:/', $splitComplateDate[1]);
			
			
			list($hr, $min, $sec)= $plitTime;
			
			
			$clearDateTime = date("Y-m-d H:i:s A", mktime($hr, $min, $sec, $month, $day, $year));
			
			call_debug($clearDateTime, false);
			$timestamp = strtotime(date("Y-m-d h:i", strtotime($start_time)) . " + 15 minutes");
			$new_generate_datetime = date('Y-m-d H:i:s A', $timestamp);
			
			call_debug($new_generate_datetime);
			
		}
		
		
	}
	
	function check_date_is_within_range($start_date, $end_date, $todays_date)
	{
	
		$start_timestamp = strtotime($start_date);
		$end_timestamp = strtotime($end_date);
		$today_timestamp = strtotime($todays_date);
	
		return (($today_timestamp >= $start_timestamp) && ($today_timestamp <= $end_timestamp));
	
	}
}
