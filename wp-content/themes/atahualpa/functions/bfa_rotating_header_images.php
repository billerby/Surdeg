<?php
function bfa_rotating_header_images() {

	if (file_exists(ABSPATH."/wpmu-settings.php")) {

		################### images in WP upload folder (on WPMU)
		
		$files = m_find_in_dir(get_option('upload_path'),
			'atahualpa_header_[0-9]+\.(jpe?g|png|gif|bmp)$');

		if ($files) {
			foreach($files as $value) {
				$bfa_header_images[] = "'" . str_replace(get_option('upload_path'),
				get_option('fileupload_url'), $value) . "'"; 
			} 
		}

	}

	# If no user uploaded header image files were found in WPMU, or this is not WPMU:

	if (!file_exists(ABSPATH."/wpmu-settings.php") OR !$files ) {

			
		################### images in /images/header/ (on regular WordPress)

		$files = "";
		$imgpath = TEMPLATEPATH . '/images/header/';
		$imgdir = get_bloginfo('template_directory') . '/images/header/';
		$dh  = opendir($imgpath);

		while (FALSE !== ($filename = readdir($dh))) {
			if(eregi('.jpg', $filename) || eregi('.gif', $filename) || eregi('.png', $filename)) {
		   $files[] = $filename;
		   }
		}
		closedir($dh);

		foreach($files as $value) {
			$bfa_header_images[] = '\'' . $imgdir . $value . '\'';
		} 

	}
	

return $bfa_header_images;
}
?>