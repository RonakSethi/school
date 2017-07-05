<?php
/**
 * CloudinaryComponent 
 *  A component for Cloudinary images
 * 
 * @author Ryan Ye <ryanicle@gmail.com>
 * @author Ken Garland <ken@ufn.com>
 * @license MIT License (http://www.opensource.org/licenses/mit-license.php)
 */

App::import('Vendor', 'Cloudinary', array('file' => 'Cloudinary/Cloudinary.php'));
App::import('Vendor', 'Uploader', array('file' => 'Cloudinary/Uploader.php'));
App::import('Vendor', 'Api', array('file' => 'Cloudinary/Api.php'));
class CloudinaryComponent extends Component {
/**
 * @var $env
 */ 
	public $env = null;


	public function __construct() {
		$this->env = Configure::read('Cloudinary.env');
	}
	
	
/**
  * Initializes CloudinaryComponent for use in the controller. Check to make sure that $env exists
 *
 * @see Component::initialize()
 * @param Controller $controller A reference to the instantiating controller object
 * @return void* 
 */
	public function initialize(Controller $controller) {
		$this->env = Configure::read('Cloudinary.env');
		$this->path = Configure::read('Cloudinary.path');
		\Cloudinary::config(array( 
        "cloud_name" => "sample", 
        "api_key" => "929226218221797", 
        "api_secret" => "VfOHR7wFC6cfkjy1z6b4dk6xq_c" 
       ));

	}
	
/**
 * Startup CloudinaryComponent for use in the controller
 *
 * @param Controller $controller A reference to the instantiating controller object
 * @return void
 */
	public function startup(Controller $controller) {
		$this->Controller = $controller;
		$this->Api = new \Cloudinary\Api(); // Vendor file use namespace so we load it differently.
		$this->Uploader = new \Cloudinary\Uploader(); // Vendor files uses namespace so we load it differently.
		$this->Cloudinary = new Cloudinary();
		
		if (empty($this->env)) {
			throw new CakeException(__d('cake_dev', 'Cloudinary.env is missing. Please set Cloudinary.env in app/Config/bootstrap.php'));	
		} else { 
			putenv($this->env);
		}
	}
	
/**
 * Upload file
 * 
 * @param string $file - file with absolute path. E.g., /your_path/your_image.png
 * @param array $options
 * @throws CakeException
 */
	public function upload($file = null, $options = null) {
		if (!empty($file)) {
			echo 'g';
			pr($file);
			if (!empty($file['tmp_name'])) {
				echo 'o';
				$status = $this->Uploader->upload($file['tmp_name'], $options);
				
				return $this->_extractUploadStatus($status);
			echo 'o';
			} else {
				throw new CakeException(__d('cake_dev', $file['tmp_name'] . ' is missing'));
			}
		} else {
			throw new CakeException(__d('cake_dev', $file . ' is missing'));
		}
	}

/**
 * Delete file using public ID
 * 
 * @param string $publicId
 * @param array $options
 * @throws CakeException
 */
	public function delete($publicId = null, $options = array()) {
		if (!empty($publicId)) {
			$status = $this->Uploader->destroy($publicId, $options);
			if ($status['result'] == 'ok') {
				return true;
			} else {
				throw new CakeException(__d('cake_dev', $publicId . ' is not found or already deleted.'));
			}
		} else {
			throw new CakeException(__d('cake_dev', 'Public ID is missing'));
		}
	}

/**
 * Extract version and public_id based on secure_url
 * 
 * @param array $status
 * @return array
 */
	protected function _extractUploadStatus($status) {
		$url = parse_url($status['secure_url']);
		$path = explode('/', $url['path']);
		
		$imageInfo = explode('.', $path['5']);
		
		return array(
			'name' => $path['5'],
			'version' => $path['4'],
			'public_id' => $imageInfo[0]
		);
	}
	
/**
 * Implement in future
 * 
 * @param unknown $tag
 * @param unknown $publicIds
 * @param unknown $options
 */
	public function add_tag($tag, $publicIds = array(), $options = array()) {
		
	}

/**
 * Implement in future
 * 
 * @param unknown $tag
 * @param unknown $public_ids
 * @param unknown $options
 */
	public function remove_tag($tag, $public_ids = array(), $options = array()) {
		
	}
	
/**
 * Implement in future
 * 
 * @param unknown $tag
 * @param unknown $public_ids
 * @param unknown $options
 */
	public function replace_tag($tag, $public_ids = array(), $options = array()) {
		
	}
}