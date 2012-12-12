<?php if( !defined('BASEPATH')) exit('No direct script access allowed');
/**
 * CodeIgniter Data Model
 *
 * This model is a generic one
 *
 * @package		CodeIgniter
 * @subpackage 	Application/Model
 * @category   	Model/Libraries
 * @author		Kenneth "digiArtist_ph" P. Vallejos
 * @link		http://n2esolutions.org
 * @since		Mid 2011
 * @version		2.3.5
 *
 *
 * 
 * Instructions:
 *      SELECT QUERY:
 *          $params['querystring']     // SQL query strings >>> OPTIONAL | if this is supplied the rest of the indices and values of the array are ignored.
 *                                          e.i. $params['querystring'] = 'SELECT * FROM <table name> WHERE ... ORDER BY ... LIMIT N, M';
 * 
 *          $params['table']['name']    // Name of the table to query from >>> REQUIRED
 *                                          e.i. $params['table'] = array('name' => '<table name>');
 * 
 *          $params['fields']           // This index has the actual (not an alias) column/field names of the table. >>> OPTIONAL | If this "fields" index is omitted
 *                                         the whole column/fields of the table are returned.
 *                                         [Note 1] : When defining the "fields" index it should contain an array with KEY => VALUE pair
 *                                              e.i: $params['fields'] = array('<colname1>' => '<colvalue1>', 'colname2' => 'colvalue2', ... , 'colnameN' => 'colvalueN');
 *                                         [Note 2]: When defining "fields" index it should not have an array which has BLANK KEY => VALUE pair.
 *                                              e.i. 1. >>> $params['fields'] = array(); (CAUSES ERRORS)
 *                                              e.i. 2. >>> $params['fields'] = array('' => '', '<colname1>' => 'colvalue1'); (CAUSES ERRORS)
 *                                         [Note 3]. When assigning an array to "fields" index, the array could have a BLANK values. This is logical way in SELECT QUERIES
 *                                                   but it is the otherwise in INSERT QUERIES.
 *                                              e.i. e.i: $params['fields'] = array('<colname1>' => '', '<colname2>' => '', ... , '<colnameN>' => '');
 * 
 * 
 *          $params['table']['criteria']        // This is the column name of the table in the WHERE CLAUSE >>> OPTIONAL
 *          $params['table']['criteria_value']  // This is the column value of the table in the WHERE CLAUSE >>> OPTIONAL
 *                                              e.i. $params['table'] = array('criteria' => '<colname>', 'criteria_value' => 'colvalue');
 * 
 *          $params['table']['criteria_phrase'] // This is the WHERE CLAUSE in QUERY STRING form >>> OPTIONAL
 *                                              e.i. $params['table']['criteria_phrase'] = '(<colname1>="<value1" and <colname2>="<value2>") or <colname3> like "%<value3>%" ';
 *          
 *          $params['table']['order_by']        // This is the ORDER BY CLAUSE >>> OPTIONAL
 *                                              e.i. $params['table']['order_by'] = '<fieldname>:asc';
 *                                                   $params['table']['order_by'] = '<fieldname>:desc';
 *                                                   $params['table']['order_by'] = '<fieldname>'; >> asc is the default
 *                                                   $params['table'] = array('order_by' => '<fieldname>:desc');
 *          $params['table']['limit']           // This is the LIMIT CLAUSE
 *                                              e.i. $params['table'] = array('limit' => '<startfrom>:<noofrecords>');
 *                                                   $params['table']['limit'] = '0:10';
 *          INSERT QUERY:
 *              $params['querystring']  >>> OPTIONAL
 *                                          e.i. $params['querystring'] = 'INSER INTO <table name>(<colname1>, <colname2> ... , <colnameN>) VALUES("<colvalue1>", "<colvalue2>", ... , "<colvalueN>" )';
 *              $params['table']    >>> REQUIRED
 *              $params['fields']   >>> REQUIRED
 *                                          e.i. $params['fields'] = array('<colname1>' => '<colvalue1>', 'colname2' => 'colvalue2', ... , 'colnameN' => 'colvalueN');
 *                                          e.i. $params['fields'] = array(
 *                                                                          'c_id' => '', 
 *                                                                          'section' => '', 
 *                                                                          'title' => '', 
 *                                                                          'fullcontent' => '', 
 *                                                                          'attribs' => array('link=option?about_us', 'menu=main',
 *                                                                          );
 *																													 'count=101'); >>> optional <<<
 *          UPDATE QUERY:
 *              $params['table']        >>> REQUIRED
 *              $params['fields']       >>> REQUIRED
 *                                          e.i. $params['fields'] = array('<colname1>' => '<colvalue1>', 'colname2' => 'colvalue2', ... , 'colnameN' => 'colvalueN');
 *                                          e.i. $params['fields'] = array(
 *                                                                          'c_id' => '', 
 *                                                                          'section' => '', 
 *                                                                          'title' => '', 
 *                                                                          'fullcontent' => '', 
 *                                                                          'attribs' => array('link=option?about_us', 'menu=main',
 *                                                                          );
 *         DELETE QUERY:
 *             $params['table']                         >>> REQUIRED
 *             $params['table']['criteria']             >>> REQUIRED
 *             $params['table']['criteria_value']       >>> REQUIRED
 *                                                          e.i. $params['table'] = array('name' => '<table name>', 'criteria' => '<colname>', 'criteria_value' => '<colvalue>');

 *         TRANSACTION: 
 *             $params['transact']                  // This will execute several queries in one batch and commit/saves those into the   >>> REQUIRED
 *                                                     database if no error/s occured, otherwise all queries are rolled back/undos all
 *                                                     queries that have been executed against the database.
 *                                                     THIS ASSURES the CREDIBILITY and ATOMICITY of the data inside the database
 *                                                     [Note] : The TRANSACTTION is available when the table's engine is INNODB only.
 *                                                      e.i. $params['transact'] = array(
 *                                                                                          'AN SQL QUERY...',
 *                                                                                          'ANOTHER QUERY...',
 *                                                                                          'AND YET ANOTHER QUERY...'
 *                                                                                       );
 * 
 * 		   STORED PROCEDURE:
 * 				Stored procedures can have parameters or don't have any at all. It depends on their definition on the RDBMS server
 * 				
 * 												e.i. 
 * 													( associative type )
 * 													$params = array(
 * 																	'title' => $cart['adTitle'],
 *																	'subcategory' => $cart['adCategories'],
 *																	'images' => $cart['adImages'],
 *																	'advr' => $this->_getUserID()
 *																	);
 *								
 *																				OR
 *													( indexed type )
 *													$params = array(
 * 																	$cart['adTitle'],
 * 																	$cart['adCategories'],
 * 																	$cart['adImages'],
 * 																	$this->_getUserID()
 *																	);
 *								
 * 													$this->mdldata->executeSP('sp_add_listing', $params);
 * 
 * 				NOTES: 	1. Store procedure's array parameter. This type of array can be an indexed or associative array (please see above examples).
 * 					   		When using an associative type of array parameter, make sure the values of your key=>value pair array are the ones you intended
 * 					   		to pass in to the called stored procedure.
 * 						
 * 						2. Make sure to use 'mysqli' db driver than that of the default db driver, which is 'mysql'
 * 							2.1 Change the database.php file located at ./application/config/
 * 								e.i: $db['default']['dbdriver'] = 'mysqli'; // 'mysql' - default;		
 * 
 * 
 *      SAMPLE CODE 1:
 *          {CONTROLLER}
 *              params['transact'] = array(                                        
 *                                       'INSERT INTO list(name_title, address) VALUES("Beauty Salon", "Cagayan de Oro City")',
 *                                       'INSERT INTO account(email, fname) VALUES("somemadil@someddomain", "John")',
 *                                       'SELECT * FROM account'
 *                                   );
 *           
 *              $this->mdldata->reset();
 *              if($this->mdldata->executeTransact($params))
 *                  echo 'success';
 *              else
 *                  echo 'failed';
 * 
 *      SAMPLE CODE 2:
 *          {CONTROLLER}
 *      
 *              $this->mdldata->reset();
 *              $params['table'] = array('name' => 'package_features', 'criteria_phrase' => 'package like "%business%" and name!=""', 'limit' => '0:10');                
 *              $this->mdldata->select($params);
 *		$data['records'] = $this->mdldata->_mRecords;
 *		$data['rowCount'] = $this->mdldata->_mRowCount;
 * 
 * 
 * 
 *      SAMPLE CODE 3:
 *          {CONTROLLER}
 * 
 *              $params = array(
 *                           'table' => array('name' => 'account'),
 *                           'fields' => array(
 *                                       'email' => $this->input->post('email'),
 *                                       'pword' => md5($this->input->post('password')),
 *                                       'fname' => $this->input->post('fname'),
 *                                       'lname' => $this->input->post('lname'),
 *                                       'add1' => $this->input->post('address'),
 *                                       'country' => $this->input->post('country')
 *                                       )                                
 *                               );
 *               
 *               $this->mdldata->reset();
 *               $this->mdldata->insert($params)
 * 
 *  
 */

