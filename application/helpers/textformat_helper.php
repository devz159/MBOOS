<?php if(! defined('BASEPATH')) exit('No direct script access allowed');

if( ! function_exists('parseHTMLText')) {
	function parseHTMLText($text, $tosql = TRUE) {
		
		if($tosql) { // from textarea to MySQL
			$text = preg_replace('/[\r]/', "<br />", $text, ENT_QUOTES);
			$text = preg_replace('/\n/', '', $text);
			$text = htmlentities($text, ENT_QUOTES);
			return $text;
		} else { // from MySQL to textarea
			$text = html_entity_decode($text, ENT_QUOTES);
			$text = preg_replace('/<br \/>/', "\n", $text);
			
			return $text;
		}
	}
}

if ( !function_exists('genSelectMonth')) {
        function genSelectMonth() {
            $output = '';
            
            $output .=  '<select name="month">' .
                            '<option value="01">01</option>' .
                            '<option value="02">02</option>' .
                            '<option value="03">03</option>' .
                            '<option value="04">04</option>' .
                            '<option value="01">05</option>' .
                            '<option value="01">06</option>' .
                            '<option value="01">07</option>' .
                            '<option value="01">08</option>' .
                            '<option value="01">09</option>' .
                            '<option value="01">10</option>' .
                            '<option value="01">11</option>' .
                            '<option value="01">12</option>' .             
                        '</select>';
            
            return $output;
        }
}

if ( !function_exists('genSelectYear')) {
    function genSelectYear() {
        $output = '';
        
        $output .=  '<select name="year">' .
                        '<option value="2011">2011</option>' . 
                        '<option value="2012">2012</option>' . 
                        '<option value="2013">2013</option>' . 
                        '<option value="2014">2014</option>' . 
                        '<option value="2015">2015</option>' . 
                        '<option value="2016">2016</option>' . 
                        '<option value="2017">2017</option>' . 
                        '<option value="2018">2018</option>' . 
                        '<option value="2019">2019</option>' . 
                        '<option value="2020">2020</option>' . 
                        '<option value="2021">2021</option>' . 
                        '<option value="2022">2022</option>' . 
                        '<option value="2023">2023</option>' . 
                        '<option value="2024">2024</option>' . 
                        '<option value="2025">2025</option>' . 
                        '<option value="2026">2026</option>' . 
                        '<option value="2027">2027</option>' . 
                        '<option value="2028">2028</option>' . 
                        '<option value="2029">2029</option>' . 
                        '<option value="2030">2030</option>' . 
                        '<option value="2031">2031</option>' . 
                    '</select>'; 
        
        return $output;
    }
}

if ( !function_exists('genSelectCountry')) {
    function genSelectCountry($params = array()) {
        $CI =& get_instance();
        $strQry = "SELECT * FROM cj_country";
        $countries = $CI->db->query($strQry)->result();

        $output = '';

        if(!empty ($params)){
            $output .= '<select name="country" ' . prep_html_property($params) . '>';
        } else {
            $output .= '<select name="country">';
        }
        foreach ($countries as $country) {
            $output .= '<option value="' . $country->cid . '">' . $country->cname . '</option>';
        }    

        $output .= '</select>';

        return $output;
    }
}

if( !function_exists('prep_html_property')) {
    function prep_html_property($params = array()) {
        $output = '';

        foreach($params as $key => $val) {
            $output .= $key . '="' . $val . '" ';
        }

        return trim($output);
    }
}
