<?php

class Paypalsettings {

	static private 	$CI;

	static public function env($sandbox ="https://www.sandbox.paypal.com/cgi-bin/webscr", $live="https://www.paypal.com/cgi-bin/webscr") {

		self::$CI =& get_instance();

		$strQry = sprintf("SELECT value AS environ FROM `settings` WHERE `setting` LIKE '%c%s%c'", 37, "paypalsandbox", 37);

		$record = self::$CI->db->query($strQry)->result();

		foreach($record as $rec) {
			if($rec->environ == '0')
			return trim($live);
		}
		
		return trim($sandbox);

	}

	static public function envHost($sandbox ="www.sandbox.paypal.com", $live="www.paypal.com") {

		self::$CI =& get_instance();

		$strQry = sprintf("SELECT value AS environ FROM `settings` WHERE `setting` LIKE '%c%s%c'", 37, "paypalsandbox", 37);

		$record = self::$CI->db->query($strQry)->result();

		foreach($record as $rec) {
			if($rec->environ == '0')
			return sprintf("Host: %s", trim($live));
		}
		// 'Host: www.sandbox.paypal.com'
			return sprintf("Host: %s", trim($sandbox));

	}
}