class Mdldata extends CI_Model {

	
	private $_mSQLString;
        private $_mSQLText;
	public $_mRecords;
	public $_mRowCount;        
        
	public function __construct() {
		
            parent::__construct();
            // initializes some values
            $this->_mSQLString = '';
            $this->_mRecords = null;
            $this->_mRowCount = 0;
            $this->_mSQLText = FALSE; // flags the methods (select, insert, update & delete) will not execute the query instead generate an SQL QUERY text/string.

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
			if(array_key_exists('fields', $params) && !empty ($params['fields'])) {
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
                        
                        if($this->_mSQLText)
                            return TRUE;
		}
		
		$strQry = $this->_mSQLString;
		
		// @neerevisit: enabled method to throw Exception 
		/* if($this->db->query($strQry)) {
			$this->_mRecords = $this->db->query($strQry)->result();
                        $this->_mRowCount = $this->__getRowCount();
			return TRUE;
		}
		
		return FALSE; */
		
		if(!$this->db->query($strQry)) {			
			throw new Exception("Unable to query records");
		}
		
		$this->_mRecords = $this->db->query($strQry)->result();
		$this->_mRowCount = $this->__getRowCount();
		
		return TRUE;
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
                        
                        if($this->_mSQLText)
                            return TRUE;
		}
		
