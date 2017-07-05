<?php
class ImageComponent extends Object {
    var $name = 'Image';
    private $file;
    private $image;
    private $info;
		
	public function prepare($file) {
		if (file_exists($file)) {
			$this->file = $file;

			$info = getimagesize($file);

			$this->info = array(
            	'width'  => $info[0],
            	'height' => $info[1],
            	'bits'   => $info['bits'],
            	'mime'   => $info['mime']
        	);
        	
        	$this->image = $this->create($file);
    	} else {
      		exit('Error: Could not load image ' . $file . '!');
    	}
	}
		
	public function create($image) {
		$mime = $this->info['mime'];
		
		if ($mime == 'image/gif') {
			return imagecreatefromgif($image);
		} elseif ($mime == 'image/png') {
			return imagecreatefrompng($image);
		} elseif ($mime == 'image/jpeg') {
			return imagecreatefromjpeg($image);
		}
    }	
	
    public function save($file, $quality = 100) {
     
        $info = pathinfo($file);
        $extension = strtolower($info['extension']);
   
        if ($extension == 'jpeg' || $extension == 'jpg') {
            imagejpeg($this->image, $file, $quality);
        } elseif($extension == 'png') {
            imagepng($this->image, $file, 0);
        } elseif($extension == 'gif') {
            imagegif($this->image, $file);
        }
		   
	    imagedestroy($this->image);
    }	    
	
    public function resize($width = 0, $height = 0,$r=255,$g=255,$b=255,$ratio=true) {
    	if (!$this->info['width'] || !$this->info['height']) {
			return;
		}

		$xpos = 0;
		$ypos = 0;

		$scale = min($width / $this->info['width'], $height / $this->info['height']);
		
		if ($scale == 1) {
			return;
		}
		
                if($ratio!=false)
                {
		$new_width = (int)($this->info['width'] * $scale);
		$new_height = (int)($this->info['height'] * $scale);			
    	$xpos = (int)(($width - $new_width) / 2);
   		$ypos = (int)(($height - $new_height) / 2);
        		        
       	$image_old = $this->image;
        $this->image = imagecreatetruecolor($width, $height);
		
		if (isset($this->info['mime']) && $this->info['mime'] == 'image/png') {		
			imagealphablending($this->image, false);
			imagesavealpha($this->image, true);
			$background = imagecolorallocatealpha($this->image, $r, $g, $b, 127);
			imagecolortransparent($this->image, $background);
		} else {
			$background = imagecolorallocate($this->image, $r, $g, $b);
		}
		
		imagefilledrectangle($this->image, 0, 0, $width, $height, $background);
	
        imagecopyresampled($this->image, $image_old, $xpos, $ypos, 0, 0, $new_width, $new_height, $this->info['width'], $this->info['height']);
        imagedestroy($image_old);
           
        $this->info['width']  = $width;
        $this->info['height'] = $height;
                }
                else
                {
                    
                    $new_width = (int)($width);
		$new_height = (int)($height);			
    	$xpos = (int)(($width - $new_width) / 2);
   		$ypos = (int)(($height - $new_height) / 2);
        		        
       	$image_old = $this->image;
        $this->image = imagecreatetruecolor($width, $height);
		
		if (isset($this->info['mime']) && $this->info['mime'] == 'image/png') {		
			imagealphablending($this->image, false);
			imagesavealpha($this->image, true);
			$background = imagecolorallocatealpha($this->image, $r, $g, $b, 127);
			imagecolortransparent($this->image, $background);
		} else {
			$background = imagecolorallocate($this->image, $r, $g, $b);
		}
		
		imagefilledrectangle($this->image, 0, 0, $width, $height, $background);
	
        imagecopyresampled($this->image, $image_old, $xpos, $ypos, 0, 0, $new_width, $new_height, $this->info['width'], $this->info['height']);
        imagedestroy($image_old);
           
        $this->info['width']  = $width;
        $this->info['height'] = $height;
                    
                }
        
        
    }
    
    public function watermark($file, $position = 'bottomright') {
        $watermark = $this->create($file);
        
        $watermark_width = imagesx($watermark);
        $watermark_height = imagesy($watermark);
        
        switch($position) {
            case 'topleft':
                $watermark_pos_x = 0;
                $watermark_pos_y = 0;
                break;
            case 'topright':
                $watermark_pos_x = $this->info['width'] - $watermark_width;
                $watermark_pos_y = 0;
                break;
            case 'bottomleft':
                $watermark_pos_x = 0;
                $watermark_pos_y = $this->info['height'] - $watermark_height;
                break;
            case 'bottomright':
                $watermark_pos_x = $this->info['width'] - $watermark_width;
                $watermark_pos_y = $this->info['height'] - $watermark_height;
                break;
        }
        
        imagecopy($this->image, $watermark, $watermark_pos_x, $watermark_pos_y, 0, 0, 120, 40);
        
        imagedestroy($watermark);
    }
    
