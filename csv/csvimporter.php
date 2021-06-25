<?php
echo "starting\n";
if (($handle = fopen(get_stylesheet_directory()."/csv/Page.csv", "r")) !== FALSE) {
	$posts = get_posts(array (
		'numberposts' => -1,
		'post_type' => 'post'
	));
	$i = 0;
    while (($data = fgetcsv($handle, 0, ",")) !== FALSE) {
		foreach($posts as $post){
			//echo $post->post_title. "\n";
			//print_r($data[46]);
			if (str_contains($data[3], "Team Up for Virtual Happy Hour")){
				echo "yaaaas";
			}
			if ($data[3] == $post->post_title && $data[3] != ""){ 
				echo "title: ".$post->post_title;
				echo "\n";
				echo "title: ". $data[3];
				echo "\n";
				// echo "date: ".$data[46];
				//echo "\n\n";
				$i++;
			}
			// if ($data[3] == get_post_meta($post->ID, "_yoast_wpseo_title", true) && $data[3] != "" && $data[3] != null) { 
			// 	echo "YOAST MATCH #########";
			// 	$i++;
			// 	print_r($data[42]);
			// 	print "\n";
			// 	print_r(get_post_meta($post->ID, "_yoast_wpseo_title", true));
			// 	print "\n\n";	
			// }
		}
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
		// if ($data[3] != false){
		// 	wp_insert_post($post_arr, true, false);
		// }
		// use wilamette;
		// delete from wp_postmeta where meta_key = '_yoast_wpseo_focuskw'
    }
	echo ("\nNumber of posts: ".$i);
    fclose($handle);
	die();
}
?>
