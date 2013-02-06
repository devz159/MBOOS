<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * @author		Ian Paul Kionisala
 */
 
 if ( ! function_exists('now'))
{
	function now()
	{
		$CI =& get_instance();

		if (strtolower($CI->config->item('time_reference')) == 'gmt')
		{
			$now = time();
			$system_time = date("w Y m, d, g:i a");  // date function
			
			if (strlen($system_time) < 10)
			{
				$system_time = time();
				log_message('error', 'The Date class could not set a proper GMT timestamp so the local time() value was used.');
			}

			return $system_time;
		}
		else
		{
			return time();
		}
	}
}

if ( ! function_exists('mdate'))
{
	function mdate($datestr = '', $time = '')
	{
		if ($datestr == '')
			return '';

		if ($time == '')
			$time = now();

		$datestr = str_replace('%\\', '', preg_replace("/(\w+) (\d+), (\d+)/i", "\\\\\\1", $datestr));
		return date($datestr, $time);
	}
}

if ( ! function_exists('getDateArr'))
{
	function getDateArr($arrDate)
	{
			$splitComplateDate = preg_split('/ /', $arrDate);
			
			
			
			$splitDate = preg_split('/-/', $splitComplateDate[0]);
			
			list($year, $month, $day)= $splitDate;
			
			$plitTime = preg_split('/:/', $splitComplateDate[1]);
			
			
			list($hr, $min, $sec)= $plitTime;

		$arrDate = date("D, M d, Y h:i:s A",mktime($hr,$min,$sec,$month, $day, $year));

		return $arrDate;
	}
	
}

