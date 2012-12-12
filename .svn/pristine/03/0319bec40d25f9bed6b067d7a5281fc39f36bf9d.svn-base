<?php if( !defined('BASEPATH')) exit('No direct script access allowed');
/**
 * CodeIgniter Data Model
 *
 * This model is a generic one
 *
 * @package			CodeIgniter
 * @subpackage    	Application/Model
 * @category        Model/Libraries
 * @author			Kenneth P. Vallejos
 * @link			http://n2esolutions.org
 * @version			2.0.3
 *
 *
 * SAMPLE CODE:
	$params['querystring'] = 'SELECT * FROM contents'; >>> optional <<<
	$params['fields'] = array('c_id' => '', 'section' => '', 'title' => '', 'fullcontent' => '', 'attribs' => array('link=option?about_us', 'menu=main',
																													 'count=101'); >>> optional <<<
	$params['table'] = array('name' => 'contents', 'criteria' => 'c_id', 'criteria_value' => '7', 'order_by' => '[fieldname][:[asc|desc]]');
        $params['table'] = array('name' => 'contents', 'criteria_phrase' => 'package like "%business%" and name!=""', 'order_by' => '[fieldname][:[asc|desc]]', 'limit' => '0:10');
        
	$this->mdlData->select($params);
	$data['records'] = $this->mdlData->_mRecords;
 *
 *
 */
class Mdldata extends CI_Model {
	
	private $_mSQLString;
	public $_mRecords;
	public $_mRowCount;
        
	public function __construct() {
		
            parent::__construct();
            // initializes some values
            $this->_mSQLString = '';
            $this->_mRecords = null;
            $this->_mRowCount = 0;

	}
	
	public function select($params) {
		if(empty($params))
			return FALSE;
			
		if(array_key_exists('querystring', $params)) {
			$this->_mSQLString = $params['querystring'];
		} else {
			$output = '';
			$output .= "SELECT ";
			
			// fields
			if(array_key_exists('fields', $params)) {
				$output .= $this->__stringConcatSelect($params['fields']);
			} else {
				$output .= " * ";
			}
			
			$output .=  " FROM " . $params['table']['name'];
			
			// where clause
                        if(array_key_exists('criteria_phrase', $params['table'])) {
                            $output .= " WHERE " . trim($params['table']['criteria_phrase']);
                        } else {
                            if(array_key_exists('criteria', $params['table'])) {
                                $output .= " WHERE " . $params['table']['criteria'] . "='" . $params['table']['criteria_value'] . "'";
                            }
			} 
			// order by clause
			if(array_key_exists('order_by', $params['table'])) {
                            $order = preg_split('/:/', $params['table']['order_by']);

                            switch(count($order)) {
                                    case 2:
                                            list($field, $flag) = $order;
                                            $output .= " ORDER BY " . $field . " " . $this->__order_by($flag);
                                            break;
                                    case 1:
                                            $output .= " ORDER BY " . $params['table']['order_by'] . " asc";
                            }				

			}
                        // offset
                        if(array_key_exists('limit', $params['table'])) {
                            $limit = preg_split('/:/', $params['table']['limit']);
                            
                            switch(count($limit)) {
                                case 2:
                                    list($offset, $lim) = $limit;
                                    $output .= " LIMIT " . $offset . ", " . $lim;
                                    break;
                                case 1:
                                    $output .= " LIMIT " . $params['table']['limit'];
                            }                            
                        }
			
			$this->_mSQLString = $output;		
		}
		
		$strQry = $this->_mSQLString;
		
		if($this->db->query($strQry)) {
			$this->_mRecords = $this->db->query($strQry)->result();
                        $this->_mRowCount = $this->__getRowCount();
			return TRUE;
		}
		
		return FALSE;
	}
	
	public function insert($params) {
		
		if(empty($params))
			return FALSE;
			
		if(array_key_exists('querystring', $params)) {
			$this->_mSQLString = $params['querystring'];
		} else {
			$output = '';
			$output .= "INSERT INTO " . $params['table']['name'];
			$output .= $this->__stringConcatInsert($params['fields']);

			$this->_mSQLString = $output;						
		}
		
		$strQry = $this->_mSQLString;
		
		if($this->db->query($strQry))
			return TRUE;
		
		return FALSE;
	}
	
	public function update($params) {
		
		if(empty($params))
			return FALSE;
			
		if(array_key_exists('querystring', $params)) {
			$this->_mSQLString = $params['querystring'];
		} else {
				
			$output = 'UPDATE ' . $params['table']['name'] . " SET ";
			$output .= $this->__stringConcatUpdate($params['fields']);
			$output .= " WHERE " . $params['table']['criteria'] . "='" . $params['table']['criteria_value'] . "'";
			$this->_mSQLString = $output;
		}
		
		$strQry = $this->_mSQLString;
		
		if($this->db->query($strQry))			
			return TRUE;
		
		return FALSE;
	}
	
	public function delete($params) {
		
		if(empty($params))
			return FALSE;
		
		if(array_key_exists('querystring', $params)) {
			$this->_mSQLString = $params['querystring'];
		} else {
				
			$output = 'DELETE FROM ' . $params['table']['name'];
			$output .= " WHERE " . $params['table']['criteria'] . "='" . $params['table']['criteria_value'] . "'";
			$this->_mSQLString = $output;
		}
		
		$strQry = $this->_mSQLString;
		
		if($this->db->query($strQry))
			return TRUE;
			
		return FALSE;
	}
	
	/**
	 *--------------------------------------------------------------
	 * UTILITIES 
	 *--------------------------------------------------------------
	 */
        private function __getRowCount() {
            
            $strQry = $this->_mSQLString;
            
            return $this->db->query($strQry)->num_rows();   
        }
        
	private function __stringConcatSelect($params) {
	
		$output = "";
		
		if(!empty($params)) {
			foreach($params as $key => $value):				
					$output .= $key . ", ";
			endforeach;	
		} 
		
		return rtrim($output, ", ");
		
	}	
	
	private function __stringConcatUpdate($params) {

		$output = "";
		
		if(!empty($params)) {
			foreach($params as $key => $value):				
				if(is_array($value)):
					$output .= $key . "='" . implode(", ", $value) . "', ";
				else :
					$output .= $key . "='" . $value . "', ";
				endif;
			endforeach;	
		} 
		
		return rtrim($output, ", ");
		
	}
	
	private function __stringConcatInsert($params) {
		
		$output1 = "(";
		$output2 = "VALUES(";
		
		if(!empty($params)) {
			foreach($params as $key => $value):				
				$output1 .= $key . ", ";
				if(is_array($value)):
					$output2 .= "'" . implode(", ", $value) . "', ";
				else :
					$output2 .= "'" . $value . "', ";
				endif;
			endforeach;	
		} 
		
		return rtrim($output1, ", ") . ") " . rtrim($output2, ", ") . ")";
	}
	
	private function __order_by($char) {
		$ptrnAsc = '/[\s]*a[\w]+/i';
		$ptrnDesc = '/[\s]*d[\w]+/i';
		
		if(preg_match($ptrnAsc, $char))
			$output = 'asc';
			
		if(preg_match($ptrnDesc, $char))
			$output = 'desc';
		
		return trim($output);
	}
	
	public function buildQueryString() {
		return $this->_mSQLString;
	}
	
	public function reset() {
		$this->_mSQLString = '';
		$this->_mRecords = null;
	}
	
	/*---------------        END      ------------------*/
}

