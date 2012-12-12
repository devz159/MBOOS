<?php if ( !defined('BASEPATH')) exit('No direct script access allowed.');
/**
 * 
 * This is multipleupload class
 * that enable users to upload multiple files into server.
 * and creates a thumbnail image of the original image
 * 
 * @license GPL
 * @author Kenneth "digiArtist_ph" P. Vallejos
 * @since Saturday, January 21, 2012
 * @version 1.0.0
 * 
 * Instructions:
 * 		
 * 		Requirements:
 * 			1. Create a folder where the uploaded images to be stored into. e.i. 'uploads'. 
 * 			2. Create a folder where the thumbnail images are to be stored into. e.i. 'thumbs'. 'thumbs' folder should be placed inside the 'uploads' folder.
 * 
 * 			folder structure should look like this:
 * 				sitename/uploads/thumbs
 
 * 			note: Make sure the two required folders have a write permission on them, So the system can create images files in them.
 * 
 *  
 * 		SAMPLE CODE:
 * 			$config = array	(
 *							'upload_path' => 'uploads/',
 *							'allowed_types' => 'gif|jpg|png',
 *							'max_size' => '100',
 *							'max_width' => '2500',
 *							'max_height' => '2500'
 *						);
 *						
 *			$this->load->library('multipleupload', $config);
 *		
 *			if(! $this->multipleupload->do_upload()) {
 *				echo '$this->multipleupload->display_errors()';
 *			} else {
 *				echo 'success';
 *			}
 *
 *
 */
class Multipleupload {
	public $_mData;
	public $_mErrors;
	private $CI;
	private $FILES;
	private $_mFields;
	
	
	public function __construct($params = array()) {
		echo 'Initializing Multipleupload Class...<br />';
		
		// initializes some member variables
		$this->_mData = array();
		$this->FILES = null;
		$this->_mErrors = array();
		$this->_mFields = array();
		
		$this->CI =& get_instance(); // references to core of ci
	
		if( ! empty($params))
			$this->initialize($params);
		
	}
	
	public function initialize($params = array()) {
		
		if(empty($params))
			return FALSE;		
			
		foreach($params as $key => $val): 			
			$this->$key = $val;			
		endforeach;
		
		if(count($this->_mFields) <= 0)
			return FALSE;
		
		if(! empty($_FILES['file'])) {
				foreach($_FILES['file'] as $k =>  $file):
					
					$cntr = 0;
					
					foreach($file as $v):
						$_FILES['tmpFile'][$cntr][$k] = $v;
						$cntr++;
					endforeach;
					
				endforeach;
				
				$this->FILES = $_FILES['tmpFile'];
				/*				
				call_debug($this->FILES, FALSE);
				echo 'Member variables: <br />';
				call_debug($this->_mFields, FALSE);
				*/
		}
			
		return TRUE;
	}
	
	public function __set($mVarName, $mVarValue) {
		
		$this->_mFields[$mVarName] = $mVarValue;
		
	}
	
	public function  do_upload($file = 'userfile') {
		
		$this->CI->load->library('upload');
		$this->CI->load->library('image_lib');
		
		$cntr = 0;
		// loop the whole $FILES array		
		foreach($this->FILES as $key => $val):
		
			$_FILES[$file] = $this->FILES[$cntr];
			 
			
			// calls the initialize method of upload class
			$this->CI->upload->initialize($this->_mFields);
			
			// uploads file to the server
			if(! $this->CI->upload->do_upload()) {		
				$this->_mErrors = $this->CI->upload->display_errors();
				return FALSE;
			}
			
			// resizes the image into smaller version (thumbnails)
			$config['image_library'] = 'gd2';
			$config['source_image'] = $_FILES[$file]['tmp_name'];
			$config['new_image'] = 'uploads/thumbs/' . $_FILES[$file]['name'];
			$config['create_thumb'] = TRUE;
			$config['maintain_ratio'] = TRUE;
			$config['width'] = 75;
			$config['height'] = 50;
			
			$this->CI->image_lib->initialize($config);
			if( ! $this->CI->image_lib->resize()) {
				$this->_mErrors = $this->CI->image_lib->display_errors();
				return FALSE;
			}
			
			$cntr++;
		endforeach;
	
		return TRUE;
	}
	
	public function display_errors() {
		return $this->_mErrors;
	}
	
}