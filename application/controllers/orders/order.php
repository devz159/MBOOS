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
}
