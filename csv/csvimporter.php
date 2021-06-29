<?php
echo "starting\n";
if (($handle = fopen(get_stylesheet_directory()."/csv/Page.csv", "r")) !== FALSE) {
	$posts = get_posts(array (
		'numberposts' => -1,
		'post_type' => 'post'
	));
	$i = 0;
	$k = 0;
    while (($data = fgetcsv($handle, 0, ",")) !== FALSE) {
		if ($i == 0){
			$key = $data; $i++;
		}
		//echo(gettype($data[46]));
		if ($data[46] != 'NULL'){
			foreach($posts as $post){
				if ($data[3] == $post->post_title && $data[3] != ""){ 
					echo "winner 1";
					echo $data[3];
					$k++;
				}
				if ($data[32] == get_post_meta($post->ID, "_yoast_wpseo_title", true) && $data[32] != "" && $data[32] != null) { 
					echo "yoast winner 1";
					$k++;
				}
				if ($data[44] == $post->post_excerpt && $data[44] != ""){ 
					echo "winner 2";
					echo $data[3];
					$k++;
				}

				if ($data[3] == get_post_meta($post->ID, "_yoast_wpseo_title", true) && $data[3] != "" && $data[3] != null) { 
					echo "yoast winner 1";
					$k++;
				}

			}
			// foreach($data as $datum){

			// 	if ($datum != 'NULL' && $datum != ''){
			// 		echo $key[$j]. "$j : ";
			// 		echo $datum;
			// 		echo "||";
			// 	}
			// 	$j++;
			// }
		}
		if ($data[43] != 'NULL'){
			foreach($posts as $post){
				if ($data[3] == $post->post_title && $data[3] != ""){ 
					echo "winner 2";
					echo $data[3];
					$i++;
				}
				if ($data[44] == $post->post_excerpt && $data[44] != ""){ 
					echo "winner 2";
					echo $data[3];
					$i++;
				}
				if ($data[32] == get_post_meta($post->ID, "_yoast_wpseo_metadesc", true) && $data[32] != "" && $data[32] != null) { 
					echo "yoast winner 2";
					$i++;
				}
				if ($data[3] == get_post_meta($post->ID, "_yoast_wpseo_title", true) && $data[3] != "" && $data[3] != null) { 
					echo "yoast winner 1";
					$i++;
				}


			}
			//print_r($data[46]);
			// print("     ");
			//$j = 0;
			// foreach($data as $datum){
			// 	if ($datum != 'NULL' && $datum != ''){
			// 		echo $key[$j]. "$j : ";
			// 		echo $datum;
			// 		echo "||";
			// 	}
			// 	$j++;
			// }
		}
		foreach($posts as $post){
			//echo $post->post_title. "\n";
			//print_r($data[46]);
			// 	echo "title: ".$post->post_title;
			// 	echo "\n";
			// 	echo "date: ".$data[46];
			// 	//echo "\n\n";
			// 	$i++;
			// 	// wp_update_post(
			// 	// 	array (
			// 	// 		'ID'            => $post->ID, // ID of the post to update
			// 	// 		'post_date'     => $data[46],
			// 	// 		'post_date_gmt' => get_gmt_from_date( $data[46] )
			// 	// 	)
			// 	// );	
			// }
			// if ($data[3] == get_post_meta($post->ID, "_yoast_wpseo_title", true) && $data[3] != "" && $data[3] != null) { 
			// 	echo "YOAST MATCH #########";
			// 	echo "title: ". $data[3];
			// 	print_r(get_post_meta($post->ID, "_yoast_wpseo_title", true));
			// 	print "\n\n";
			// 	echo "date: ".$data[46];
			// 	$k++;
			// 	// wp_update_post(
			// 	// 	array (
			// 	// 		'ID'            => $post->ID, // ID of the post to update
			// 	// 		'post_date'     => $data[46],
			// 	// 		'post_date_gmt' => get_gmt_from_date( $data[46] )
			// 	// 	)
			// 	// );
			// }
	
		}
		// $post_arr = array(
		// 	'post_title'   => $data[3],
		// 	'post_excerpt' => $data[44],
		// 	'comment_status' => 'closed',
		// 	'post_content' => $data[5],
		// 	'post_status'  => 'draft',
		// 	'post_author'  => get_current_user_id(),
		// 	'meta_input'   => array(
		// 		'_yoast_wpseo_title' => $data[3],
		// 		'_yoast_wpseo_focuskw' => $data[33],
		// 		'_yoast_wpseo_metadesc' => $data[32],
		// 	),
		// );
		
		// if ($data[3] != false){
		// 	wp_insert_post($post_arr, true, false);
		// }
		// use wilamette;
		// delete from wp_postmeta where meta_key = '_yoast_wpseo_focuskw'
    }
	echo ("\nNumber of posts: ".$i. " and : " . $k);
    fclose($handle);
	die();
}
?>
