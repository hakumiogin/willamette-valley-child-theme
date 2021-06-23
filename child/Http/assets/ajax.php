<?php



add_action( 'wp_ajax_nopriv_getPosts', 'getPosts' );
add_action( 'wp_ajax_getPosts', 'getPosts' );

function getPosts($notAjax = false) {
    return "posts";
}


add_action( 'wp_ajax_nopriv_getBlogs', 'getBlogs' );
add_action( 'wp_ajax_getBlogs', 'getBlogs' );

function getBlogs($notAjax = false) {

    $args = array (
        'posts_per_page' => -1,
        'post_type' => 'post',
        'post_status' => 'publish',
    );

    $searchFilter = $_POST['s'];
    $catsFilters = $_POST['categories'];
    $monthFilters = $_POST['months'];
    $sortType = $_POST['sortType'];
    $page = ($_POST['page']) ?: 1;
    if ($searchFilter) {
        $args['s'] = $searchFilter;
    }
    if ($catsFilters) {
        $args['tax_query'][][] = array (
            'taxonomy' => 'category',
            'field'    => 'term_id',
            'terms'    => $catsFilters

        );
    }
    if ($monthFilters) {
        foreach($monthFilters as $month) {
            $today = getdate($month);
            $args['date_query'][][] = array (
                'column' => 'post_modified',
                'after'  => array(
                    'year'  => $today['year'],
                    'month' => $today['mon'],
                    'day'   => 1,
                ),
                'before'  => array(
                    'year'  => $today['year'],
                    'month' => $today['mon'],
                    'day'   => 31,
                ),
            );
        }
    }
    $blogs = new WP_Query($args);
    if ($sortType == 'name') {
        usort($blogs->posts, function($a, $b) {
            return strnatcmp($a->post_title, $b->post_title);
        });
    }
    $totalPages = ceil(count($blogs->posts) / 12);
    $blogs->posts = array_values($blogs->posts);
    $blogs->post_count = count($blogs->posts);
    if ($page == 'last') {
        $page = $totalPages;
    } elseif ($page == 'first') $page = 1;
    $offset = ($page - 1) * 12;
    $blogs->posts = array_slice($blogs->posts, $offset, 12);



    $html = '';
    foreach($blogs->posts as $post){
		if ($_GET["type"] == "otis-slider"){

		} else if ($_GET["type"] == "slider"){

		} else if ($_GET["type"] == "list"){
			
		}
        setup_postdata($post);
        $blogFields = get_fields($post);
        $thumbnail_id = get_post_thumbnail_id($post);
        $thumbnail_post = $post->ID;
        if ($thumbnail_id) {
            $imageAlt = get_post_meta($thumbnail_id, '_wp_attachment_image_alt', true);
            $imageUrl = get_the_post_thumbnail_url($thumbnail_post, 'bones-thumb-750' );
        }

        //extras data
        $teaser = blog_get_excerpt($post);

        $html .= '<div class="blog"';
        $html .= '>';
        $html .= '<div class="imageAndInfo">'; //image and info

        if ($thumbnail_id):
            $html .= '<div class="image">';
            $html .= '<img data-load-type="img"';
            $html .= 'data-load-offest="lg"';
            $html .= 'data-load-all="'.$imageUrl.'"';
            $html .= 'alt="'.$imageAlt.'"';
            $html .= 'src="'.get_template_directory_uri().'/library/images/pixel.png">';
            $html .= '</div>';
        endif;

        $html .= '<div class="info">';
        $html .= '<p class="title">'.get_the_title($post).'</p>';
        $html .= '<p class="date">'.get_the_modified_date('M d, Y', $post->ID).'</p>';
        $html .= '<p class="teaser">'.$teaser.'</p>';
        $html .= '</div>'; //info
        $html .= '</div>'; //image and info

        $html .= '<div class="actions">';
        $html .= '<a href="'.get_the_permalink($post).'" class="mmButton green">Read More</a>';
        $html .= '</div>';
        $html .= '</div>';

    }



    if ($notAjax) {
        return array('html' => $html, 'count' => $blogs->post_count);
    } else {
        $isFirst = ($page == 1);
        $isLast = ($page == $totalPages);
        echo json_encode(
            array(
                'html' => $html,
                'count' => $blogs->post_count,
                'offset' => $offset,
                'page' => $page,
                'number_returned' => count($blogs->posts),
                'isFirst' => $isFirst,
                'isLast' => $isLast,
                'args' => $args
            )
        );
        wp_die();
    }
}
