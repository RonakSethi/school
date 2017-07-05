<?php
/**
 *  Basically a wrapper for bootstrapping Cloudinary in various contexts
 */
class CakeCloudinary {

 public $cache_name = 'cloudinary';

/**
 * Import the vendor files (Cloudinary PHP Classes)
 *
 * @see 
 * @param 
 * @return void* 
 */
	public function initialize() {
		// init config
		Configure::load('cloudinary');
		$config = Configure::read('Cloudinary');
		$this->config = $config;

		Cache::config('cloudinary', array(
	    'engine' => 'File',
	    'duration' => '+12 hours',
	    'probability' => 100,
	    'path' => CACHE . 'cloudinary' . DS,
		));

		$this->env = $this->getEnv();
		$this->path = Configure::read('Cloudinary.path');

		// init libraries
		$import[] = App::import('Vendor', 'Cloudinary.cloudinary_php/src/Cloudinary');
		$import[] = App::import('Vendor', 'Cloudinary.cloudinary_php/src/Uploader');
		$import[] = App::import('Vendor', 'Cloudinary.cloudinary_php/src/Api');

		// check stuff
		if (empty($this->env)) {
			throw new CakeException(__d('cake_dev', 'Cloudinary.env is missing. Please set Cloudinary.env in app/Config/cloudinary.php'));	
		} else { 
			putenv($this->env);
		}
		
		if (empty($this->path)) {
			throw new CakeException(__d('cake_dev', 'Cloudinary.path is missing. Please set Cloudinary.path in app/Config/cloudinary.php'));
		} else {
			if (!file_exists($this->path)) {
				App::uses('Folder', 'Utility');
				$dir = new Folder($this->path, true, 0777);
			}
		}
		return $this;
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
		return 'CLOUDINARY_URL=cloudinary://'.$this->config['api_key'].':'.$this->config['secret'].'@'.$this->config['cloud_name'];
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

public function getCloudImage($publicId) {
	$cloudResource = $this->getResource($publicId);
	$cloudImage = array_filter(explode('/', $cloudResource['url']));
	if (count($cloudImage) > 1) {
		$cloudImage = $cloudImage[count($cloudImage)];
	}
	return $cloudImage;
}

/**
 * 
 * @param  string $publicId      [description]
 * @param  string $resource_type [description]
 * @param  string $type          [description]
 * @return [type]                [description]
 */
	public function getResource($publicId = '') {

		$return = false; // default lets fail
		$cache_key = 'cloudinary.'.$publicId.'.apicache';
		$exists = Cache::read($cache_key, $this->cache_name);

		if (!$exists) {
			if (!empty($publicId)) {
				 try {
					$api = new \Cloudinary\Api();
					$return = $api->resource($publicId);
					Cache::write($cache_key, $return, $this->cache_name);
				 } catch (Exception $e) {
				  	// fail!
				 }
			}
		} else {
			$return = $exists;
		}

		return $return;
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

?>