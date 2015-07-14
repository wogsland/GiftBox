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
	var $cropped_image_file_name;
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
	var $redirect_url;
	var $auto_play;
	var $overlay_content;
	var $overlay_left;
	var $overlay_top;
	
	public function init($object) {
		foreach (get_object_vars($object) as $key => $value) {
			$this->$key = $value;
		}
	}
	
	public function load() {
		$bento = execute_query("SELECT * FROM bento WHERE giftbox_id = $this->giftbox_id AND css_id = '$this->css_id'")->fetch_object("Bento");
		return $bento;
	}
	
	public function delete() {
		execute("DELETE FROM bento WHERE giftbox_id = $this->giftbox_id AND css_id = '$this->css_id'");
	}
	
	public function setGiftboxId($id) {
		$this->giftbox_id = $id;
	}
	
	public function save() {
		include 'config.php';
		
		$slider_value = $this->slider_value ? $this->slider_value : 'null';
		$image_file_name = $this->image_file_name;
		$cropped_image_file_name = $this->cropped_image_file_name;
		$download_file_name = $this->download_file_name;

		// Prefix the file names with the token ID to avoid file name collisions
		$test = explode("_", $image_file_name);
		if(strlen($this->image_file_name) > 0 && $test[0] != $this->giftbox_id){
			$image_file_name = $this->giftbox_id."_".$image_file_name;
		}
		$test = explode("_", $cropped_image_file_name);
		if(strlen($this->cropped_image_file_name) > 0 && $test[0] != $this->giftbox_id){
			$cropped_image_file_name = $this->giftbox_id."_".$cropped_image_file_name;
		}

		// Delete any old images files before deleting the old bento record
		$bento = $this->load();
		if ($bento) {
			if (strlen($bento->cropped_image_file_name) > 0 && $bento->cropped_image_file_name != $cropped_image_file_name) {
				if ($google_app_engine) {
					$image_path = CloudStorageTools::getPublicUrl($file_storage_path.$bento->cropped_image_file_name, $use_https);
				} else {
					$image_path = $file_storage_path.$bento->cropped_image_file_name;
				}
				unlink($image_path);
			}
			if (strlen($bento->image_file_name) > 0 && $bento->image_file_name != $image_file_name) {
				if ($google_app_engine) {
					$image_path = CloudStorageTools::getPublicUrl($file_storage_path.$bento->image_file_name, $use_https);
				} else {
					$image_path = $file_storage_path.$bento->image_file_name;
				}
				unlink($image_path);
			}
		}
		$this->delete();
		
		$image_file_name = str_replace("'", "''", $image_file_name);
		$cropped_image_file_name = str_replace("'", "''", $cropped_image_file_name);
		$download_file_name = str_replace("'", "''", $download_file_name);
		$sql = "INSERT INTO bento (giftbox_id, css_id, css_width, css_height, css_top, css_left, "
			."image_file_name, cropped_image_file_name, image_width, image_height, image_top, image_left, download_file_name, "
			."download_mime_type, content_uri, slider_value, "
			."image_top_in_container, image_left_in_container, image_hyperlink, redirect_url, auto_play,"
			."overlay_content, overlay_left, overlay_top, overlay_width) "
			."VALUES ($this->giftbox_id, '$this->css_id', '$this->css_width', '$this->css_height', "
			."'$this->css_top', '$this->css_left', '$image_file_name', '$cropped_image_file_name', '$this->image_width', "
			."'$this->image_height', '$this->image_top', '$this->image_left', '$download_file_name', "
			."'$this->download_mime_type', '$this->content_uri', $slider_value, "
			."'$this->image_top_in_container', '$this->image_left_in_container', "
			."'$this->image_hyperlink', '$this->redirect_url', '$this->auto_play',"
			."'$this->overlay_content', '$this->overlay_left', '$this->overlay_top', '$this->overlay_width')";
		$this->id = insert($sql);
		if(sizeof($this->gallery_file_list) > 0){
			$photo_gallery = new PhotoGallery();
			$photo_gallery->giftboxId = $this->giftbox_id;
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
			echo '<i class="bento-link-icon visible icon-link fa fa-picture-o fa-lg"></i>'.PHP_EOL;
		} else {
			echo '<div class="bento">'.PHP_EOL;
		}
		
		if (is_spotify($this->content_uri)) {
			$background_color = "black";
		} else {
			$background_color = "white";
		}

		if ($this->cropped_image_file_name) {
			$ext = pathinfo($this->cropped_image_file_name, PATHINFO_EXTENSION);			
			if ($google_app_engine) {
				if ($ext == "gif") {
					$image_path = CloudStorageTools::getPublicUrl($file_storage_path.$this->image_file_name, $use_https);
				} else {
					$image_path = CloudStorageTools::getPublicUrl($file_storage_path.$this->cropped_image_file_name, $use_https);
				}
			} else {
				if ($ext == "gif") {
					$image_path = $file_storage_path.$this->image_file_name;
				} else {
					$image_path = $file_storage_path.$this->cropped_image_file_name;
				}
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

		if($this->overlay_content){
			echo '<div class="'.$this->id.'" style="font-size: 100%; font-family: Lato-Bold, sans-serif; width: '.($this->overlay_width+2).'%; position:absolute; word-break: break-all; left: '.($this->overlay_left + 2).'%; top: '.$this->overlay_top.'%;">'.$this->overlay_content.'</div>';
			echo '<script>
				window.onload = function(){
					var oHeight = $($(".'.$this->id.'")[0].parentNode).height();
					var percentChange = ((oHeight/("'.$this->css_height.'").split("px")[0]) * 100) - 2;
					$(".giftbox")[0].style.fontSize = percentChange + "%";
				}
				var originalHeight = $(window).height();
				$(window).resize(function() { 
					var percent = originalHeight/$(window).height();
					originalHeight = $(window).height();
					var currentSize = $(".giftbox")[0].style.fontSize;
					currentSize = parseFloat(currentSize);
					$(".giftbox")[0].style.fontSize = (currentSize/percent) + "%";
				});

			</script>';
			
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
				if($this->auto_play == 1){
					echo "<div class=\"youtube-video auto-play\" id=\"player?".$video_id."?".$this->id."\"></div>";
				} else { 
					echo "<div class=\"youtube-video\" id=\"player?".$video_id."?".$this->id."\"></div>";
				}
			  	if($this->redirect_url){
			  		echo "<div id='redirect_url'>".$this->redirect_url."</div>".PHP_EOL;

				};
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