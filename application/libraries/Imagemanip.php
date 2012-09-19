<?php (defined('BASEPATH')) OR exit('No direct script access allowed');

class Imagemanip
{
	const max_pixel_width = 1024;
	const max_pixel_height = 768;
	
	protected $path_to_orig_directory = 'user_content/images/original/';
	protected $path_to_thumb_directory = 'user_content/images/generated_cache/';
	protected $path_to_fonts = 'web/fonts/';
	
	protected $existing_filters = array("sepia", "invert", "sharpen", "sharpen_little");
	protected $filename_original;
	protected $filename_thumb;
	protected $crop;
	protected $width;
	protected $height;
	protected $width_original;
	protected $height_original;
	protected $filters;
	protected $alt;
	protected $tag;
	protected $tag_pos;
	
	public function __construct($orig_filename = '', $crop = 'no', $w = 100, $h = 75, $filters = array(), $alt = '', $tag = '') {
		if($orig_filename != '') {
			$this->create($orig_filename,$crop,$w,$h,$filters,$alt,$tag);
		}
	}
	
	
	public function create($orig_filename = '', $crop = 'no', $w = 100, $h = 75, $filters = array(), $alt = '', $tag = '') {
		$this->set_orig_filename($orig_filename);
		$this->set_crop($crop);
		$this->set_width($w);
		$this->set_height($h);
		$this->set_filters($filters);
		$this->set_alt($alt);
		$this->set_tag($tag);
		$this->set_tag_pos(5);
	}
	
	public function __toString() {
		return $this->get_filepath(FALSE);
	}
	
	public function get_filepath($fullsize = FALSE) {
		$this->genereate_filename($fullsize);
		$this->generate_image($fullsize);
		return base_url().$this->path_to_thumb_directory.$this->filename_thumb;
	}
	
	public function get_img_tag() {
		if($this->crop != "no") {
			$use_width = $this->width;
			$use_height = $this->height;
		} else {
			$use_width = $this->width_original;
			$use_height = $this->height_original;
		}
		$this->genereate_filename(false);
		if($this->generate_image(false)) {
			return '<img src="'.$this->get_filepath(false).'" width="'.$use_width.'" height="'.$use_height.'" alt="'.$this->alt.'" />';
		} else {
			return '<div class="not_writable" style="background-color: #ccc; border: 1px solid #000; color: #fff; display: inline-block; width: '.$use_width.'px; height: '.$use_height.'px;">'.$this->path_to_thumb_directory.' is not writable</div>';
		}
	}
	
	public function set_tag_pos($tag) {
		if($tag > 0 && $tag < 6) $this->tag_pos = $tag;
		else $this->tag_pos = 1;
	}
	
	public function set_tag($tag = '') {
		$this->tag = $tag;
	}
	
	public function set_alt($alt) {
		if($alt == "") $this->alt = "image";
		else $this->alt = $alt;
	}
	
	public function set_filters($filters) {
		$this->filters = array();
		foreach($filters as $filter) {
			$this->add_filter($filter);
		}
	}
	
	public function add_filter($filter) {
		if(in_array($filter, $this->existing_filters) && !in_array($filter, $this->filters)) {
			$this->filters[] = $filter;
		}
		sort($this->filters, SORT_STRING);
	}
	
	public function set_width($w) {
		if($this->width_original == 0 || $w <= $this->width_original){
			$this->width = $w;
		} else {
			$this->width = 1;
		}
	}
	
	public function set_height($h) {
		if($this->height_original == 0 || $h <= $this->height_original){
			$this->height = $h;
		} else {
			$this->height = 1;
		}
	}
	
	public function set_crop($string) {
		switch($string) {
			case "zoom":
				$this->crop = "zoom";
				break;
			case "fit":
				$this->crop = "fit";
				break;
			default:
				$this->crop = "no";
				break;
		}
	}
	
	private function set_orig_filename($string) {
		$filename = '';
		if(substr($string, -4) == '.jpg' || substr($string, -4) == '.png') $filename = $string; else $filename = $string.".jpg";
		if(!file_exists($this->path_to_orig_directory.$filename)) {
			$this->filename_original = 'unknown';
		} else {
			$this->filename_original = $filename;
			$size = getimagesize($this->get_filepath_orginal());
		}
		
		if(isset($size)) {
			preg_match_all('/(width|height)=\"(\d+)\"/i',$size['3'], $result);
			$this->width_original = $result[2][0];
			$this->height_original = $result[2][1];
		} else {
			$this->width_original = 0;
			$this->height_original = 0;
		}
	}
	
