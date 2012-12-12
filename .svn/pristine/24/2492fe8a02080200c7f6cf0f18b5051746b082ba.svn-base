<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * 
 * Checks a file if exist if not then it creates it.
 * 
 * @author Kenneth "digiArtist_ph" P. Vallejos
 * @since Sunday, November 13, 2011
 * @version 1.0
 *
 */
class File_maker {
	
	private $_mPath;
	private $_mFilename;
	private $_mCharStruct;
	public $mData;
	
	public function __construct($config = array()){
		
		//echo 'Initialising File Maker Class...<br />';
		
		// initializes some variables
		$this->_mPath = '';
		$this->_mFilename = '';
		$this->_mCharStruct = '';
		$this->mData = array();
		
		if(! empty($config)) {
			$this->initialize($config);
		}
	}
	
	/**
	 * 
	 * Anylizes the parameter being passed and executes some I/O function.
	 * 
	 * @param array $params The required indices are the following: "filename" & "path"
	 * @return boolean Returns TRUE/FALSE indicating the result of the action taken at hand.
	 */
	public function initialize($params = array()) {
		
		if(empty($params))
			return FALSE;
		
		// checks for thre required array indices
		if(! array_key_exists('filename', $params)) 
			return FALSE;
		else 
			$this->_mFilename = $params['filename'];
		
		if(! array_key_exists('path', $params))
			return FALSE;
		else
			$this->_mPath = $params['path']; 
		
		if(array_key_exists('char_struct', $params))
			$this->_mCharStruct = $params['char_struct'];			
			
		// checks if the specified file exists
		if($this->_fileIsExist($params['filename'])) {
			log_message('info', 'File ' . $params['filename'] . ' does exist.');
			
			if(!chmod($this->_appendSlash($this->_mPath) . $this->_mFilename, 0755)) {
				log_message('error', 'Changing mode not successful.');
				return FALSE;
			} else { 
				log_message('info', 'Changing mode successful.');
			}
			
			if(! $this->_isFileWritable($this->_appendSlash($this->_mPath) . $this->_mFilename)) {
				log_message('error', 'The file: ' . $this->_mFilename . '\ is not writable.');
				return FALSE;
			}
			
		} else {
			// creates the specified file
			$this->_makeFile();
		}
		
		return TRUE;
	}
	
	public function parseData() {
		$this->_readFileContents();
	}
	
	private function _fileIsExist() {
		
		if( ! file_exists($this->_appendSlash($this->_mPath) . $this->_mFilename))
			return FALSE;
			
		return TRUE;
	}
	
	private function _hasTrailingSlashes($path) {
		
		$pattern = '/[\w\W]*\/$/';
		
		if( ! preg_match($pattern, $path))
			return FALSE;
		
		return TRUE;
	}
	
	private function _appendSlash($path) {
		
		if(! $this->_hasTrailingSlashes($path))
			return $path . '/';
		
		return $path;
	}
	
	private function _isFileWritable($filename) {
		
		if( ! is_writable($filename))
			return FALSE;
			
		return TRUE;
	}
	
	private function _makeFile() {
		$strSession = "no_site_section:NOSESSIONVARIABLE";
		
		($this->_mCharStruct != '') ? $strSession = $this->_mCharStruct : $strSession;
			
		
		if(! $handle = fopen($this->_appendSlash($this->_mPath) . $this->_mFilename, "w"))
			return FALSE;
		
		if(! fwrite($handle, $strSession))
			return FALSE;
			
		fclose($handle);
		
		return TRUE;
	}
	
	private function  _readFileContents() {
		
		if($handle = fopen($this->_appendSlash($this->_mPath) . $this->_mFilename, "r")) {
			while (($buffer = fgets($handle, 4096)) !== FALSE) {			
				$arr = preg_split('/:/', $buffer);
				
				list($key, $val) = $arr;

				$this->mData[$key] = $val;
			}			
		}
	}
	
}