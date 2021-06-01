<?php
namespace Madden\Theme\Setup;
use function Madden\Theme\App\config;

register_block_pattern(
    'willamette/left-image-text-pattern',
    array(
        'title'       => __( 'Image and Text', config('textdomain') ),
        'description' => _x( 'Image and Text.', 'Block pattern description', config('textdomain') ),
        'content'     => '<!-- wp:columns --><div class="wp-block-columns"><!-- wp:column {"width":"66.66%"} --><div class="wp-block-column" style="flex-basis:66.66%"><!-- wp:image {"id":134746,"sizeSlug":"large","linkDestination":"none"} --><figure class="wp-block-image size-large"><img src="../wp-content/themes/mm-WillametteValley-child-theme/resources/assets/images/exampletwothirds.jpeg" alt="" class="wp-image-134746"/></figure><!-- /wp:image --></div><!-- /wp:column --><!-- wp:column {"width":"33.33%"} --><div class="wp-block-column" style="flex-basis:33.33%"><!-- wp:heading {"level":3} --><h3>Itenerary</h3><!-- /wp:heading --><!-- wp:paragraph --><p>Paragraph text is nice and cool and here it is being a good paragraph of text for me to style. Let me wow you with my bewildering sense of paragraph text that I a putting on display here for us all to enjoy.</p><!-- /wp:paragraph --></div><!-- /wp:column --></div><!-- /wp:columns -->',
		'category'    => 'madden',
		)
); 
register_block_pattern(
    'willamette/right-image-text-pattern',
    array(
        'title'       => __( 'Image and Text', config('textdomain') ),
        'description' => _x( 'Image and Text.', 'Block pattern description', config('textdomain') ),
        'content'     => '<!-- wp:columns --><div class="wp-block-columns"><!-- wp:column {"width":"33.33%"} --><div class="wp-block-column" style="flex-basis:33.33%"><!-- wp:heading {"level":3} --><h3>Itenerary</h3><!-- /wp:heading --><!-- wp:paragraph --><p>Paragraph text is nice and cool and here it is being a good paragraph of text for me to style. Let me wow you with my bewildering sense of paragraph text that I a putting on display here for us all to enjoy.</p><!-- /wp:paragraph --></div><!-- /wp:column --><!-- wp:column {"width":"66.66%"} --><div class="wp-block-column" style="flex-basis:66.66%"><!-- wp:image {"id":134753,"sizeSlug":"large","linkDestination":"none"} --><figure class="wp-block-image size-large"><img src="../wp-content/themes/mm-WillametteValley-child-theme/resources/assets/images/exampletwothirds.jpeg" alt="" class="wp-image-134753"/></figure><!-- /wp:image --></div><!-- /wp:column --></div><!-- /wp:columns -->',
		'category'    => 'madden',
		)

	);
register_block_pattern(
    'willamette/fullwidth-image',
    array(
        'title'       => __( 'Full width image', config('textdomain') ),
        'description' => _x( 'Full width image.', 'Block pattern description', config('textdomain') ),
        'content'     => '<!-- wp:image {"align":"full","id":134754,"sizeSlug":"large","linkDestination":"none"} --><figure class="wp-block-image alignfull size-large"><img src="../wp-content/themes/mm-WillametteValley-child-theme/resources/assets/images/fullwidth.jpg" alt="" class="wp-image-134754"/></figure><!-- /wp:image -->',
		'category'    => 'madden',
		)
); 
register_block_pattern(
    'willamette/three-icons',
    array(
        'title'       => __( 'Three icons', config('textdomain') ),
        'description' => _x( 'Three icons.', 'Block pattern description', config('textdomain') ),
        'content'     => '<!-- wp:columns {"className":"narrow-columns plain-links"} --><div class="wp-block-columns narrow-columns"><!-- wp:column --><div class="wp-block-column"><!-- wp:image {"id":134761,"sizeSlug":"large","linkDestination":"none"} --><figure class="wp-block-image size-large"><img src="../wp-content/themes/mm-WillametteValley-child-theme/resources/assets/images/narrowcolumnsicon.png" alt="" class="wp-image-134761"/></figure><!-- /wp:image --><!-- wp:paragraph {"align":"center"} --><p class="has-text-align-center"><a href="#">Outdoors and Recreation</a></p><!-- /wp:paragraph --></div><!-- /wp:column --><!-- wp:column --><div class="wp-block-column"><!-- wp:image {"id":134760,"sizeSlug":"large","linkDestination":"none"} --><figure class="wp-block-image size-large"><img src="../wp-content/themes/mm-WillametteValley-child-theme/resources/assets/images/narrowcolumnsicon.png" alt="" class="wp-image-134760"/></figure><!-- /wp:image --><!-- wp:paragraph {"align":"center"} --><p class="has-text-align-center"><a href="#">Outdoors and Recreation</a></p><!-- /wp:paragraph --></div><!-- /wp:column --><!-- wp:column --><div class="wp-block-column"><!-- wp:image {"id":134762,"sizeSlug":"large","linkDestination":"none"} --><figure class="wp-block-image size-large"><img src="../wp-content/themes/mm-WillametteValley-child-theme/resources/assets/images/narrowcolumnsicon.png" alt="" class="wp-image-134762"/></figure><!-- /wp:image --><!-- wp:paragraph {"align":"center"} --><p class="has-text-align-center"><a href="#">Outdoors and Recreation</a></p><!-- /wp:paragraph --></div><!-- /wp:column --></div><!-- /wp:columns -->',
		'category'    => 'madden',
		)
); 
register_block_pattern(
    'willamette/pattern-bg',
    array(
        'title'       => __( 'Pattern Background', config('textdomain') ),
        'description' => _x( 'Pattern Background.', 'Block pattern description', config('textdomain') ),
        'content'     => '<!-- wp:group {"align":"full","className":"pattern-bg"} --><div class="wp-block-group alignfull pattern-bg"><div class="wp-block-group__inner-container"><!-- wp:group {"className":"notfullwidth"} --><div class="wp-block-group notfullwidth"><div class="wp-block-group__inner-container"><!-- wp:heading {"textAlign":"center","level":3} --><h3 class="has-text-align-center">Recommended Reads</h3><!-- /wp:heading --></div></div><!-- /wp:group --></div></div><!-- /wp:group -->',
		'category'    => 'madden',
		)
); 

?>