	private function generate_image($fullsize = false) {
		if(!file_exists($this->path_to_thumb_directory.$this->filename_thumb)) {
			if(!is_writable($this->path_to_thumb_directory)) {
				return false;
			}
			if($this->get_filepath_orginal() == "unknown") {
				$image = imagecreatetruecolor($this->width,$this->height);
				$white = imagecolorallocate($image, 220, 220, 220);
				imagefill($image, 0, 0, $white);
				$this->image_tag($image, "Not found", 3, 100, "gray");
			} else {
				
				$use_crop = $this->crop;
				$use_width = $this->width;
				$use_height = $this->height;
				
				if($fullsize) {
					if($this->width_original < self::max_pixel_width) {
						$use_width = $this->width_original;
					} else {
						$use_width = self::max_pixel_width;
					}
					if($this->height_original < self::max_pixel_height) {
						$use_height = $this->height_original;
					} else {
						$use_height = self::max_pixel_height;
					}	
					$use_crop = "fit";
				}
				
				$image = NULL;
				if(substr($this->get_filepath_orginal(), -4) == '.png') {
					$image = imagecreatefrompng($this->get_filepath_orginal());
				} else {
					$image = imagecreatefromjpeg($this->get_filepath_orginal());
				}
				
				if($use_crop != "no") {
					$this->image_crop($image, $use_crop, $use_width, $use_height);
				} 
				
				foreach($this->filters as $filter) {
					switch($filter) {
						case "sepia":
							$this->image_filter_sepia($image);
							break;
						case "invert":
							$this->image_filter_invert($image);
							break;
						case "sharpen":
							$this->image_filter_sharpen($image);
							break;
						case "sharpen_little":
							$this->image_filter_sharpen_little($image);
							break;
					}
				}
				if($this->tag != '') {
					$this->image_tag($image, $this->tag, 5, 20, "white", "gray");
				}
				
			}
			
			imagejpeg($image, $this->path_to_thumb_directory.$this->filename_thumb, 90);
			imagedestroy($image);
			
		}
		return true;
		
	}
	
	private function get_filepath_orginal() {
		if($this->filename_original == "unknown") return $this->filename_original;
		return $this->path_to_orig_directory.$this->filename_original;
	}
	
	private function genereate_filename($fullsize = false) {
		$use_crop = $this->crop;
		$use_width = $this->width;
		$use_height = $this->height;
		if($fullsize) {
			if($this->width_original < self::max_pixel_width) {
				$use_width = $this->width_original;
			} else {
				$use_width = self::max_pixel_width;
			}
			if($this->height_original < self::max_pixel_height) {
				$use_height = $this->height_original;
			} else {
				$use_height = self::max_pixel_height;
			}	
			$use_crop = "fit";
		}
		$thumb = $this->get_filepath_orginal()."?crop=".$use_crop."&size=".$use_width."x".$use_height."&tag=".$this->tag;
		if($this->get_filepath_orginal() != 'unknown') {
			foreach($this->filters as $filter) {
				if(in_array($filter, $this->existing_filters))
					$thumb .= "&".$filter;
			}
		}
		$this->filename_thumb = md5($thumb).".jpg";
	}
	
	
	
	/*
	FILTERS
	*/
	private function image_tag(&$image, $text, $pos = 1, $size = 20, $col = "white", $bgcolor = "none") {
		$width = imagesx($image);
		$height = imagesy($image);
		$font_size = $size;
		$font = $this->path_to_fonts.'GeosansLight.ttf';

		switch($col) {
			case "red":
				$color = imagecolorallocate($image, 255, 0, 0);
				break;
			case "black":
				$color = imagecolorallocate($image, 0, 0, 0);
				break;
			case "gray":
				$color = imagecolorallocate($image, 150, 150, 150);
				break;
			case "white":
			default:
				$color = imagecolorallocate($image, 255, 255, 255);
				break;
		}
		while(true) {
			$arr = imagettfbbox($font_size, 0, $font, $text);
			$text_width = $arr[2] - $arr[0];
			if($text_width > ($width - 20)) {
				$font_size -= 2;
			} else {
				break;
			}
			//echo "(".$font_size. " ".$text_width.")";
		}

		$top = $font_size + 5;
		$bottom = $height - 6;
		$vcenter = $height/2+$font_size/2;

		$left = 10;
		$right = $width-$text_width - $left;
		$center = ($width-$text_width)/2;

		switch($pos) {
			case 2:
				$x1 = $left;
				$y1 = $bottom;
				break;
			case 3:	
				$x1 = $center;
				$y1 = $vcenter;
				break;
			case 4:
				$x1 = $right;
				$y1 = $top;
				break;
			case 5:
				$x1 = $right;
				$y1 = $bottom;
				break;
			case 1:
			default:
				$x1 = $left;
				$y1 = $top;
				break;
		}

		$im = imagecreatetruecolor($width, $height);
		switch($bgcolor) {
			case "gray":
				$bg = imagecolorallocate($im, 50, 50, 50);
				break;
			case "black":
				$bg = imagecolorallocate($im, 1, 1, 1);
				break;
			case "red":
				$bg = imagecolorallocate($im, 255, 0, 0);
				break;
			default:
				$bg = imagecolorallocate($im, 0, 0, 0);
				break;
		}
		$black = imagecolorallocate($im, 0, 0, 0);

		// Make the background transparent
		imagecolortransparent($im, $black);

		// Draw a red rectangle
		$padding = 5;
		imagefilledrectangle($im, $x1-$padding*2, $y1+$padding, $x1+$text_width+$padding*2, $y1-$font_size-$padding, $bg);
		imagecopymerge($image,$im, 0, 0, 0, 0, $width, $height, 75);

		imagettftext($image, $font_size, 0, $x1, $y1, $color, $font, $text);
	}