		$strQry = $this->_mSQLString;
		
		// @neerevisit: enabled method to throw Exception
		/* if($this->db->query($strQry))
			return TRUE;
		
		return FALSE; */
		if(!$this->db->query($strQry)) {
			throw new Exception('Something goes wrong');
		}
		
		return TRUE;
		
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
                        
                        if($this->_mSQLText)
                            return TRUE;
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
                        
                        if($this->_mSQLText)
                            return TRUE;
		}
		
		$strQry = $this->_mSQLString;
		
		if($this->db->query($strQry))
			return TRUE;
			
		return FALSE;
	}
        
        public function executeTransact($params) {
            
            if(array_key_exists('querystring', $params))
                return FALSE;
            
            if(!array_key_exists('transact', $params)) {
                return FALSE;
            } else {
                if(empty ($params['transact']))
                    return FALSE;
               
                // starts the transaction
                $this->db->trans_begin();
                
                // executes each query in the array
                foreach($params['transact'] as $t) {
                    $this->db->query($t);               
                }
                
                // checks for the ATOMICITY of the transaction done
                if ($this->db->trans_status() === FALSE) {
                    $this->db->trans_rollback();
                    return FALSE;                
                } else {
                    $this->db->trans_commit();
                }   
            }
            
            return TRUE;
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
		
	public function buildQueryString() {
		return $this->_mSQLString;
	}
	
	public function reset() {
		$this->_mSQLString = '';
		$this->_mRecords = null;
	}
	
	public function SQLText($flag) {
		$this->_mSQLText = $flag;            
	}
	
	public function executeSP($procName, $params = array()) {

		if(empty($params)){
			if(!$this->db->query("CALL $procName()"))
				throw new Exception('Unable to execute ' . $procName . ' stored procedure.');
			
		} else {
			if(!$this->db->query("CALL $procName(" . $this->_implodeParameters($params). ")", $this->_safe_escape($params)))
				throw new Exception('Unable to execute ' . $procName . ' stored procedure.');
		}
		
		return TRUE;
		
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
	
	/**
	 * Escapes string from HTML entities
	 * @param array $params
	 * @return array
	 */
	private function _safe_escape($params) {
		if(empty($param))
			return $params;
	
		foreach ($params as $node):
			$node = $this->db->escape($node);
		endforeach;		
		
		return $params;
	}
	
	private function _implodeParameters($params) {
		$output = '';
		
		for($i = 0; $i < count($params); $i++) {
			$output .= "?, ";
		}
		
		preg_match('/[?, ]+(?=,)/', $output, $matches);
		$output = $matches[0];
		
		return $output;
	}
	/*---------------        END      ------------------*/
}

