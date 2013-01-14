<?php if(! defined('BASEPATH')) exit('No direct script access allowed');
/*
 *
* This is a Cart Utility Class extend to N2E Solution Cart Library
* that manages order list session variables
*
* @license GPL
* @author Ian Paul F. Kionisala
* @since Wednesday, May 5, 2012
* @version 1.0
*
*
*/
class cart_utility {
	 
	// declare member variables
	private $_mOrder;
	private $_mOrderItem;
	private $_mCI;
	private $_mOrderList;
	private $_mPieces;
	private $_mCases;
	private $_mTotal_amount;
	
	public $_mItemList;
	
	public function __construct() {
		
		// initialize variables	
		$this->_mCI =& get_instance();
		$this->_mOrder = '';
		$this->_mOrderItem = '';
		$this->_mOrderList = '';
		$this->_mPieces = 0;
		$this->_mCases = 0;
		$this->_mTotal_amount = 0;
		$this->_mItemList = array();
		
		
		$this->_mCI->load->library('cart');
	}
	
	// read the cart session
	public function readString($params) {
		
		// get the total pcs
		$this->getTotalPcs($params);
		// get the total cases
		$this->getTotalCases($params);
		//get the total amount
		$this->getTotalAmount($params);
	
		// show the cart session
		$this->_mCI->cart->show();
		$sessCart = $this->_mCI->cart->_mData;
		
		$this->_mOrderList = $sessCart['order_list'];
	
		foreach($params as $key => $val) {
				
			$order[] = "'" .$key ."' => '" . $val . "'";
				
		}
		
		
		$orderItem = implode(",", $order);

		$this->_mOrderList = $this->_mOrderList . $orderItem . " + ";
		
		call_debug($this->_mOrderList);
		$this->writeString($this->_mOrderList);

		$this->writeTotalToCart($this->_mPieces, $this->_mCases, $this->_mTotal_amount);
	}
	
	// write session var
	public function writeString($params) { /* your two main functions */
		
		$this->_mOrder = $this->_mOrder . $params;
		
		$params = array(
				'order_list' => $this->_mOrder
		);
		
		$this->_mCI->cart->insert($params);
		
	}
	
	public function writeTotalToCart($totalPieces, $totalCases, $totalAmount) {
		
		$params = array(
				'order_total_pieces' => $totalPieces,
				'order_total_cases' => $totalCases,
				'order_total_amount' => $totalAmount
		);
		

		$this->_mCI->cart->insert($params);
		
	}
	
	// get the total pcs
	public function getTotalPcs($params) {
	
		
		$this->_mCI->cart->show();
		
		$sessCart = $this->_mCI->cart->_mData;
		
		$sessCart['order_total_pieces'];
		

		$this->_mPieces = $sessCart['order_total_pieces'] + $params['pieces'];
	}
	
	// get the total cases
	public function getTotalCases($params) {
		
		$this->_mCI->cart->show();
		
		$sessCart = $this->_mCI->cart->_mData;
		
		$sessCart['order_total_cases'];
		
		$this->_mCases = $sessCart['order_total_cases'] + $params['cases'];
	}
	
	// get the total amount
	public function getTotalAmount($params) {
		
		$this->_mCI->cart->show();
		
		$sessCart = $this->_mCI->cart->_mData;
		
		$sessCart['order_total_amount'];
		
		$this->_mTotal_amount = $sessCart['order_total_amount'] + $params['subtotal'];
	}
	
	// convert string to array
	public function stringToArray($params) {
		

		$orderArr = explode(',+', $params);
		
		$tmpArray = array();
		
		foreach($orderArr as $v) {
			if($v != "" && preg_match('/=>/',$v)):
			$tmpArray[] = $v;
			endif;
		}

		$array = $tmpArray;
		
		foreach($array as $k => $v):
		
			$tmpArray = preg_split("/,/", $v);

			// remove single qoute
			$pattern1 = "/'/";
			$array = preg_replace($pattern1, "", $tmpArray);
			//call_debug($array);
			foreach($array as $val) {
				$keyVal = preg_split('/=>/',$val);
			
				$cleandArray[$k][trim($keyVal[0])] = trim($keyVal[1]);
			}
			
		endforeach;
		
		$this->_mItemList = $cleandArray;
		

	}	
	
	public function update($params) {
		echo "working update <br />";
		
		
		$this->_mCI->cart->show();
		
		$sessCart = $this->_mCI->cart->_mData;
		
		$this->stringToArray($sessCart['order_list']);
		
		$selectedArr = $this->_mItemList[$params['row_id']];

			$itemcode = $params['item_code'];
			$itemname = $params['item_name'];
			$price = $params['unit_price'];
			$LC = $params['LC'];
			$packsize = $params['packsize'];
			$cases = $params['cases'];
			$pieces = $params['pieces'];
			$subtotal = $params['subtotal'];
			$pricetype = $params['pricetype'];			
	
			$this->_mItemList[$params['row_id']]['item_name'] = $itemname;
			$this->_mItemList[$params['row_id']]['unit_price'] = $price;
			$this->_mItemList[$params['row_id']]['LC'] = $LC;
			$this->_mItemList[$params['row_id']]['packsize'] = $packsize;
			$this->_mItemList[$params['row_id']]['cases'] = $cases;
			$this->_mItemList[$params['row_id']]['pieces'] = $pieces;
			$this->_mItemList[$params['row_id']]['subtotal'] = $subtotal;
			$this->_mItemList[$params['row_id']]['pricetype'] = $pricetype;	
		
		
			$this->arrayToString($this->_mItemList);

	}
	
	public function arrayToString($params) {
		echo "working arrayToString";
		
		//call_debug($params,false);
		for($i = 0; $i<count($params); $i++) {
			$arr[] = implode("=>", $params[$i]);
		}
	
		//call_debug($arr);
		
		for($j = 0; $j<count($arr); $j++) {
			$arrExp[] = explode("=>", $arr[$j]);
		}
	
		$tmpArray = array();
		foreach($arrExp as $key => $value) {
	 
			$tmpArray[$key] = array(
					
					'item_code' => $value['0'], 
					'item_name' => $value['1'],
					'unit_price' => $value['2'],
					'LC' => $value['3'],
					'packsize' => $value['4'],
					'cases' => $value['5'],
					'pieces' => $value['6'],
					'subtotal' => $value['7'],
					'pricetype' => $value['8']					
					);
		}

		$order = '';
		
		foreach($tmpArray as $first => $arrFirst) {
		
			foreach($arrFirst as $k => $v) {
				$order .= "'" .$k ."' => '" . $v . "',";
			}
			preg_match('/[\w\s\W\S\+]+(?=,)/', $order, $matches);
			$order= $matches[0];
			$order .= ' + ';
		}
		
	
		$this->writeString($order);
		
		
		// show the cart session
		$this->_mCI->cart->show();
		$sessCart = $this->_mCI->cart->_mData;
		
		$this->_mOrderList = $sessCart['order_list'];
		
		
		$this->stringToArray($this->_mOrderList);
		
		
		$totalCases = 0;
		foreach($this->_mItemList as $cases) {
			$totalCases = $cases['cases'] + $totalCases;
		}
		
		$totalPieces = 0;
		foreach($this->_mItemList as $pcs) {
			$totalPieces = $pcs['pieces'] + $totalPieces;
		}

		$totalAmount = 0;
		foreach($this->_mItemList as $total) {
			$totalAmount = $total['subtotal'] + $totalAmount;
		}

		
		$this->writeTotalToCart($totalPieces, $totalCases, $totalAmount);
		
	}
	
}