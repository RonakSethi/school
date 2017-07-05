<?php
/**
 * CloudinaryComponent 
 *  A component for Cloudinary images
 * 
 * @author Ryan Ye <ryanicle@gmail.com>
 * @license MIT License (http://www.opensource.org/licenses/mit-license.php)
 */
class CloudinaryComponent extends Component {
/**
 * @var $env
 */ 
	public $env = null;

/**
 * @var $path
 */
	public $path = null;
	
	public function __construct() {
		$this->env = Configure::read('Cloudinary.env');
		$this->path = Configure::read('Cloudinary.path');
	}
	
	
/**
  * Initializes CloudinaryComponent for use in the controller. Check to make sure that $env exists
 *
 * @see Component::initialize()
 * @param Controller $controller A reference to the instantiating controller object
 * @return void* 
 */
	public function initialize(Controller $controller) {
		// Calling Cloudinary library which is located in app/Vendor/Cloudinary
		if (file_exists(APP . 'Vendor' . DS . 'Cloudinary')) {
			include_once APP . 'Vendor' . DS . 'Cloudinary' . DS . 'Cloudinary.php';
			include_once APP . 'Vendor' . DS . 'Cloudinary' . DS . 'Uploader.php';
			include_once APP . 'Vendor' . DS . 'Cloudinary' . DS . 'Api.php';
		} else {
			throw new CakeException(__d('cake_dev', 'app/Vendor/Cloudinary is missing. Please download it from https://github.com/cloudinary/cloudinary_php'));
		}
	}
	
/**
 * Startup CloudinaryComponent for use in the controller
 *
 * @param Controller $controller A reference to the instantiating controller object
 * @return void
 */
	public function startup(Controller $controller) {
		$this->controller = $controller;
		
		if (empty($this->env)) {
			throw new CakeException(__d('cake_dev', 'Cloudinary.env is missing. Please set Cloudinary.env in app/Config/bootstrap.php'));	
		} else { 
			putenv($this->env);
		}
		
		if (empty($this->path)) {
			throw new CakeException(__d('cake_dev', 'Cloudinary.path is missing. Please set Cloudinary.path in app/Config/bootstrap.php'));
		} else {
			if (!file_exists($this->path)) {
				App::uses('Folder', 'Utility');
				$dir = new Folder($this->path, true, 0777);
			}
		}
	}
	
/**
 * Set env
 * 
 * @param string $env
 * @return void
 */	
	public function setEnv($env) {
		$this->env = $env;
	}
	
/**
 * Get env
 * 
 * @return $env
 */	
	public function getEnv() {
		return $this->env;
	}
	
/**
 * Set path
 * 
 * @param string $path
 * @return void
 */	
	public function setPath($path) {
		if (!empty($path)) $this->path = $path;
	}
	
/**
 * Get path
 * 
 * @return $path
 */	
	public function getPath() {
		return $this->path;
	}

/**
 * Upload file
 * 
 * @param string $file - file with absolute path. E.g., /your_path/your_image.png
 * @param array $options
 * @throws CakeException
 */
	public function upload($file = null, $options = array()) {
		if (!empty($file)) {
			if (file_exists($this->path . DS . $file)) {
				$status = \Cloudinary\Uploader::upload($this->path . DS . $file, $options);
				return $this->_extractUploadStatus($status);
			} else {
				throw new CakeException(__d('cake_dev', $this->path . DS . $file . ' is missing'));
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
			$status = \Cloudinary\Uploader::destroy($publicId, $options);
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