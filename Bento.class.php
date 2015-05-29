<?php
include_once 'config.php';
use google\appengine\api\cloud_storage\CloudStorageTools;
if ($google_app_engine) {
	include_once 'google/appengine/api/cloud_storage/CloudStorageTools.php';
}

include_once 'util.php';
include 'PhotoGallery.class.php';

class Bento {
	var $id;
	var $giftbox_id;
	var $css_id;
	var $css_width;
	var $css_height;
	var $css_top;
	var $css_left;
	var $image_file_name;
	var $image_width;
	var $image_height;
	var $image_top;
	var $image_left;
	var $download_file_name;
	var $download_mime_type;
	var $content_uri;
	var $slider_value;
	var $image_left_in_container;
	var $image_top_in_container;
	var $image_hyperlink;
	var $gallery_file_list = array();
	
	public function init($object) {
		foreach (get_object_vars($object) as $key => $value) {
			$this->$key = $value;
		}
	}
	
	public function setGiftboxId($id) {
		$this->giftbox_id = $id;
	}
	
	public function save() {
		$image_file_name = str_replace("'", "''", $this->image_file_name);
		$download_file_name = str_replace("'", "''", $this->download_file_name);
		$slider_value = $this->slider_value ? $this->slider_value : 'null';
		$sql = "INSERT INTO bento (giftbox_id, css_id, css_width, css_height, css_top, css_left, "
			."image_file_name, image_width, image_height, image_top, image_left, download_file_name, "
			."download_mime_type, content_uri, slider_value, "
			."image_top_in_container, image_left_in_container, image_hyperlink) "
			."VALUES ($this->giftbox_id, '$this->css_id', '$this->css_width', '$this->css_height', "
			."'$this->css_top', '$this->css_left', '$image_file_name', '$this->image_width', "
			."'$this->image_height', '$this->image_top', '$this->image_left', '$download_file_name', "
			."'$this->download_mime_type', '$this->content_uri', $slider_value, "
			."'$this->image_top_in_container', '$this->image_left_in_container', "
			."'$this->image_hyperlink')";
		$this->id = insert($sql);
		if(sizeof($this->gallery_file_list) > 0){
			$photo_gallery = new PhotoGallery();
			$photo_gallery->setBentoId($this->id);
			$photo_gallery->setFileNames($this->gallery_file_list);
			$photo_gallery->save();
		}
	}
	
	public function render() {
		include 'config.php';
		$gallery = PhotoGallery::fetch($this->id);
		if(sizeof($gallery)> 0){
			foreach($gallery as $file_name){
				if ($google_app_engine) {
	//				CloudStorageTools::deleteImageServingUrl($file_storage_path.$file_name);
	//				$image_path = CloudStorageTools::getImageServingUrl($file_storage_path.$file_name, ['secure_url' => $use_https]);
					$image_path = CloudStorageTools::getPublicUrl($file_storage_path.$file_name[2], $use_https);
				} else {
					$image_path = $file_storage_path.$file_name[2];
				}
				array_push($this->gallery_file_list, $image_path);
			}
		}
		if ($this->gallery_file_list){
			echo '<div class="bento gallery '.$this->id.'" href="'.$this->gallery_file_list[0].'">'.PHP_EOL;
		} else {
			echo '<div class="bento">'.PHP_EOL;
		}
		
		if (is_spotify($this->content_uri)) {
			$background_color = "black";
		} else {
			$background_color = "white";
		}

		if ($this->image_file_name) {
			$file_name = $this->css_id."-cropped_".$this->image_file_name;
			if ($google_app_engine) {
//				CloudStorageTools::deleteImageServingUrl($file_storage_path.$file_name);
//				$image_path = CloudStorageTools::getImageServingUrl($file_storage_path.$file_name, ['secure_url' => $use_https]);
				$image_path = CloudStorageTools::getPublicUrl($file_storage_path.$file_name, $use_https);
			} else {
				$image_path = $file_storage_path.$file_name;
			}
			if ($this->download_file_name && (strpos($this->download_mime_type, 'audio') === 0)) {
				// Show the image as a poster in the audio player
			} else {
				if ($this->image_hyperlink) {
					echo '<a href="'.$this->image_hyperlink.'" target="_blank">'.PHP_EOL;
				}
				echo '<img src="'.$image_path.'">'.PHP_EOL;
				if ($this->image_hyperlink) {
					echo '</a>'.PHP_EOL;
				}
			}
		}
		if ($this->download_file_name) {
			$download_file_names[] = $this->download_file_name;
			if ($google_app_engine) {
				$path = CloudStorageTools::getPublicUrl($file_storage_path.$this->download_file_name, $use_https);
			} else {
				$path = $file_storage_path.$this->download_file_name;
			}
			$download_paths[] = $path;
			if (strpos($this->download_mime_type, 'video') === 0) {
				echo '<video id="'.$this->download_file_name.'" class="video-js vjs-default-skin video-player" controls preload="auto" width="auto" height="auto" data-setup="{}">'.PHP_EOL;
				echo '<source src="'.$path.'" type="'.$this->download_mime_type.'" />'.PHP_EOL;
				echo '<p class="vjs-no-js">To view this video please enable JavaScript, and consider upgrading to a web browser that <a href="http://videojs.com/html5-video-support/" target="_blank">supports HTML5 video</a></p>'.PHP_EOL;									
				echo '</video>'.PHP_EOL;
			} else if (strpos($this->download_mime_type, 'audio') === 0) {
				echo '<audio class="audio-player video-js vjs-default-skin" controls preload="auto" src="'.$path.'" width="auto" height="auto" poster="'.$image_path.'" data-setup="{}">'.PHP_EOL;
				echo '<source src="'.$path.'" type="'.$this->download_mime_type.'" />'.PHP_EOL;
			} else {
				echo '<img class="download-icon" src="images/download.jpg">'.PHP_EOL;
			}
		}
		if ($this->content_uri) {
			if (is_youtube($this->content_uri)) {
				$video_id = youtube_id($this->content_uri);
				echo "<iframe class=\"youtube-player\" type=\"text/html\" src=\"//www.youtube.com/embed/".$video_id."?wmode=opaque\" frameborder=\"0\"></iframe>".PHP_EOL;
			} elseif (is_soundcloud($this->content_uri)) {
				echo "<iframe src=\"https://w.soundcloud.com/player/?url=".$this->content_uri."\" frameborder=\"0\"></iframe>".PHP_EOL;
			} elseif (is_spotify($this->content_uri)) {
				echo "<iframe src=\"".$this->content_uri."\" frameborder=\"0\"></iframe>".PHP_EOL;
			} elseif (8 !== FALSE){
				echo "<iframe src=\"".$this->content_uri."\" frameborder=\"0\"></iframe>".PHP_EOL;
			}
		}
		if ($this->image_hyperlink) {
			echo '<i class="bento-link-icon visible icon-link fa fa-link fa-lg"></i>'.PHP_EOL;
		}
		echo '</div>'.PHP_EOL;
		if ($this->gallery_file_list){
			foreach($this->gallery_file_list as $key => $file_name){
				if($key != 0){
					echo '<div id="'.$key.'"href="'.$file_name.'" class="'.$this->id.'"></div>';
				}
			}
		}
	}
}