	private function image_crop(&$image, $crop, $thumb_width, $thumb_height) {
		$new_image = imagecreatetruecolor($thumb_width, $thumb_height);
		$width = imagesx($image);
		$height = imagesy($image);

		if($crop == "fit") { // fit
			$original_aspect = $width / $height;
			$thumb_aspect = $thumb_width / $thumb_height;

			if($original_aspect >= $thumb_aspect) {
			   // If image is wider than thumbnail (in aspect ratio sense)
			   $new_height = $height / ($width / $thumb_width);
			   $new_width = $thumb_width;
			} else {
			   // If the thumbnail is wider than the image
			   $new_width = $width / ($height / $thumb_height);
			   $new_height = $thumb_height;
			}
			$new_image = imagecreatetruecolor($new_width, $new_height);
			// Resize and crop
			imagecopyresampled($new_image,
			                   $image,
			                   0,
			                   0,
			                   0, 0,
			                   $new_width, $new_height,
			                   $width, $height);
			$image = $new_image;
		} else { // zoom
			$original_aspect = $width / $height;
			$thumb_aspect = $thumb_width / $thumb_height;

			if($original_aspect >= $thumb_aspect) {
			   // If image is wider than thumbnail (in aspect ratio sense)
			   $new_height = $thumb_height;
			   $new_width = $width / ($height / $thumb_height);
			} else {
			   // If the thumbnail is wider than the image
			   $new_width = $thumb_width;
			   $new_height = $height / ($width / $thumb_width);
			}

			// Resize and crop
			imagecopyresampled($new_image,
			                   $image,
			                   0 - ($new_width - $thumb_width) / 2, // Center the image horizontally
			                   0 - ($new_height - $thumb_height) / 2, // Center the image vertically
			                   0, 0,
			                   $new_width, $new_height,
			                   $width, $height);
			$image = $new_image;
		}
	}

	private function image_filter_grayscale(&$image){
	    $width = imagesx($image);
	    $height = imagesy($image);
	    for($x = 0; $x < $width; $x++){
	        for($y = 0; $y < $height; $y++){
	            $rgb = imagecolorat($image, $x, $y);
	            $r = ($rgb>>16)&0xFF;
	            $g = ($rgb>>8)&0xFF;
	            $b = $rgb&0xFF;
	            $bw = (int)(($r+$g+$b)/3);
	            $color = imagecolorallocate($image, $bw, $bw, $bw);
	            imagesetpixel($image, $x, $y, $color);
	        }
	    }
	}

	private function image_filter_invert(&$image){
	    $width = imagesx($image);
	    $height = imagesy($image);
	    for($x = 0; $x < $width; $x++){
	        for($y = 0; $y < $height; $y++){
	            $rgb = imagecolorat($image, $x, $y);
	            $r = 0xFF-(($rgb>>16)&0xFF);
	            $g = 0xFF-(($rgb>>8)&0xFF);
	            $b = 0xFF-($rgb&0xFF);
	            $color = imagecolorallocate($image, $r, $g, $b);
	            imagesetpixel($image, $x, $y, $color);
	        }
	    }
	}

	private function image_filter_sepia(&$image){
	    $width = imagesx($image);
	    $height = imagesy($image);
	    for($_x = 0; $_x < $width; $_x++){
	        for($_y = 0; $_y < $height; $_y++){
	            $rgb = imagecolorat($image, $_x, $_y);
	            $r = ($rgb>>16)&0xFF;
	            $g = ($rgb>>8)&0xFF;
	            $b = $rgb&0xFF;

	            $y = $r*0.299 + $g*0.587 + $b*0.114;
	            $i = 0.15*0xFF;
	            $q = -0.001*0xFF;

	            $r = $y + 0.956*$i + 0.621*$q;
	            $g = $y - 0.272*$i - 0.647*$q;
	            $b = $y - 1.105*$i + 1.702*$q;

	            if($r<0||$r>0xFF){$r=($r<0)?0:0xFF;}
	            if($g<0||$g>0xFF){$g=($g<0)?0:0xFF;}
	            if($b<0||$b>0xFF){$b=($b<0)?0:0xFF;}

	            $color = imagecolorallocate($image, $r, $g, $b);
	            imagesetpixel($image, $_x, $_y, $color);
	        }
	    }
	}

	private function image_filter_sharpen(&$image) {
		$sharpenMatrix = array(array(-1, -1, -1), array(-1, 16, -1), array(-1, -1, -1));
		$divisor = 8;
		$offset = 0;
		imageconvolution($image, $sharpenMatrix, $divisor, $offset);
	}

	private function image_filter_sharpen_little(&$image) {
		$sharpenMatrix = array(array(0, -1, 0), array(-1, 8, -1), array(0, -1, 0));
		$divisor = 4;
		$offset = 0;
		imageconvolution($image, $sharpenMatrix, $divisor, $offset);
	}
}
