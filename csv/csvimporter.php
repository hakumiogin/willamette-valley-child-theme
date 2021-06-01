<?php
if (($handle = fopen(get_stylesheet_directory_uri()."/csv/Page.csv", "r")) !== FALSE) {
    while (($data = fgetcsv($handle, 0, ",")) !== FALSE) {
		$post_arr = array(
			'post_title'   => $data[3],
			'post_excerpt' => $data[44],
			'comment_status' => 'closed',
			'post_content' => $data[5],
			'post_status'  => 'draft',
			'post_author'  => get_current_user_id(),
			'meta_input'   => array(
				'_yoast_wpseo_title' => $data[3],
				'_yoast_wpseo_focuskw' => $data[33],
				'_yoast_wpseo_metadesc' => $data[32],
			),
		);
		if ($data[3] != false){
			wp_insert_post($post_arr, true, false);
		}
		// use wilamette;
		// delete from wp_postmeta where meta_key = '_yoast_wpseo_focuskw'
    }
    fclose($handle);
	die();
}
?>