    public function crop($top_x, $top_y, $bottom_x, $bottom_y) {
        $image_old = $this->image;
        $this->image = imagecreatetruecolor($bottom_x - $top_x, $bottom_y - $top_y);
        
        imagecopy($this->image, $image_old, 0, 0, $top_x, $top_y, $this->info['width'], $this->info['height']);
        imagedestroy($image_old);
        
        $this->info['width'] = $bottom_x - $top_x;
        $this->info['height'] = $bottom_y - $top_y;
    }
    
    public function rotate($degree, $color = 'FFFFFF') {
		$rgb = $this->html2rgb($color);
		
        $this->image = imagerotate($this->image, $degree, imagecolorallocate($this->image, $rgb[0], $rgb[1], $rgb[2]));
        
		$this->info['width'] = imagesx($this->image);
		$this->info['height'] = imagesy($this->image);
    }
	    
    private function filter($filter) {
        imagefilter($this->image, $filter);
    }
            
    private function text($text, $x = 0, $y = 0, $size = 5, $color = '000000') {
		$rgb = $this->html2rgb($color);
        
		imagestring($this->image, $size, $x, $y, $text, imagecolorallocate($this->image, $rgb[0], $rgb[1], $rgb[2]));
    }
    
    private function merge($file, $x = 0, $y = 0, $opacity = 100) {
        $merge = $this->create($file);

        $merge_width = imagesx($image);
        $merge_height = imagesy($image);
		        
        imagecopymerge($this->image, $merge, $x, $y, 0, 0, $merge_width, $merge_height, $opacity);
    }
			
	private function html2rgb($color) {
		if ($color[0] == '#') {
			$color = substr($color, 1);
		}
		
		if (strlen($color) == 6) {
			list($r, $g, $b) = array($color[0] . $color[1], $color[2] . $color[3], $color[4] . $color[5]);   
		} elseif (strlen($color) == 3) {
			list($r, $g, $b) = array($color[0] . $color[0], $color[1] . $color[1], $color[2] . $color[2]);    
		} else {
			return FALSE;
		}
		
		$r = hexdec($r); 
		$g = hexdec($g); 
		$b = hexdec($b);    
		
		return array($r, $g, $b);
	}
        
        
        
      public  function roundcorner($sourceImageFile, $outputfile,$radius='8') {
    # test source image
    
    if (file_exists($sourceImageFile)) {
      $res = is_array($info = getimagesize($sourceImageFile));
      } 
    else $res = false;

    # open image
    if ($res) {
      $w = $info[0];
      $h = $info[1];
      switch ($info['mime']) {
        case 'image/jpeg': $src = imagecreatefromjpeg($sourceImageFile);
          break;
        case 'image/gif': $src = imagecreatefromgif($sourceImageFile);
          break;
        case 'image/png': $src = imagecreatefrompng($sourceImageFile);
          break;
        default: 
          $res = false;
        }
      }

    # create corners
    if ($res) {

      $q = 10; # change this if you want
      $radius *= $q;

      # find unique color
      do {
        $r = rand(0, 255);
        $g = rand(0, 255);
        $b = rand(0, 255);
        }
      while (imagecolorexact($src, $r, $g, $b) < 0);

      $nw = $w*$q;
      $nh = $h*$q;

      $img = imagecreatetruecolor($nw, $nh);
      $alphacolor = imagecolorallocatealpha($img, $r, $g, $b, 127);
      imagealphablending($img, false);
      imagesavealpha($img, true);
      imagefilledrectangle($img, 0, 0, $nw, $nh, $alphacolor);

      imagefill($img, 0, 0, $alphacolor);
      imagecopyresampled($img, $src, 0, 0, 0, 0, $nw, $nh, $w, $h);

      imagearc($img, $radius-1, $radius-1, $radius*2, $radius*2, 180, 270, $alphacolor);
      imagefilltoborder($img, 0, 0, $alphacolor, $alphacolor);
      imagearc($img, $nw-$radius, $radius-1, $radius*2, $radius*2, 270, 0, $alphacolor);
      imagefilltoborder($img, $nw-1, 0, $alphacolor, $alphacolor);
      imagearc($img, $radius-1, $nh-$radius, $radius*2, $radius*2, 90, 180, $alphacolor);
      imagefilltoborder($img, 0, $nh-1, $alphacolor, $alphacolor);
      imagearc($img, $nw-$radius, $nh-$radius, $radius*2, $radius*2, 0, 90, $alphacolor);
      imagefilltoborder($img, $nw-1, $nh-1, $alphacolor, $alphacolor);
      imagealphablending($img, true);
      imagecolortransparent($img, $alphacolor);

      # resize image down
      $dest = imagecreatetruecolor($w, $h);
      imagealphablending($dest, false);
      imagesavealpha($dest, true);
      imagefilledrectangle($dest, 0, 0, $w, $h, $alphacolor);
      imagecopyresampled($dest, $img, 0, 0, 0, 0, $w, $h, $nw, $nh);
        
        $res = $dest;
      imagepng( $res,$outputfile );
      }
    }
    
}
?>
