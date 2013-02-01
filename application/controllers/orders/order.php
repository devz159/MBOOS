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
		
		echo date('l', get_next_workday());
				
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
	
}
