<?php
class Images_model extends CI_Model 
{
	

    function __construct()
    {
        // Call the Model constructor
        parent::__construct();
    }
    
	function get_config() 
	{
		
		$config['upload_path'] ='./user_content/images/original';
		$config['allowed_types'] = 'jpg|png|JPG|PNG';
		$config['max_size']	= '8000';
		$config['max_width']  = '6000';
		$config['max_height']  = '6000';
		$config['overwrite']  = FALSE;
		$config['file_name']  = uniqid('temp_');
		return $config;
	}

	function add_uploaded_image(&$upload_data, $userid, $title = '', $description = '') 
	{
		//do_dump($upload_data);
		$temp_path = 'user_content/images/original/';
		$new_path = 'user_content/images/original/';

		$orig_filepath = $temp_path . $upload_data['file_name'];
		$ext = $upload_data['file_ext'];
		$width = $upload_data['image_width'];
		$height = $upload_data['image_height'];

		$image = NULL;
		if(strcasecmp($ext, '.png') == 0) 
		{
			$image = imagecreatefrompng($orig_filepath);
		} else {
			$image = imagecreatefromjpeg($orig_filepath);
		}
		
		$docrop = false;
		if($width > 1920)
		{
			$width = 1920;
			$docrop = true;
		}
		if($height > 1200)
		{
			$height = 1200;
			$docrop = true;
		}

		if ($docrop) 
		{
			$this->image_crop($image, $width, $height);
		}

		$new_filename = uniqid() . ".jpg";

		imagejpeg($image, $new_path . $new_filename, 90);
		imagedestroy($image);
		unlink($orig_filepath);

		$data = array(
			'user_id' => $userid,
			'image_original_filename' => $new_filename,
			'width' => $width,
			'height' => $height,
			'image_title' => $title,
			'image_description' => $description,
			);
		$this->db->insert('images', $data);
		$images_id = $this->db->insert_id();
		
		return $images_id;
	}

	function delete_image($id)
	{
		$query = $this->db->get_where('images', array('id' => $id), 1, 0);
		if ($query->num_rows() == 1) 
		{
			$res = $query->result();
			$res = $res[0];
			foreach (glob('user_content/images/generated_cache/'.substr($res->image_original_filename, 0, -4)."*") as $filename) {
				unlink($filename);
			}
			unlink('user_content/images/original/'.$res->image_original_filename);
		}
		$this->db->delete('images', array('id' => $id)); 
		$this->db->delete('news_images', array('images_id' => $id)); 
	}

	function add_or_replace_news_image($news_id, $images_id, $size, $position, $height)
	{
		$query = $this->db->get_where('news_images', array('news_id' => $news_id), 1, 0);
		if ($query->num_rows() == 0) 
		{
			$data = array(
				'news_id' => $news_id,
				'images_id' => $images_id,
				'size' => $size,
				'position' => $position,
				'height' => $height,
				);
			$this->db->insert('news_images', $data);
		} else {
			$data = array(
				'size' => $size,
				'position' => $position,
				'height' => $height,
				);
			if ($images_id != 0) {
				$data['images_id'] = $images_id;
			}

			$this->db->where('news_id', $news_id);
			$this->db->update('news_images', $data); 
		}
	}

	function get_all_images(){
		$this->db->select('*');
		$this->db->from('images');
		$query = $this->db->get();
		$result = $query->result();

		foreach($result as &$res){
			$image = new imagemanip($res->image_original_filename, 'zoom', 100, 100);
			$res->image = $image;
		}

		return $result;
	}
	

	function get_images($limit = 0){
		$this->db->select('image_original_filename');
		$this->db->from('images');
		if($limit){
			$this->db->limit($limit);
		}
		$query = $this->db->get();
		$result = $query->result();
		foreach($result as &$res){
			$image = new imagemanip();
			$image->create($res->image_original_filename, 'zoom', 100, 100);
			$res = $image->get_img_tag();
		}
		return $result;
	}


	private function image_crop(&$image, $thumb_width, $thumb_height) {
		$new_image = imagecreatetruecolor($thumb_width, $thumb_height);
		$width = imagesx($image);
		$height = imagesy($image);

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
	} 
	
}
