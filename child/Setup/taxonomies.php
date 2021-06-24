<?php 
namespace Madden\Theme\Child\Setup;

use function Madden\Theme\Child\config;
/**
 * Add custom taxonomies
 *
 * Additional custom taxonomies can be defined here
 * http://codex.wordpress.org/Function_Reference/register_taxonomy
 */
function add_custom_taxonomies() {
	$labels = array(
        'name'              => _x( 'Contributors', 'taxonomy general name', 'textdomain' ),
        'singular_name'     => _x( 'Contributor', 'taxonomy singular name', 'textdomain' ),
        'search_items'      => __( 'Search Contributors', 'textdomain' ),
        'all_items'         => __( 'All Contributors', 'textdomain' ),
        'view_item'         => __( 'View Contributor', 'textdomain' ),
        'edit_item'         => __( 'Edit Contributor', 'textdomain' ),
        'update_item'       => __( 'Update Contributor', 'textdomain' ),
        'add_new_item'      => __( 'Add New Contributor', 'textdomain' ),
        'new_item_name'     => __( 'New Contributor Name', 'textdomain' ),
        'not_found'         => __( 'No Contributors Found', 'textdomain' ),
        'back_to_items'     => __( 'Back to Contributors', 'textdomain' ),
        'menu_name'         => __( 'Contributors', 'textdomain' ),
    );
 
    $args = array(
        'labels'            => $labels,
        'hierarchical'      => false,
        'public'            => true,
        'show_ui'           => true,
        'show_admin_column' => true,
        'query_var'         => true,
        'rewrite'           => array( 'slug' => 'contributor' ),
        'show_in_rest'      => true,
    );
 
 
    register_taxonomy( 'contributor', 'post', $args );
}
add_action( 'init', 'Madden\Theme\Child\Setup\add_custom_taxonomies', 0 );

add_action( 'admin_footer-edit-tags.php', 'Madden\Theme\Child\Setup\remove_cat_tag_description' );

function remove_cat_tag_description(){
    global $current_screen;
    switch ( $current_screen->id ) 
    {
        case 'edit-category':
            // WE ARE AT /wp-admin/edit-tags.php?taxonomy=category
            // OR AT /wp-admin/edit-tags.php?action=edit&taxonomy=category&tag_ID=1&post_type=post
            break;
        case 'edit-post_tag':
            // WE ARE AT /wp-admin/edit-tags.php?taxonomy=post_tag
            // OR AT /wp-admin/edit-tags.php?action=edit&taxonomy=post_tag&tag_ID=3&post_type=post
            break;
    }
    ?>
    <script type="text/javascript">
    jQuery(document).ready( function($) {
        $('#tag-description').parent().find('label').html('Bio');
        $('#tag-description').parent().find('p').html('');
        $('#tag-name').parent().find('label').html('Contributor Name');
        $('#tag-name').parent().find('p').html('');
        $('#tag-slug').parent().hide();
    });
    </script>
    <?php
}
?>