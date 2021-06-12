<div class="featured-slider">
	<?php 
	$posts = get_field("posts");
	foreach ($posts as $post): ?>
		<div class="featured-slider__item">
			<div class="wp-block-columns">
				<div class="wp-block-column" style="flex-basis:66.66%">
					<?php 
					$images = get_field("photos", $post["post"]->ID);
					if ($images){
						$featured_photo_url = $images[0]["image_url"];
					} else {
						$image = get_the_post_thumbnail_url($post["post"]->ID);
						if ($image){
							$featured_photo_url = get_the_post_thumbnail_url($post["post"]->ID, "full");
						}
					} ?>
					<figure class="wp-block-image" style="float:right;"><img loading="lazy" src="<?= $featured_photo_url ?>" alt="" class="wp-image-135235" sizes="(max-width: 1024px) 100vw, 1024px"></figure>
				</div>
				<div class="wp-block-column" style="flex-basis:33.33%">
					<h2><?= $post["post"]->post_title; ?></h2>
					<div class="post-content">
						<?php
						$blocks = parse_blocks($post["post"]->post_content);
						if ($blocks){
							echo render_block($blocks[0]);
							if (count($blocks) > 2){
								echo render_block($blocks[1]);
								echo render_block($blocks[2]);
							}

						}
						?>
					</div>
					<div class="wp-block-buttons">
						<div class="wp-block-button is-style-Two-Tone">
							<a class="wp-block-button__link has-white-color has-purple-background-color has-text-color has-background" href="<?= $post["post"]->the_permalink; ?>">Explore More</a>
						</div>
					</div>
				</div>
			</div>
		</div>
	<?php endforeach; ?>
</div>

